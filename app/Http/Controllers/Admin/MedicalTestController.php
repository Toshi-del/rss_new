<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalTestCategory;
use App\Models\MedicalTest;
use Illuminate\Http\Request;

class MedicalTestController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = MedicalTestCategory::orderBy('sort_order')->get();
        $selectedCategoryId = $request->get('category_id');
        return view('admin.medical-tests.create', compact('categories', 'selectedCategoryId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        MedicalTest::create($request->all());

        return redirect()->route('medical-test-categories.show', $request->medical_test_category_id)
            ->with('success', 'Medical test created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalTest $medicalTest)
    {
        return view('admin.medical-tests.show', compact('medicalTest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalTest $medicalTest)
    {
        $categories = MedicalTestCategory::orderBy('sort_order')->get();
        return view('admin.medical-tests.edit', compact('medicalTest', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicalTest $medicalTest)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $medicalTest->update($request->all());

        return redirect()->route('medical-test-categories.show', $medicalTest->medical_test_category_id)
            ->with('success', 'Medical test updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalTest $medicalTest)
    {
        $categoryId = $medicalTest->medical_test_category_id;
        $medicalTest->delete();

        return redirect()->route('medical-test-categories.show', $categoryId)
            ->with('success', 'Medical test deleted successfully.');
    }
}
