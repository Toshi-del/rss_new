<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\PreEmploymentRecord;
use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
use Carbon\Carbon;

class PatientDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create patient users
        $patients = [
            [
                'fname' => 'Jane',
                'lname' => 'Doe',
                'mname' => 'Marie',
                'email' => 'patient@rsshealth.com',
                'phone' => '09123456789',
                'birthday' => '1995-12-25',
                'age' => 29,
                'company' => 'AsiaPro',
                'role' => 'patient',
                'password' => Hash::make('password'),
            ],
            [
                'fname' => 'John',
                'lname' => 'Smith',
                'mname' => 'Robert',
                'email' => 'john.smith@rsshealth.com',
                'phone' => '09187654321',
                'birthday' => '1990-08-15',
                'age' => 34,
                'company' => 'Pasig Catholic College',
                'role' => 'patient',
                'password' => Hash::make('password'),
            ],
            [
                'fname' => 'Maria',
                'lname' => 'Garcia',
                'mname' => 'Santos',
                'email' => 'maria.garcia@rsshealth.com',
                'phone' => '09234567890',
                'birthday' => '1988-03-10',
                'age' => 36,
                'company' => 'PrimeLime',
                'role' => 'patient',
                'password' => Hash::make('password'),
            ],
            [
                'fname' => 'Carlos',
                'lname' => 'Rodriguez',
                'mname' => 'Lopez',
                'email' => 'carlos.rodriguez@rsshealth.com',
                'phone' => '09345678901',
                'birthday' => '1992-11-20',
                'age' => 32,
                'company' => 'AsiaPro',
                'role' => 'patient',
                'password' => Hash::make('password'),
            ],
            [
                'fname' => 'Ana',
                'lname' => 'Martinez',
                'mname' => 'Cruz',
                'email' => 'ana.martinez@rsshealth.com',
                'phone' => '09456789012',
                'birthday' => '1997-06-05',
                'age' => 27,
                'company' => 'Pasig Catholic College',
                'role' => 'patient',
                'password' => Hash::make('password'),
            ],
        ];

                foreach ($patients as $patientData) {
            $user = User::firstOrCreate(
                ['email' => $patientData['email']],
                $patientData
            );
        }

        // Create appointments
        $appointments = [
            [
                'appointment_date' => Carbon::now()->addDays(5),
                'time_slot' => '9:00 AM',
                'appointment_type' => 'Annual Physical Examination',
                'blood_chemistry' => ['FBS', 'LIPID', 'HBSAG'],
                'notes' => 'Regular annual checkup',
                'patients_data' => [],
                'status' => 'Pending',
                'created_by' => 1, // Assuming admin user ID
            ],
            [
                'appointment_date' => Carbon::now()->addDays(10),
                'time_slot' => '2:00 PM',
                'appointment_type' => 'Pre-Employment Medical Examination',
                'blood_chemistry' => ['FBS', 'LIPID', 'HBSAG', 'CREATININE', 'BUN'],
                'notes' => 'Pre-employment screening',
                'patients_data' => [],
                'status' => 'Approved',
                'created_by' => 1,
            ],
            [
                'appointment_date' => Carbon::now()->subDays(15),
                'time_slot' => '10:30 AM',
                'appointment_type' => 'General Checkup',
                'blood_chemistry' => ['FBS'],
                'notes' => 'Routine health check',
                'patients_data' => [],
                'status' => 'completed',
                'created_by' => 1,
            ],
        ];

        foreach ($appointments as $appointmentData) {
            $appointment = Appointment::create($appointmentData);
            
            // Create patient records for each appointment
            foreach (User::where('role', 'patient')->take(3)->get() as $index => $user) {
                Patient::firstOrCreate(
                    ['email' => $user->email, 'appointment_id' => $appointment->id],
                    [
                        'first_name' => $user->fname,
                        'last_name' => $user->lname,
                        'middle_name' => $user->mname,
                        'age' => $user->age,
                        'sex' => $user->fname === 'Jane' || $user->fname === 'Maria' || $user->fname === 'Ana' ? 'Female' : 'Male',
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'appointment_id' => $appointment->id,
                    ]
                );
            }
        }

        // Create pre-employment records
        $preEmploymentRecords = [
            [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'age' => 29,
                'sex' => 'Female',
                'email' => 'patient@rsshealth.com',
                'phone_number' => '09123456789',
                'medical_exam_type' => 'Pre-Employment Medical Examination',
                'blood_tests' => ['FBS', 'LIPID', 'HBSAG', 'CREATININE'],
                'other_exams' => 'Chest X-Ray, ECG',
                'billing_type' => 'Company',
                'company_name' => 'AsiaPro',
                'status' => 'Approved',
                'created_by' => 1,
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'age' => 34,
                'sex' => 'Male',
                'email' => 'john.smith@rsshealth.com',
                'phone_number' => '09187654321',
                'medical_exam_type' => 'Pre-Employment with Drug Test',
                'blood_tests' => ['FBS', 'LIPID', 'HBSAG', 'CREATININE', 'BUN'],
                'other_exams' => 'Chest X-Ray, Drug Test',
                'billing_type' => 'Company',
                'company_name' => 'Pasig Catholic College',
                'status' => 'Pending',
                'created_by' => 1,
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Garcia',
                'age' => 36,
                'sex' => 'Female',
                'email' => 'maria.garcia@rsshealth.com',
                'phone_number' => '09234567890',
                'medical_exam_type' => 'Pre-Employment with ECG & Drug Test',
                'blood_tests' => ['FBS', 'LIPID', 'HBSAG', 'CREATININE', 'BUN', 'HEPA A IGM'],
                'other_exams' => 'Chest X-Ray, ECG, Drug Test',
                'billing_type' => 'Company',
                'company_name' => 'PrimeLime',
                'status' => 'Pending',
                'created_by' => 1,
            ],
        ];

        foreach ($preEmploymentRecords as $recordData) {
            PreEmploymentRecord::firstOrCreate(
                ['email' => $recordData['email']],
                $recordData
            );
        }

        // Create pre-employment examinations
        $preEmploymentExaminations = [
            [
                'user_id' => 1,
                'name' => 'Jane Doe',
                'company_name' => 'AsiaPro',
                'date' => Carbon::now()->subDays(30),
                'status' => 'completed',
                'illness_history' => 'No significant medical history',
                'accidents_operations' => 'None',
                'past_medical_history' => 'Occasional seasonal allergies',
                'family_history' => ['hypertension', 'diabetes'],
                'personal_habits' => ['coffee_tea'],
                'physical_exam' => [
                    'temp' => '36.8°C',
                    'height' => '165 cm',
                    'heart_rate' => '72 bpm',
                    'weight' => '58 kg'
                ],
                'skin_marks' => 'Small birthmark on left forearm',
                'visual' => '20/20 both eyes',
                'ishihara_test' => 'Normal color vision',
                'findings' => 'Normal physical examination',
                'lab_report' => [
                    'urinalysis' => 'Normal',
                    'cbc' => 'Normal',
                    'xray' => 'Normal chest X-ray',
                    'fecalysis' => 'Normal',
                    'blood_chemistry' => 'Normal',
                    'others' => 'None'
                ],
                'physical_findings' => [
                    'Neck' => ['result' => 'Normal', 'findings' => 'No palpable masses'],
                    'Chest-Breast Axilla' => ['result' => 'Normal', 'findings' => 'Clear breath sounds'],
                    'Lungs' => ['result' => 'Normal', 'findings' => 'No wheezing or crackles'],
                    'Heart' => ['result' => 'Normal', 'findings' => 'Regular rhythm, no murmurs'],
                    'Abdomen' => ['result' => 'Normal', 'findings' => 'Soft, non-tender'],
                    'Extremities' => ['result' => 'Normal', 'findings' => 'No edema or deformities'],
                    'Anus-Rectum' => ['result' => 'Normal', 'findings' => 'No abnormalities'],
                    'G.U.T' => ['result' => 'Normal', 'findings' => 'No complaints'],
                    'Inguinal / Genital' => ['result' => 'Normal', 'findings' => 'No hernias']
                ],
                'lab_findings' => [
                    'Chest X-Ray' => ['result' => 'Normal', 'findings' => 'Clear lung fields'],
                    'Urinalysis' => ['result' => 'Normal', 'findings' => 'No protein or glucose'],
                    'Fecalysis' => ['result' => 'Normal', 'findings' => 'No ova or parasites'],
                    'CBC' => ['result' => 'Normal', 'findings' => 'Hemoglobin 13.5 g/dL'],
                    'Drug Test' => ['result' => 'Negative', 'findings' => 'No illicit substances detected'],
                    'HBsAg Screening' => ['result' => 'Negative', 'findings' => 'No hepatitis B infection'],
                    'HEPA A IGG & IGM' => ['result' => 'Negative', 'findings' => 'No hepatitis A infection'],
                    'Others' => ['result' => 'N/A', 'findings' => 'N/A']
                ],
                'ecg' => 'Normal sinus rhythm, no abnormalities detected',
                'pre_employment_record_id' => 1,
            ],
            [
                'user_id' => 2,
                'name' => 'John Smith',
                'company_name' => 'Pasig Catholic College',
                'date' => Carbon::now()->subDays(15),
                'status' => 'pending',
                'illness_history' => 'History of mild asthma',
                'accidents_operations' => 'Appendectomy 2015',
                'past_medical_history' => 'Well-controlled asthma',
                'family_history' => ['asthma', 'heart_disease'],
                'personal_habits' => ['cigarettes', 'coffee_tea'],
                'physical_exam' => [
                    'temp' => '37.1°C',
                    'height' => '178 cm',
                    'heart_rate' => '76 bpm',
                    'weight' => '75 kg'
                ],
                'skin_marks' => 'Surgical scar on right lower abdomen',
                'visual' => '20/25 both eyes',
                'ishihara_test' => 'Normal color vision',
                'findings' => 'Mild wheezing on auscultation',
                'lab_report' => [
                    'urinalysis' => 'Normal',
                    'cbc' => 'Normal',
                    'xray' => 'Pending',
                    'fecalysis' => 'Normal',
                    'blood_chemistry' => 'Pending',
                    'others' => 'Drug test pending'
                ],
                'physical_findings' => [
                    'Neck' => ['result' => 'Normal', 'findings' => 'No palpable masses'],
                    'Chest-Breast Axilla' => ['result' => 'Mild wheezing', 'findings' => 'Bilateral wheezing on expiration'],
                    'Lungs' => ['result' => 'Mild wheezing', 'findings' => 'Decreased air entry'],
                    'Heart' => ['result' => 'Normal', 'findings' => 'Regular rhythm, no murmurs'],
                    'Abdomen' => ['result' => 'Normal', 'findings' => 'Surgical scar present'],
                    'Extremities' => ['result' => 'Normal', 'findings' => 'No edema or deformities'],
                    'Anus-Rectum' => ['result' => 'Normal', 'findings' => 'No abnormalities'],
                    'G.U.T' => ['result' => 'Normal', 'findings' => 'No complaints'],
                    'Inguinal / Genital' => ['result' => 'Normal', 'findings' => 'No hernias']
                ],
                'lab_findings' => [
                    'Chest X-Ray' => ['result' => 'Pending', 'findings' => 'Scheduled for next week'],
                    'Urinalysis' => ['result' => 'Normal', 'findings' => 'No protein or glucose'],
                    'Fecalysis' => ['result' => 'Normal', 'findings' => 'No ova or parasites'],
                    'CBC' => ['result' => 'Normal', 'findings' => 'Hemoglobin 14.2 g/dL'],
                    'Drug Test' => ['result' => 'Pending', 'findings' => 'Scheduled for next week'],
                    'HBsAg Screening' => ['result' => 'Negative', 'findings' => 'No hepatitis B infection'],
                    'HEPA A IGG & IGM' => ['result' => 'Negative', 'findings' => 'No hepatitis A infection'],
                    'Others' => ['result' => 'N/A', 'findings' => 'N/A']
                ],
                'ecg' => 'Pending',
                'pre_employment_record_id' => 2,
            ],
        ];

        foreach ($preEmploymentExaminations as $examData) {
            PreEmploymentExamination::firstOrCreate(
                ['pre_employment_record_id' => $examData['pre_employment_record_id']],
                $examData
            );
        }

        // Create annual physical examinations
        $annualPhysicalExaminations = [
            [
                'user_id' => 1,
                'patient_id' => 1,
                'name' => 'Jane Doe',
                'date' => Carbon::now()->subDays(60),
                'status' => 'completed',
                'illness_history' => 'No significant medical history',
                'accidents_operations' => 'None',
                'past_medical_history' => 'Occasional seasonal allergies',
                'family_history' => ['hypertension', 'diabetes'],
                'personal_habits' => ['coffee_tea'],
                'physical_exam' => [
                    'temp' => '36.7°C',
                    'height' => '165 cm',
                    'heart_rate' => '70 bpm',
                    'weight' => '57 kg'
                ],
                'skin_marks' => 'Small birthmark on left forearm',
                'visual' => '20/20 both eyes',
                'ishihara_test' => 'Normal color vision',
                'findings' => 'Normal physical examination',
                'lab_report' => [
                    'urinalysis' => 'Normal',
                    'cbc' => 'Normal',
                    'xray' => 'Normal chest X-ray',
                    'fecalysis' => 'Normal',
                    'blood_chemistry' => 'Normal',
                    'others' => 'None'
                ],
                'physical_findings' => [
                    'Neck' => ['result' => 'Normal', 'findings' => 'No palpable masses'],
                    'Chest-Breast Axilla' => ['result' => 'Normal', 'findings' => 'Clear breath sounds'],
                    'Lungs' => ['result' => 'Normal', 'findings' => 'No wheezing or crackles'],
                    'Heart' => ['result' => 'Normal', 'findings' => 'Regular rhythm, no murmurs'],
                    'Abdomen' => ['result' => 'Normal', 'findings' => 'Soft, non-tender'],
                    'Extremities' => ['result' => 'Normal', 'findings' => 'No edema or deformities'],
                    'Anus-Rectum' => ['result' => 'Normal', 'findings' => 'No abnormalities'],
                    'G.U.T' => ['result' => 'Normal', 'findings' => 'No complaints'],
                    'Inguinal / Genital' => ['result' => 'Normal', 'findings' => 'No hernias']
                ],
                'lab_findings' => [
                    'Chest X-Ray' => ['result' => 'Normal', 'findings' => 'Clear lung fields'],
                    'Urinalysis' => ['result' => 'Normal', 'findings' => 'No protein or glucose'],
                    'Fecalysis' => ['result' => 'Normal', 'findings' => 'No ova or parasites'],
                    'CBC' => ['result' => 'Normal', 'findings' => 'Hemoglobin 13.8 g/dL'],
                    'Drug Test' => ['result' => 'Negative', 'findings' => 'No illicit substances detected'],
                    'HBsAg Screening' => ['result' => 'Negative', 'findings' => 'No hepatitis B infection'],
                    'HEPA A IGG & IGM' => ['result' => 'Negative', 'findings' => 'No hepatitis A infection'],
                    'Others' => ['result' => 'N/A', 'findings' => 'N/A']
                ],
                'ecg' => 'Normal sinus rhythm, no abnormalities detected',
            ],
            [
                'user_id' => 3,
                'patient_id' => 3,
                'name' => 'Maria Garcia',
                'date' => Carbon::now()->subDays(45),
                'status' => 'completed',
                'illness_history' => 'History of mild hypertension',
                'accidents_operations' => 'None',
                'past_medical_history' => 'Well-controlled hypertension with medication',
                'family_history' => ['hypertension', 'diabetes', 'heart_disease'],
                'personal_habits' => ['alcohol', 'coffee_tea'],
                'physical_exam' => [
                    'temp' => '36.9°C',
                    'height' => '160 cm',
                    'heart_rate' => '78 bpm',
                    'weight' => '65 kg'
                ],
                'skin_marks' => 'None',
                'visual' => '20/30 both eyes',
                'ishihara_test' => 'Normal color vision',
                'findings' => 'Mildly elevated blood pressure',
                'lab_report' => [
                    'urinalysis' => 'Normal',
                    'cbc' => 'Normal',
                    'xray' => 'Normal chest X-ray',
                    'fecalysis' => 'Normal',
                    'blood_chemistry' => 'Mildly elevated cholesterol',
                    'others' => 'None'
                ],
                'physical_findings' => [
                    'Neck' => ['result' => 'Normal', 'findings' => 'No palpable masses'],
                    'Chest-Breast Axilla' => ['result' => 'Normal', 'findings' => 'Clear breath sounds'],
                    'Lungs' => ['result' => 'Normal', 'findings' => 'No wheezing or crackles'],
                    'Heart' => ['result' => 'Normal', 'findings' => 'Regular rhythm, no murmurs'],
                    'Abdomen' => ['result' => 'Normal', 'findings' => 'Soft, non-tender'],
                    'Extremities' => ['result' => 'Normal', 'findings' => 'No edema or deformities'],
                    'Anus-Rectum' => ['result' => 'Normal', 'findings' => 'No abnormalities'],
                    'G.U.T' => ['result' => 'Normal', 'findings' => 'No complaints'],
                    'Inguinal / Genital' => ['result' => 'Normal', 'findings' => 'No hernias']
                ],
                'lab_findings' => [
                    'Chest X-Ray' => ['result' => 'Normal', 'findings' => 'Clear lung fields'],
                    'Urinalysis' => ['result' => 'Normal', 'findings' => 'No protein or glucose'],
                    'Fecalysis' => ['result' => 'Normal', 'findings' => 'No ova or parasites'],
                    'CBC' => ['result' => 'Normal', 'findings' => 'Hemoglobin 12.8 g/dL'],
                    'Drug Test' => ['result' => 'Negative', 'findings' => 'No illicit substances detected'],
                    'HBsAg Screening' => ['result' => 'Negative', 'findings' => 'No hepatitis B infection'],
                    'HEPA A IGG & IGM' => ['result' => 'Negative', 'findings' => 'No hepatitis A infection'],
                    'Others' => ['result' => 'N/A', 'findings' => 'N/A']
                ],
                'ecg' => 'Normal sinus rhythm, no abnormalities detected',
            ],
        ];

        foreach ($annualPhysicalExaminations as $examData) {
            AnnualPhysicalExamination::firstOrCreate(
                ['patient_id' => $examData['patient_id']],
                $examData
            );
        }
    }
}
