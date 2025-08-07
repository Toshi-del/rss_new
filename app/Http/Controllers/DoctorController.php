<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PreEmploymentRecord;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Show the doctor dashboard
     */
    public function dashboard()
    {
        // Get pre-employment records
        $preEmployments = PreEmploymentRecord::latest()->take(5)->get();
        $preEmploymentCount = PreEmploymentRecord::count();

        // Get appointments with patients
        $appointments = Appointment::with('patients')->latest()->take(10)->get();
        $appointmentCount = Appointment::count();

        // Get all patients
        $patients = Patient::latest()->take(10)->get();
        $patientCount = Patient::count();

        // Get annual physicals (appointments with type 'annual_physical')
        $annualPhysicals = Appointment::where('appointment_type', 'annual_physical')->count();

        return view('doctor.dashboard', compact(
            'preEmployments',
            'preEmploymentCount',
            'appointments',
            'appointmentCount',
            'patients',
            'patientCount',
            'annualPhysicals'
        ));
    }

    /**
     * Show pre-employment records
     */
    public function preEmployment()
    {
        $preEmployments = PreEmploymentRecord::latest()->get();
        
        return view('doctor.pre-employment', compact('preEmployments'));
    }

    /**
     * Show annual physical examination patients
     */
    public function annualPhysical()
    {
        $patients = Patient::latest()->get();
        
        return view('doctor.annual-physical', compact('patients'));
    }
}
