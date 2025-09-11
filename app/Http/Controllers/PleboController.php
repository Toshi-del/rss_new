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
        $validated = $request->validate([
            'examination_type' => 'required|in:pre-employment,annual-physical',
            'pre_employment_record_id' => 'required_if:examination_type,pre-employment|nullable|exists:pre_employment_records,id',
            'patient_id' => 'required_if:examination_type,annual-physical|nullable|exists:patients,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'age' => 'required|integer|min:0',
            'number' => 'nullable|string|max:255',
            'xray_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:25000',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('xray_image')) {
            $path = $request->file('xray_image')->store('xray-images', 'public');
            $validated['xray_image_path'] = $path;
        }

        if ($validated['examination_type'] === 'pre-employment' && $request->filled('pre_employment_record_id')) {
            $validated['pre_employment_record_id'] = (int)$request->input('pre_employment_record_id');
        }
        if ($validated['examination_type'] === 'annual-physical') {
            if ($request->filled('annual_physical_examination_id')) {
                $validated['annual_physical_examination_id'] = (int)$request->input('annual_physical_examination_id');
            }
            if ($request->filled('patient_id')) {
                $validated['patient_id'] = (int)$request->input('patient_id');
            }
        }

        $medicalChecklist = MedicalChecklist::create($validated);

        return redirect()->back()->with('success', 'Medical checklist created successfully.');
    }

    /**
     * Update an existing medical checklist
     */
    public function updateMedicalChecklist(Request $request, $id)
    {
        $medicalChecklist = MedicalChecklist::findOrFail($id);

        $validated = $request->validate([
            'chest_xray_done_by' => 'nullable|string|max:100',
            'xray_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:25000',
        ]);

        if ($request->hasFile('xray_image') && $request->file('xray_image')->isValid()) {
            $path = $request->file('xray_image')->store('xray-images', 'public');
            $validated['xray_image_path'] = $path;
        }

        if (array_key_exists('chest_xray_done_by', $validated)) {
            $medicalChecklist->chest_xray_done_by = $validated['chest_xray_done_by'];
        }
        if (array_key_exists('xray_image_path', $validated)) {
            $medicalChecklist->xray_image_path = $validated['xray_image_path'];
        }
        $medicalChecklist->save();

        return redirect()->back()->with('success', 'X-ray information updated successfully.');
    }
}


