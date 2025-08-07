<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\RegistrationLink;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('created_by', Auth::id())
            ->where('role', 'patient')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('company.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('company.employees.create');
    }

    public function generateLink(Request $request)
    {
        try {
            // Debug authentication
            if (!Auth::check()) {
                \Log::error('User not authenticated for generate link');
                return response()->json([
                    'error' => 'User not authenticated'
                ], 401);
            }

            $user = Auth::user();
            \Log::info('User attempting to generate link', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'has_role_company' => $user->hasRole('company')
            ]);

            if (!$user->hasRole('company')) {
                \Log::error('User does not have company role', [
                    'user_id' => $user->id,
                    'user_role' => $user->role
                ]);
                return response()->json([
                    'error' => 'Unauthorized: User does not have company role'
                ], 403);
            }

            $expiryHours = $request->input('expiry_hours', 24);
            $expiryTime = now()->addHours($expiryHours);
            
            // Create a unique token for the registration link
            $token = Str::random(32);
            
            // Store the registration link in database
            $registrationLink = RegistrationLink::create([
                'created_by' => Auth::id(),
                'token' => $token,
                'expiry_hours' => $expiryHours,
                'expires_at' => $expiryTime,
            ]);
            
            $registrationUrl = route('company.employees.register', [
                'token' => $token,
                'created_by' => Auth::id()
            ]);
            
            // Log the generated link for debugging
            \Log::info('Generated registration link', [
                'link' => $registrationUrl,
                'token' => $token,
                'created_by' => Auth::id(),
                'expires_at' => $expiryTime
            ]);
            
            return response()->json([
                'link' => $registrationUrl,
                'expires_at' => $expiryTime->format('Y-m-d H:i:s'),
                'expiry_hours' => $expiryHours
            ]);
        } catch (\Exception $e) {
            \Log::error('Error generating registration link', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'error' => 'Failed to generate registration link: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showRegisterForm(Request $request)
    {
        $token = $request->query('token');
        $createdBy = $request->query('created_by');
        
        if (!$token || !$createdBy) {
            return redirect()->route('login')->with('error', 'Invalid registration link.');
        }

        // Check if token is valid and not expired
        $registrationLink = RegistrationLink::where('token', $token)
            ->where('created_by', $createdBy)
            ->first();

        if (!$registrationLink || !$registrationLink->isValid()) {
            return redirect()->route('login')->with('error', 'Invalid or expired registration link.');
        }

        $creator = User::find($createdBy);
        if (!$creator) {
            return redirect()->route('login')->with('error', 'Invalid registration link.');
        }

        return view('company.employees.register', compact('creator', 'createdBy', 'token', 'registrationLink'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'birthday' => 'required|date',
            'company' => 'required|in:yes,no',
            'password' => 'required|string|min:8|confirmed',
            'created_by' => 'required|exists:users,id',
            'token' => 'required|string',
        ]);

        // Validate token again
        $registrationLink = RegistrationLink::where('token', $request->token)
            ->where('created_by', $request->created_by)
            ->first();

        if (!$registrationLink || !$registrationLink->isValid()) {
            return back()->withInput()->with('error', 'Invalid or expired registration link.');
        }

        // Calculate age
        $birthday = \Carbon\Carbon::parse($request->birthday);
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
            'role' => 'patient',
            'password' => bcrypt($request->password),
            'created_by' => $request->created_by,
        ]);

        // Mark the registration link as used
        $registrationLink->update(['is_used' => true]);

        // Auto-login the new user
        Auth::login($user);

        return redirect()->route('patient.dashboard')
            ->with('success', 'Account created successfully! Welcome to your dashboard.');
    }

    public function show($id)
    {
        $employee = User::where('created_by', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        
        return view('company.employees.show', compact('employee'));
    }

    public function destroy($id)
    {
        $employee = User::where('created_by', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        
        $employee->delete();

        return redirect()->route('company.employees.index')
            ->with('success', 'Employee account deleted successfully.');
    }
}
