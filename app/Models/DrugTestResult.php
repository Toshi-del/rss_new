<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrugTestResult extends Model
{
    protected $fillable = [
        'user_id',
        'nurse_id',
        'pre_employment_record_id',
        'pre_employment_examination_id',
        'annual_physical_examination_id',
        'appointment_id',
        'opd_examination_id',
        'patient_name',
        'address',
        'age',
        'gender',
        'examination_datetime',
        'last_intake_date',
        'test_method',
        'methamphetamine_result',
        'methamphetamine_remarks',
        'marijuana_result',
        'marijuana_remarks',
        'test_conducted_by',
        'conforme',
        'status',
        'completed_at'
    ];

    protected $casts = [
        'examination_datetime' => 'datetime',
        'last_intake_date' => 'date',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }

    public function preEmploymentRecord(): BelongsTo
    {
        return $this->belongsTo(PreEmploymentRecord::class);
    }

    public function preEmploymentExamination(): BelongsTo
    {
        return $this->belongsTo(PreEmploymentExamination::class);
    }

    public function annualPhysicalExamination(): BelongsTo
    {
        return $this->belongsTo(AnnualPhysicalExamination::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function opdExamination(): BelongsTo
    {
        return $this->belongsTo(OpdExamination::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeSentToDoctor($query)
    {
        return $query->where('status', 'sent_to_doctor');
    }

    // Accessors
    public function getIsPositiveAttribute(): bool
    {
        return $this->methamphetamine_result === 'Positive' || $this->marijuana_result === 'Positive';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => '<span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending</span>',
            'completed' => '<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Completed</span>',
            'sent_to_doctor' => '<span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Sent to Doctor</span>',
            default => '<span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Unknown</span>'
        };
    }

    // Methods
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }

    public function sendToDoctor(): void
    {
        $this->update(['status' => 'sent_to_doctor']);
    }
}
