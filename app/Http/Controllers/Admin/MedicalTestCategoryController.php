<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalTestCategory;
use Illuminate\Http\Request;

class MedicalTestCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = MedicalTestCategory::withCount('medicalTests')->orderBy('sort_order')->get();
        return view('admin.medical-test-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.medical-test-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        MedicalTestCategory::create($request->all());

        return redirect()->route('medical-test-categories.index')
            ->with('success', 'Medical test category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalTestCategory $medicalTestCategory)
    {
        $category = $medicalTestCategory->load('medicalTests')->loadCount('medicalTests');
        return view('admin.medical-test-categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalTestCategory $medicalTestCategory)
    {
        $category = $medicalTestCategory;
        return view('admin.medical-test-categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicalTestCategory $medicalTestCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $medicalTestCategory->update($request->all());

        return redirect()->route('medical-test-categories.index')
            ->with('success', 'Medical test category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalTestCategory $medicalTestCategory)
    {
        $medicalTestCategory->delete();

        return redirect()->route('medical-test-categories.index')
            ->with('success', 'Medical test category deleted successfully.');
    }
}
