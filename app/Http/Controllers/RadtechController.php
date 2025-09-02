<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PreEmploymentRecord;
use App\Models\MedicalChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RadtechController extends Controller
{
    /**
     * Show the radtech dashboard
     */
    public function dashboard()
    {
        // Get pre-employment records
        $preEmployments = PreEmploymentRecord::latest()->take(5)->get();
        $preEmploymentCount = PreEmploymentRecord::count();

        // Get patients for annual physical
        $patients = Patient::latest()->take(5)->get();
        $patientCount = Patient::count();

        // Get appointments
        $appointments = Appointment::with('patients')->latest()->take(5)->get();
        $appointmentCount = Appointment::count();

        return view('radtech.dashboard', compact(
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
        
        return view('radtech.medical-checklist', compact('medicalChecklist', 'preEmploymentRecord', 'examinationType'));
    }

    /**
     * Show medical checklist for annual physical
     */
    public function showMedicalChecklistAnnualPhysical($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $medicalChecklist = MedicalChecklist::where('patient_id', $patientId)->first();
        $examinationType = 'annual-physical';
        
        return view('radtech.medical-checklist', compact('medicalChecklist', 'patient', 'examinationType'));
    }

    /**
     * Update medical checklist (add radtech initials)
     */
    public function updateMedicalChecklist(Request $request, $id)
    {
        $medicalChecklist = MedicalChecklist::findOrFail($id);
        
        $validated = $request->validate([
            'xray_done_by' => 'required|string|max:100',
            'xray_date' => 'required|date',
            'xray_notes' => 'nullable|string',
        ]);

        $validated['radtech_id'] = Auth::id();
        
        $medicalChecklist->update($validated);

        return redirect()->back()->with('success', 'X-ray information updated successfully.');
    }
}
