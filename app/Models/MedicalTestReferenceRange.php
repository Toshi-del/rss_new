<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalTestReferenceRange extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_test_id',
        'reference_name',
        'reference_range',
        'sort_order',
    ];

    /**
     * Get the medical test that owns the reference range.
     */
    public function medicalTest()
    {
        return $this->belongsTo(MedicalTest::class);
    }
}
