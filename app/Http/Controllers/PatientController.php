<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Show the patient dashboard
     */
    public function dashboard()
    {
        return view('patient.dashboard');
    }

    /**
     * Show the patient profile
     */
    public function profile()
    {
        return view('patient.profile');
    }

    /**
     * Update the patient profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->update($request->only(['fname', 'lname', 'mname', 'email', 'phone', 'company']));

        return redirect()->route('patient.profile')->with('success', 'Profile updated successfully!');
    }
}
