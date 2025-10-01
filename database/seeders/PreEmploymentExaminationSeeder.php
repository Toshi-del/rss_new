<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreEmploymentExamination;
use App\Models\PreEmploymentRecord;
use App\Models\User;
use Carbon\Carbon;

class PreEmploymentExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates comprehensive pre-employment examination records
     * with data from different medical staff to test data flow and integration.
     */
    public function run(): void
    {
        // Get users for different roles
        $nurse = User::where('role', 'nurse')->first();
        $pathologist = User::where('role', 'pathologist')->first();
        $radiologist = User::where('role', 'radiologist')->first();
        $ecgTech = User::where('role', 'ecg_tech')->first();
        
        // Get some pre-employment records
        $records = PreEmploymentRecord::where('status', 'approved')->take(5)->get();
        
        if ($records->isEmpty()) {
            $this->command->warn('No approved pre-employment records found. Please run PreEmploymentRecordSeeder first.');
            return;
        }
        
        if (!$nurse || !$pathologist) {
            $this->command->warn('Required users (nurse, pathologist) not found. Please run UserSeeder first.');
            return;
        }
        
        $this->command->info('Creating comprehensive pre-employment examinations...');
        
        foreach ($records as $index => $record) {
            // Create examination with nurse's data (initial examination)
            $examination = PreEmploymentExamination::create([
                'pre_employment_record_id' => $record->id,
                'user_id' => $record->created_by,
                'name' => $record->first_name . ' ' . $record->last_name,
                'company_name' => $record->company_name,
                'date' => Carbon::now()->subDays(rand(1, 30)),
                'status' => 'Approved',
                'created_by' => $nurse->id,
                
                // Medical History (filled by nurse)
                'illness_history' => $this->getRandomIllnessHistory(),
                'accidents_operations' => $this->getRandomAccidentsOperations(),
                'past_medical_history' => $this->getRandomPastMedicalHistory(),
                
                // Family History (filled by nurse)
                'family_history' => $this->getRandomFamilyHistory(),
                
                // Personal Habits (filled by nurse)
                'personal_habits' => $this->getRandomPersonalHabits(),
                
                // Physical Examination (filled by nurse)
                'physical_exam' => [
                    'temp' => rand(360, 380) / 10 . '°C',
                    'height' => rand(150, 190) . ' cm',
                    'weight' => rand(50, 90) . ' kg',
                    'heart_rate' => rand(60, 100) . ' bpm',
                    'blood_pressure' => rand(110, 130) . '/' . rand(70, 90) . ' mmHg',
                ],
                
                // Skin Marks (filled by nurse)
                'skin_marks' => $this->getRandomSkinMarks(),
                
                // Visual Assessment (filled by nurse)
                'visual' => $this->getRandomVisualAcuity(),
                'ishihara_test' => $this->getRandomIshiharaTest(),
                
                // General Findings (filled by nurse)
                'findings' => $this->getRandomFindings(),
                
                // Laboratory Report (filled by pathologist)
                'lab_report' => [
                    'urinalysis' => $this->getRandomLabResult(),
                    'urinalysis_findings' => $this->getRandomLabFindings('urinalysis'),
                    'cbc' => $this->getRandomLabResult(),
                    'cbc_findings' => $this->getRandomLabFindings('cbc'),
                    'xray' => 'Normal',
                    'xray_findings' => 'No active pulmonary disease',
                    'fecalysis' => $this->getRandomLabResult(),
                    'fecalysis_findings' => $this->getRandomLabFindings('fecalysis'),
                    'blood_chemistry' => $this->getRandomLabResult(),
                    'drug_test' => 'Negative',
                    'drug_test_findings' => 'No drugs detected',
                    'hbsag_screening' => rand(0, 1) ? 'Non-Reactive' : 'Reactive',
                    'hepa_a_igg_igm' => 'Non-Reactive',
                    'others' => 'All tests within normal limits',
                ],
                
                // Physical Findings (filled by doctor)
                'physical_findings' => [
                    'Neck' => [
                        'result' => 'Normal',
                        'findings' => 'No palpable masses, no lymphadenopathy'
                    ],
                    'Chest-Breast Axilla' => [
                        'result' => 'Normal',
                        'findings' => 'Symmetrical chest expansion, no masses'
                    ],
                    'Lungs' => [
                        'result' => 'Clear',
                        'findings' => 'Clear breath sounds bilaterally'
                    ],
                    'Heart' => [
                        'result' => 'Normal',
                        'findings' => 'Regular rate and rhythm, no murmurs'
                    ],
                    'Abdomen' => [
                        'result' => 'Soft',
                        'findings' => 'Non-tender, no organomegaly'
                    ],
                    'Extremities' => [
                        'result' => 'Normal',
                        'findings' => 'Full range of motion, no deformities'
                    ],
                    'Anus-Rectum' => [
                        'result' => 'Normal',
                        'findings' => 'No abnormalities noted'
                    ],
                    'GUT' => [
                        'result' => 'Normal',
                        'findings' => 'No abnormalities'
                    ],
                    'Inguinal / Genital' => [
                        'result' => 'Normal',
                        'findings' => 'No hernias, no masses'
                    ],
                ],
                
                // Lab Findings (filled by radiologist/pathologist)
                'lab_findings' => [
                    'chest_xray' => [
                        'result' => 'Normal',
                        'finding' => 'Heart and lungs are normal in size and appearance. No active pulmonary disease.',
                        'reviewed_by' => $radiologist ? $radiologist->id : null,
                        'reviewed_at' => Carbon::now()->subDays(rand(1, 5))->toDateTimeString(),
                    ],
                ],
                
                // ECG (filled by ECG tech)
                'ecg' => $ecgTech ? $this->getRandomECGResult() : null,
                'ecg_date' => $ecgTech ? Carbon::now()->subDays(rand(1, 5))->toDateString() : null,
                'ecg_technician' => $ecgTech ? ($ecgTech->fname . ' ' . $ecgTech->lname) : null,
            ]);
            
            $this->command->info("Created examination #{$examination->id} for {$examination->name}");
        }
        
        $this->command->info('Pre-employment examinations seeded successfully!');
    }
    
    /**
     * Get random illness history
     */
    private function getRandomIllnessHistory(): string
    {
        $options = [
            'No previous hospitalizations',
            'Hospitalized for appendectomy in 2018',
            'Admitted for pneumonia in 2020, fully recovered',
            'No significant illness history',
            'Hospitalized for dengue fever in 2019',
        ];
        
        return $options[array_rand($options)];
    }
    
    /**
     * Get random accidents/operations
     */
    private function getRandomAccidentsOperations(): string
    {
        $options = [
            'No previous accidents or operations',
            'Minor vehicular accident in 2019, no major injuries',
            'Appendectomy performed in 2017',
            'Tonsillectomy as a child',
            'No surgical history',
        ];
        
        return $options[array_rand($options)];
    }
    
    /**
     * Get random past medical history
     */
    private function getRandomPastMedicalHistory(): string
    {
        $options = [
            'No significant past medical history',
            'History of childhood asthma, currently asymptomatic',
            'Seasonal allergies, controlled with antihistamines',
            'No chronic medical conditions',
            'History of hypertension, well-controlled with medication',
        ];
        
        return $options[array_rand($options)];
    }
    
    /**
     * Get random family history
     */
    private function getRandomFamilyHistory(): array
    {
        $conditions = ['asthma', 'diabetes', 'heart_disease', 'hypertension', 'cancer'];
        $selected = [];
        
        // Randomly select 0-3 conditions
        $count = rand(0, 3);
        for ($i = 0; $i < $count; $i++) {
            $selected[] = $conditions[array_rand($conditions)];
        }
        
        return array_unique($selected);
    }
    
    /**
     * Get random personal habits
     */
    private function getRandomPersonalHabits(): array
    {
        return [
            'alcohol' => rand(0, 1),
            'cigarettes' => rand(0, 1),
            'coffee_tea' => rand(0, 1),
        ];
    }
    
    /**
     * Get random skin marks
     */
    private function getRandomSkinMarks(): string
    {
        $options = [
            'No identifying marks, scars, or tattoos',
            'Small scar on left knee from childhood injury',
            'Mole on right shoulder, approximately 5mm',
            'Birthmark on lower back',
            'Tattoo on left forearm - tribal design',
            'Surgical scar on abdomen from appendectomy',
        ];
        
        return $options[array_rand($options)];
    }
    
    /**
     * Get random visual acuity
     */
    private function getRandomVisualAcuity(): string
    {
        $options = [
            '20/20 both eyes uncorrected',
            '20/20 both eyes with correction',
            'OD: 20/20, OS: 20/25 uncorrected',
            '20/30 both eyes, correctable to 20/20',
            '20/20 right eye, 20/30 left eye',
        ];
        
        return $options[array_rand($options)];
    }
    
    /**
     * Get random Ishihara test result
     */
    private function getRandomIshiharaTest(): string
    {
        $options = [
            'Normal color vision - all plates identified correctly',
            'Passed - 15/15 plates correctly identified',
            'Normal - no color vision deficiency detected',
            'Mild red-green color deficiency detected',
            'Normal color perception',
        ];
        
        return $options[array_rand($options)];
    }
    
    /**
     * Get random findings
     */
    private function getRandomFindings(): string
    {
        $options = [
            'Patient appears healthy and fit for employment',
            'No significant abnormalities noted',
            'All systems within normal limits',
            'Patient is in good general health',
            'Fit for duty with no restrictions',
        ];
        
        return $options[array_rand($options)];
    }
    
    /**
     * Get random lab result
     */
    private function getRandomLabResult(): string
    {
        $options = [
            'Normal',
            'Within normal limits',
            'No abnormalities detected',
        ];
        
        return $options[array_rand($options)];
    }
    
    /**
     * Get random lab findings
     */
    private function getRandomLabFindings(string $testType): string
    {
        $findings = [
            'urinalysis' => [
                'Color: Yellow, Transparency: Clear, pH: 6.0, Specific Gravity: 1.020',
                'Normal urinalysis - no abnormal findings',
                'WBC: 0-2/hpf, RBC: 0-1/hpf, No bacteria',
            ],
            'cbc' => [
                'WBC: 7.5 x10^9/L, RBC: 5.0 x10^12/L, Hgb: 14.5 g/dL, Hct: 42%',
                'All parameters within normal range',
                'Platelet count: 250 x10^9/L, Normal differential',
            ],
            'fecalysis' => [
                'No ova or parasites seen',
                'Normal stool examination',
                'Color: Brown, Consistency: Formed, No blood',
            ],
        ];
        
        $options = $findings[$testType] ?? ['Normal findings'];
        return $options[array_rand($options)];
    }
    
    /**
     * Get random ECG result
     */
    private function getRandomECGResult(): string
    {
        $options = [
            'Normal sinus rhythm, rate 72 bpm, normal axis, no ST-T changes',
            'Sinus rhythm, HR 68 bpm, normal ECG',
            'Regular sinus rhythm, rate 75 bpm, no abnormalities',
            'NSR, rate 70 bpm, normal intervals, no ischemic changes',
            'Normal 12-lead ECG, sinus rhythm at 73 bpm',
        ];
        
        return $options[array_rand($options)];
    }
}
