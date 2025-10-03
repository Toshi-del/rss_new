<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'drug_test',
        'physical_findings',
        'lab_findings',
        'ecg',
        'ecg_date',
        'ecg_technician',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'family_history' => 'array',
        'personal_habits' => 'array',
        'physical_exam' => 'array',
        'lab_report' => 'array',
        'drug_test' => 'array',
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

    public function drugTestResults(): HasMany
    {
        return $this->hasMany(DrugTestResult::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value) return $value;
                $patient = $this->patient;
                return $patient ? $patient->full_name : null;
            }
        );
    }
}
