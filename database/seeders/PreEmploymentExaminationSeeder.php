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
     */
    public function run(): void
    {
        $records = PreEmploymentRecord::all();
        $doctor = User::where('role', 'doctor')->first();
        foreach ($records as $record) {
            PreEmploymentExamination::create([
                'user_id' => $doctor ? $doctor->id : null,
                'name' => $record->full_name,
                'company_name' => $record->company_name,
                'date' => Carbon::now()->subDays(rand(1, 30)),
                'status' => $record->status ?? 'pending',
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
                'pre_employment_record_id' => $record->id,
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
