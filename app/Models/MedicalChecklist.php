<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalChecklist extends Model
{
    // Define examination types for consistency
    public const EXAMINATION_TYPES = [
        'Chest X-Ray',
        'Stool Exam',
        'Urinalysis', 
        'Drug Test',
        'Blood Extraction',
        'ElectroCardioGram (ECG)',
        'Physical Exam'
    ];

    protected $fillable = [
        'user_id',
        'patient_id',
        'pre_employment_record_id',
        'annual_physical_examination_id',
        'opd_examination_id',
        'name',
        'age',
        'number',
        'date',
        // Individual examination fields - only done_by fields
        'chest_xray_done_by',
        'stool_exam_done_by',
        'urinalysis_done_by',
        'drug_test_done_by',
        'blood_extraction_done_by',
        'ecg_done_by',
        'physical_exam_done_by',
        'optional_exam',
        'doctor_signature',
        'examination_type',
        // X-ray image
        'xray_image_path',
    ];

    protected $casts = [
        'date' => 'date',
        'xray_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function preEmploymentRecord(): BelongsTo
    {
        return $this->belongsTo(PreEmploymentRecord::class);
    }

    public function annualPhysicalExamination(): BelongsTo
    {
        return $this->belongsTo(AnnualPhysicalExamination::class);
    }

    public function preEmploymentExamination(): BelongsTo
    {
        return $this->belongsTo(PreEmploymentExamination::class, 'pre_employment_record_id', 'pre_employment_record_id');
    }

    public function radtech(): BelongsTo
    {
        return $this->belongsTo(User::class, 'radtech_id');
    }

    public function opdExamination(): BelongsTo
    {
        return $this->belongsTo(OpdExamination::class);
    }
}
