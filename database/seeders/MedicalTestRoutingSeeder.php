<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MedicalTest;
use App\Models\MedicalTestRouting;
use App\Models\MedicalTestCategory;

class MedicalTestRoutingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define routing rules based on test names and categories
        $routingRules = [
            // Pre-Employment Tests
            'AUDIOMETRY AND ISHIHARA ONLY' => [
                ['staff_role' => 'nurse', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'doctor', 'priority' => 2, 'requires_special_note' => false],
            ],
            // Pre-Employment Medical Examination - Composite examination with multiple components
            'Pre-Employment Medical Examination' => [
                // Physical Examination (Height, Weight, Temp, Heart Rate, Eye Acuity, Skin Marks)
                ['staff_role' => 'nurse', 'priority' => 1, 'requires_special_note' => true, 'special_note_template' => 'Physical Examination: Height, Weight, Temperature, Heart Rate, Eye Acuity, Skin Marks assessment'],
                // X-Ray
                ['staff_role' => 'radtech', 'priority' => 2, 'requires_special_note' => true, 'special_note_template' => 'X-Ray imaging required for pre-employment examination'],
                ['staff_role' => 'radiologist', 'priority' => 3, 'requires_special_note' => true, 'special_note_template' => 'X-Ray interpretation for pre-employment examination'],
                // Blood Collection and Lab Tests (CBC)
                ['staff_role' => 'phlebotomist', 'priority' => 4, 'requires_special_note' => true, 'special_note_template' => 'Blood collection for CBC - pre-employment examination'],
                // Lab Analysis (CBC, Fecalysis, Urinalysis)
                ['staff_role' => 'pathologist', 'priority' => 5, 'requires_special_note' => true, 'special_note_template' => 'Lab analysis: CBC, Fecalysis, Urinalysis for pre-employment examination'],
                // Final Medical Review
                ['staff_role' => 'doctor', 'priority' => 6, 'requires_special_note' => true, 'special_note_template' => 'Final medical review and clearance - compile all test results'],
            ],
            'Pre-Employment with Drug Test' => [
                // Physical Examination + Drug Test coordination
                ['staff_role' => 'nurse', 'priority' => 1, 'requires_special_note' => true, 'special_note_template' => 'Physical Examination: Height, Weight, Temperature, Heart Rate, Eye Acuity, Skin Marks + coordinate drug test'],
                // X-Ray
                ['staff_role' => 'radtech', 'priority' => 2, 'requires_special_note' => true, 'special_note_template' => 'X-Ray imaging required for pre-employment with drug test'],
                ['staff_role' => 'radiologist', 'priority' => 3, 'requires_special_note' => true, 'special_note_template' => 'X-Ray interpretation for pre-employment with drug test'],
                // Blood Collection
                ['staff_role' => 'phlebotomist', 'priority' => 4, 'requires_special_note' => true, 'special_note_template' => 'Blood collection for CBC - pre-employment with drug test'],
                // Drug Test
                ['staff_role' => 'med_tech', 'priority' => 5, 'requires_special_note' => true, 'special_note_template' => 'Drug test required for pre-employment - verify patient ID'],
                // Lab Analysis
                ['staff_role' => 'pathologist', 'priority' => 6, 'requires_special_note' => true, 'special_note_template' => 'Lab analysis: CBC, Fecalysis, Urinalysis + drug test results for pre-employment'],
                // Final Review
                ['staff_role' => 'doctor', 'priority' => 7, 'requires_special_note' => true, 'special_note_template' => 'Final medical review including drug test results - compile all test results'],
            ],
            'Pre-Employment with ECG and Drug test' => [
                // Physical Examination + ECG and Drug Test coordination
                ['staff_role' => 'nurse', 'priority' => 1, 'requires_special_note' => true, 'special_note_template' => 'Physical Examination: Height, Weight, Temperature, Heart Rate, Eye Acuity, Skin Marks + coordinate ECG and drug test'],
                // X-Ray
                ['staff_role' => 'radtech', 'priority' => 2, 'requires_special_note' => true, 'special_note_template' => 'X-Ray imaging required for pre-employment with ECG and drug test'],
                ['staff_role' => 'radiologist', 'priority' => 3, 'requires_special_note' => true, 'special_note_template' => 'X-Ray interpretation for pre-employment with ECG and drug test'],
                // ECG
                ['staff_role' => 'ecg_tech', 'priority' => 4, 'requires_special_note' => true, 'special_note_template' => 'ECG required for pre-employment with drug test - ensure proper electrode placement'],
                // Blood Collection
                ['staff_role' => 'phlebotomist', 'priority' => 5, 'requires_special_note' => true, 'special_note_template' => 'Blood collection for CBC - pre-employment with ECG and drug test'],
                // Drug Test
                ['staff_role' => 'med_tech', 'priority' => 6, 'requires_special_note' => true, 'special_note_template' => 'Drug test required for pre-employment - verify patient ID'],
                // Lab Analysis
                ['staff_role' => 'pathologist', 'priority' => 7, 'requires_special_note' => true, 'special_note_template' => 'Lab analysis: CBC, Fecalysis, Urinalysis + drug test results for pre-employment'],
                // Final Review
                ['staff_role' => 'doctor', 'priority' => 8, 'requires_special_note' => true, 'special_note_template' => 'Final medical review including ECG and drug test results - compile all test results'],
            ],
            'Pre-Employment with Drug test and AUDIO and ISHIHARA' => [
                ['staff_role' => 'nurse', 'priority' => 1, 'requires_special_note' => true, 'special_note_template' => 'Patient requires drug test, audiometry and Ishihara test'],
                ['staff_role' => 'med_tech', 'priority' => 2, 'requires_special_note' => true, 'special_note_template' => 'Drug test required - includes audiometry and Ishihara'],
                ['staff_role' => 'doctor', 'priority' => 3, 'requires_special_note' => false],
            ],
            'Drug test only (bring valid I.D)' => [
                ['staff_role' => 'med_tech', 'priority' => 1, 'requires_special_note' => true, 'special_note_template' => 'Drug test only - verify valid ID'],
            ],

            // Annual Medical Examinations - Composite examination with multiple components
            'Annual Medical Examination' => [
                // Physical Examination (Height, Weight, Temp, Heart Rate, Eye Acuity, Skin Marks)
                ['staff_role' => 'nurse', 'priority' => 1, 'requires_special_note' => true, 'special_note_template' => 'Physical Examination: Height, Weight, Temperature, Heart Rate, Eye Acuity, Skin Marks assessment'],
                // X-Ray
                ['staff_role' => 'radtech', 'priority' => 2, 'requires_special_note' => true, 'special_note_template' => 'X-Ray imaging required for annual medical examination'],
                ['staff_role' => 'radiologist', 'priority' => 3, 'requires_special_note' => true, 'special_note_template' => 'X-Ray interpretation for annual medical examination'],
                // Blood Collection and Lab Tests (CBC)
                ['staff_role' => 'phlebotomist', 'priority' => 4, 'requires_special_note' => true, 'special_note_template' => 'Blood collection for CBC - annual medical examination'],
                // Lab Analysis (CBC, Fecalysis, Urinalysis)
                ['staff_role' => 'pathologist', 'priority' => 5, 'requires_special_note' => true, 'special_note_template' => 'Lab analysis: CBC, Fecalysis, Urinalysis for annual medical examination'],
                // Final Medical Review
                ['staff_role' => 'doctor', 'priority' => 6, 'requires_special_note' => true, 'special_note_template' => 'Final medical review and clearance - compile all test results'],
            ],
            'Annual Medical with Drug Test' => [
                // Physical Examination + Drug Test coordination
                ['staff_role' => 'nurse', 'priority' => 1, 'requires_special_note' => true, 'special_note_template' => 'Physical Examination: Height, Weight, Temperature, Heart Rate, Eye Acuity, Skin Marks + coordinate drug test'],
                // X-Ray
                ['staff_role' => 'radtech', 'priority' => 2, 'requires_special_note' => true, 'special_note_template' => 'X-Ray imaging required for annual medical with drug test'],
                ['staff_role' => 'radiologist', 'priority' => 3, 'requires_special_note' => true, 'special_note_template' => 'X-Ray interpretation for annual medical with drug test'],
                // Blood Collection
                ['staff_role' => 'phlebotomist', 'priority' => 4, 'requires_special_note' => true, 'special_note_template' => 'Blood collection for CBC - annual medical with drug test'],
                // Drug Test
                ['staff_role' => 'med_tech', 'priority' => 5, 'requires_special_note' => true, 'special_note_template' => 'Drug test for annual medical examination - verify patient ID'],
                // Lab Analysis
                ['staff_role' => 'pathologist', 'priority' => 6, 'requires_special_note' => true, 'special_note_template' => 'Lab analysis: CBC, Fecalysis, Urinalysis + drug test results for annual medical'],
                // Final Review
                ['staff_role' => 'doctor', 'priority' => 7, 'requires_special_note' => true, 'special_note_template' => 'Final medical review including drug test results - compile all test results'],
            ],
            'Annual Medical with ECG and Drug test' => [
                // Physical Examination + ECG and Drug Test coordination
                ['staff_role' => 'nurse', 'priority' => 1, 'requires_special_note' => true, 'special_note_template' => 'Physical Examination: Height, Weight, Temperature, Heart Rate, Eye Acuity, Skin Marks + coordinate ECG and drug test'],
                // X-Ray
                ['staff_role' => 'radtech', 'priority' => 2, 'requires_special_note' => true, 'special_note_template' => 'X-Ray imaging required for annual medical with ECG and drug test'],
                ['staff_role' => 'radiologist', 'priority' => 3, 'requires_special_note' => true, 'special_note_template' => 'X-Ray interpretation for annual medical with ECG and drug test'],
                // ECG
                ['staff_role' => 'ecg_tech', 'priority' => 4, 'requires_special_note' => true, 'special_note_template' => 'ECG required for annual medical with drug test - ensure proper electrode placement'],
                // Blood Collection
                ['staff_role' => 'phlebotomist', 'priority' => 5, 'requires_special_note' => true, 'special_note_template' => 'Blood collection for CBC - annual medical with ECG and drug test'],
                // Drug Test
                ['staff_role' => 'med_tech', 'priority' => 6, 'requires_special_note' => true, 'special_note_template' => 'Drug test for annual medical examination - verify patient ID'],
                // Lab Analysis
                ['staff_role' => 'pathologist', 'priority' => 7, 'requires_special_note' => true, 'special_note_template' => 'Lab analysis: CBC, Fecalysis, Urinalysis + drug test results for annual medical'],
                // Final Review
                ['staff_role' => 'doctor', 'priority' => 8, 'requires_special_note' => true, 'special_note_template' => 'Final medical review including ECG and drug test results - compile all test results'],
            ],

            // Blood Tests - Route to Phlebotomist first, then Pathologist
            'CBC' => [
                ['staff_role' => 'phlebotomist', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],
            'FBS' => [
                ['staff_role' => 'phlebotomist', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],
            'Cholesterol' => [
                ['staff_role' => 'phlebotomist', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],
            'Triglycerides' => [
                ['staff_role' => 'phlebotomist', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],
            'HDL & LDL' => [
                ['staff_role' => 'phlebotomist', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],

            // X-Ray Tests - Route to Radtech first, then Radiologist
            'CXR-PA 11X14' => [
                ['staff_role' => 'radtech', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'radiologist', 'priority' => 2, 'requires_special_note' => false],
            ],
            'Chest X-ray with Package' => [
                ['staff_role' => 'radtech', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'radiologist', 'priority' => 2, 'requires_special_note' => false],
            ],

            // ECG Tests - Route to ECG Tech
            'Electrocardiogram' => [
                ['staff_role' => 'ecg_tech', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'doctor', 'priority' => 2, 'requires_special_note' => false],
            ],

            // Drug Tests - Route to Med Tech
            'Drugtest (Met & THC)' => [
                ['staff_role' => 'med_tech', 'priority' => 1, 'requires_special_note' => true, 'special_note_template' => 'Drug test for Methamphetamine and THC'],
            ],

            // Urine/Stool Tests - Route to Med Tech first, then Pathologist
            'Urinalysis' => [
                ['staff_role' => 'med_tech', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],
            'Fecalysis' => [
                ['staff_role' => 'med_tech', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],

            // Special Tests
            'Pregnancy Test' => [
                ['staff_role' => 'med_tech', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],

            // Histology - Route to Pathologist
            'Papsmear' => [
                ['staff_role' => 'nurse', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],

            // Serology Tests - Route to Med Tech first, then Pathologist
            'VDRL' => [
                ['staff_role' => 'phlebotomist', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],
            'HBsAg (Latex)' => [
                ['staff_role' => 'phlebotomist', 'priority' => 1, 'requires_special_note' => false],
                ['staff_role' => 'pathologist', 'priority' => 2, 'requires_special_note' => false],
            ],
        ];

        // Process each routing rule
        foreach ($routingRules as $testName => $routes) {
            // Find the medical test by name
            $medicalTest = MedicalTest::where('name', $testName)->first();
            
            if ($medicalTest) {
                // Delete existing routing rules for this test
                MedicalTestRouting::where('medical_test_id', $medicalTest->id)->delete();
                
                // Create new routing rules
                foreach ($routes as $route) {
                    MedicalTestRouting::create([
                        'medical_test_id' => $medicalTest->id,
                        'staff_role' => $route['staff_role'],
                        'priority' => $route['priority'],
                        'requires_special_note' => $route['requires_special_note'] ?? false,
                        'special_note_template' => $route['special_note_template'] ?? null,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Create default routing for tests without specific rules
        $testsWithoutRouting = MedicalTest::whereNotIn('id', function($query) {
            $query->select('medical_test_id')->from('medical_test_routings');
        })->get();

        foreach ($testsWithoutRouting as $test) {
            // Default routing: Nurse -> Doctor
            MedicalTestRouting::create([
                'medical_test_id' => $test->id,
                'staff_role' => 'nurse',
                'priority' => 1,
                'requires_special_note' => false,
                'is_active' => true,
            ]);
            
            MedicalTestRouting::create([
                'medical_test_id' => $test->id,
                'staff_role' => 'doctor',
                'priority' => 2,
                'requires_special_note' => false,
                'is_active' => true,
            ]);
        }
    }
}
