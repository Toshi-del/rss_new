<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\MedicalTest;
use App\Models\MedicalTestRouting;
use App\Models\AppointmentTestAssignment;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MedicalTestRoutingService
{
    /**
     * Route tests for an approved appointment
     */
    public function routeTestsForAppointment(Appointment $appointment): array
    {
        $assignments = [];
        $medicalTest = $appointment->medicalTest;
        
        if (!$medicalTest) {
            Log::warning("No medical test found for appointment {$appointment->id}");
            return $assignments;
        }

        // Get routing rules for this test
        $routingRules = MedicalTestRouting::getRoutingForTest($medicalTest->id);
        
        if ($routingRules->isEmpty()) {
            // Create default routing if none exists
            $this->createDefaultRouting($medicalTest);
            $routingRules = MedicalTestRouting::getRoutingForTest($medicalTest->id);
        }

        // Create assignments based on routing rules
        foreach ($routingRules as $rule) {
            $specialNotes = $this->generateSpecialNotes($rule, $appointment, $medicalTest);
            $assignedUser = $this->findAvailableUserForRole($rule->staff_role);
            
            $assignment = AppointmentTestAssignment::create([
                'appointment_id' => $appointment->id,
                'medical_test_id' => $medicalTest->id,
                'staff_role' => $rule->staff_role,
                'assigned_to_user_id' => $assignedUser ? $assignedUser->id : null,
                'status' => 'pending',
                'special_notes' => $specialNotes,
                'assigned_at' => now(),
            ]);
            
            $assignments[] = $assignment;
        }

        return $assignments;
    }

    /**
     * Generate special notes for test assignment
     */
    private function generateSpecialNotes(MedicalTestRouting $rule, Appointment $appointment, MedicalTest $medicalTest): ?string
    {
        $notes = [];
        
        // Add template-based notes
        if ($rule->special_note_template) {
            $appointmentData = [
                'test_name' => $medicalTest->name,
                'appointment_date' => $appointment->appointment_date,
                'time_slot' => $appointment->time_slot,
                'company' => $appointment->creator->company ?? 'N/A',
            ];
            
            $notes[] = $rule->generateSpecialNote($appointmentData);
        }

        // Add specific notes based on test name
        $testName = strtolower($medicalTest->name);
        
        if (str_contains($testName, 'drug test')) {
            $notes[] = "⚠️ Drug test required - verify patient ID and collect specimen";
        }
        
        if (str_contains($testName, 'ecg') || str_contains($testName, 'electrocardiogram')) {
            $notes[] = "📊 ECG test required - ensure patient is relaxed and electrodes are properly placed";
        }
        
        if (str_contains($testName, 'ishihara')) {
            $notes[] = "👁️ Ishihara color vision test - ensure proper lighting conditions";
        }
        
        if (str_contains($testName, 'audiometry')) {
            $notes[] = "🔊 Audiometry test - ensure quiet environment for accurate results";
        }
        
        if (str_contains($testName, 'x-ray') || str_contains($testName, 'cxr')) {
            $notes[] = "📸 X-ray imaging required - verify patient preparation and positioning";
        }

        return !empty($notes) ? implode("\n", $notes) : null;
    }

    /**
     * Create default routing for a test
     */
    private function createDefaultRouting(MedicalTest $medicalTest): void
    {
        // Default: Nurse first, then Doctor
        MedicalTestRouting::create([
            'medical_test_id' => $medicalTest->id,
            'staff_role' => 'nurse',
            'priority' => 1,
            'requires_special_note' => false,
            'is_active' => true,
        ]);
        
        MedicalTestRouting::create([
            'medical_test_id' => $medicalTest->id,
            'staff_role' => 'doctor',
            'priority' => 2,
            'requires_special_note' => false,
            'is_active' => true,
        ]);
    }

    /**
     * Get test assignments summary for an appointment
     */
    public function getTestAssignmentsSummary(Appointment $appointment): array
    {
        $assignments = AppointmentTestAssignment::getAssignmentsForAppointment($appointment->id);
        
        $summary = [
            'total_assignments' => $assignments->count(),
            'by_staff_role' => [],
            'by_status' => [],
            'special_notes' => [],
        ];
        
        foreach ($assignments as $assignment) {
            // Count by staff role
            if (!isset($summary['by_staff_role'][$assignment->staff_role])) {
                $summary['by_staff_role'][$assignment->staff_role] = 0;
            }
            $summary['by_staff_role'][$assignment->staff_role]++;
            
            // Count by status
            if (!isset($summary['by_status'][$assignment->status])) {
                $summary['by_status'][$assignment->status] = 0;
            }
            $summary['by_status'][$assignment->status]++;
            
            // Collect special notes
            if ($assignment->special_notes) {
                $summary['special_notes'][] = [
                    'staff_role' => $assignment->staff_role,
                    'notes' => $assignment->special_notes,
                ];
            }
        }
        
        return $summary;
    }

    /**
     * Get assignments for specific staff role
     */
    public function getAssignmentsForStaff(string $staffRole, string $status = null): array
    {
        return AppointmentTestAssignment::getAssignmentsForStaffRole($staffRole, $status)->toArray();
    }

    /**
     * Check if test should exclude certain components
     */
    public function shouldExcludeTestComponent(MedicalTest $medicalTest, string $component): bool
    {
        $testName = strtolower($medicalTest->name);
        $component = strtolower($component);
        
        // Annual Medical Examination excludes Ishihara and ECG by default
        if (str_contains($testName, 'annual medical examination') && !str_contains($testName, 'ecg')) {
            if ($component === 'ishihara' || $component === 'ecg') {
                return true;
            }
        }
        
        // Pre-employment without ECG excludes ECG
        if (str_contains($testName, 'pre-employment') && !str_contains($testName, 'ecg')) {
            if ($component === 'ecg') {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get staff role display name
     */
    public function getStaffRoleDisplayName(string $staffRole): string
    {
        $displayNames = [
            'doctor' => 'Doctor',
            'nurse' => 'Nurse',
            'phlebotomist' => 'Phlebotomist',
            'pathologist' => 'Pathologist',
            'radiologist' => 'Radiologist',
            'radtech' => 'Radiology Technician',
            'ecg_tech' => 'ECG Technician',
            'med_tech' => 'Medical Technologist',
        ];
        
        return $displayNames[$staffRole] ?? ucfirst($staffRole);
    }

    /**
     * Find an available user for a specific staff role
     */
    private function findAvailableUserForRole(string $staffRole): ?User
    {
        // Map staff roles to user roles in the system
        $roleMapping = [
            'doctor' => 'doctor',
            'nurse' => 'nurse',
            'phlebotomist' => 'plebo',
            'pathologist' => 'pathologist',
            'radiologist' => 'radiologist',
            'radtech' => 'radtech',
            'ecg_tech' => 'ecgtech',
            'med_tech' => 'nurse', // Map med_tech to nurse since medtech role doesn't exist
        ];

        $userRole = $roleMapping[$staffRole] ?? $staffRole;
        
        // Find users with the required role
        $availableUsers = User::where('role', $userRole)->get();
        
        if ($availableUsers->isEmpty()) {
            Log::warning("No users found with role: {$userRole} for staff role: {$staffRole}");
            return null;
        }

        // For now, assign to the first available user
        // In the future, this could be enhanced with load balancing logic
        return $availableUsers->first();
    }
}
