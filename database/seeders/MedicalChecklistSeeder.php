<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalChecklist;
use App\Models\PreEmploymentRecord;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;

class MedicalChecklistSeeder extends Seeder
{
    /**
     * Generate sample examination data
     */
    private function generateExaminationData(bool $allCompleted = true): array
    {
        return [
            'chest_xray_done_by' => $allCompleted ? '' : '',
            'stool_exam_done_by' => $allCompleted ? '' : '',
            'urinalysis_done_by' => $allCompleted ? '' : '',
            'drug_test_done_by' => $allCompleted ? '' : '',
            'blood_extraction_done_by' => $allCompleted ? '' : '',
            'ecg_done_by' => $allCompleted ? '' : '',
            'physical_exam_done_by' => $allCompleted ? '' : '',
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctor = User::where('role', 'doctor')->first();
        
        // Create sample checklists for pre-employment records
        $preEmploymentRecords = PreEmploymentRecord::all();
        foreach ($preEmploymentRecords as $record) {
            $examinationData = $this->generateExaminationData();
            MedicalChecklist::create(array_merge([
                'user_id' => $doctor ? $doctor->id : null,
                'pre_employment_record_id' => $record->id,
                'name' => $record->first_name . ' ' . $record->last_name,
                'age' => $record->age,
                'number' => 'EMP-' . str_pad($record->id, 4, '0', STR_PAD_LEFT),
                'date' => Carbon::now()->subDays(rand(1, 30)),
                'optional_exam' => 'Audiometry/Ishihara',
                'doctor_signature' => 'Dr. Smith',
                'examination_type' => 'pre_employment',
            ], $examinationData));
        }

        // Create sample checklists for patients (annual physical)
        $patients = Patient::all();
        foreach ($patients as $patient) {
            // Find or create annual physical examination record
            $annualPhysicalExamination = \App\Models\AnnualPhysicalExamination::firstOrCreate(
                ['patient_id' => $patient->id],
                ['patient_id' => $patient->id]
            );
            
            $examinationData = $this->generateExaminationData();
            MedicalChecklist::create(array_merge([
                'user_id' => $doctor ? $doctor->id : null,
                'patient_id' => $patient->id,
                'annual_physical_examination_id' => $annualPhysicalExamination->id,
                'name' => $patient->first_name . ' ' . $patient->last_name,
                'age' => $patient->age,
                'number' => 'PAT-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT),
                'date' => Carbon::now()->subDays(rand(1, 30)),
                'optional_exam' => 'Audiometry/Ishihara',
                'doctor_signature' => 'Dr. Johnson',
                'examination_type' => 'annual_physical',
            ], $examinationData));
        }
    }
}
