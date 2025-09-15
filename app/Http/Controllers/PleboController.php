<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PreEmploymentRecord;
use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
use App\Models\MedicalChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PleboController extends Controller
{
    /**
     * Show the plebo dashboard
     */
    public function dashboard()
    {
        $preEmployments = PreEmploymentRecord::where('status', 'approved')->latest()->take(5)->get();
        $preEmploymentCount = PreEmploymentRecord::where('status', 'approved')->count();

        $patients = Patient::where('status', 'approved')->latest()->take(5)->get();
        $patientCount = Patient::where('status', 'approved')->count();

        $appointments = Appointment::with('patients')->latest()->take(5)->get();
        $appointmentCount = Appointment::count();

        return view('plebo.dashboard', compact(
            'preEmployments',
            'preEmploymentCount',
            'patients',
            'patientCount',
            'appointments',
            'appointmentCount'
        ));
    }

    /**
     * Show medical checklist for pre-employment
     */
    public function showMedicalChecklistPreEmployment($recordId)
    {
        $preEmploymentRecord = PreEmploymentRecord::findOrFail($recordId);
        $medicalChecklist = MedicalChecklist::where('pre_employment_record_id', $recordId)->first();
        $examinationType = 'pre-employment';
        $number = 'EMP-' . str_pad($preEmploymentRecord->id, 4, '0', STR_PAD_LEFT);
        $name = trim(($preEmploymentRecord->first_name ?? '') . ' ' . ($preEmploymentRecord->last_name ?? ''));
        $age = $preEmploymentRecord->age ?? null;
        $date = now()->format('Y-m-d');

        return view('plebo.medical-checklist', compact('medicalChecklist', 'preEmploymentRecord', 'examinationType', 'number', 'name', 'age', 'date'));
    }

    /**
     * Show medical checklist for annual physical
     */
    public function showMedicalChecklistAnnualPhysical($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $medicalChecklist = MedicalChecklist::where('patient_id', $patientId)->first();
        $examinationType = 'annual-physical';
        $number = 'PAT-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
        $name = trim(($patient->first_name ?? '') . ' ' . ($patient->last_name ?? ''));
        $age = $patient->age ?? null;
        $date = now()->format('Y-m-d');

        return view('plebo.medical-checklist', compact('medicalChecklist', 'patient', 'examinationType', 'number', 'name', 'age', 'date'));
    }

    /**
     * List pre-employment records for plebo
     */
    public function preEmployment()
    {
        $preEmployments = PreEmploymentRecord::where('status', 'approved')
            ->whereDoesntHave('preEmploymentExamination', function ($q) {
                $q->whereIn('status', ['Approved', 'sent_to_company']);
            })
            ->latest()->paginate(15);
        return view('plebo.pre-employment', compact('preEmployments'));
    }

    /**
     * List annual physical patients for plebo
     */
    public function annualPhysical()
    {
        $patients = Patient::where('status', 'approved')
            ->whereDoesntHave('annualPhysicalExamination', function ($q) {
                $q->whereIn('status', ['completed', 'sent_to_company']);
            })
            ->latest()->paginate(15);
        return view('plebo.annual-physical', compact('patients'));
    }

    public function sendAnnualPhysicalToDoctor($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        
        // Check if medical checklist exists
        $hasMedicalChecklist = MedicalChecklist::where('patient_id', $patientId)->exists();
        
        if (!$hasMedicalChecklist) {
            return redirect()->route('plebo.annual-physical')->with('error', 'Please complete the medical checklist before sending to doctor.');
        }
        
        $exam = AnnualPhysicalExamination::firstOrCreate(
            ['patient_id' => $patientId],
            [
                'user_id' => Auth::id(),
                'name' => $patient->full_name,
                'date' => now()->toDateString(),
                'status' => 'Pending',
            ]
        );
        $exam->update(['status' => 'completed']);
        return redirect()->route('plebo.annual-physical')->with('success', 'Annual physical sent to doctor.');
    }

    public function sendPreEmploymentToDoctor($recordId)
    {
        $record = PreEmploymentRecord::findOrFail($recordId);
        
        // Check if medical checklist exists
        $hasMedicalChecklist = MedicalChecklist::where('pre_employment_record_id', $recordId)->exists();
        
        if (!$hasMedicalChecklist) {
            return redirect()->route('plebo.pre-employment')->with('error', 'Please complete the medical checklist before sending to doctor.');
        }
        
        $exam = PreEmploymentExamination::firstOrCreate(
            ['pre_employment_record_id' => $recordId],
            [
                'user_id' => $record->created_by,
                'name' => $record->full_name,
                'company_name' => $record->company_name,
                'date' => now()->toDateString(),
                'status' => $record->status,
            ]
        );
        $exam->update(['status' => 'Approved']);
        return redirect()->route('plebo.pre-employment')->with('success', 'Pre-employment sent to doctor.');
    }

    /**
     * Store a new medical checklist
     */
    public function storeMedicalChecklist(Request $request)
    {
        $data = $request->validate([
            'examination_type' => 'required|in:pre_employment,annual_physical',
            'pre_employment_record_id' => 'nullable|exists:pre_employment_records,id',
            'patient_id' => 'nullable|exists:patients,id',
            'annual_physical_examination_id' => 'nullable|exists:annual_physical_examinations,id',
            'name' => 'required|string',
            'age' => 'required|integer',
            'number' => 'nullable|string',
            'date' => 'required|date',
            // Individual examination fields - only done_by fields
            'chest_xray_done_by' => 'nullable|string',
            'stool_exam_done_by' => 'nullable|string',
            'urinalysis_done_by' => 'nullable|string',
            'drug_test_done_by' => 'nullable|string',
            'blood_extraction_done_by' => 'nullable|string',
            'ecg_done_by' => 'nullable|string',
            'physical_exam_done_by' => 'nullable|string',
            'optional_exam' => 'nullable|string',
            'special_notes' => 'nullable|string',
            'phlebotomist_name' => 'nullable|string',
            'phlebotomist_signature' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        
        // Debug logging
        \Log::info('Medical Checklist Data:', $data);

        // Find existing medical checklist or create new one
        $medicalChecklist = null;
        
        if ($data['examination_type'] === 'pre_employment' && $data['pre_employment_record_id']) {
            $medicalChecklist = MedicalChecklist::where('pre_employment_record_id', $data['pre_employment_record_id'])->first();
        } elseif ($data['examination_type'] === 'annual_physical' && $data['patient_id']) {
            $medicalChecklist = MedicalChecklist::where('patient_id', $data['patient_id'])->first();
        }

        try {
            if ($medicalChecklist) {
                $medicalChecklist->update($data);
                \Log::info('Medical Checklist Updated:', ['id' => $medicalChecklist->id, 'data' => $data]);
            } else {
                $medicalChecklist = MedicalChecklist::create($data);
                \Log::info('Medical Checklist Created:', ['id' => $medicalChecklist->id, 'data' => $data]);
            }

            // Redirect based on examination type
            if ($data['examination_type'] === 'pre_employment') {
                return redirect()->route('plebo.pre-employment')->with('success', 'Medical checklist saved successfully.');
            } else {
                return redirect()->route('plebo.annual-physical')->with('success', 'Medical checklist saved successfully.');
            }
        } catch (\Exception $e) {
            \Log::error('Medical Checklist Save Error:', ['error' => $e->getMessage(), 'data' => $data]);
            return redirect()->back()->with('error', 'Failed to save medical checklist: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing medical checklist
     */
    public function updateMedicalChecklist(Request $request, $id)
    {
        $medicalChecklist = MedicalChecklist::findOrFail($id);

        $data = $request->validate([
            'examination_type' => 'required|in:pre_employment,annual_physical',
            'pre_employment_record_id' => 'nullable|exists:pre_employment_records,id',
            'patient_id' => 'nullable|exists:patients,id',
            'annual_physical_examination_id' => 'nullable|exists:annual_physical_examinations,id',
            'name' => 'required|string',
            'age' => 'required|integer',
            'number' => 'nullable|string',
            'date' => 'required|date',
            // Individual examination fields - only done_by fields
            'chest_xray_done_by' => 'nullable|string',
            'stool_exam_done_by' => 'nullable|string',
            'urinalysis_done_by' => 'nullable|string',
            'drug_test_done_by' => 'nullable|string',
            'blood_extraction_done_by' => 'nullable|string',
            'ecg_done_by' => 'nullable|string',
            'physical_exam_done_by' => 'nullable|string',
            'optional_exam' => 'nullable|string',
            'special_notes' => 'nullable|string',
            'phlebotomist_name' => 'nullable|string',
            'phlebotomist_signature' => 'nullable|string',
        ]);

        $medicalChecklist->update($data);

        // Redirect based on examination type
        if ($data['examination_type'] === 'pre_employment') {
            return redirect()->route('plebo.pre-employment')->with('success', 'Medical checklist updated successfully.');
        } else {
            return redirect()->route('plebo.annual-physical')->with('success', 'Medical checklist updated successfully.');
        }
    }
}


