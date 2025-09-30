<?php

namespace App\Http\Controllers;

use App\Models\MedicalChecklist;
use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
use App\Models\PreEmploymentRecord;
use App\Models\Patient;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RadiologistController extends Controller
{
    public function dashboard()
    {
        $checklists = MedicalChecklist::whereNotNull('xray_image_path')
            ->latest('date')
            ->take(20)
            ->get();

        $preEmployments = PreEmploymentExamination::with('preEmploymentRecord')
            ->whereHas('preEmploymentRecord', function($query) {
                $query->where('status', 'approved');
            })
            ->whereNotIn('status', ['Approved', 'sent_to_company'])
            ->latest('date')
            ->take(20)
            ->get()
            ->map(function ($exam) {
                $finding = null;
                $labFindings = $exam->lab_findings ?? [];
                if (is_array($labFindings)) {
                    $finding = $labFindings['chest_xray'] ?? ($labFindings['Chest X-Ray'] ?? null);
                    if (is_array($finding)) {
                        $finding = implode(', ', array_map(function ($v) {
                            return is_scalar($v) ? (string)$v : '';
                        }, $finding));
                        $finding = trim($finding, ', ');
                    }
                }
                return [
                    'id' => $exam->id,
                    'name' => $exam->name,
                    'company' => optional($exam->preEmploymentRecord)->company_name,
                    'finding' => $finding,
                ];
            });

        $annuals = AnnualPhysicalExamination::with('patient')
            ->whereHas('patient', function($query) {
                $query->where('status', 'approved');
            })
            ->whereNotIn('status', ['completed', 'sent_to_company'])
            ->latest('date')
            ->take(20)
            ->get()
            ->map(function ($exam) {
                $finding = null;
                $labFindings = $exam->lab_findings ?? [];
                if (is_array($labFindings)) {
                    $finding = $labFindings['chest_xray'] ?? ($labFindings['Chest X-Ray'] ?? null);
                    if (is_array($finding)) {
                        $finding = implode(', ', array_map(function ($v) {
                            return is_scalar($v) ? (string)$v : '';
                        }, $finding));
                        $finding = trim($finding, ', ');
                    }
                }
                return [
                    'id' => $exam->id,
                    'name' => $exam->name,
                    'company' => optional($exam->patient)->company_name ?? optional($exam->patient)->company,
                    'finding' => $finding,
                ];
            });

        return view('radiologist.dashboard', compact('checklists', 'preEmployments', 'annuals'));
    }

    public function showPreEmployment($id)
    {
        // $id is PreEmploymentRecord ID
        $record = PreEmploymentRecord::findOrFail($id);
        
        // Get the examination for this record
        $exam = PreEmploymentExamination::where('pre_employment_record_id', $id)->first();
        
        $cxr_result = '—';
        $cxr_finding = '—';
        
        if ($exam) {
            $cxr = $exam->lab_findings['chest_xray'] ?? ($exam->lab_findings['Chest X-Ray'] ?? null);
            if (is_array($cxr)) {
                $cxr_result = is_scalar($cxr['result'] ?? null) ? (string)$cxr['result'] : '—';
                $cxr_finding = is_scalar($cxr['finding'] ?? null) ? (string)$cxr['finding'] : '—';
            } else {
                $cxr_finding = is_scalar($cxr) ? (string)$cxr : '—';
            }
        }
        
        // Get the medical checklist with X-ray image
        $checklist = MedicalChecklist::where('pre_employment_record_id', $id)
            ->whereNotNull('xray_image_path')
            ->latest('date')
            ->first();
            
        // Fallback: attempt match by full name if still null
        if (!$checklist) {
            $fullName = $record->first_name . ' ' . $record->last_name;
            $checklist = MedicalChecklist::where('name', $fullName)
                ->whereNotNull('xray_image_path')
                ->latest('date')
                ->first();
        }
        
        $data = [
            'record' => $record,
            'exam' => $exam,
            'full_name' => $record->first_name . ' ' . $record->last_name,
            'sex' => $record->sex,
            'age' => $record->age,
            'company' => $record->company_name,
            'cxr_result' => $cxr_result,
            'cxr_finding' => $cxr_finding,
            'checklist' => $checklist,
        ];
        return view('radiologist.pre-employment-show', $data);
    }

    public function showAnnualPhysical($id)
    {
        // $id is Patient ID
        $patient = Patient::findOrFail($id);
        
        // Get the examination for this patient
        $exam = AnnualPhysicalExamination::where('patient_id', $id)->first();
        
        $cxr_result = '—';
        $cxr_finding = '—';
        
        if ($exam) {
            $cxr = $exam->lab_findings['chest_xray'] ?? ($exam->lab_findings['Chest X-Ray'] ?? null);
            if (is_array($cxr)) {
                $cxr_result = is_scalar($cxr['result'] ?? null) ? (string)$cxr['result'] : '—';
                $cxr_finding = is_scalar($cxr['finding'] ?? null) ? (string)$cxr['finding'] : '—';
            } else {
                $cxr_finding = is_scalar($cxr) ? (string)$cxr : '—';
            }
        }
        
        // Get the medical checklist with X-ray image
        $checklist = MedicalChecklist::where('patient_id', $id)
            ->whereNotNull('xray_image_path')
            ->latest('date')
            ->first();
            
        // Fallback: attempt match by full name if still null
        if (!$checklist) {
            $fullName = $patient->first_name . ' ' . $patient->last_name;
            $checklist = MedicalChecklist::where('name', $fullName)
                ->whereNotNull('xray_image_path')
                ->latest('date')
                ->first();
        }
        
        $data = [
            'patient' => $patient,
            'exam' => $exam,
            'full_name' => $patient->first_name . ' ' . $patient->last_name,
            'sex' => $patient->sex,
            'age' => $patient->age,
            'company' => $patient->company_name ?? ($patient->company ?? null),
            'cxr_result' => $cxr_result,
            'cxr_finding' => $cxr_finding,
            'checklist' => $checklist,
        ];
        return view('radiologist.annual-physical-show', $data);
    }

    public function updatePreEmployment(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'cxr_result' => 'nullable|string',
            'cxr_finding' => 'nullable|string',
        ]);
        
        // $id is PreEmploymentRecord ID
        $record = PreEmploymentRecord::findOrFail($id);
        
        // Get or create the examination
        $exam = PreEmploymentExamination::where('pre_employment_record_id', $id)->first();
        
        if (!$exam) {
            // Create examination if it doesn't exist
            $exam = new PreEmploymentExamination();
            $exam->pre_employment_record_id = $id;
            $exam->name = $record->first_name . ' ' . $record->last_name;
            $exam->date = now();
            $exam->status = 'Approved';
            $exam->lab_findings = [];
        }
        
        $lab = is_array($exam->lab_findings) ? $exam->lab_findings : [];
        $lab['chest_xray'] = [
            'result' => $request->input('cxr_result'),
            'finding' => $request->input('cxr_finding'),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now()->toDateTimeString(),
        ];
        $exam->lab_findings = $lab;
        $exam->save();
        
        // Create notification for admin when X-ray interpretation is completed
        $radiologist = Auth::user();
        $patientName = $record->full_name;
        
        Notification::createForAdmin(
            'xray_interpreted',
            'X-Ray Interpretation Completed - Pre-Employment',
            "Radiologist {$radiologist->name} has completed X-ray interpretation for {$patientName} (Pre-Employment). Result: " . ($request->input('cxr_result') ?: 'No result specified'),
            [
                'examination_id' => $exam->id,
                'patient_name' => $patientName,
                'radiologist_name' => $radiologist->name,
                'examination_type' => 'pre_employment',
                'xray_result' => $request->input('cxr_result'),
                'xray_finding' => $request->input('cxr_finding'),
                'has_findings' => !empty($request->input('cxr_finding'))
            ],
            'medium',
            $radiologist,
            $exam
        );
        
        return redirect()->route('radiologist.pre-employment-xray')->with('success', 'Chest X-Ray findings updated successfully. The record will remain visible to other radiologists.');
    }

    public function updateAnnualPhysical(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'cxr_result' => 'nullable|string',
            'cxr_finding' => 'nullable|string',
        ]);
        
        // $id is Patient ID
        $patient = Patient::findOrFail($id);
        
        // Get or create the examination
        $exam = AnnualPhysicalExamination::where('patient_id', $id)->first();
        
        if (!$exam) {
            // Create examination if it doesn't exist
            $exam = new AnnualPhysicalExamination();
            $exam->patient_id = $id;
            $exam->name = $patient->first_name . ' ' . $patient->last_name;
            $exam->date = now();
            $exam->status = 'completed';
            $exam->lab_findings = [];
        }
        
        $lab = is_array($exam->lab_findings) ? $exam->lab_findings : [];
        $lab['chest_xray'] = [
            'result' => $request->input('cxr_result'),
            'finding' => $request->input('cxr_finding'),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now()->toDateTimeString(),
        ];
        $exam->lab_findings = $lab;
        $exam->save();
        
        // Create notification for admin when X-ray interpretation is completed
        $radiologist = Auth::user();
        $patientName = $patient->full_name;
        
        Notification::createForAdmin(
            'xray_interpreted',
            'X-Ray Interpretation Completed - Annual Physical',
            "Radiologist {$radiologist->name} has completed X-ray interpretation for {$patientName} (Annual Physical). Result: " . ($request->input('cxr_result') ?: 'No result specified'),
            [
                'examination_id' => $exam->id,
                'patient_name' => $patientName,
                'radiologist_name' => $radiologist->name,
                'examination_type' => 'annual_physical',
                'xray_result' => $request->input('cxr_result'),
                'xray_finding' => $request->input('cxr_finding'),
                'has_findings' => !empty($request->input('cxr_finding'))
            ],
            'medium',
            $radiologist,
            $exam
        );
        
        return redirect()->route('radiologist.annual-physical-xray')->with('success', 'Chest X-Ray findings updated successfully. The record will remain visible to other radiologists.');
    }

    /**
     * Show pre-employment X-ray list
     */
    public function preEmploymentXray(Request $request)
    {
        $query = PreEmploymentRecord::with(['medicalTestCategory', 'medicalTest', 'medicalChecklist'])
            ->where('status', 'approved')
            ->where(function($query) {
                // Check medical test relationships OR other_exams column for X-ray services
                $query->whereHas('medicalTest', function($q) {
                    $q->where(function($subQ) {
                        $subQ->where('name', 'like', '%Pre-Employment%')
                             ->orWhere('name', 'like', '%X-ray%')
                             ->orWhere('name', 'like', '%Chest%')
                             ->orWhere('name', 'like', '%Radiology%');
                    });
                })->orWhereHas('medicalTests', function($q) {
                    $q->where(function($subQ) {
                        $subQ->where('name', 'like', '%Pre-Employment%')
                             ->orWhere('name', 'like', '%X-ray%')
                             ->orWhere('name', 'like', '%Chest%')
                             ->orWhere('name', 'like', '%Radiology%');
                    });
                })->orWhere(function($q) {
                    // Also check other_exams column for X-ray services
                    $q->where('other_exams', 'like', '%Pre-Employment%')
                      ->orWhere('other_exams', 'like', '%X-ray%')
                      ->orWhere('other_exams', 'like', '%Chest%')
                      ->orWhere('other_exams', 'like', '%Radiology%');
                });
            });

        // Handle tab filtering
        $xrayStatus = $request->get('xray_status', 'needs_attention');
        
        if ($xrayStatus === 'needs_attention') {
            // Records that need radiologist review (X-ray completed but no findings)
            $query->whereHas('medicalChecklist', function ($q) {
                $q->whereNotNull('chest_xray_done_by')
                  ->whereNotNull('xray_image_path');
            })
            ->whereDoesntHave('preEmploymentExamination', function ($q) {
                $q->whereNotNull('xray_findings')
                  ->where('xray_findings', '!=', '');
            });
        } elseif ($xrayStatus === 'review_completed') {
            // Records where radiologist review is completed
            $query->whereHas('medicalChecklist', function ($q) {
                $q->whereNotNull('chest_xray_done_by')
                  ->whereNotNull('xray_image_path');
            })
            ->whereHas('preEmploymentExamination', function ($q) {
                $q->whereNotNull('xray_findings')
                  ->where('xray_findings', '!=', '');
            });
        }

        $preEmployments = $query->latest()->get();

        return view('radiologist.pre-employment-xray', compact('preEmployments'));
    }

    /**
     * Show annual physical X-ray list
     */
    public function annualPhysicalXray()
    {
        $patients = Patient::where('status', 'approved')
            ->whereHas('medicalChecklist', function ($q) {
                $q->whereNotNull('chest_xray_done_by')
                  ->whereNotNull('xray_image_path');
            })
            ->whereDoesntHave('annualPhysicalExamination', function ($q) {
                $q->whereNotNull('lab_findings->chest_xray->result')
                  ->whereNotNull('lab_findings->chest_xray->finding')
                  ->where('lab_findings->chest_xray->reviewed_by', auth()->id());
            })
            ->with('medicalChecklist')
            ->latest()
            ->get();

        return view('radiologist.annual-physical-xray', compact('patients'));
    }

    /**
     * Show X-ray gallery
     */
    public function xrayGallery()
    {
        $checklists = MedicalChecklist::whereNotNull('xray_image_path')
            ->whereNotNull('chest_xray_done_by')
            ->with(['preEmploymentRecord', 'patient'])
            ->latest('date')
            ->paginate(20);

        return view('radiologist.xray-gallery', compact('checklists'));
    }
}


