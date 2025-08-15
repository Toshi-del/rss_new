<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\PreEmploymentRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        return view('admin.tests');
    }
    
    /**
     * Show messages page
     */
    public function messages()
    {
        return view('admin.messages');
    }
    
    /**
     * Show reports page
     */
    public function report()
    {
        return view('admin.report');
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
}
