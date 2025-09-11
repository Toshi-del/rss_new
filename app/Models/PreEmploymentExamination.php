<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PreEmploymentExamination extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'company_name',
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
        'pre_employment_record_id',
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

    public function preEmploymentRecord(): BelongsTo
    {
        return $this->belongsTo(PreEmploymentRecord::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value) return $value;
                $record = $this->preEmploymentRecord;
                return $record ? ($record->first_name . ' ' . $record->last_name) : null;
            }
        );
    }

    protected function companyName(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value) return $value;
                $record = $this->preEmploymentRecord;
                return $record ? $record->company_name : null;
            }
        );
    }
}
