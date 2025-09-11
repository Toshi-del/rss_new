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
}
