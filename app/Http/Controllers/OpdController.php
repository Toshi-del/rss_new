<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        ];
        session(['opd_incoming_tests' => $incoming]);
        return back()->with('success', 'Added to Incoming Tests');
    }

    public function removeIncomingTest($testId)
    {
        $incoming = session('opd_incoming_tests', []);
        unset($incoming[$testId]);
        session(['opd_incoming_tests' => $incoming]);
        return back()->with('success', 'Removed from Incoming Tests');
    }
}






