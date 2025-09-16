<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpdTest extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'medical_test',
        'appointment_date',
        'appointment_time',
        'price',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'price' => 'decimal:2',
    ];

    /**
     * Get the OPD examination for this test
     */
    public function opdExamination()
    {
        return $this->hasOne(OpdExamination::class);
    }

    /**
     * Get the medical checklist for this test
     */
    public function medicalChecklist()
    {
        return $this->hasOne(MedicalChecklist::class);
    }

    /**
     * Scope for approved tests
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending tests
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
