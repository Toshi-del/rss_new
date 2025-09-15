<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PreEmploymentRecord;
use App\Models\MedicalChecklist;
use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EcgtechController extends Controller
{
    /**
     * Show the ECG tech dashboard
     */
    public function dashboard()
    {
        // Get pre-employment records not yet submitted
        $preEmployments = PreEmploymentRecord::where('status', 'approved')
            ->whereDoesntHave('preEmploymentExamination', function ($q) {
                $q->whereIn('status', ['Approved', 'sent_to_company']);
            })
            ->latest()->take(5)->get();
        $preEmploymentCount = PreEmploymentRecord::where('status', 'approved')->count();

        // Get patients for annual physical not yet submitted
        $patients = Patient::where('status', 'approved')
            ->whereDoesntHave('annualPhysicalExamination', function ($q) {
                $q->whereIn('status', ['completed', 'sent_to_company']);
            })
            ->latest()->take(5)->get();
        $patientCount = Patient::where('status', 'approved')->count();

        // Get ECG reports (simulated data for now)
        $ecgReports = collect([
            (object)['patient_name' => 'John Doe', 'date' => now()->format('Y-m-d'), 'ecg_result' => 'Normal', 'status' => 'completed'],
            (object)['patient_name' => 'Jane Smith', 'date' => now()->subDay()->format('Y-m-d'), 'ecg_result' => 'Abnormal', 'status' => 'completed'],
            (object)['patient_name' => 'Bob Johnson', 'date' => now()->subDays(2)->format('Y-m-d'), 'ecg_result' => 'Normal', 'status' => 'completed'],
        ]);
        $ecgReportCount = $ecgReports->count();

        return view('ecgtech.dashboard', compact(
            'preEmployments',
            'preEmploymentCount',
            'patients',
            'patientCount',
            'ecgReports',
            'ecgReportCount'
        ));
    }

    /**
     * Show pre-employment records for ECG tech
     */
    public function preEmployment()
    {
        $preEmployments = PreEmploymentRecord::where('status', 'approved')
            ->whereDoesntHave('preEmploymentExamination', function ($q) {
                $q->whereIn('status', ['Approved', 'sent_to_company']);
            })
            ->latest()->paginate(15);
        
        return view('ecgtech.pre-employment', compact('preEmployments'));
    }

    /**
     * Show annual physical patients for ECG tech
     */
    public function annualPhysical()
    {
        $patients = Patient::where('status', 'approved')
            ->whereDoesntHave('annualPhysicalExamination', function ($q) {
                $q->whereIn('status', ['completed', 'sent_to_company']);
            })
            ->latest()->paginate(15);
        
        return view('ecgtech.annual-physical', compact('patients'));
    }

    /**
     * Send ECG tech pre-employment to doctor
     */
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
        return redirect()->route('ecgtech.pre-employment')->with('success', 'Pre-employment sent to doctor.');
    }

    /**
     * Send ECG tech annual physical to doctor
     */
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
        // Mark as completed from ECG tech to send up to doctor
        $exam->update(['status' => 'completed']);
        return redirect()->route('ecgtech.annual-physical')->with('success', 'Annual physical sent to doctor.');
    }

    /**
     * Show medical checklist for pre-employment
     */
    public function showMedicalChecklistPreEmployment($recordId)
    {
        $record = PreEmploymentRecord::findOrFail($recordId);
        $medicalChecklist = MedicalChecklist::where('pre_employment_record_id', $recordId)->first();
        $examinationType = 'pre-employment';
        $number = 'PEM-' . str_pad($record->id, 4, '0', STR_PAD_LEFT);
        $name = trim(($record->first_name ?? '') . ' ' . ($record->last_name ?? ''));
        $age = $record->age ?? null;
        $date = now()->format('Y-m-d');

        return view('ecgtech.medical-checklist', compact('medicalChecklist', 'record', 'examinationType', 'number', 'name', 'age', 'date'));
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

        return view('ecgtech.medical-checklist', compact('medicalChecklist', 'patient', 'examinationType', 'number', 'name', 'age', 'date'));
    }

    /**
     * Show medical checklist page for pre-employment
     */
    public function showMedicalChecklistPagePreEmployment($recordId)
    {
        $record = PreEmploymentRecord::findOrFail($recordId);
        $medicalChecklist = MedicalChecklist::where('pre_employment_record_id', $recordId)->first();
        $examinationType = 'pre-employment';
        $number = 'PEM-' . str_pad($record->id, 4, '0', STR_PAD_LEFT);
        $name = trim(($record->first_name ?? '') . ' ' . ($record->last_name ?? ''));
        $age = $record->age ?? null;
        $date = now()->format('Y-m-d');

        return view('ecgtech.medical-checklist-page', compact('medicalChecklist', 'record', 'examinationType', 'number', 'name', 'age', 'date'));
    }

    /**
     * Show medical checklist page for annual physical
     */
    public function showMedicalChecklistPageAnnualPhysical($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $record = $patient; // For consistency with the blade template
        $medicalChecklist = MedicalChecklist::where('patient_id', $patientId)->first();
        $examinationType = 'annual-physical';
        $number = 'PAT-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
        $name = trim(($patient->first_name ?? '') . ' ' . ($patient->last_name ?? ''));
        $age = $patient->age ?? null;
        $date = now()->format('Y-m-d');

        return view('ecgtech.medical-checklist-page', compact('medicalChecklist', 'patient', 'record', 'examinationType', 'number', 'name', 'age', 'date'));
    }

    /**
     * Store medical checklist
     */
    public function storeMedicalChecklist(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'pre_employment_record_id' => 'nullable|exists:pre_employment_records,id',
            'examination_type' => 'required|in:annual-physical,pre-employment',
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'date' => 'required|date',
            'number' => 'nullable|string|max:255',
            
            
            // Done by fields (ECG Tech can only fill ECG)
            'chest_xray_done_by' => 'nullable|string|max:255',
            'stool_exam_done_by' => 'nullable|string|max:255',
            'urinalysis_done_by' => 'nullable|string|max:255',
            'drug_test_done_by' => 'nullable|string|max:255',
            'blood_extraction_done_by' => 'nullable|string|max:255',
            'ecg_done_by' => 'required|string|max:255',
            'physical_exam_done_by' => 'nullable|string|max:255',
            
            // Optional and doctor signature (read-only for ECG Tech)
            'optional_exam' => 'nullable|string|max:255',
            'doctor_signature' => 'nullable|string|max:255',
        ]);

        $data['user_id'] = Auth::id();

        // Prepare the search criteria based on examination type
        $searchCriteria = [];
        if ($data['examination_type'] === 'annual-physical' && $data['patient_id']) {
            $searchCriteria['patient_id'] = $data['patient_id'];
            $searchCriteria['pre_employment_record_id'] = null;
        } elseif ($data['examination_type'] === 'pre-employment' && $data['pre_employment_record_id']) {
            $searchCriteria['pre_employment_record_id'] = $data['pre_employment_record_id'];
            $searchCriteria['patient_id'] = null;
        }

        MedicalChecklist::updateOrCreate(
            $searchCriteria,
            $data
        );

        // Redirect back to the previous page (dashboard or list page)
        $redirectUrl = url()->previous();
        
        // If coming from a specific route, redirect to the appropriate list
        if (str_contains($redirectUrl, 'pre-employment')) {
            return redirect()->route('ecgtech.pre-employment')->with('success', 'ECG checklist saved successfully.');
        } elseif (str_contains($redirectUrl, 'annual-physical')) {
            return redirect()->route('ecgtech.annual-physical')->with('success', 'ECG checklist saved successfully.');
        } else {
            return redirect()->route('ecgtech.dashboard')->with('success', 'ECG checklist saved successfully.');
        }
    }

    /**
     * Update medical checklist
     */
    public function updateMedicalChecklist(Request $request, $id)
    {
        $medicalChecklist = MedicalChecklist::findOrFail($id);
        
        $data = $request->validate([
            'ecg_result' => 'required|string|max:500',
            'ecg_findings' => 'nullable|string|max:1000',
            'rhythm' => 'nullable|string|max:255',
            'rate' => 'nullable|string|max:255',
            'pr_interval' => 'nullable|string|max:255',
            'qrs_duration' => 'nullable|string|max:255',
            'qt_interval' => 'nullable|string|max:255',
            'axis' => 'nullable|string|max:255',
            'interpretation' => 'nullable|string|max:1000',
        ]);

        $medicalChecklist->update($data);

        return redirect()->back()->with('success', 'ECG checklist updated successfully.');
    }

    /**
     * Show messages view
     */
    public function messages()
    {
        return view('ecgtech.messages');
    }

    /**
     * Simple test method
     */
    public function testContacts()
    {
        return response()->json(['message' => 'Test successful', 'user_id' => Auth::id()]);
    }

    /**
     * Get chat users (doctors and admins)
     */
    public function chatUsers()
    {
        try {
            // First, let's check if we can query users at all
            $users = User::whereIn('role', [
                    'doctor', 
                    'admin', 
                    'nurse', 
                    'radtech', 
                    'radiologist', 
                    'plebo', 
                    'pathologist'
                ])
                ->where('id', '!=', Auth::id())
                ->get();

            $formattedUsers = [];
            
            foreach ($users as $user) {
                try {
                    $unreadCount = Message::where('sender_id', $user->id)
                        ->where('receiver_id', Auth::id())
                        ->where('is_read', false)
                        ->count();
                } catch (\Exception $e) {
                    $unreadCount = 0; // Default to 0 if there's an issue with messages
                }
                
                // Format role names for display
                $roleDisplayNames = [
                    'doctor' => 'Doctor',
                    'admin' => 'Admin',
                    'nurse' => 'Nurse (Medtech)',
                    'radtech' => 'Radtech',
                    'radiologist' => 'Radiologist',
                    'plebo' => 'Plebo',
                    'pathologist' => 'Pathologist'
                ];
                
                $formattedUsers[] = [
                    'id' => $user->id ?? 0,
                    'fname' => $user->fname ?? '',
                    'lname' => $user->lname ?? '',
                    'role' => $roleDisplayNames[$user->role] ?? ucfirst($user->role ?? 'Unknown'),
                    'unread_count' => $unreadCount
                ];
            }

            return response()->json(['filtered_users' => $formattedUsers]);
        } catch (\Exception $e) {
            \Log::error('Error in chatUsers: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to load contacts: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Fetch messages
     */
    public function fetchMessages()
    {
        try {
            $messages = Message::where(function ($query) {
                $query->where('sender_id', Auth::id())
                      ->orWhere('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                // Get sender and receiver info manually to avoid relationship issues
                $sender = User::find($message->sender_id);
                $receiver = User::find($message->receiver_id);
                
                return [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'message' => $message->message,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at,
                    'updated_at' => $message->updated_at,
                    'sender' => $sender ? [
                        'id' => $sender->id,
                        'fname' => $sender->fname,
                        'lname' => $sender->lname,
                        'role' => $sender->role
                    ] : null,
                    'receiver' => $receiver ? [
                        'id' => $receiver->id,
                        'fname' => $receiver->fname,
                        'lname' => $receiver->lname,
                        'role' => $receiver->role
                    ] : null
                ];
            });

            return response()->json($messages);
        } catch (\Exception $e) {
            \Log::error('Error in fetchMessages: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to fetch messages: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Send message
     */
    public function sendMessage(Request $request)
    {
        try {
            // Get data from request (works for both JSON and form data)
            $receiverId = $request->input('receiver_id');
            $message = $request->input('message');
            
            if (!$receiverId) {
                return response()->json(['error' => 'receiver_id is required'], 400);
            }
            
            if (!$message) {
                return response()->json(['error' => 'message is required'], 400);
            }
            
            if (strlen($message) > 1000) {
                return response()->json(['error' => 'message is too long'], 400);
            }
            
            // Validate that the receiver exists
            $receiver = User::find($receiverId);
            if (!$receiver) {
                return response()->json(['error' => 'Invalid receiver_id'], 400);
            }

            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $receiverId,
                'message' => $message,
                'is_read' => false
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error in sendMessage: ' . $e->getMessage());
            \Log::error('Request data: ' . json_encode($request->all()));
            return response()->json(['error' => 'Failed to send message: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request)
    {
        try {
            // Get sender_id from request (works for both JSON and form data)
            $senderId = $request->input('sender_id');
            
            if (!$senderId) {
                return response()->json(['error' => 'sender_id is required'], 400);
            }
            
            // Validate that the sender exists
            $sender = User::find($senderId);
            if (!$sender) {
                return response()->json(['error' => 'Invalid sender_id'], 400);
            }

            Message::where('sender_id', $senderId)
                ->where('receiver_id', Auth::id())
                ->update(['is_read' => true]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error in markAsRead: ' . $e->getMessage());
            \Log::error('Request data: ' . json_encode($request->all()));
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to mark messages as read: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing pre-employment examination
     */
    public function editPreEmployment($id)
    {
        try {
            // Find the pre-employment record
            $preEmploymentRecord = \App\Models\PreEmploymentRecord::findOrFail($id);
            
            // Find or create the examination record
            $preEmployment = $preEmploymentRecord->preEmploymentExamination;
            if (!$preEmployment) {
                $preEmployment = $preEmploymentRecord->preEmploymentExamination()->create([
                    'status' => 'pending',
                    'created_by' => Auth::id(),
                ]);
            }
            
            return view('ecgtech.pre-employment-edit', compact('preEmployment'));
        } catch (\Exception $e) {
            \Log::error('Error in editPreEmployment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load pre-employment examination for editing.');
        }
    }

    /**
     * Show the form for editing annual physical examination
     */
    public function editAnnualPhysical($id)
    {
        try {
            // Find the patient
            $patient = \App\Models\Patient::findOrFail($id);
            
            // Find or create the examination record
            $annualPhysical = $patient->annualPhysicalExamination;
            if (!$annualPhysical) {
                $annualPhysical = $patient->annualPhysicalExamination()->create([
                    'status' => 'pending',
                    'created_by' => Auth::id(),
                ]);
            }
            
            return view('ecgtech.annual-physical-edit', compact('annualPhysical'));
        } catch (\Exception $e) {
            \Log::error('Error in editAnnualPhysical: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load annual physical examination for editing.');
        }
    }

    /**
     * Update pre-employment examination ECG results
     */
    public function updatePreEmployment(Request $request, $id)
    {
        try {
            $request->validate([
                'ecg' => 'required|string|max:1000',
                'heart_rate' => 'nullable|string|max:255',
            ]);

            // Find the pre-employment record
            $preEmploymentRecord = \App\Models\PreEmploymentRecord::findOrFail($id);
            
            // Find or create the examination record
            $preEmployment = $preEmploymentRecord->preEmploymentExamination;
            if (!$preEmployment) {
                $preEmployment = $preEmploymentRecord->preEmploymentExamination()->create([
                    'status' => 'pending',
                    'created_by' => Auth::id(),
                ]);
            }
            
            // Get existing physical_exam data or create new array
            $physicalExam = $preEmployment->physical_exam ?? [];
            if ($request->heart_rate) {
                $physicalExam['heart_rate'] = $request->heart_rate;
            }
            
            $preEmployment->update([
                'ecg' => $request->ecg,
                'ecg_date' => now()->toDateString(),
                'ecg_technician' => Auth::user()->fname . ' ' . Auth::user()->lname,
                'physical_exam' => $physicalExam,
            ]);

            return redirect()->route('ecgtech.pre-employment')->with('success', 'ECG examination results updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in updatePreEmployment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update ECG examination results.')->withInput();
        }
    }

    /**
     * Update annual physical examination ECG results
     */
    public function updateAnnualPhysical(Request $request, $id)
    {
        try {
            $request->validate([
                'ecg' => 'required|string|max:1000',
                'heart_rate' => 'nullable|string|max:255',
            ]);

            // Find the patient
            $patient = \App\Models\Patient::findOrFail($id);
            
            // Find or create the examination record
            $annualPhysical = $patient->annualPhysicalExamination;
            if (!$annualPhysical) {
                $annualPhysical = $patient->annualPhysicalExamination()->create([
                    'status' => 'pending',
                    'created_by' => Auth::id(),
                ]);
            }
            
            // Get existing physical_exam data or create new array
            $physicalExam = $annualPhysical->physical_exam ?? [];
            if ($request->heart_rate) {
                $physicalExam['heart_rate'] = $request->heart_rate;
            }
            
            $annualPhysical->update([
                'ecg' => $request->ecg,
                'ecg_date' => now()->toDateString(),
                'ecg_technician' => Auth::user()->fname . ' ' . Auth::user()->lname,
                'physical_exam' => $physicalExam,
            ]);

            return redirect()->route('ecgtech.annual-physical')->with('success', 'ECG examination results updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in updateAnnualPhysical: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update ECG examination results.')->withInput();
        }
    }
}
