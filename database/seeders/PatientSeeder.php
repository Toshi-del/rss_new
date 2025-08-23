<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a company user to create appointments
        $companyUser = User::where('role', 'company')->first();
        
        if (!$companyUser) {
            $this->command->info('No company user found. Please create a company user first.');
            return;
        }

        // Create sample appointments first
        $appointments = [
            [
                'appointment_date' => Carbon::now()->subDays(5),
                'time_slot' => '09:00 AM',
                'appointment_type' => 'annual_physical',
                'status' => 'completed',
                'created_by' => $companyUser->id,
            ],
            [
                'appointment_date' => Carbon::now()->subDays(3),
                'time_slot' => '10:30 AM',
                'appointment_type' => 'annual_physical',
                'status' => 'completed',
                'created_by' => $companyUser->id,
            ],
            [
                'appointment_date' => Carbon::now()->subDays(1),
                'time_slot' => '02:00 PM',
                'appointment_type' => 'annual_physical',
                'status' => 'pending',
                'created_by' => $companyUser->id,
            ],
        ];

        foreach ($appointments as $appointmentData) {
            $appointment = Appointment::create($appointmentData);
            
            // Create sample patients for each appointment
            $patients = [
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'middle_name' => 'Michael',
                    'age' => 35,
                    'sex' => 'Male',
                    'email' => 'john.doe@example.com',
                    'phone' => '09123456789',
                    'appointment_id' => $appointment->id,
                ],
                [
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'middle_name' => 'Elizabeth',
                    'age' => 28,
                    'sex' => 'Female',
                    'email' => 'jane.smith@example.com',
                    'phone' => '09187654321',
                    'appointment_id' => $appointment->id,
                ],
                [
                    'first_name' => 'Robert',
                    'last_name' => 'Johnson',
                    'middle_name' => 'David',
                    'age' => 42,
                    'sex' => 'Male',
                    'email' => 'robert.johnson@example.com',
                    'phone' => '09234567890',
                    'appointment_id' => $appointment->id,
                ],
                [
                    'first_name' => 'Sarah',
                    'last_name' => 'Wilson',
                    'middle_name' => 'Anne',
                    'age' => 31,
                    'sex' => 'Female',
                    'email' => 'sarah.wilson@example.com',
                    'phone' => '09345678901',
                    'appointment_id' => $appointment->id,
                ],
                [
                    'first_name' => 'Michael',
                    'last_name' => 'Brown',
                    'middle_name' => 'James',
                    'age' => 39,
                    'sex' => 'Male',
                    'email' => 'michael.brown@example.com',
                    'phone' => '09456789012',
                    'appointment_id' => $appointment->id,
                ],
            ];
            
            foreach ($patients as $patientData) {
                Patient::create($patientData);
            }
        }

        $this->command->info('Sample patients data created successfully!');
    }
}
