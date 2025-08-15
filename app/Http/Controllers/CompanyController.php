<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\PreEmploymentRecord;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Show the company dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get appointments for the current company user
        $appointments = Appointment::where('created_by', $user->id)
            ->with('patients')
            ->orderBy('appointment_date', 'desc')
            ->limit(10)
            ->get();
            
        // Get pre-employment records for the current company user
        $preEmploymentRecords = PreEmploymentRecord::where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Calculate statistics
        $pendingAppointmentsCount = Appointment::where('created_by', $user->id)
            ->where('status', 'pending')
            ->count();
            
        $approvedAppointmentsCount = Appointment::where('created_by', $user->id)
            ->where('status', 'approved')
            ->count();
            
        $totalAppointmentsCount = Appointment::where('created_by', $user->id)->count();
        
        // Calculate pre-employment statistics
        $totalPreEmploymentCount = PreEmploymentRecord::where('created_by', $user->id)->count();
        
        return view('company.dashboard', compact(
            'appointments',
            'preEmploymentRecords',
            'pendingAppointmentsCount',
            'approvedAppointmentsCount',
            'totalAppointmentsCount',
            'totalPreEmploymentCount'
        ));
    }

    /**
     * Show the company settings page
     */
    public function settings()
    {
        return view('company.settings');
    }

    /**
     * Update company settings
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'industry' => 'nullable|string|max:100',
            'employee_count' => 'nullable|string|max:50',
        ]);

        $user->update($validated);

        return redirect()->route('company.settings')->with('success', 'Settings updated successfully!');
    }

    /**
     * Show medical results page
     */
    public function medicalResults(Request $request)
    {
        $user = Auth::user();
        
        // Get annual physical examination results (from appointments)
        $annualPhysicalResults = Appointment::where('created_by', $user->id)
            ->where('appointment_type', 'annual_physical')
            ->with(['patients' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy('appointment_date', 'desc')
            ->get();
            
        // Get pre-employment examination results
        $preEmploymentResults = PreEmploymentRecord::where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Filter by status if requested
        $statusFilter = $request->get('status');
        if ($statusFilter) {
            if ($statusFilter === 'annual_physical') {
                $annualPhysicalResults = $annualPhysicalResults->filter(function($appointment) {
                    return $appointment->status === 'completed';
                });
            } elseif ($statusFilter === 'pre_employment') {
                $preEmploymentResults = $preEmploymentResults->filter(function($record) {
                    return $record->status === 'passed' || $record->status === 'failed';
                });
            }
        }
        
        // Calculate statistics
        $totalAnnualPhysical = $annualPhysicalResults->count();
        $completedAnnualPhysical = $annualPhysicalResults->where('status', 'completed')->count();
        $totalPreEmployment = $preEmploymentResults->count();
        $passedPreEmployment = $preEmploymentResults->where('status', 'passed')->count();
        $failedPreEmployment = $preEmploymentResults->where('status', 'failed')->count();
        
        return view('company.medical-results', compact(
            'annualPhysicalResults',
            'preEmploymentResults',
            'totalAnnualPhysical',
            'completedAnnualPhysical',
            'totalPreEmployment',
            'passedPreEmployment',
            'failedPreEmployment',
            'statusFilter'
        ));
    }
}
