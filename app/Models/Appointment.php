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
        'medical_test_categories_id',
        'medical_test_id',
        'notes',
        'patients_data',
        'excel_file_path',
        'created_by',
        'status',
        'total_price',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'patients_data' => 'array',
        'total_price' => 'decimal:2',
    ];

    public function medicalTestCategory(): BelongsTo
    {
        return $this->belongsTo(MedicalTestCategory::class, 'medical_test_categories_id');
    }

    public function medicalTest(): BelongsTo
    {
        return $this->belongsTo(MedicalTest::class, 'medical_test_id');
    }

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