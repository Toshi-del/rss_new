<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnualPhysicalExamination extends Model
{
    protected $fillable = [
        'user_id',
        'patient_id',
        'name',
        'date',
        'status',
        'illness_history',
        'accidents_operations',
        'past_medical_history',
        'family_history',
        'personal_habits',
        'physical_exam',
        'skin_marks',
        'visual',
        'ishihara_test',
        'findings',
        'lab_report',
        'physical_findings',
        'lab_findings',
        'ecg',
    ];

    protected $casts = [
        'date' => 'date',
        'family_history' => 'array',
        'personal_habits' => 'array',
        'physical_exam' => 'array',
        'lab_report' => 'array',
        'physical_findings' => 'array',
        'lab_findings' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
