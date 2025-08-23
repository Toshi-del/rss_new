@extends('layouts.doctor')

@section('title', 'Edit Pre-Employment Examination')
@section('page-title', 'Edit Pre-Employment Examination')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 mb-8">
        <div class="bg-blue-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">CERTIFICATE OF MEDICAL EXAMINATION</h2>
        </div>
        @if($preEmployment->preEmploymentRecord)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Full Name</label>
                <div class="text-lg font-semibold">{{ $preEmployment->preEmploymentRecord->full_name ?? ($preEmployment->preEmploymentRecord->first_name . ' ' . $preEmployment->preEmploymentRecord->last_name) }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Age</label>
                <div class="text-lg font-semibold">{{ $preEmployment->preEmploymentRecord->age }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Sex</label>
                <div class="text-lg font-semibold">{{ $preEmployment->preEmploymentRecord->sex }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Company Name</label>
                <div class="text-lg font-semibold">{{ $preEmployment->preEmploymentRecord->company_name }}</div>
            </div>
        </div>
        @endif
        <form action="{{ route('doctor.pre-employment.update', $preEmployment->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')
            <!-- Patient & Company Info -->
            {{-- Removed old Patient & Company Info fields (Name, Company Name, Date, Status) --}}
            <!-- Medical History -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Illness / Hospitalization</label>
                        <div class="bg-white p-3 rounded-lg border border-gray-300 min-h-[4rem] text-sm">{{ $preEmployment->illness_history ?: 'No data entered' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Accidents / Operations</label>
                        <div class="bg-white p-3 rounded-lg border border-gray-300 min-h-[4rem] text-sm">{{ $preEmployment->accidents_operations ?: 'No data entered' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Past Medical History</label>
                        <div class="bg-white p-3 rounded-lg border border-gray-300 min-h-[4rem] text-sm">{{ $preEmployment->past_medical_history ?: 'No data entered' }}</div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold uppercase mb-2">Family Medical History</label>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $family = $preEmployment->family_history ?? [];
                            $options = ['asthma','arthritis','migraine','diabetes','heart_disease','tuberculosis','allergies','anemia','cancer','insanity','hypertension','epilepsy'];
                        @endphp
                        @foreach($options as $opt)
                            <span class="inline-flex items-center text-xs bg-white px-2 py-1 rounded shadow-sm border border-gray-200 {{ in_array($opt, $family ?? []) ? 'bg-blue-50 border-blue-200' : 'bg-gray-50' }}">
                                <i class="fas {{ in_array($opt, $family ?? []) ? 'fa-check text-blue-600' : 'fa-times text-gray-400' }} mr-1"></i>
                                {{ str_replace('_', ' ', ucfirst($opt)) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Personal History -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Personal History</label>
                <div class="flex flex-wrap gap-3">
                    @php
                        $habits = $preEmployment->personal_habits ?? [];
                        $habitOptions = ['alcohol','cigarettes','coffee_tea'];
                    @endphp
                    @foreach($habitOptions as $habit)
                        <span class="inline-flex items-center text-xs bg-white px-2 py-1 rounded shadow-sm border border-gray-200 {{ in_array($habit, $habits ?? []) ? 'bg-blue-50 border-blue-200' : 'bg-gray-50' }}">
                            <i class="fas {{ in_array($habit, $habits ?? []) ? 'fa-check text-blue-600' : 'fa-times text-gray-400' }} mr-1"></i>
                            {{ str_replace('_', ' ', ucfirst($habit)) }}
                        </span>
                    @endforeach
                </div>
            </div>
            <!-- Physical Examination -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Physical Examination</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php $phys = $preEmployment->physical_exam ?? []; @endphp
                    <div>
                        <label class="block text-xs mb-1">Temp</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm">{{ $phys['temp'] ?: 'Not recorded' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Height</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm">{{ $phys['height'] ?: 'Not recorded' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Heart Rate</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm">{{ $phys['heart_rate'] ?: 'Not recorded' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Weight</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm">{{ $phys['weight'] ?: 'Not recorded' }}</div>
                    </div>
                </div>
            </div>
            <!-- Skin Identification Marks -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Skin Identification Marks</label>
                <div class="bg-white p-3 rounded-lg border border-gray-300 text-sm">{{ $preEmployment->skin_marks ?: 'No marks recorded' }}</div>
            </div>
            <!-- Visual, Ishihara, Findings -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Visual</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm">{{ $preEmployment->visual ?: 'Not tested' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Ishihara Test</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm">{{ $preEmployment->ishihara_test ?: 'Not tested' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Findings</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm">{{ $preEmployment->findings ?: 'No findings' }}</div>
                    </div>
                </div>
            </div>
            <!-- Laboratory Examination Report -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Laboratory Examination Report</label>
                @php
                    $lab = $preEmployment->lab_report ?? [];
                    $labFields = ['urinalysis','cbc','xray','fecalysis','blood_chemistry','others'];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($labFields as $field)
                        <div>
                            <label class="block text-xs capitalize mb-1">{{ str_replace('_', ' ', $field) }}</label>
                            <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm">{{ $lab[$field] ?: 'Not available' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

        <!-- Physical and Laboratory Findings Section -->
        <div class="mt-12">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow border border-gray-200 mb-8">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-bold uppercase border-b">Body Part</th>
                            <th class="px-4 py-2 text-left text-xs font-bold uppercase border-b">Result</th>
                            <th class="px-4 py-2 text-left text-xs font-bold uppercase border-b">Findings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $physicalRows = [
                                'Neck',
                                'Chest-Breast Axilla',
                                'Lungs',
                                'Heart',
                                'Abdomen',
                                'Extremities',
                                'Anus-Rectum',
                                'G.U.T',
                                'Inguinal / Genital',
                            ];
                        @endphp
                        @foreach($physicalRows as $row)
                        <tr>
                            <td class="px-4 py-2 border-b text-xs">{{ $row }}</td>
                            <td class="px-4 py-2 border-b text-xs">
                                <input type="text" name="physical_findings[{{ $row }}][result]" class="form-input w-full rounded border-gray-300 text-xs" value="{{ old('physical_findings.'.$row.'.result', $preEmployment->physical_findings[$row]['result'] ?? '') }}">
                            </td>
                            <td class="px-4 py-2 border-b text-xs">
                                <input type="text" name="physical_findings[{{ $row }}][findings]" class="form-input w-full rounded border-gray-300 text-xs" value="{{ old('physical_findings.'.$row.'.findings', $preEmployment->physical_findings[$row]['findings'] ?? '') }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="font-bold text-sm mb-2">LABORATORY EXAMINATIONS REPORT</div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow border border-gray-200 mb-8">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-bold uppercase border-b">Test</th>
                            <th class="px-4 py-2 text-left text-xs font-bold uppercase border-b">Result</th>
                            <th class="px-4 py-2 text-left text-xs font-bold uppercase border-b">Findings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $labRows = [
                                'Chest X-Ray',
                                'Urinalysis',
                                'Fecalysis',
                                'CBC',
                                'Drug Test',
                                'HBsAg Screening',
                                'HEPA A IGG & IGM',
                                'Others',
                            ];
                        @endphp
                        @foreach($labRows as $row)
                        <tr>
                            <td class="px-4 py-2 border-b text-xs">{{ $row }}</td>
                            <td class="px-4 py-2 border-b text-xs">
                                <input type="text" name="lab_findings[{{ $row }}][result]" class="form-input w-full rounded border-gray-300 text-xs" value="{{ old('lab_findings.'.$row.'.result', $preEmployment->lab_findings[$row]['result'] ?? '') }}">
                            </td>
                            <td class="px-4 py-2 border-b text-xs">
                                <input type="text" name="lab_findings[{{ $row }}][findings]" class="form-input w-full rounded border-gray-300 text-xs" value="{{ old('lab_findings.'.$row.'.findings', $preEmployment->lab_findings[$row]['findings'] ?? '') }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mb-8">
                <label class="block text-xs font-bold uppercase mb-1">ECG:</label>
                <input type="text" name="ecg" class="form-input w-full rounded border-gray-300 text-xs" value="{{ old('ecg', $preEmployment->ecg ?? '') }}">
            </div>
        </div>
        <!-- PHYSICIAN'S SIGNATURE -->
        <div class="flex flex-col md:flex-row justify-between items-center mt-8 gap-6">
            <div class="text-xs text-gray-500 w-full md:w-auto">
                <div>PHYSICIAN'S SIGNATURE</div>
                <div class="border-b border-gray-400 w-48 mt-2"></div>
            </div>
        </div>
        <!-- Signature and Submit -->
        <div class="flex flex-col md:flex-row justify-between items-center mt-8 gap-6">
            <div class="w-full md:w-auto flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-lg shadow hover:bg-blue-700 transition-colors font-semibold tracking-wide">SAVE EXAM RESULT</button>
            </div>
        </div>
        </form>
@endsection

