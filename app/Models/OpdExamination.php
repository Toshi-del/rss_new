<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdExamination extends Model
{
    use HasFactory;

    protected $table = 'opd_examinations';

    protected $fillable = [
        'user_id',
        'name',
        'date',
        'status',
        'illness_history',
        'accidents_operations',
        'past_medical_history',
        'family_history',
        'personal_habits',
        'physical_exam',
        'physical_findings',
        'lab_findings',
        'ecg',
        'skin_marks',
        'visual',
        'ishihara_test',
        'findings',
        'lab_report',
    ];

    protected $casts = [
        'date' => 'date',
        'family_history' => 'array',
        'personal_habits' => 'array',
        'physical_exam' => 'array',
        'physical_findings' => 'array',
        'lab_findings' => 'array',
        'lab_report' => 'array',
    ];

    /**
     * Get the user that owns the OPD examination
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('M d, Y') : null;
    }

    /**
     * Scope for pending examinations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for completed examinations
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for approved examinations
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Get drug test result for this OPD examination
     */
    public function drugTestResult()
    {
        return $this->hasOne(\App\Models\DrugTestResult::class);
    }
}
