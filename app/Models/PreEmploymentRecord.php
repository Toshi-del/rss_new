<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PreEmploymentRecord extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'sex',
        'email',
        'phone_number',
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

    /**
     * Get all medical tests for this pre-employment record
     */
    public function medicalTests(): BelongsToMany
    {
        return $this->belongsToMany(MedicalTest::class, 'pre_employment_medical_tests')
            ->withPivot(['medical_test_category_id', 'test_price'])
            ->withTimestamps();
    }

    /**
     * Get all medical test categories for this pre-employment record
     */
    public function medicalTestCategories(): BelongsToMany
    {
        return $this->belongsToMany(MedicalTestCategory::class, 'pre_employment_medical_tests')
            ->withPivot(['medical_test_id', 'test_price'])
            ->withTimestamps();
    }

    /**
     * Get the pivot records for medical tests
     */
    public function preEmploymentMedicalTests(): HasMany
    {
        return $this->hasMany(PreEmploymentMedicalTest::class);
    }
}
