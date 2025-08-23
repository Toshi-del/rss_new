<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
use App\Models\User;

class ExaminationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users to associate with examinations
        $users = User::whereIn('role', ['patient', 'company'])->take(5)->get();
        
        if ($users->count() > 0) {
            // Create sample Pre-Employment Examinations
            foreach ($users as $user) {
                PreEmploymentExamination::create([
                    'user_id' => $user->id,
                    'name' => $user->fname . ' ' . $user->lname,
                    'company_name' => $user->company,
                    'date' => now()->subDays(rand(1, 30)),
                    'status' => ['pending', 'completed', 'in_progress'][rand(0, 2)],
                    'illness_history' => 'No significant illness history',
                    'accidents_operations' => 'None reported',
                    'past_medical_history' => 'No major medical issues',
                    'family_history' => ['diabetes', 'hypertension'],
                    'personal_habits' => ['non-smoker', 'occasional alcohol'],
                    'physical_exam' => ['normal', 'slight variations'],
                    'skin_marks' => 'None',
                    'visual' => '20/20',
                    'ishihara_test' => 'Passed',
                    'findings' => 'Fit for employment',
                    'lab_report' => ['blood_count' => 'normal', 'urinalysis' => 'normal'],
                ]);
            }

            // Create sample Annual Physical Examinations
            foreach ($users as $user) {
                AnnualPhysicalExamination::create([
                    'user_id' => $user->id,
                    'patient_id' => null, // Will be linked when patient system is fully implemented
                    'name' => $user->fname . ' ' . $user->lname,
                    'date' => now()->subDays(rand(1, 90)),
                    'status' => ['pending', 'completed', 'in_progress'][rand(0, 2)],
                    'illness_history' => 'Annual checkup - no new issues',
                    'accidents_operations' => 'None since last exam',
                    'past_medical_history' => 'Stable condition',
                    'family_history' => ['diabetes', 'hypertension'],
                    'personal_habits' => ['non-smoker', 'regular exercise'],
                    'physical_exam' => ['normal', 'healthy'],
                    'skin_marks' => 'None',
                    'visual' => '20/20',
                    'ishihara_test' => 'Passed',
                    'findings' => 'Good health, continue current lifestyle',
                    'lab_report' => ['cholesterol' => 'normal', 'blood_pressure' => '120/80'],
                ]);
            }
        }
    }
}
