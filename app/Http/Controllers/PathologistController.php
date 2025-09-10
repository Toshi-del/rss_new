<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\PreEmploymentRecord;
use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;

class PathologistController extends Controller
{
    public function dashboard()
    {
        // Fetch approved items not yet submitted to the doctor
        $patients = Patient::where('status', 'approved')
            ->whereDoesntHave('annualPhysicalExamination', function ($q) {
                $q->whereIn('status', ['completed', 'sent_to_company']);
            })
            ->latest()->take(20)->get();

        $preEmployments = PreEmploymentRecord::where('status', 'approved')
            ->whereDoesntHave('preEmploymentExamination', function ($q) {
                $q->whereIn('status', ['Approved', 'sent_to_company']);
            })
            ->latest()->take(20)->get();

        // Stub metrics/sections for now
        $pendingLabRequests = 0;
        $bloodSamplesInProcess = 0;
        $resultsToReview = 0;
        $bloodChemistries = [];
        $labRequests = [];

        return view('pathologist.dashboard', compact(
            'pendingLabRequests',
            'bloodSamplesInProcess',
            'resultsToReview',
            'bloodChemistries',
            'labRequests',
            'patients',
            'preEmployments'
        ));
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
        return redirect()->route('pathologist.dashboard')->with('success', 'Annual physical sent to doctor.');
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
        return redirect()->route('pathologist.dashboard')->with('success', 'Pre-employment sent to doctor.');
    }
}


