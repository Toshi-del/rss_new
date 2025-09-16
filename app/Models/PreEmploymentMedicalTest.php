<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreEmploymentMedicalTest extends Model
{
    protected $fillable = [
        'pre_employment_record_id',
        'medical_test_category_id',
        'medical_test_id',
        'test_price',
    ];

    protected $casts = [
        'test_price' => 'decimal:2',
    ];

    public function preEmploymentRecord(): BelongsTo
    {
        return $this->belongsTo(PreEmploymentRecord::class);
    }

    public function medicalTestCategory(): BelongsTo
    {
        return $this->belongsTo(MedicalTestCategory::class);
    }

    public function medicalTest(): BelongsTo
    {
        return $this->belongsTo(MedicalTest::class);
    }
}
