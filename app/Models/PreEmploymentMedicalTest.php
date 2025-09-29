<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreEmploymentMedicalTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pre_employment_record_id',
        'medical_test_id',
        'medical_test_category_id',
    ];

    /**
     * Get the pre-employment record that owns this medical test
     */
    public function preEmploymentRecord()
    {
        return $this->belongsTo(PreEmploymentRecord::class);
    }

    /**
     * Get the medical test
     */
    public function medicalTest()
    {
        return $this->belongsTo(MedicalTest::class);
    }

    /**
     * Get the medical test category
     */
    public function medicalTestCategory()
    {
        return $this->belongsTo(MedicalTestCategory::class);
    }
}
