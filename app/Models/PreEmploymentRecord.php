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
        'medical_exam_type',
        'blood_tests',
        'other_exams',
        'billing_type',
        'company_name',
        'uploaded_file',
        'status',
        'registration_link_sent',
        'created_by',
    ];

    protected $casts = [
        'blood_tests' => 'array',
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
}
