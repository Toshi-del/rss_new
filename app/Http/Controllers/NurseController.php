<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Message;
use App\Models\Patient;
use App\Models\PreEmploymentRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NurseController extends Controller
{
    /**
     * Show the nurse dashboard
     */
    public function dashboard()
    {
        // Get patients
        $patients = Patient::latest()->take(5)->get();
        $patientCount = Patient::count();

        // Get appointments
        $appointments = Appointment::with('patients')->latest()->take(5)->get();
        $appointmentCount = Appointment::count();

        // Get pre-employment records
        $preEmployments = PreEmploymentRecord::latest()->take(5)->get();
        $preEmploymentCount = PreEmploymentRecord::count();

        return view('nurse.dashboard', compact(
            'patients',
            'patientCount',
            'appointments',
            'appointmentCount',
            'preEmployments',
            'preEmploymentCount'
        ));
    }





    /**
     * Show pre-employment records
     */
    public function preEmployment()
    {
        $preEmployments = PreEmploymentRecord::latest()->get();
        
        return view('nurse.pre-employment', compact('preEmployments'));
    }

    /**
     * Show annual physical examination patients
     */
    public function annualPhysical()
    {
        $patients = Patient::latest()->get();
        
        return view('nurse.annual-physical', compact('patients'));
    }

    /**
     * Show pre-employment edit form
     */
    public function editPreEmployment($id)
    {
        $preEmployment = \App\Models\PreEmploymentExamination::with('preEmploymentRecord')->findOrFail($id);
        
        return view('nurse.pre-employment-edit', compact('preEmployment'));
    }

    /**
     * Update pre-employment examination
     */
    public function updatePreEmployment(Request $request, $id)
    {
        $preEmployment = \App\Models\PreEmploymentExamination::findOrFail($id);
        
        $validated = $request->validate([
            'illness_history' => 'nullable|string',
            'accidents_operations' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'family_history' => 'nullable|array',
            'personal_habits' => 'nullable|array',
            'physical_exam' => 'nullable|array',
            'skin_marks' => 'nullable|string',
            'visual' => 'nullable|string',
            'ishihara_test' => 'nullable|string',
            'findings' => 'nullable|string',
            'lab_report' => 'nullable|array',
            'physical_findings' => 'nullable|array',
            'lab_findings' => 'nullable|array',
            'ecg' => 'nullable|string',
        ]);

        $preEmployment->update($validated);

        return redirect()->back()->with('success', 'Pre-employment examination updated successfully.');
    }

    /**
     * Show annual physical edit form
     */
    public function editAnnualPhysical($id)
    {
        $annualPhysical = \App\Models\AnnualPhysicalExamination::with('patient')->findOrFail($id);
        
        return view('nurse.annual-physical-edit', compact('annualPhysical'));
    }

    /**
     * Update annual physical examination
     */
    public function updateAnnualPhysical(Request $request, $id)
    {
        $annualPhysical = \App\Models\AnnualPhysicalExamination::findOrFail($id);
        
        $validated = $request->validate([
            'illness_history' => 'nullable|string',
            'accidents_operations' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'family_history' => 'nullable|array',
            'personal_habits' => 'nullable|array',
            'physical_exam' => 'nullable|array',
            'skin_marks' => 'nullable|string',
            'visual' => 'nullable|string',
            'ishihara_test' => 'nullable|string',
            'findings' => 'nullable|string',
            'lab_report' => 'nullable|array',
            'physical_findings' => 'nullable|array',
            'lab_findings' => 'nullable|array',
            'ecg' => 'nullable|string',
        ]);

        $annualPhysical->update($validated);

        return redirect()->back()->with('success', 'Annual physical examination updated successfully.');
    }

    /**
     * Show medical checklist for pre-employment
     */
    public function showMedicalChecklistPreEmployment($recordId)
    {
        $preEmploymentRecord = PreEmploymentRecord::findOrFail($recordId);
        $medicalChecklist = \App\Models\MedicalChecklist::where('pre_employment_record_id', $recordId)->first();
        $examinationType = 'pre-employment';
        
        return view('nurse.medical-checklist', compact('medicalChecklist', 'preEmploymentRecord', 'examinationType'));
    }

    /**
     * Show medical checklist for annual physical
     */
    public function showMedicalChecklistAnnualPhysical($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $annualPhysicalExamination = \App\Models\AnnualPhysicalExamination::where('patient_id', $patientId)->first();
        $medicalChecklist = \App\Models\MedicalChecklist::where('annual_physical_examination_id', $annualPhysicalExamination->id ?? 0)->first();
        $examinationType = 'annual-physical';
        
        return view('nurse.medical-checklist', compact('medicalChecklist', 'patient', 'annualPhysicalExamination', 'examinationType'));
    }

    /**
     * Store medical checklist
     */
    public function storeMedicalChecklist(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'age' => 'required|integer',
            'number' => 'nullable|string',
            'examination_type' => 'required|string',
            'pre_employment_record_id' => 'nullable|integer',
            'patient_id' => 'nullable|integer',
            'annual_physical_examination_id' => 'nullable|integer',
            'chest_xray_done_by' => 'nullable|string',
            'stool_exam_done_by' => 'nullable|string',
            'urinalysis_done_by' => 'nullable|string',
            'drug_test_done_by' => 'nullable|string',
            'blood_extraction_done_by' => 'nullable|string',
            'ecg_done_by' => 'nullable|string',
            'physical_exam_done_by' => 'nullable|string',
            'optional_exam' => 'nullable|string',
            'nurse_signature' => 'nullable|string',
        ]);

        \App\Models\MedicalChecklist::create($validated);

        return redirect()->back()->with('success', 'Medical checklist created successfully.');
    }

    /**
     * Update medical checklist
     */
    public function updateMedicalChecklist(Request $request, $id)
    {
        $medicalChecklist = \App\Models\MedicalChecklist::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'age' => 'required|integer',
            'number' => 'nullable|string',
            'chest_xray_done_by' => 'nullable|string',
            'stool_exam_done_by' => 'nullable|string',
            'urinalysis_done_by' => 'nullable|string',
            'drug_test_done_by' => 'nullable|string',
            'blood_extraction_done_by' => 'nullable|string',
            'ecg_done_by' => 'nullable|string',
            'physical_exam_done_by' => 'nullable|string',
            'optional_exam' => 'nullable|string',
            'nurse_signature' => 'nullable|string',
        ]);

        $medicalChecklist->update($validated);

        return redirect()->back()->with('success', 'Medical checklist updated successfully.');
    }

    /**
     * Show nurse messages view
     */
    public function messages()
    {
        return view('nurse.messages');
    }

    /**
     * Get users that nurses can chat with (admin and doctor only)
     */
    public function chatUsers()
    {
        $currentUser = Auth::user();
        $users = User::whereIn('role', ['admin', 'doctor'])
            ->where('id', '!=', $currentUser->id)
            ->select('id', 'fname', 'lname', 'role', 'company')
            ->get();
        // Add unread message count for each user
        $usersWithUnread = $users->map(function($user) use ($currentUser) {
            $unreadCount = Message::where('sender_id', $user->id)
                ->where('receiver_id', $currentUser->id)
                ->whereNull('read_at')
                ->count();
            $user->unread_count = $unreadCount;
            return $user;
        });
        return response()->json([
            'current_user' => $currentUser->only(['id', 'fname', 'lname', 'role']),
            'filtered_users' => $usersWithUnread
        ]);
    }

    /**
     * Fetch messages for the current nurse
     */
    public function fetchMessages()
    {
        $userId = Auth::id();
        // Mark messages to this user as delivered if not set
        Message::whereNull('delivered_at')
            ->where('receiver_id', $userId)
            ->update(['delivered_at' => now()]);
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json($messages);
    }

    /**
     * Send a message (nurse can only send to admin or doctor)
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);
        $receiver = User::find($request->receiver_id);
        if (!in_array($receiver->role, ['admin', 'doctor'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);
        return response()->json($message);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id'
        ]);
        Message::where('sender_id', $request->sender_id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }
}
