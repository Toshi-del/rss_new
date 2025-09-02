<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PreEmploymentRecord;
use App\Models\User;
use Carbon\Carbon;

class MedicalResultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a company user
        $companyUser = User::where('role', 'company')->first();
        
        if (!$companyUser) {
            $this->command->info('No company user found. Please create a company user first.');
            return;
        }

        // Create sample annual physical appointments
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
                    'age' => 35,
                    'sex' => 'Male',
                    'email' => 'john.doe@example.com',
                    'phone' => '09123456789',
                    'appointment_id' => $appointment->id,
                ],
                [
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'age' => 28,
                    'sex' => 'Female',
                    'email' => 'jane.smith@example.com',
                    'phone' => '09187654321',
                    'appointment_id' => $appointment->id,
                ],
            ];
            
            foreach ($patients as $patientData) {
                Patient::create($patientData);
            }
        }

        // Create sample pre-employment records
        $preEmploymentRecords = [
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'age' => 32,
                'sex' => 'Male',
                'email' => 'michael.johnson@example.com',
                'phone_number' => '09111222333',
                'medical_exam_type' => 'comprehensive',
                'blood_tests' => ['cbc', 'chemistry', 'hiv'],
                'other_exams' => 'Chest X-ray, ECG',
                'billing_type' => 'Company',
                'company_name' => $companyUser->company_name ?? 'Sample Company',
                'status' => 'Approved',
                'created_by' => $companyUser->id,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'age' => 29,
                'sex' => 'Female',
                'email' => 'sarah.wilson@example.com',
                'phone_number' => '09444555666',
                'medical_exam_type' => 'basic',
                'blood_tests' => ['cbc'],
                'other_exams' => 'None',
                'billing_type' => 'Patient',
                'company_name' => $companyUser->company_name ?? 'Sample Company',
                'status' => 'Declined',
                'created_by' => $companyUser->id,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'age' => 41,
                'sex' => 'Male',
                'email' => 'david.brown@example.com',
                'phone_number' => '09777888999',
                'medical_exam_type' => 'comprehensive',
                'blood_tests' => ['cbc', 'chemistry', 'hiv', 'hepatitis'],
                'other_exams' => 'Chest X-ray, ECG, Drug Test',
                'billing_type' => 'Company',
                'company_name' => $companyUser->company_name ?? 'Sample Company',
                'status' => 'Pending',
                'created_by' => $companyUser->id,
            ],
        ];

        foreach ($preEmploymentRecords as $recordData) {
            PreEmploymentRecord::create($recordData);
        }

        $this->command->info('Sample medical results data created successfully!');
    }
}
