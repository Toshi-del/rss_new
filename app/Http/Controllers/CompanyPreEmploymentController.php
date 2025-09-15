<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\PreEmploymentRecord;
use App\Models\MedicalTestCategory;
use App\Models\MedicalTest;

class CompanyPreEmploymentController extends Controller
{
    public function index()
    {
        $files = PreEmploymentRecord::with(['medicalTestCategory', 'medicalTest'])
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
        $validated = $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
            'medical_test_categories_id' => 'required|exists:medical_test_categories,id',
            'medical_test_id' => 'required|exists:medical_tests,id',
            'package_other_exams' => 'nullable|string',
            'billing_type' => 'required|in:Patient,Company',
            'company_name' => 'required_if:billing_type,Company|nullable|string',
        ]);

        // Ensure the selected test belongs to the selected category
        $selectedTest = MedicalTest::find($request->medical_test_id);
        if (!$selectedTest || (int) $selectedTest->medical_test_category_id !== (int) $request->medical_test_categories_id) {
            return back()
                ->withInput()
                ->withErrors(['medical_test_id' => 'Selected medical test does not belong to the chosen category.']);
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
                        
                        // Save to database with price of selected medical test
                        PreEmploymentRecord::create([
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'age' => $age,
                            'sex' => $sex,
                            'email' => $email,
                            'phone_number' => trim($row[5]),
                            'medical_test_categories_id' => $request->medical_test_categories_id,
                            'medical_test_id' => $request->medical_test_id,
                            'total_price' => $selectedTest->price ?? 0,
                            'other_exams' => $request->package_other_exams,
                            'billing_type' => $request->billing_type,
                            'company_name' => $request->company_name,
                            'uploaded_file' => $file->getClientOriginalName(),
                            'created_by' => Auth::id(),
                        ]);
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
        $record = PreEmploymentRecord::with(['medicalTestCategory', 'medicalTest'])
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        
        return view('company.pre-employment.show', compact('record'));
    }
} 