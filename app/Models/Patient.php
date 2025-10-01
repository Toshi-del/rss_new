<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'age',
        'sex',
        'email',
        'phone',
        'address',
        'appointment_id',
        'company_name',
    ];

    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function getFullNameAttribute(): string
    {
        $name = $this->first_name . ' ' . $this->last_name;
        if ($this->middle_name) {
            $name = $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
        }
        return $name;
    }

    public function getAgeSexAttribute(): string
    {
        return $this->age . ' / ' . $this->sex;
    }

    public function annualPhysicalExamination(): HasOne
    {
        return $this->hasOne(AnnualPhysicalExamination::class);
    }

    public function medicalChecklist(): HasOne
    {
        return $this->hasOne(MedicalChecklist::class, 'patient_id');
    }

    /**
     * Get all medical checklists for this patient (for filtering)
     */
    public function medicalChecklists(): HasMany
    {
        return $this->hasMany(MedicalChecklist::class, 'patient_id');
    }

}
