<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PreEmploymentRecord extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'sex',
        'email',
        'phone_number',
        'medical_test_categories_id',
        'medical_test_id',
        'total_price',
        'other_exams',
        'billing_type',
        'company_name',
        'uploaded_file',
        'status',
        'registration_link_sent',
        'created_by',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function preEmploymentExamination(): HasOne
    {
        return $this->hasOne(PreEmploymentExamination::class, 'pre_employment_record_id');
    }

    public function medicalTestCategory(): BelongsTo
    {
        return $this->belongsTo(MedicalTestCategory::class, 'medical_test_categories_id');
    }

    public function medicalTest(): BelongsTo
    {
        return $this->belongsTo(MedicalTest::class, 'medical_test_id');
    }


    // Helper method to parse other_exams JSON data
    public function getParsedOtherExamsAttribute()
    {
        if (empty($this->other_exams)) {
            return null;
        }

        // Try to decode as JSON first
        $decoded = json_decode($this->other_exams, true);
        
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // If not JSON, return as plain text
        return ['additional_exams' => $this->other_exams];
    }

    // Helper method to get all selected tests (including from other_exams)
    public function getAllSelectedTestsAttribute()
    {
        $tests = [];
        
        // Add primary test
        if ($this->medicalTest) {
            $tests[] = [
                'category_id' => $this->medical_test_categories_id,
                'category_name' => $this->medicalTestCategory->name ?? 'Unknown',
                'test_id' => $this->medical_test_id,
                'test_name' => $this->medicalTest->name,
                'price' => $this->medicalTest->price ?? 0,
                'is_primary' => true,
            ];
        }

        // Add tests from other_exams if they exist (excluding the primary test to avoid duplicates)
        $parsedOtherExams = $this->parsed_other_exams;
        if ($parsedOtherExams && isset($parsedOtherExams['selected_tests'])) {
            foreach ($parsedOtherExams['selected_tests'] as $test) {
                // Skip if this is the same as the primary test (avoid duplicates)
                if (isset($test['test_id']) && $test['test_id'] == $this->medical_test_id) {
                    continue;
                }
                
                // If category_name is 'Unknown', try to fetch it from the database
                if (($test['category_name'] ?? '') === 'Unknown' && isset($test['category_id'])) {
                    $category = \App\Models\MedicalTestCategory::find($test['category_id']);
                    if ($category) {
                        $test['category_name'] = $category->name;
                    }
                }
                
                $tests[] = array_merge($test, ['is_primary' => false]);
            }
        }

        return collect($tests);
    }

    /**
     * Get drug test result for this pre-employment record
     */
    public function drugTestResult()
    {
        return $this->hasOne(\App\Models\DrugTestResult::class);
    }
}
