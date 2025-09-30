<?php

namespace App\Services;

use App\Models\MedicalChecklist;
use App\Models\PreEmploymentRecord;
use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
use App\Models\OpdExamination;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MedicalWorkflowService
{
    /**
     * Check if pre-employment examination is complete and ready for doctor
     */
    public function checkPreEmploymentCompletion(PreEmploymentRecord $record): bool
    {
        // Check if nurse examination exists
        $nurseExam = PreEmploymentExamination::where('pre_employment_record_id', $record->id)->first();
        if (!$nurseExam) {
            return false;
        }

        // Check if medical checklist exists and required fields are completed
        $checklist = MedicalChecklist::where('pre_employment_record_id', $record->id)->first();
        if (!$checklist) {
            return false;
        }

        // Check required medical staff completion based on medical test type
        $medicalTestName = strtolower($record->medicalTest->name ?? '');
        $requiredFields = $this->getRequiredFieldsForTest($medicalTestName);
        
        foreach ($requiredFields as $field) {
            if (empty($checklist->$field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if annual physical examination is complete and ready for doctor
     */
    public function checkAnnualPhysicalCompletion(Patient $patient): bool
    {
        // Check if nurse examination exists
        $nurseExam = AnnualPhysicalExamination::where('patient_id', $patient->id)->first();
        if (!$nurseExam) {
            return false;
        }

        // Check if medical checklist exists and required fields are completed
        $checklist = MedicalChecklist::where('patient_id', $patient->id)->first();
        if (!$checklist) {
            return false;
        }

        // Check required medical staff completion based on medical test type
        $medicalTestName = strtolower($patient->appointment->medicalTest->name ?? '');
        $requiredFields = $this->getRequiredFieldsForTest($medicalTestName);
        
        foreach ($requiredFields as $field) {
            if (empty($checklist->$field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if OPD examination is complete and ready for doctor
     */
    public function checkOpdCompletion(User $opdPatient): bool
    {
        // Check if nurse examination exists
        $nurseExam = OpdExamination::where('user_id', $opdPatient->id)->first();
        if (!$nurseExam) {
            return false;
        }

        // Check if medical checklist exists and basic fields are completed
        $checklist = MedicalChecklist::where('opd_examination_id', $nurseExam->id)->first();
        if (!$checklist) {
            return false;
        }

        // For OPD, require basic medical staff completion
        $requiredFields = ['physical_exam_done_by'];
        
        foreach ($requiredFields as $field) {
            if (empty($checklist->$field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get required fields based on medical test type
     */
    private function getRequiredFieldsForTest(string $medicalTestName): array
    {
        $baseFields = ['physical_exam_done_by'];
        
        // Add fields based on test requirements
        if (str_contains($medicalTestName, 'drug test')) {
            $baseFields[] = 'drug_test_done_by';
        }
        
        if (str_contains($medicalTestName, 'ecg')) {
            $baseFields[] = 'ecg_done_by';
        }
        
        if (str_contains($medicalTestName, 'x-ray') || str_contains($medicalTestName, 'xray')) {
            $baseFields[] = 'chest_xray_done_by';
        }
        
        // Blood tests require phlebotomist
        if (str_contains($medicalTestName, 'blood') || 
            str_contains($medicalTestName, 'cbc') || 
            str_contains($medicalTestName, 'chemistry')) {
            $baseFields[] = 'blood_extraction_done_by';
        }
        
        // Stool and urine tests
        if (str_contains($medicalTestName, 'stool')) {
            $baseFields[] = 'stool_exam_done_by';
        }
        
        if (str_contains($medicalTestName, 'urine') || str_contains($medicalTestName, 'urinalysis')) {
            $baseFields[] = 'urinalysis_done_by';
        }

        return $baseFields;
    }

    /**
     * Progress pre-employment examination to doctor
     */
    private function progressPreEmploymentToDoctor(PreEmploymentRecord $record): bool
    {
        $exam = PreEmploymentExamination::where('pre_employment_record_id', $record->id)->first();
        
        if ($exam && $exam->status !== 'Approved') {
            $exam->update(['status' => 'Approved']);
            
            Log::info('Pre-employment examination automatically progressed to doctor', [
                'record_id' => $record->id,
                'patient_name' => $record->full_name,
                'company' => $record->company_name
            ]);
            
            return true;
        }
        
        return false;
    }

    /**
     * Progress annual physical examination to doctor
     */
    private function progressAnnualPhysicalToDoctor(Patient $patient): bool
    {
        $exam = AnnualPhysicalExamination::where('patient_id', $patient->id)->first();
        
        if ($exam && $exam->status !== 'completed') {
            $exam->update(['status' => 'completed']);
            
            Log::info('Annual physical examination automatically progressed to doctor', [
                'patient_id' => $patient->id,
                'patient_name' => $patient->full_name
            ]);
            
            return true;
        }
        
        return false;
    }
    /**
     * Progress OPD examination to doctor
     */
    public function progressOpdToDoctor(User $opdPatient): bool
    {
        $exam = OpdExamination::where('user_id', $opdPatient->id)->first();
        
        if ($exam && $exam->status !== 'completed') {
            $exam->update(['status' => 'completed']);
            
            Log::info('OPD examination automatically progressed to doctor', [
                'patient_id' => $opdPatient->id,
                'patient_name' => trim(($opdPatient->fname ?? '') . ' ' . ($opdPatient->lname ?? ''))
            ]);
            
            return true;
        }
        
        return false;
    }

    /**
     * Trigger workflow check when medical checklist is updated
     */
    public function onMedicalChecklistUpdated(MedicalChecklist $checklist): void
    {
        if ($checklist->pre_employment_record_id) {
            $record = PreEmploymentRecord::with('medicalTest')->find($checklist->pre_employment_record_id);
            if ($record && $this->checkPreEmploymentCompletion($record)) {
                $this->progressPreEmploymentToDoctor($record);
            }
        }
        
        if ($checklist->patient_id) {
            $patient = Patient::with('appointment.medicalTest')->find($checklist->patient_id);
            if ($patient && $this->checkAnnualPhysicalCompletion($patient)) {
                $this->progressAnnualPhysicalToDoctor($patient);
            }
        }
        
        if ($checklist->opd_examination_id) {
            $opdExam = OpdExamination::find($checklist->opd_examination_id);
            if ($opdExam) {
                $opdPatient = User::find($opdExam->user_id);
                if ($opdPatient && $this->checkOpdCompletion($opdPatient)) {
                    $this->progressOpdToDoctor($opdPatient);
                }
            }
        }
    }

    /**
     * Trigger workflow check when examination is created/updated
     */
    public function onExaminationUpdated($examination, string $type): void
    {
        switch ($type) {
            case 'pre_employment':
                if ($examination->pre_employment_record_id) {
                    $record = PreEmploymentRecord::with('medicalTest')->find($examination->pre_employment_record_id);
                    if ($record && $this->checkPreEmploymentCompletion($record)) {
                        $this->progressPreEmploymentToDoctor($record);
                    }
                }
                break;
                
            case 'annual_physical':
                if ($examination->patient_id) {
                    $patient = Patient::with('appointment.medicalTest')->find($examination->patient_id);
                    if ($patient && $this->checkAnnualPhysicalCompletion($patient)) {
                        $this->progressAnnualPhysicalToDoctor($patient);
                    }
                }
                break;
                
            case 'opd':
                if ($examination->user_id) {
                    $opdPatient = User::find($examination->user_id);
                    if ($opdPatient && $this->checkOpdCompletion($opdPatient)) {
                        $this->progressOpdToDoctor($opdPatient);
                    }
                }
                break;
        }
    }
}
