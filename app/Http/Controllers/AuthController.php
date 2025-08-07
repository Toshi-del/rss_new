<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect based on user role
            $user = Auth::user();
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isCompany()) {
                return redirect()->route('company.dashboard');
            } elseif ($user->isDoctor()) {
                return redirect()->route('doctor.dashboard');
            } elseif ($user->isNurse()) {
                return redirect()->route('nurse.dashboard');
            } else {
                return redirect()->route('patient.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'birthday' => 'required|date',
            'company' => 'nullable|in:Pasig Catholic College,AsiaPro,PrimeLime',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Calculate age
        $birthday = Carbon::parse($request->birthday);
        $age = $birthday->age;

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'mname' => $request->mname,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthday' => $request->birthday,
            'age' => $age,
            'company' => $request->company,
            'role' => 'patient', // Default role
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('patient.dashboard');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
