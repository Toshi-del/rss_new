<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\PreEmploymentRecord;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        // Get basic statistics
        $totalPatients = Patient::count();
        $approvedAppointments = Appointment::where('status', 'approved')->count();
        $testsToday = Appointment::whereDate('appointment_date', Carbon::today())
            ->where('status', 'approved')
            ->count();
        $totalPreEmployment = PreEmploymentRecord::count();
        
        // Get appointment statistics
        $appointmentStats = $this->getAppointmentStatistics();
        
        // Get pre-employment statistics
        $preEmploymentStats = $this->getPreEmploymentStatistics();
        
        // Get recent patients with appointments (last 5 records)
        $patients = Patient::with(['appointment' => function($query) {
            $query->orderBy('appointment_date', 'desc');
        }])
        ->whereHas('appointment')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
        
        // Get recent pre-employment records (last 5 records)
        $preEmployments = PreEmploymentRecord::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Generate chart data (provide up to 365 days so UI can slice to weekly/monthly/yearly)
        $preEmploymentChartData = $this->generatePreEmploymentChartData();
        $annualPhysicalChartData = $this->generateAnnualPhysicalChartData();

        return view('admin.dashboard', compact(
            'totalPatients',
            'approvedAppointments', 
            'testsToday',
            'totalPreEmployment',
            'patients',
            'preEmployments',
            'preEmploymentChartData',
            'annualPhysicalChartData',
            'appointmentStats',
            'preEmploymentStats'
        ));
    }
    
    /**
     * Get appointment statistics for weekly, monthly, and yearly
     */
    private function getAppointmentStatistics()
    {
        $now = Carbon::now();
        
        // Weekly statistics (last 7 days)
        $weeklyStats = [
            'total' => Appointment::whereBetween('created_at', [$now->copy()->subDays(7), $now])->count(),
            'approved' => Appointment::whereBetween('created_at', [$now->copy()->subDays(7), $now])
                ->where('status', 'approved')->count(),
            'pending' => Appointment::whereBetween('created_at', [$now->copy()->subDays(7), $now])
                ->where('status', 'pending')->count(),
            'cancelled' => Appointment::whereBetween('created_at', [$now->copy()->subDays(7), $now])
                ->where('status', 'cancelled')->count(),
        ];
        
        // Monthly statistics (last 30 days)
        $monthlyStats = [
            'total' => Appointment::whereBetween('created_at', [$now->copy()->subDays(30), $now])->count(),
            'approved' => Appointment::whereBetween('created_at', [$now->copy()->subDays(30), $now])
                ->where('status', 'approved')->count(),
            'pending' => Appointment::whereBetween('created_at', [$now->copy()->subDays(30), $now])
                ->where('status', 'pending')->count(),
            'cancelled' => Appointment::whereBetween('created_at', [$now->copy()->subDays(30), $now])
                ->where('status', 'cancelled')->count(),
        ];
        
        // Yearly statistics (last 365 days)
        $yearlyStats = [
            'total' => Appointment::whereBetween('created_at', [$now->copy()->subDays(365), $now])->count(),
            'approved' => Appointment::whereBetween('created_at', [$now->copy()->subDays(365), $now])
                ->where('status', 'approved')->count(),
            'pending' => Appointment::whereBetween('created_at', [$now->copy()->subDays(365), $now])
                ->where('status', 'pending')->count(),
            'cancelled' => Appointment::whereBetween('created_at', [$now->copy()->subDays(365), $now])
                ->where('status', 'cancelled')->count(),
        ];
        
        return [
            'weekly' => $weeklyStats,
            'monthly' => $monthlyStats,
            'yearly' => $yearlyStats
        ];
    }
    
    /**
     * Get pre-employment statistics for weekly, monthly, and yearly
     */
    private function getPreEmploymentStatistics()
    {
        $now = Carbon::now();
        
        // Weekly statistics (last 7 days)
        $weeklyStats = [
            'total' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(7), $now])->count(),
            'passed' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(7), $now])
                ->where('status', 'passed')->count(),
            'failed' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(7), $now])
                ->where('status', 'failed')->count(),
            'pending' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(7), $now])
                ->where('status', 'pending')->count(),
        ];
        
        // Monthly statistics (last 30 days)
        $monthlyStats = [
            'total' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(30), $now])->count(),
            'passed' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(30), $now])
                ->where('status', 'passed')->count(),
            'failed' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(30), $now])
                ->where('status', 'failed')->count(),
            'pending' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(30), $now])
                ->where('status', 'pending')->count(),
        ];
        
        // Yearly statistics (last 365 days)
        $yearlyStats = [
            'total' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(365), $now])->count(),
            'passed' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(365), $now])
                ->where('status', 'passed')->count(),
            'failed' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(365), $now])
                ->where('status', 'failed')->count(),
            'pending' => PreEmploymentRecord::whereBetween('created_at', [$now->copy()->subDays(365), $now])
                ->where('status', 'pending')->count(),
        ];
        
        return [
            'weekly' => $weeklyStats,
            'monthly' => $monthlyStats,
            'yearly' => $yearlyStats
        ];
    }
    
    /**
     * Generate pre-employment chart data for the last 365 days
     */
    private function generatePreEmploymentChartData()
    {
        $data = [];
        $startDate = Carbon::now()->subDays(365);
        
        for ($i = 0; $i < 365; $i++) {
            $date = $startDate->copy()->addDays($i);
            $count = PreEmploymentRecord::whereDate('created_at', $date)->count();
            
            $data[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }
        
        return $data;
    }

    /**
     * Generate annual physical examination chart data for the last 365 days
     */
    private function generateAnnualPhysicalChartData()
    {
        $data = [];
        $startDate = Carbon::now()->subDays(365);

        for ($i = 0; $i < 365; $i++) {
            $date = $startDate->copy()->addDays($i);
            $count = Appointment::whereDate('appointment_date', $date)
                ->where('appointment_type', 'annual_physical')
                ->count();

            $data[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }

        return $data;
    }
    
    /**
     * Show patients page
     */
    public function patients()
    {
        $patients = Patient::with('appointment')->paginate(15);
        return view('admin.patients', compact('patients'));
    }
    
    /**
     * Show appointments page
     */
    public function appointments()
    {
        $appointments = Appointment::with('patients')->paginate(15);
        return view('admin.appointments', compact('appointments'));
    }
    
    /**
     * Show pre-employment page
     */
    public function preEmployment()
    {
        $preEmployments = PreEmploymentRecord::paginate(15);
        return view('admin.pre-employment', compact('preEmployments'));
    }
    
    /**
     * Show tests page
     */
    public function tests()
    {
        $preEmploymentResults = \App\Models\PreEmploymentExamination::all();
        $annualPhysicalResults = \App\Models\AnnualPhysicalExamination::all();
        return view('admin.tests', compact('preEmploymentResults', 'annualPhysicalResults'));
    }
    
    /**
     * Show messages page
     */
    public function messages()
    {
        return view('admin.messages');
    }
    
    /**
     * Show the admin report page with examination data and company linkage
     */
    public function report()
    {
        // Pre-Employment Examinations with user and company info
        $preEmploymentExams = PreEmploymentExamination::with(['user' => function($q) {
            $q->select('id', 'fname', 'lname', 'company', 'role');
        }])->get();

        // Annual Physical Examinations with user info
        $annualPhysicalExams = AnnualPhysicalExamination::with(['user' => function($q) {
            $q->select('id', 'fname', 'lname', 'company', 'role');
        }])->get();

        // Patient company account linkage: patient.appointment_id > appointment.created_by
        $patients = \App\Models\Patient::with(['appointment.creator' => function($q) {
            $q->select('id', 'fname', 'lname', 'company', 'role');
        }])->get();

        // Debug information
        \Log::info('Admin Report Data:', [
            'pre_employment_count' => $preEmploymentExams->count(),
            'annual_physical_count' => $annualPhysicalExams->count(),
            'patients_count' => $patients->count(),
        ]);

        return view('admin.report', compact('preEmploymentExams', 'annualPhysicalExams', 'patients'));
    }

    /**
     * Show all company accounts and their patients (admin view)
     */
    public function companyAccountsAndPatients()
    {
        // Get all users with role 'company'
        $companies = User::where('role', 'company')->get();
        // For each company, get all patients under their appointments
        $companiesWithPatients = $companies->map(function ($company) {
            // Get all appointment IDs created by this company
            $appointmentIds = $company->appointments()->pluck('id');
            // Get all patients whose appointment_id is in those appointments
            $patients = Patient::whereIn('appointment_id', $appointmentIds)->get();
            $company->patients = $patients;
            return $company;
        });
        return view('admin.accounts-and-patients', compact('companiesWithPatients'));
    }

    /**
     * Fetch chat messages for the admin.
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
     * Mark messages from a specific sender as read by the current user.
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
        ]);
        $userId = Auth::id();
        Message::where('sender_id', $request->sender_id)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        return response()->json(['status' => 'ok']);
    }

    /**
     * Send a chat message from admin to another user.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
        return response()->json($message, 201);
    }

    /**
     * Get all users for admin chat interface.
     */
    public function chatUsers()
    {
        $users = User::select('id', 'fname', 'lname', 'role', 'company')
            ->where('id', '!=', Auth::id()) // Exclude current admin user
            ->orderBy('fname')
            ->orderBy('lname')
            ->get();
        
        // Convert company enum values to strings for frontend compatibility
        $users = $users->map(function($user) {
            $user->company = $user->company ? (string) $user->company : null;
            return $user;
        });
        
        return response()->json($users);
    }

    /**
     * Approve an appointment
     */
    public function approveAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'approved';
        $appointment->save();
        // Update all patients with this appointment_id
        \App\Models\Patient::where('appointment_id', $appointment->id)
            ->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Appointment and patients approved successfully.');
    }

    /**
     * Decline an appointment
     */
    public function declineAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'declined';
        $appointment->save();
        return redirect()->back()->with('success', 'Appointment declined successfully.');
    }

    /**
     * Approve a pre-employment record
     */
    public function approvePreEmployment($id)
    {
        $record = PreEmploymentRecord::findOrFail($id);
        $record->status = 'passed';
        $record->save();
        return redirect()->back()->with('success', 'Pre-employment record approved.');
    }

    /**
     * Decline a pre-employment record
     */
    public function declinePreEmployment($id)
    {
        $record = PreEmploymentRecord::findOrFail($id);
        $record->status = 'failed';
        $record->save();
        return redirect()->back()->with('success', 'Pre-employment record declined.');
    }

    /**
     * Send registration email for passed pre-employment records
     */
    public function sendRegistrationEmail($id)
    {
        try {
            $record = PreEmploymentRecord::findOrFail($id);
            
            // Check if status is passed
            if ($record->status !== 'passed') {
                return redirect()->back()->with('error', 'Only passed pre-employment records can receive registration emails.');
            }

            // Check if email exists
            if (empty($record->email)) {
                return redirect()->back()->with('error', 'No email address found for this record.');
            }

            // Create PHPMailer instance
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = env('MAIL_PORT', 587);
            
            // Debug settings (comment out in production)
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            
            // Set timeout
            $mail->Timeout = 30;
            
            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@rsshealth.com'), 'RSS Citi Health Services');
            $mail->addAddress($record->email, $record->first_name . ' ' . $record->last_name);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Pre-Employment Registration - RSS Citi Health Services';
            
            // Generate registration link
            $registrationLink = route('register') . '?email=' . urlencode($record->email) . '&type=pre_employment&record_id=' . $record->id;
            
            $mail->Body = $this->getRegistrationEmailTemplate($record, $registrationLink);
            $mail->AltBody = $this->getRegistrationEmailTextTemplate($record, $registrationLink);
            
            $mail->send();
            
            return redirect()->back()->with('success', 'Registration email sent successfully to ' . $record->email);
            
        } catch (Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Email could not be sent. Error: ' . $e->getMessage());
        }
    }

    /**
     * Get HTML email template for registration
     */
    private function getRegistrationEmailTemplate($record, $registrationLink)
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Pre-Employment Registration</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #4f46e5; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                .content { background: #f9fafb; padding: 20px; border-radius: 0 0 8px 8px; }
                .button { display: inline-block; background: #4f46e5; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
                .footer { text-align: center; margin-top: 20px; color: #6b7280; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>🎉 Congratulations!</h1>
                    <h2>Pre-Employment Medical Examination Passed</h2>
                </div>
                <div class="content">
                    <p>Dear <strong>' . htmlspecialchars($record->first_name . ' ' . $record->last_name) . '</strong>,</p>
                    
                    <p>We are pleased to inform you that your pre-employment medical examination has been <strong>PASSED</strong>.</p>
                    
                    <p><strong>Examination Details:</strong></p>
                    <ul>
                        <li><strong>Medical Exam Type:</strong> ' . htmlspecialchars($record->medical_exam_type) . '</li>
                        <li><strong>Blood Tests:</strong> ' . (is_array($record->blood_tests) ? implode(', ', $record->blood_tests) : $record->blood_tests) . '</li>
                        <li><strong>Other Exams:</strong> ' . htmlspecialchars($record->other_exams ?? 'N/A') . '</li>
                        <li><strong>Company:</strong> ' . htmlspecialchars($record->company_name ?? 'N/A') . '</li>
                    </ul>
                    
                    <p>To complete your registration and access your medical records, please click the button below:</p>
                    
                    <div style="text-align: center;">
                        <a href="' . $registrationLink . '" class="button">Complete Registration</a>
                    </div>
                    
                    <p><strong>Important Notes:</strong></p>
                    <ul>
                        <li>This link is valid for 7 days</li>
                        <li>Please complete your registration to access your medical dashboard</li>
                        <li>Keep your login credentials secure</li>
                    </ul>
                    
                    <p>If you have any questions, please contact our support team.</p>
                    
                    <p>Best regards,<br>
                    <strong>RSS Citi Health Services Team</strong></p>
                </div>
                <div class="footer">
                    <p>This is an automated message. Please do not reply to this email.</p>
                    <p>&copy; ' . date('Y') . ' RSS Citi Health Services. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Get plain text email template for registration
     */
    private function getRegistrationEmailTextTemplate($record, $registrationLink)
    {
        return "Congratulations!\n\n" .
               "Your pre-employment medical examination has been PASSED.\n\n" .
               "Examination Details:\n" .
               "- Medical Exam Type: " . $record->medical_exam_type . "\n" .
               "- Blood Tests: " . (is_array($record->blood_tests) ? implode(', ', $record->blood_tests) : $record->blood_tests) . "\n" .
               "- Other Exams: " . ($record->other_exams ?? 'N/A') . "\n" .
               "- Company: " . ($record->company_name ?? 'N/A') . "\n\n" .
               "To complete your registration, visit: " . $registrationLink . "\n\n" .
               "Best regards,\nRSS Citi Health Services Team";
    }
}
