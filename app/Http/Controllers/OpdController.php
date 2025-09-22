<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\AppointmentConfirmation;
use App\Models\User;
use Carbon\Carbon;

class OpdController extends Controller
{
    public function dashboard()
    {
        $incoming = session('opd_incoming_tests', []);
        $total = collect($incoming)->sum(function($item){ return (float)($item['price'] ?? 0); });
        return view('opd.dashboard', compact('incoming', 'total'));
    }

    public function medicalTestCategories()
    {
        $categories = \App\Models\MedicalTestCategory::with('medicalTests')
            ->orderByRaw("CASE WHEN LOWER(name) LIKE '%pre-employment%' OR LOWER(name) LIKE '%pre employment%' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->paginate(15);
        return view('opd.medical-test-categories', compact('categories'));
    }

    public function medicalTests()
    {
        $tests = \App\Models\MedicalTest::with('category')->orderBy('name')->paginate(15);
        return view('opd.medical-tests', compact('tests'));
    }

    public function incomingTests()
    {
        $incoming = session('opd_incoming_tests', []);
        $total = collect($incoming)->sum(function($item){ return (float)($item['price'] ?? 0); });
        return view('opd.incoming-tests', compact('incoming', 'total'));
    }

    public function addIncomingTest($testId)
    {
        $test = \App\Models\MedicalTest::with('category')->findOrFail($testId);
        $incoming = session('opd_incoming_tests', []);

        $appointmentData = [
            'customer_name' => request('customer_name'),
            'customer_email' => request('customer_email'),
            'appointment_date' => request('appointment_date'),
            'appointment_time' => request('appointment_time'),
        ];

        $testDetails = [
            'id' => $test->id,
            'name' => $test->name,
            'category' => optional($test->category)->name,
            'price' => (float)($test->price ?? 0),
        ];

        $incoming[$test->id] = array_merge($testDetails, $appointmentData);

        session(['opd_incoming_tests' => $incoming]);

        // Persist to OPD table
        DB::table('opd_tests')->insert([
            'customer_name' => $appointmentData['customer_name'],
            'customer_email' => $appointmentData['customer_email'],
            'medical_test' => $test->name,
            'appointment_date' => $appointmentData['appointment_date'] ?: null,
            'appointment_time' => $appointmentData['appointment_time'] ?: null,
            'price' => $testDetails['price'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send email confirmation if customer email is provided
        if (!empty($appointmentData['customer_email']) && filter_var($appointmentData['customer_email'], FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($appointmentData['customer_email'])
                    ->send(new AppointmentConfirmation($appointmentData, $testDetails));
                
                return back()->with('success', 'Added to Incoming Tests and confirmation email sent!');
            } catch (\Exception $e) {
                // Log the error but don't fail the request
                \Log::error('Failed to send appointment confirmation email: ' . $e->getMessage());
                return back()->with('success', 'Added to Incoming Tests (email could not be sent)');
            }
        }

        return back()->with('success', 'Added to Incoming Tests');
    }

    public function removeIncomingTest($testId)
    {
        $incoming = session('opd_incoming_tests', []);
        unset($incoming[$testId]);
        session(['opd_incoming_tests' => $incoming]);
        return back()->with('success', 'Removed from Incoming Tests');
    }

    public function result()
    {
        $incoming = session('opd_incoming_tests', []);

        $first = collect($incoming)->first();

        $appointment_date = $first['appointment_date'] ?? null;
        $appointment_time = $first['appointment_time'] ?? null;
        $customer_name = $first['customer_name'] ?? null;
        $customer_email = $first['customer_email'] ?? null;

        if (!$appointment_date || !$customer_name) {
            $latest = DB::table('opd_tests')
                ->when($customer_email, function ($q) use ($customer_email) {
                    $q->where('customer_email', $customer_email);
                })
                ->orderByDesc('id')
                ->first();
            if ($latest) {
                $appointment_date = $appointment_date ?: ($latest->appointment_date ?? null);
                $appointment_time = $appointment_time ?: ($latest->appointment_time ?? null);
                $customer_name = $customer_name ?: ($latest->customer_name ?? null);
                $customer_email = $customer_email ?: ($latest->customer_email ?? null);
            }
        }

        $patientName = $customer_name;
        $examDate = $appointment_date ?: now()->toDateString();

        return view('opd.result', compact(
            'appointment_date',
            'appointment_time',
            'customer_name',
            'customer_email',
            'patientName',
            'examDate'
        ));
    }

    /**
     * Show the OPD account creation form
     */
    public function showCreateAccount()
    {
        return view('opd.create-account');
    }

    /**
     * Handle OPD account creation with default role 'opd'
     */
    public function createAccount(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'birthday' => 'required|date',
            'company' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Additional duplicate prevention checks
        $firstName = trim($request->fname);
        $lastName = trim($request->lname);
        $email = trim($request->email);
        $phone = trim($request->phone);

        // Check for existing user with same name and email combination
        $existingUser = User::where('fname', $firstName)
            ->where('lname', $lastName)
            ->where('email', $email)
            ->first();

        if ($existingUser) {
            return back()->withErrors([
                'email' => 'A user with the same name and email already exists. Please use a different email or contact support if this is an error.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // Check for existing user with same name and phone combination
        $existingUserByPhone = User::where('fname', $firstName)
            ->where('lname', $lastName)
            ->where('phone', $phone)
            ->first();

        if ($existingUserByPhone) {
            return back()->withErrors([
                'phone' => 'A user with the same name and phone number already exists. Please use a different phone number or contact support if this is an error.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // Calculate age
        $birthday = Carbon::parse($request->birthday);
        $age = $birthday->age;

        $user = User::create([
            'fname' => $firstName,
            'lname' => $lastName,
            'mname' => $request->mname,
            'email' => $email,
            'phone' => $phone,
            'birthday' => $request->birthday,
            'age' => $age,
            'company' => $request->company,
            'role' => 'opd', // Default role for OPD accounts
            'password' => Hash::make($request->password),
            'created_by' => auth()->id(), // Track who created this account
        ]);

        return redirect()->route('opd.dashboard')->with('success', 'OPD account created successfully for ' . $user->full_name . '!');
    }
}






