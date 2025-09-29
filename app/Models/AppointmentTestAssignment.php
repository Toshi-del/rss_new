<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentTestAssignment extends Model
{
    protected $fillable = [
        'appointment_id',
        'medical_test_id',
        'staff_role',
        'assigned_to_user_id',
        'status',
        'special_notes',
        'assigned_at',
        'completed_at',
        'results',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function medicalTest(): BelongsTo
    {
        return $this->belongsTo(MedicalTest::class);
    }

    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    /**
     * Get assignments for a specific staff role
     */
    public static function getAssignmentsForStaffRole($staffRole, $status = null)
    {
        $query = self::with(['appointment', 'medicalTest', 'assignedToUser'])
                     ->where('staff_role', $staffRole);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->orderBy('assigned_at', 'desc')->get();
    }

    /**
     * Get assignments for a specific appointment
     */
    public static function getAssignmentsForAppointment($appointmentId)
    {
        return self::with(['medicalTest', 'assignedToUser'])
                   ->where('appointment_id', $appointmentId)
                   ->orderBy('staff_role')
                   ->orderBy('assigned_at')
                   ->get();
    }

    /**
     * Mark assignment as completed
     */
    public function markCompleted($results = null)
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'results' => $results,
        ]);
    }

    /**
     * Check if assignment is overdue (more than 24 hours)
     */
    public function isOverdue(): bool
    {
        if ($this->status === 'completed') {
            return false;
        }
        
        return $this->assigned_at && $this->assigned_at->diffInHours(now()) > 24;
    }
}
