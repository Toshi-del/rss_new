<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    protected $fillable = [
        'appointment_date',
        'time_slot',
        'appointment_type',
        'blood_chemistry',
        'notes',
        'patients_data',
        'excel_file_path',
        'created_by',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'blood_chemistry' => 'array',
        'patients_data' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function getFormattedTimeSlotAttribute(): string
    {
        return $this->time_slot;
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->appointment_date->format('M d, Y');
    }
}