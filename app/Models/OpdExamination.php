<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpdExamination extends Model
{
    protected $fillable = [
        'opd_test_id',
        'customer_name',
        'customer_email',
        'medical_test',
        'date',
        'physical_exam',
        'skin_marks',
        'visual',
        'ishihara_test',
        'findings',
        'test_results',
        'recommendations',
        'status',
        'nurse_id',
    ];

    protected $casts = [
        'date' => 'date',
        'physical_exam' => 'array',
    ];

    /**
     * Get the OPD test that owns this examination
     */
    public function opdTest()
    {
        return $this->belongsTo(OpdTest::class);
    }

    /**
     * Get the nurse who created this examination
     */
    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }

    /**
     * Scope for pending examinations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Scope for examinations sent to doctor
     */
    public function scopeSentToDoctor($query)
    {
        return $query->where('status', 'Sent to Doctor');
    }

    /**
     * Scope for completed examinations
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }
}
