<?php

namespace App\Http\Controllers;

use App\Models\MedicalChecklist;
use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
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
        $exam = PreEmploymentExamination::with('preEmploymentRecord')->findOrFail($id);
        $record = $exam->preEmploymentRecord;
        $cxr = $exam->lab_findings['chest_xray'] ?? ($exam->lab_findings['Chest X-Ray'] ?? null);
        $cxr_result = null; $cxr_finding = null;
        if (is_array($cxr)) {
            $cxr_result = is_scalar($cxr['result'] ?? null) ? (string)$cxr['result'] : null;
            $cxr_finding = is_scalar($cxr['finding'] ?? null) ? (string)$cxr['finding'] : null;
        } else {
            $cxr_finding = is_scalar($cxr) ? (string)$cxr : null;
        }
        if (!$cxr_result) { $cxr_result = '—'; }
        if (!$cxr_finding) { $cxr_finding = '—'; }
        $checklist = MedicalChecklist::where('pre_employment_record_id', optional($record)->id)
            ->whereNotNull('xray_image_path')
            ->latest('date')
            ->first();
        // Fallback: attempt match by full name if still null
        if (!$checklist) {
            $fullName = $exam->name ?? ($record ? ($record->first_name . ' ' . $record->last_name) : null);
            if ($fullName) {
                $checklist = MedicalChecklist::where('name', $fullName)
                    ->whereNotNull('xray_image_path')
                    ->latest('date')
                    ->first();
            }
        }
        $data = [
            'full_name' => $exam->name ?? ($record ? ($record->first_name . ' ' . $record->last_name) : ''),
            'sex' => $record->sex ?? null,
            'age' => $record->age ?? null,
            'company' => $record->company_name ?? null,
            'cxr_result' => $cxr_result,
            'cxr_finding' => $cxr_finding,
            'checklist' => $checklist,
        ];
        return view('radiologist.pre-employment-show', $data);
    }

    public function showAnnualPhysical($id)
    {
        $exam = AnnualPhysicalExamination::with('patient')->findOrFail($id);
        $patient = $exam->patient;
        $cxr = $exam->lab_findings['chest_xray'] ?? ($exam->lab_findings['Chest X-Ray'] ?? null);
        $cxr_result = null; $cxr_finding = null;
        if (is_array($cxr)) {
            $cxr_result = is_scalar($cxr['result'] ?? null) ? (string)$cxr['result'] : null;
            $cxr_finding = is_scalar($cxr['finding'] ?? null) ? (string)$cxr['finding'] : null;
        } else {
            $cxr_finding = is_scalar($cxr) ? (string)$cxr : null;
        }
        if (!$cxr_result) { $cxr_result = '—'; }
        if (!$cxr_finding) { $cxr_finding = '—'; }
        // Prefer direct link via annual_physical_examination_id; fallback to patient_id
        $checklist = MedicalChecklist::where('annual_physical_examination_id', $exam->id)
            ->whereNotNull('xray_image_path')
            ->latest('date')
            ->first();
        if (!$checklist) {
            $checklist = MedicalChecklist::where('patient_id', optional($patient)->id)
                ->whereNotNull('xray_image_path')
                ->latest('date')
                ->first();
        }
        // Fallback by full name if needed
        if (!$checklist) {
            $fullName = $exam->name ?? ($patient ? ($patient->first_name . ' ' . $patient->last_name) : null);
            if ($fullName) {
                $checklist = MedicalChecklist::where('name', $fullName)
                    ->whereNotNull('xray_image_path')
                    ->latest('date')
                    ->first();
            }
        }
        $data = [
            'full_name' => $exam->name ?? ($patient ? ($patient->first_name . ' ' . $patient->last_name) : ''),
            'sex' => $patient->sex ?? null,
            'age' => $patient->age ?? null,
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
        $exam = PreEmploymentExamination::findOrFail($id);
        $lab = is_array($exam->lab_findings) ? $exam->lab_findings : [];
        $lab['chest_xray'] = [
            'result' => $request->input('cxr_result'),
            'finding' => $request->input('cxr_finding'),
        ];
        $exam->lab_findings = $lab;
        $exam->save();
        return redirect()->route('radiologist.dashboard')->with('success', 'Chest X-Ray finding updated.');
    }

    public function updateAnnualPhysical(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'cxr_result' => 'nullable|string',
            'cxr_finding' => 'nullable|string',
        ]);
        $exam = AnnualPhysicalExamination::findOrFail($id);
        $lab = is_array($exam->lab_findings) ? $exam->lab_findings : [];
        $lab['chest_xray'] = [
            'result' => $request->input('cxr_result'),
            'finding' => $request->input('cxr_finding'),
        ];
        $exam->lab_findings = $lab;
        $exam->save();
        return redirect()->route('radiologist.dashboard')->with('success', 'Chest X-Ray finding updated.');
    }
}


