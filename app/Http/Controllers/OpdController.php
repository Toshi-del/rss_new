<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $incoming[$test->id] = [
            'id' => $test->id,
            'name' => $test->name,
            'category' => optional($test->category)->name,
            'price' => (float)($test->price ?? 0),
            'appointment_date' => request('appointment_date'),
            'appointment_time' => request('appointment_time'),
            'customer_name' => request('customer_name'),
            'customer_email' => request('customer_email'),
        ];

        session(['opd_incoming_tests' => $incoming]);

        // Persist to OPD table
        DB::table('opd_tests')->insert([
            'customer_name' => request('customer_name'),
            'customer_email' => request('customer_email'),
            'medical_test' => $test->name,
            'appointment_date' => request('appointment_date') ?: null,
            'appointment_time' => request('appointment_time') ?: null,
            'price' => (float)($test->price ?? 0),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
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
}






