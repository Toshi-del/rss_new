<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnualPhysicalExamination;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;

class AnnualPhysicalExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $doctor = User::where('role', 'doctor')->first();
        
        foreach ($patients as $patient) {
            AnnualPhysicalExamination::create([
                'user_id' => $doctor ? $doctor->id : null,
                'patient_id' => $patient->id,
                'name' => $patient->full_name,
                'date' => Carbon::now()->subDays(rand(1, 30)),
                'status' => 'completed',
                'illness_history' => 'No significant illness history',
                'accidents_operations' => 'None reported',
                'past_medical_history' => 'No major medical issues',
                'family_history' => ['diabetes', 'hypertension'],
                'personal_habits' => ['non-smoker', 'occasional alcohol'],
                'physical_exam' => ['normal', 'slight variations'],
                'skin_marks' => 'None',
                'visual' => '20/20',
                'ishihara_test' => 'Passed',
                'findings' => 'Fit for annual physical',
                'lab_report' => ['blood_count' => 'normal', 'urinalysis' => 'normal'],
                'physical_findings' => [
                    'Neck' => ['result' => 'Normal', 'findings' => 'No issues'],
                    'Heart' => ['result' => 'Normal', 'findings' => 'No murmur'],
                ],
                'lab_findings' => [
                    'CBC' => ['result' => 'Normal', 'findings' => 'Within range'],
                    'Urinalysis' => ['result' => 'Normal', 'findings' => 'Clear'],
                ],
                'ecg' => 'Normal',
            ]);
        }
    }
}
