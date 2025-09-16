<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\PreEmploymentRecord;
use App\Models\MedicalTestCategory;
use App\Models\MedicalTest;
use App\Models\PreEmploymentMedicalTest;

class CompanyPreEmploymentController extends Controller
{
    public function index()
    {
        $files = PreEmploymentRecord::with(['medicalTests', 'medicalTestCategories'])
            ->where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('company.pre-employment.index', compact('files'));
    }

    public function create()
    {
        $medicalTestCategories = MedicalTestCategory::with(['activeMedicalTests' => function($query) {
            $query->distinct();
        }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->distinct()
            ->get();

        return view('company.pre-employment.create', compact('medicalTestCategories'));
    }

    public function store(Request $request)
    {
        // Decode JSON arrays from frontend
        $categoryIds = json_decode($request->medical_test_categories_id, true);
        $testIds = json_decode($request->medical_test_id, true);
        
        // Replace the request data with decoded arrays for validation
        $request->merge([
            'medical_test_categories_id' => $categoryIds,
            'medical_test_id' => $testIds,
        ]);

        $validated = $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
            'medical_test_categories_id' => 'required|array|min:1',
            'medical_test_categories_id.*' => 'exists:medical_test_categories,id',
            'medical_test_id' => 'required|array|min:1',
            'medical_test_id.*' => 'exists:medical_tests,id',
            'package_other_exams' => 'nullable|string',
            'billing_type' => 'required|in:Patient,Company',
            'company_name' => 'required_if:billing_type,Company|nullable|string',
        ]);

        // Validate that arrays have the same length and tests belong to their categories
        if (count($categoryIds) !== count($testIds)) {
            return back()
                ->withInput()
                ->withErrors(['medical_test_id' => 'Number of categories and tests must match.']);
        }

        // Validate each test belongs to its corresponding category
        $totalPrice = 0;
        for ($i = 0; $i < count($categoryIds); $i++) {
            $test = MedicalTest::find($testIds[$i]);
            if (!$test || (int) $test->medical_test_category_id !== (int) $categoryIds[$i]) {
                return back()
                    ->withInput()
                    ->withErrors(['medical_test_id' => 'One or more selected medical tests do not belong to their chosen categories.']);
            }
            $totalPrice += $test->price ?? 0;
        }

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Remove header row
            array_shift($rows);

            $processedRows = 0;
            $errorRows = [];

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 because we removed header and arrays are 0-indexed

                // Validate required fields
                $errors = [];
                
                if (empty($row[0])) {
                    $errors[] = 'First Name is required';
                }
                
                if (empty($row[1])) {
                    $errors[] = 'Last Name is required';
                }
                
                // Handle separate age and sex fields
                $age = null;
                $sex = null;
                
                if (empty($row[2]) || !is_numeric($row[2])) {
                    $errors[] = 'Age must be a valid number';
                } else {
                    $age = (int) $row[2];
                }
                
                if (empty($row[3])) {
                    $errors[] = 'Sex is required';
                } else {
                    $sex = ucfirst(strtolower(trim($row[3])));
                    if (!in_array($sex, ['Male', 'Female'])) {
                        $errors[] = 'Sex must be Male or Female';
                    }
                }
                
                if (empty($row[4]) || !filter_var($row[4], FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Valid Email is required';
                }
                
                if (empty($row[5])) {
                    $errors[] = 'Phone Number is required';
                }

                if (!empty($errors)) {
                    $errorRows[] = [
                        'row' => $rowNumber,
                        'errors' => $errors,
                        'data' => $row
                    ];
                } else {
                    // Check for duplicate records (same first name, last name, and email)
                    $firstName = trim($row[0]);
                    $lastName = trim($row[1]);
                    $email = trim($row[4]);
                    
                    $existingRecord = PreEmploymentRecord::where('first_name', $firstName)
                        ->where('last_name', $lastName)
                        ->where('email', $email)
                        ->where('created_by', Auth::id())
                        ->first();
                    
                    if ($existingRecord) {
                        $errorRows[] = [
                            'row' => $rowNumber,
                            'errors' => ['Duplicate record: A person with the same name and email already exists'],
                            'data' => $row
                        ];
                    } else {
                        $processedRows++;
                        
                        // Create the pre-employment record
                        $record = PreEmploymentRecord::create([
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'age' => $age,
                            'sex' => $sex,
                            'email' => $email,
                            'phone_number' => trim($row[5]),
                            'total_price' => $totalPrice,
                            'other_exams' => $request->package_other_exams,
                            'billing_type' => $request->billing_type,
                            'company_name' => $request->company_name,
                            'uploaded_file' => $file->getClientOriginalName(),
                            'created_by' => Auth::id(),
                        ]);

                        // Create the medical test associations
                        for ($i = 0; $i < count($categoryIds); $i++) {
                            $test = MedicalTest::find($testIds[$i]);
                            PreEmploymentMedicalTest::create([
                                'pre_employment_record_id' => $record->id,
                                'medical_test_category_id' => $categoryIds[$i],
                                'medical_test_id' => $testIds[$i],
                                'test_price' => $test->price ?? 0,
                            ]);
                        }
                    }
                }
            }

            if ($processedRows > 0) {
                $message = "Successfully processed {$processedRows} pre-employment records.";
                if (!empty($errorRows)) {
                    $duplicateCount = count(array_filter($errorRows, function($error) {
                        return in_array('Duplicate record: A person with the same name and email already exists', $error['errors']);
                    }));
                    if ($duplicateCount > 0) {
                        $message .= " {$duplicateCount} duplicate records were skipped.";
                    }
                }
                return redirect()->route('company.pre-employment.index')
                    ->with('success', $message);
            } else {
                $errorMessage = 'No valid records found in the Excel file. Please check your data format.';
                if (!empty($errorRows)) {
                    $duplicateCount = count(array_filter($errorRows, function($error) {
                        return in_array('Duplicate record: A person with the same name and email already exists', $error['errors']);
                    }));
                    if ($duplicateCount > 0) {
                        $errorMessage = "All records were duplicates or had validation errors. {$duplicateCount} duplicate records were found.";
                    }
                }
                return back()
                    ->withInput()
                    ->with('error', $errorMessage);
            }

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $record = PreEmploymentRecord::with(['medicalTests', 'medicalTestCategories', 'preEmploymentMedicalTests.medicalTestCategory'])
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        
        return view('company.pre-employment.show', compact('record'));
    }

    public function edit($id)
    {
        $record = PreEmploymentRecord::with(['medicalTests', 'medicalTestCategories', 'preEmploymentMedicalTests'])
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        
        // Check if record can be edited
        if (in_array($record->status, ['approved', 'completed'])) {
            return redirect()->route('company.pre-employment.show', $record->id)
                ->with('error', 'This record cannot be edited because it has been ' . $record->status . '.');
        }

        $medicalTestCategories = MedicalTestCategory::with(['activeMedicalTests' => function($query) {
            $query->distinct();
        }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->distinct()
            ->get();

        return view('company.pre-employment.edit', compact('record', 'medicalTestCategories'));
    }

    public function update(Request $request, $id)
    {
        $record = PreEmploymentRecord::where('created_by', Auth::id())->findOrFail($id);
        
        // Check if record can be edited
        if (in_array($record->status, ['approved', 'completed'])) {
            return redirect()->route('company.pre-employment.show', $record->id)
                ->with('error', 'This record cannot be edited because it has been ' . $record->status . '.');
        }

        // Decode JSON arrays from frontend
        $categoryIds = json_decode($request->medical_test_categories_id, true);
        $testIds = json_decode($request->medical_test_id, true);
        
        // Replace the request data with decoded arrays for validation
        $request->merge([
            'medical_test_categories_id' => $categoryIds,
            'medical_test_id' => $testIds,
        ]);

        $validated = $request->validate([
            'medical_test_categories_id' => 'required|array|min:1',
            'medical_test_categories_id.*' => 'exists:medical_test_categories,id',
            'medical_test_id' => 'required|array|min:1',
            'medical_test_id.*' => 'exists:medical_tests,id',
            'package_other_exams' => 'nullable|string',
            'billing_type' => 'required|in:Patient,Company',
            'company_name' => 'required_if:billing_type,Company|nullable|string',
        ]);

        // Validate that arrays have the same length and tests belong to their categories
        if (count($categoryIds) !== count($testIds)) {
            return back()
                ->withInput()
                ->withErrors(['medical_test_id' => 'Number of categories and tests must match.']);
        }

        // Validate each test belongs to its corresponding category
        $totalPrice = 0;
        for ($i = 0; $i < count($categoryIds); $i++) {
            $test = MedicalTest::find($testIds[$i]);
            if (!$test || (int) $test->medical_test_category_id !== (int) $categoryIds[$i]) {
                return back()
                    ->withInput()
                    ->withErrors(['medical_test_id' => 'One or more selected medical tests do not belong to their chosen categories.']);
            }
            $totalPrice += $test->price ?? 0;
        }

        // Update the record
        $record->update([
            'total_price' => $totalPrice,
            'other_exams' => $request->package_other_exams,
            'billing_type' => $request->billing_type,
            'company_name' => $request->company_name,
        ]);

        // Delete existing medical test associations
        $record->preEmploymentMedicalTests()->delete();

        // Create new medical test associations
        for ($i = 0; $i < count($categoryIds); $i++) {
            $test = MedicalTest::find($testIds[$i]);
            PreEmploymentMedicalTest::create([
                'pre_employment_record_id' => $record->id,
                'medical_test_category_id' => $categoryIds[$i],
                'medical_test_id' => $testIds[$i],
                'test_price' => $test->price ?? 0,
            ]);
        }

        return redirect()->route('company.pre-employment.show', $record->id)
            ->with('success', 'Pre-employment record updated successfully.');
    }

    public function destroy($id)
    {
        $record = PreEmploymentRecord::where('created_by', Auth::id())->findOrFail($id);
        
        // Check if record can be deleted
        if (in_array($record->status, ['approved', 'completed'])) {
            return redirect()->route('company.pre-employment.show', $record->id)
                ->with('error', 'This record cannot be deleted because it has been ' . $record->status . '.');
        }

        // Delete associated medical tests
        $record->preEmploymentMedicalTests()->delete();
        
        // Delete the record
        $record->delete();

        return redirect()->route('company.pre-employment.index')
            ->with('success', 'Pre-employment record deleted successfully.');
    }

    public function download($id)
    {
        $record = PreEmploymentRecord::where('created_by', Auth::id())->findOrFail($id);
        
        if (!$record->uploaded_file) {
            return redirect()->route('company.pre-employment.show', $record->id)
                ->with('error', 'No file available for download.');
        }

        // In a real application, you would store the actual file path
        // For now, we'll create a simple response
        $filePath = storage_path('app/pre-employment-files/' . $record->uploaded_file);
        
        if (!file_exists($filePath)) {
            return redirect()->route('company.pre-employment.show', $record->id)
                ->with('error', 'File not found.');
        }

        return response()->download($filePath, $record->uploaded_file);
    }
}