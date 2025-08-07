<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PreEmploymentRecord;
use Illuminate\Http\Request;

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
     * Show appointments
     */
    public function appointments()
    {
        $appointments = Appointment::with('patients')->latest()->get();
        
        return view('nurse.appointments', compact('appointments'));
    }

    /**
     * Show pre-employment records
     */
    public function preEmployment()
    {
        $preEmployments = PreEmploymentRecord::latest()->get();
        
        return view('nurse.pre-employment', compact('preEmployments'));
    }
}
