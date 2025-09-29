<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Message;
use App\Models\Patient;
use App\Models\PreEmploymentRecord;
use App\Models\User;
use App\Models\OpdExamination;
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
        $patients = Patient::where('status', 'approved')->latest()->take(5)->get();
        $patientCount = Patient::where('status', 'approved')->count();

        // Get appointments with linked medical tests
        $appointments = Appointment::with(['patients', 'medicalTestCategory', 'medicalTest'])->latest()->take(5)->get();
        $appointmentCount = Appointment::count();

        // Get pre-employment records
        $preEmployments = PreEmploymentRecord::with(['medicalTestCategory','medicalTest'])
            ->where('status', 'approved')->latest()->take(5)->get();
        $preEmploymentCount = PreEmploymentRecord::where('status', 'approved')->count();

        // Get OPD walk-in patients (users with 'opd' role)
        $opdPatients = User::where('role', 'opd')->latest()->take(5)->get();
        $opdCount = User::where('role', 'opd')->count();

        // Get annual physical count
        $annualPhysicalCount = Patient::where('status', 'approved')
            ->whereDoesntHave('annualPhysicalExamination', function ($q) {
                $q->whereIn('status', ['completed', 'sent_to_company']);
            })
            ->count();

        return view('nurse.dashboard', compact(
            'patients',
            'patientCount',
            'appointments',
            'appointmentCount',
            'preEmployments',
            'preEmploymentCount',
            'opdPatients',
            'opdCount',
            'annualPhysicalCount'
        ));
    }





    /**
     * Show pre-employment records
     */
    public function preEmployment()
    {
        $preEmployments = PreEmploymentRecord::with(['medicalTestCategory','medicalTest'])
            ->whereIn('status', ['Approved', 'approved'])
            ->whereDoesntHave('preEmploymentExamination', function ($q) {
                $q->whereIn('status', ['Approved', 'sent_to_company']);
            })
            ->latest()->get();
        
        return view('nurse.pre-employment', compact('preEmployments'));
    }

    /**
     * Show annual physical examination patients
     */
    public function annualPhysical()
    {
        $patients = Patient::where('status', 'approved')
            ->whereDoesntHave('annualPhysicalExamination', function ($q) {
                $q->whereIn('status', ['completed', 'sent_to_company']);
            })
            ->latest()->get();
        
        return view('nurse.annual-physical', compact('patients'));
    }

    /** Send nurse annual physical to doctor */
    public function sendAnnualPhysicalToDoctor($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $exam = \App\Models\AnnualPhysicalExamination::firstOrCreate(
            ['patient_id' => $patientId],
            [
                'user_id' => Auth::id(),
                'name' => $patient->full_name,
                'date' => now()->toDateString(),
                'status' => 'Pending',
            ]
        );
        // Mark as completed from nurse to send up to doctor
        $exam->update(['status' => 'completed']);
        return redirect()->route('nurse.annual-physical')->with('success', 'Annual physical sent to doctor.');
    }

    /** Send nurse pre-employment to doctor */
    public function sendPreEmploymentToDoctor($recordId)
    {
        $record = PreEmploymentRecord::findOrFail($recordId);
        $exam = \App\Models\PreEmploymentExamination::firstOrCreate(
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
        return redirect()->route('nurse.pre-employment')->with('success', 'Pre-employment sent to doctor.');
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

        return redirect()->route('nurse.pre-employment')->with('success', 'Pre-employment examination saved. Not yet sent to doctor.');
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

        return redirect()->route('nurse.annual-physical')->with('success', 'Annual physical examination updated successfully.');
    }

    /**
     * Show medical checklist for pre-employment
     */
    public function showMedicalChecklistPreEmployment($recordId)
    {
        $preEmploymentRecord = PreEmploymentRecord::findOrFail($recordId);
        $medicalChecklist = \App\Models\MedicalChecklist::where('pre_employment_record_id', $recordId)->first();
        $examinationType = 'pre-employment';
        $number = 'EMP-' . str_pad($preEmploymentRecord->id, 4, '0', STR_PAD_LEFT);
        $name = trim(($preEmploymentRecord->first_name ?? '') . ' ' . ($preEmploymentRecord->last_name ?? ''));
        $age = $preEmploymentRecord->age ?? null;
        $date = now()->format('Y-m-d');
        
        return view('nurse.medical-checklist', compact('medicalChecklist', 'preEmploymentRecord', 'examinationType', 'number', 'name', 'age', 'date'));
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
            'opd_examination_id' => 'nullable|integer',
            'physical_exam_done_by' => 'nullable|string',
            'optional_exam' => 'nullable|string',
            'nurse_signature' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        \App\Models\MedicalChecklist::create($validated);

        // Redirect out of the checklist page back to the appropriate list
        $redirectRoute = match($validated['examination_type']) {
            'pre-employment' => 'nurse.pre-employment',
            'annual-physical' => 'nurse.annual-physical',
            'opd' => 'nurse.opd',
            default => 'nurse.dashboard'
        };

        return redirect()->route($redirectRoute)->with('success', 'Medical checklist created successfully.');
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
            'physical_exam_done_by' => 'nullable|string',
            'optional_exam' => 'nullable|string',
            'nurse_signature' => 'nullable|string',
        ]);

        $medicalChecklist->update($validated);

        // Redirect out of the checklist page back to the appropriate list
        $redirectRoute = match($request->input('examination_type')) {
            'pre-employment' => 'nurse.pre-employment',
            'annual-physical' => 'nurse.annual-physical',
            'opd' => 'nurse.opd',
            default => 'nurse.dashboard'
        };

        return redirect()->route($redirectRoute)->with('success', 'Medical checklist updated successfully.');
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

    /**
     * Show create pre-employment examination form
     */
    public function createPreEmployment(Request $request)
    {
        $recordId = $request->query('record_id');
        $preEmploymentRecord = PreEmploymentRecord::with(['medicalTest'])->findOrFail($recordId);
        
        return view('nurse.pre-employment-create', compact('preEmploymentRecord'));
    }

    /**
     * Store new pre-employment examination
     */
    public function storePreEmployment(Request $request)
    {
        // Get pre-employment record with medical test information to determine validation rules
        $preEmploymentRecord = PreEmploymentRecord::with(['medicalTest'])->findOrFail($request->pre_employment_record_id);
        $medicalTestName = $preEmploymentRecord->medicalTest->name ?? '';
        $isAudiometryIshiharaOnly = strtolower($medicalTestName) === 'audiometry and ishihara only';
        $showIshiharaTest = in_array(strtolower($medicalTestName), [
            'audiometry and ishihara only',
            'pre-employment with drug test and audio and ishihara'
        ]);

        // Dynamic validation rules based on medical test type
        $validationRules = [
            'pre_employment_record_id' => 'required|exists:pre_employment_records,id',
            'illness_history' => 'nullable|string',
            'accidents_operations' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'family_history' => 'nullable|array',
            'personal_habits' => 'nullable|array',
            'physical_exam' => $isAudiometryIshiharaOnly ? 'nullable|array' : 'required|array',
            'physical_exam.temp' => $isAudiometryIshiharaOnly ? 'nullable|string' : 'required|string',
            'physical_exam.height' => $isAudiometryIshiharaOnly ? 'nullable|string' : 'required|string',
            'physical_exam.weight' => $isAudiometryIshiharaOnly ? 'nullable|string' : 'required|string',
            'physical_exam.heart_rate' => $isAudiometryIshiharaOnly ? 'nullable|string' : 'required|string',
            'skin_marks' => $isAudiometryIshiharaOnly ? 'nullable|string' : 'required|string',
            'visual' => $isAudiometryIshiharaOnly ? 'nullable|string' : 'required|string',
            'ishihara_test' => $showIshiharaTest ? 'required|string' : 'nullable|string',
            'findings' => 'required|string',
            'lab_report' => 'nullable|array',
            'physical_findings' => 'nullable|array',
            'lab_findings' => 'nullable|array',
            'ecg' => 'nullable|string',
        ];

        // Dynamic validation messages
        $validationMessages = [
            'findings.required' => 'Findings are required.',
        ];

        // Add validation messages only for fields that are required
        if (!$isAudiometryIshiharaOnly) {
            $validationMessages = array_merge($validationMessages, [
                'physical_exam.required' => 'Physical examination data is required.',
                'physical_exam.temp.required' => 'Temperature is required.',
                'physical_exam.height.required' => 'Height is required.',
                'physical_exam.weight.required' => 'Weight is required.',
                'physical_exam.heart_rate.required' => 'Heart rate is required.',
                'skin_marks.required' => 'Skin marks/tattoos are required.',
                'visual.required' => 'Visual acuity is required.',
            ]);
        }

        // Add Ishihara test validation message only if it's required
        if ($showIshiharaTest) {
            $validationMessages['ishihara_test.required'] = 'Ishihara test is required.';
        }

        $validated = $request->validate($validationRules, $validationMessages);

        // Auto-populate linkage fields from the source record
        $record = PreEmploymentRecord::findOrFail($validated['pre_employment_record_id']);
        $validated['user_id'] = $record->created_by;
        $validated['name'] = $record->first_name . ' ' . $record->last_name;
        $validated['company_name'] = $record->company_name;
        $validated['date'] = now()->toDateString();
        // Ensure new examinations are not sent to the doctor on create
        $validated['status'] = 'Pending';
        
        \App\Models\PreEmploymentExamination::create($validated);

        return redirect()->route('nurse.pre-employment')->with('success', 'Pre-employment examination saved. Not yet sent to doctor.');
    }

    /**
     * Show create annual physical examination form
     */
    public function createAnnualPhysical(Request $request)
    {
        $patientId = $request->query('patient_id');
        $patient = Patient::with(['appointment.medicalTest'])->findOrFail($patientId);
        
        return view('nurse.annual-physical-create', compact('patient'));
    }

    /**
     * Store new annual physical examination
     */
    public function storeAnnualPhysical(Request $request)
    {
        // Get patient with medical test information to determine validation rules
        $patient = Patient::with(['appointment.medicalTest'])->findOrFail($request->patient_id);
        $medicalTestName = $patient->appointment->medicalTest->name ?? '';
        $isAnnualMedicalExam = in_array(strtolower($medicalTestName), [
            'annual medical examination',
            'annual medical examination with drug test',
            'annual medical examination with drug test and ecg'
        ]);

        // Dynamic validation rules based on medical test type
        $validationRules = [
            'patient_id' => 'required|exists:patients,id',
            'illness_history' => 'nullable|string',
            'accidents_operations' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'family_history' => 'nullable|array',
            'personal_habits' => 'nullable|array',
            'physical_exam' => 'required|array',
            'physical_exam.temp' => 'required|string',
            'physical_exam.height' => 'required|string',
            'physical_exam.heart_rate' => 'required|string',
            'physical_exam.weight' => 'required|string',
            'skin_marks' => 'required|string',
            'visual' => 'required|string',
            'ishihara_test' => $isAnnualMedicalExam ? 'nullable|string' : 'required|string',
            'findings' => 'required|string',
            'lab_report' => 'nullable|array',
            'physical_findings' => 'nullable|array',
            'lab_findings' => 'nullable|array',
            'ecg' => 'nullable|string',
        ];

        // Dynamic validation messages
        $validationMessages = [
            'physical_exam.required' => 'Physical examination data is required.',
            'physical_exam.temp.required' => 'Temperature is required.',
            'physical_exam.height.required' => 'Height is required.',
            'physical_exam.heart_rate.required' => 'Heart rate is required.',
            'physical_exam.weight.required' => 'Weight is required.',
            'skin_marks.required' => 'Skin identification marks are required.',
            'visual.required' => 'Visual examination is required.',
            'findings.required' => 'Findings are required.',
        ];

        // Add Ishihara test validation message only if it's required
        if (!$isAnnualMedicalExam) {
            $validationMessages['ishihara_test.required'] = 'Ishihara test is required.';
        }

        $validated = $request->validate($validationRules, $validationMessages);

        // Auto-populate linkage fields from the patient
        $patient = Patient::findOrFail($validated['patient_id']);
        $validated['user_id'] = Auth::id();
        $validated['name'] = $patient->full_name;
        $validated['date'] = now()->toDateString();
        $validated['status'] = 'Pending';
        
        \App\Models\AnnualPhysicalExamination::create($validated);

        return redirect()->route('nurse.annual-physical')->with('success', 'Annual physical examination created successfully.');
    }

    /**
     * Show OPD walk-in patients
     */
    public function opd()
    {
        $opdPatients = User::where('role', 'opd')
            ->whereDoesntHave('opdExamination', function ($q) {
                $q->whereIn('status', ['completed', 'sent_to_company']);
            })
            ->latest()->get();
        
        return view('nurse.opd', compact('opdPatients'));
    }

    /**
     * Show create OPD examination form
     */
    public function createOpdExamination(Request $request)
    {
        $userId = $request->query('user_id');
        $opdPatient = User::where('role', 'opd')->findOrFail($userId);
        
        return view('nurse.opd-create', compact('opdPatient'));
    }

    /**
     * Store new OPD examination
     */
    public function storeOpdExamination(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'illness_history' => 'nullable|string',
            'accidents_operations' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'family_history' => 'nullable|array',
            'personal_habits' => 'nullable|array',
            'physical_exam' => 'required|array',
            'physical_exam.temp' => 'required|string',
            'physical_exam.height' => 'required|string',
            'physical_exam.weight' => 'required|string',
            'physical_exam.heart_rate' => 'required|string',
            'skin_marks' => 'required|string',
            'visual' => 'required|string',
            'ishihara_test' => 'required|string',
            'findings' => 'required|string',
            'lab_report' => 'nullable|array',
            'physical_findings' => 'nullable|array',
            'lab_findings' => 'nullable|array',
            'ecg' => 'nullable|string',
        ], [
            'physical_exam.required' => 'Physical examination data is required.',
            'physical_exam.temp.required' => 'Temperature is required.',
            'physical_exam.height.required' => 'Height is required.',
            'physical_exam.weight.required' => 'Weight is required.',
            'physical_exam.heart_rate.required' => 'Heart rate is required.',
            'skin_marks.required' => 'Skin marks/tattoos are required.',
            'visual.required' => 'Visual acuity is required.',
            'ishihara_test.required' => 'Ishihara test is required.',
            'findings.required' => 'Findings are required.',
        ]);

        // Auto-populate linkage fields from the OPD patient
        $opdPatient = User::findOrFail($validated['user_id']);
        $validated['name'] = trim(($opdPatient->fname ?? '') . ' ' . ($opdPatient->lname ?? ''));
        $validated['date'] = now()->toDateString();
        $validated['status'] = 'pending';
        
        OpdExamination::create($validated);

        return redirect()->route('nurse.opd')->with('success', 'OPD examination created successfully.');
    }

    /**
     * Show edit OPD examination form
     */
    public function editOpdExamination($id)
    {
        $opdExamination = OpdExamination::with('user')->findOrFail($id);
        
        return view('nurse.opd-edit', compact('opdExamination'));
    }

    /**
     * Update OPD examination
     */
    public function updateOpdExamination(Request $request, $id)
    {
        $opdExamination = OpdExamination::findOrFail($id);
        
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

        $opdExamination->update($validated);

        return redirect()->route('nurse.opd')->with('success', 'OPD examination updated successfully.');
    }

    /**
     * Send OPD examination to doctor
     */
    public function sendOpdToDoctor($userId)
    {
        $opdPatient = User::where('role', 'opd')->findOrFail($userId);
        $exam = OpdExamination::firstOrCreate(
            ['user_id' => $userId],
            [
                'name' => trim(($opdPatient->fname ?? '') . ' ' . ($opdPatient->lname ?? '')),
                'date' => now()->toDateString(),
                'status' => 'pending',
            ]
        );
        
        // Mark as completed from nurse to send up to doctor
        $exam->update(['status' => 'completed']);
        
        return redirect()->route('nurse.opd')->with('success', 'OPD examination sent to doctor.');
    }

    /**
     * Show medical checklist for OPD
     */
    public function showMedicalChecklistOpd($userId)
    {
        $opdPatient = User::where('role', 'opd')->findOrFail($userId);
        $opdExamination = OpdExamination::where('user_id', $userId)->first();
        $medicalChecklist = \App\Models\MedicalChecklist::where('opd_examination_id', $opdExamination->id ?? 0)->first();
        $examinationType = 'opd';
        $number = 'OPD-' . str_pad($opdPatient->id, 4, '0', STR_PAD_LEFT);
        $name = trim(($opdPatient->fname ?? '') . ' ' . ($opdPatient->lname ?? ''));
        $age = $opdPatient->age ?? null;
        $date = now()->format('Y-m-d');
        
        return view('nurse.medical-checklist', compact('medicalChecklist', 'opdPatient', 'opdExamination', 'examinationType', 'number', 'name', 'age', 'date'));
    }
}
