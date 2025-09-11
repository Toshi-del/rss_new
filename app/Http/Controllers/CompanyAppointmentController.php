<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\MedicalTest;
use App\Models\MedicalTestCategory;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CompanyAppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patients','medicalTestCategory','medicalTest'])->where('created_by', Auth::id())
            ->orderBy('appointment_date', 'asc')
            ->orderBy('time_slot', 'asc')
            ->get();
        
        return view('company.appointments.index', compact('appointments'));
    }

    public function create(Request $request)
    {
        // Check if date parameter is provided
        if (!$request->has('date')) {
            return redirect()->route('company.appointments.index')
                ->with('error', 'Please select a date from the calendar.');
        }

        // Get medical tests grouped by category
        $medicalTestCategories = MedicalTestCategory::with(['medicalTests' => function($query) {
            $query->where('is_active', true)->orderBy('sort_order');
        }])->where('is_active', true)->orderBy('sort_order')->get();

        $timeSlots = [
            '8:00 AM', '8:30 AM', '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM',
            '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM', '1:00 PM', '1:30 PM',
            '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM', '4:00 PM'
        ];

        return view('company.appointments.create', compact('medicalTestCategories', 'timeSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'nullable|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'medical_test_categories_id' => 'required|exists:medical_test_categories,id',
            'medical_test_id' => 'required|exists:medical_tests,id',
            'notes' => 'nullable|string',
            'excel_file' => 'nullable|file|mimes:xlsx,xls',
        ]);

        try {
            $appointmentDate = $request->appointment_date ?? $request->query('date');
            if (empty($appointmentDate)) {
                return back()->withInput()->with('error', 'Appointment date is required. Please select a date.');
            }
            
            // Ensure the date is in the correct format
            $appointmentDate = Carbon::parse($appointmentDate)->format('Y-m-d');

            // Check for duplicate appointment (same date, time slot, and created by same user)
            $existingAppointment = Appointment::where('appointment_date', $appointmentDate)
                ->where('time_slot', $request->time_slot)
                ->where('created_by', Auth::id())
                ->first();

            if ($existingAppointment) {
                return back()->withInput()->with('error', 'An appointment already exists for this date and time slot. Please choose a different time.');
            }

            // Validate the selected test belongs to the selected category
            $selectedTest = MedicalTest::find($request->medical_test_id);
            if (!$selectedTest || (int) $selectedTest->medical_test_category_id !== (int) $request->medical_test_categories_id) {
                return back()->withInput()->withErrors(['medical_test_id' => 'Selected medical test does not belong to the chosen category.']);
            }
            $totalPrice = $selectedTest->price ?? 0;

            $appointment = Appointment::create([
                'appointment_date' => $appointmentDate,
                'time_slot' => $request->time_slot,
                'medical_test_categories_id' => $request->medical_test_categories_id,
                'medical_test_id' => $request->medical_test_id,
                'total_price' => $totalPrice,
                'notes' => $request->notes,
                'patients_data' => [], // Will be populated when Excel is processed
                'excel_file_path' => null, // Will be set if file is uploaded
                'created_by' => Auth::id(),
                'status' => 'pending',
            ]);

            // Handle Excel file upload and patient creation
            if ($request->hasFile('excel_file')) {
                $file = $request->file('excel_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('appointments', $fileName, 'public');
                
                // Update appointment with file path
                $appointment->update(['excel_file_path' => $filePath]);
                
                // Process Excel file and create patients
                $this->processExcelFile($file, $appointment);
                
                \Log::info('Excel file processed for appointment', [
                    'appointment_id' => $appointment->id,
                    'file_path' => $filePath,
                    'patients_count' => $appointment->patients()->count()
                ]);
            }

            return redirect()->route('company.appointments.index')
                ->with('success', 'Appointment created successfully.');

        } catch (\Exception $e) {
            \Log::error('Error creating appointment', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()
                ->withInput()
                ->with('error', 'Error creating appointment: ' . $e->getMessage());
        }
    }

    private function processExcelFile($file, $appointment)
    {
        try {
            \Log::info('Starting Excel file processing', [
                'appointment_id' => $appointment->id,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize()
            ]);
            
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            \Log::info('Excel file loaded', [
                'appointment_id' => $appointment->id,
                'total_rows' => count($rows)
            ]);
            
            // Skip header row
            array_shift($rows);
            
            $processedCount = 0;
            $skippedCount = 0;
            
            foreach ($rows as $index => $row) {
                \Log::info('Processing row', [
                    'appointment_id' => $appointment->id,
                    'row_index' => $index,
                    'row_data' => $row
                ]);
                
                if (empty($row[0]) && empty($row[1])) {
                    \Log::info('Skipping empty row', ['row_index' => $index]);
                    continue; // Skip empty rows
                }
                
                // Validate required fields
                if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3])) {
                    \Log::info('Skipping invalid row - missing required fields', [
                        'row_index' => $index,
                        'row_data' => $row
                    ]);
                    continue; // Skip invalid rows
                }
                
                $firstName = trim($row[0]);
                $lastName = trim($row[1]);
                $email = !empty($row[4]) ? trim($row[4]) : null;
                
                // Check for duplicate patients (same first name, last name, and email) for this specific appointment
                $existingPatientForAppointment = Patient::where('first_name', $firstName)
                    ->where('last_name', $lastName)
                    ->where('appointment_id', $appointment->id);
                
                if ($email) {
                    $existingPatientForAppointment = $existingPatientForAppointment->where('email', $email);
                } else {
                    $existingPatientForAppointment = $existingPatientForAppointment->whereNull('email');
                }
                
                $existingPatientForAppointment = $existingPatientForAppointment->first();
                
                if (!$existingPatientForAppointment) {
                    // Check if patient exists globally (across all appointments)
                    $globalExistingPatient = Patient::where('first_name', $firstName)
                        ->where('last_name', $lastName);
                    
                    if ($email) {
                        $globalExistingPatient = $globalExistingPatient->where('email', $email);
                    } else {
                        $globalExistingPatient = $globalExistingPatient->whereNull('email');
                    }
                    
                    $globalExistingPatient = $globalExistingPatient->first();
                    
                    if (!$globalExistingPatient) {
                        // Create new patient record
                        Patient::create([
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'age' => (int) $row[2],
                            'sex' => trim($row[3]),
                            'email' => $email,
                            'phone' => !empty($row[5]) ? trim($row[5]) : null,
                            'appointment_id' => $appointment->id,
                        ]);
                        $processedCount++;
                    } else {
                        // Patient exists globally but not for this appointment, create a new record for this appointment
                        Patient::create([
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'age' => (int) $row[2],
                            'sex' => trim($row[3]),
                            'email' => $email,
                            'phone' => !empty($row[5]) ? trim($row[5]) : null,
                            'appointment_id' => $appointment->id,
                        ]);
                        $processedCount++;
                    }
                } else {
                    // Patient already exists for this appointment, skip
                    $skippedCount++;
                }
            }
            
            // Get total patient count for this appointment
            $totalPatients = Patient::where('appointment_id', $appointment->id)->count();
            
            // Update appointment with patient data
            $appointment->update([
                'patients_data' => [
                    'count' => $totalPatients,
                    'processed' => $processedCount,
                    'skipped' => $skippedCount
                ]
            ]);
            
            \Log::info('Excel processing completed', [
                'appointment_id' => $appointment->id,
                'total_patients' => $totalPatients,
                'processed' => $processedCount,
                'skipped' => $skippedCount
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception('Error processing Excel file: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $appointment = Appointment::with('patients')->where('created_by', Auth::id())
            ->findOrFail($id);
        
        return view('company.appointments.show', compact('appointment'));
    }

    public function edit($id)
    {
        $appointment = Appointment::where('created_by', Auth::id())
            ->findOrFail($id);
        
        // Get medical tests grouped by category
        $medicalTestCategories = MedicalTestCategory::with(['medicalTests' => function($query) {
            $query->where('is_active', true)->orderBy('sort_order');
        }])->where('is_active', true)->orderBy('sort_order')->get();

        $timeSlots = [
            '8:00 AM', '8:30 AM', '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM',
            '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM', '1:00 PM', '1:30 PM',
            '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM', '4:00 PM'
        ];

        return view('company.appointments.edit', compact('appointment', 'medicalTestCategories', 'timeSlots'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::where('created_by', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'appointment_date' => 'required|date',
            'time_slot' => 'required|string',
            'medical_test_categories_id' => 'required|exists:medical_test_categories,id',
            'medical_test_id' => 'required|exists:medical_tests,id',
            'notes' => 'nullable|string',
        ]);

        // Check for duplicate appointment (same date, time slot, and created by same user, excluding current appointment)
        $existingAppointment = Appointment::where('appointment_date', $request->appointment_date)
            ->where('time_slot', $request->time_slot)
            ->where('created_by', Auth::id())
            ->where('id', '!=', $id)
            ->first();

        if ($existingAppointment) {
            return back()->withInput()->with('error', 'An appointment already exists for this date and time slot. Please choose a different time.');
        }

        // Validate category/test pairing and get price
        $selectedTest = MedicalTest::find($request->medical_test_id);
        if (!$selectedTest || (int) $selectedTest->medical_test_category_id !== (int) $request->medical_test_categories_id) {
            return back()->withInput()->withErrors(['medical_test_id' => 'Selected medical test does not belong to the chosen category.']);
        }
        $totalPrice = $selectedTest->price ?? 0;

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'time_slot' => $request->time_slot,
            'medical_test_categories_id' => $request->medical_test_categories_id,
            'medical_test_id' => $request->medical_test_id,
            'total_price' => $totalPrice,
            'notes' => $request->notes,
        ]);

        return redirect()->route('company.appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::where('created_by', Auth::id())
            ->findOrFail($id);
        
        $appointment->delete();

        return redirect()->route('company.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}