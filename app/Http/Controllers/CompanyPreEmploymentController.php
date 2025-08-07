<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\PreEmploymentRecord;

class CompanyPreEmploymentController extends Controller
{
    public function index()
    {
        $files = PreEmploymentRecord::where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('company.pre-employment.index', compact('files'));
    }

    public function create()
    {
        $bloodTests = [
            'FBS',
            'LIPID',
            'HBSAG',
            'CREATININE',
            'BUN',
            'HEPA A IGM'
        ];

        return view('company.pre-employment.create', compact('bloodTests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
            'medical_exam_type' => 'required|string',
            'blood_tests' => 'array',
            'package_other_exams' => 'nullable|string',
            'billing_type' => 'required|in:Patient,Company',
            'company_name' => 'required_if:billing_type,Company|nullable|string',
        ]);

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
                    $processedRows++;
                    
                    // Save to database
                    PreEmploymentRecord::create([
                        'first_name' => trim($row[0]),
                        'last_name' => trim($row[1]),
                        'age' => $age,
                        'sex' => $sex,
                        'email' => trim($row[3]),
                        'phone_number' => trim($row[4]),
                        'medical_exam_type' => $request->medical_exam_type,
                        'blood_tests' => $request->blood_tests ?? [],
                        'other_exams' => $request->package_other_exams,
                        'billing_type' => $request->billing_type,
                        'company_name' => $request->company_name,
                        'uploaded_file' => $file->getClientOriginalName(),
                        'created_by' => Auth::id(),
                    ]);
                }
            }

            if ($processedRows > 0) {
                return redirect()->route('company.pre-employment.index')
                    ->with('success', "Successfully processed {$processedRows} pre-employment records.");
            } else {
                return back()
                    ->withInput()
                    ->with('error', 'No valid records found in the Excel file. Please check your data format.');
            }

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $record = PreEmploymentRecord::where('created_by', Auth::id())
            ->findOrFail($id);
        
        return view('company.pre-employment.show', compact('record'));
    }
} 