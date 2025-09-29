<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalTestRouting extends Model
{
    protected $fillable = [
        'medical_test_id',
        'staff_role',
        'priority',
        'requires_special_note',
        'special_note_template',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_special_note' => 'boolean',
    ];

    public function medicalTest(): BelongsTo
    {
        return $this->belongsTo(MedicalTest::class);
    }

    /**
     * Get routing rules for a specific medical test
     */
    public static function getRoutingForTest($medicalTestId)
    {
        return self::where('medical_test_id', $medicalTestId)
                   ->where('is_active', true)
                   ->orderBy('priority')
                   ->get();
    }

    /**
     * Get all tests assigned to a specific staff role
     */
    public static function getTestsForStaffRole($staffRole)
    {
        return self::with('medicalTest')
                   ->where('staff_role', $staffRole)
                   ->where('is_active', true)
                   ->get();
    }

    /**
     * Check if a test requires special handling
     */
    public function requiresSpecialHandling(): bool
    {
        return $this->requires_special_note || !empty($this->special_note_template);
    }

    /**
     * Generate special note for this test routing
     */
    public function generateSpecialNote($appointmentData = []): string
    {
        if (!$this->special_note_template) {
            return '';
        }

        $note = $this->special_note_template;
        
        // Replace placeholders with actual data
        foreach ($appointmentData as $key => $value) {
            $note = str_replace("{{$key}}", $value, $note);
        }

        return $note;
    }
}
