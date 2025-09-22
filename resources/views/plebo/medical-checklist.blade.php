@extends('layouts.plebo')

@section('title', 'Medical Checklist')
@section('page-title', 'Medical Checklist')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300 text-center font-semibold">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300">
        <h4 class="font-semibold mb-2">Please correct the following errors:</h4>
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="bg-blue-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">MEDICAL CHECKLIST</h2>
        </div>

        <form action="{{ isset($medicalChecklist) && $medicalChecklist->id ? route('plebo.medical-checklist.update', $medicalChecklist->id) : route('plebo.medical-checklist.store') }}" method="POST" class="space-y-8">
            @csrf
            @if(isset($medicalChecklist) && $medicalChecklist->id)
                @method('PATCH')
            @endif
            <input type="hidden" name="examination_type" value="{{ $examinationType === 'pre-employment' ? 'pre_employment' : ($examinationType === 'opd' ? 'opd' : 'annual_physical') }}">
            @if(isset($preEmploymentRecord))
                <input type="hidden" name="pre_employment_record_id" value="{{ $preEmploymentRecord->id }}">
            @endif
            @if(isset($patient))
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            @endif
            @if(isset($user) && $examinationType === 'opd')
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                @if(isset($opdExamination))
                    <input type="hidden" name="opd_examination_id" value="{{ $opdExamination->id }}">
                @endif
            @endif
            @if(isset($annualPhysicalExamination))
                <input type="hidden" name="annual_physical_examination_id" value="{{ $annualPhysicalExamination->id }}">
            @endif

            @php
                // Precompute generated number once for reuse
                $generatedNumber = null;
                if (isset($medicalChecklist) && ($medicalChecklist->number ?? null)) {
                    $generatedNumber = $medicalChecklist->number;
                } elseif (isset($patient)) {
                    $generatedNumber = 'APEP-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                } elseif (isset($preEmploymentRecord)) {
                    $generatedNumber = 'PPEP-' . str_pad($preEmploymentRecord->id, 4, '0', STR_PAD_LEFT);
                } elseif (isset($user) && $examinationType === 'opd') {
                    $generatedNumber = 'OPD-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
                } else {
                    $generatedNumber = old('number', $number ?? '');
                }
            @endphp

            <!-- Patient Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Name</label>
                    <div class="w-full rounded-lg border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                        @if(isset($medicalChecklist) && $medicalChecklist->patient)
                            {{ $medicalChecklist->patient->full_name }}
                        @elseif(isset($patient))
                            {{ $patient->full_name }}
                        @elseif(isset($preEmploymentRecord))
                            {{ $preEmploymentRecord->first_name }} {{ $preEmploymentRecord->last_name }}
                        @else
                            {{ old('name', $medicalChecklist->name ?? $name ?? '') }}
                        @endif
                    </div>
                    <input type="hidden" name="name" value="@if(isset($medicalChecklist) && $medicalChecklist->patient){{ $medicalChecklist->patient->full_name }}@elseif(isset($patient)){{ $patient->full_name }}@elseif(isset($preEmploymentRecord)){{ $preEmploymentRecord->first_name }} {{ $preEmploymentRecord->last_name }}@else{{ old('name', $medicalChecklist->name ?? $name ?? '') }}@endif" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Date</label>
                    @php($currentDate = old('date', $medicalChecklist->date ?? $date ?? now()->format('Y-m-d')))
                    <a class="text-blue-700 hover:underline cursor-default">{{ \Carbon\Carbon::parse($currentDate)->format('Y-m-d') }}</a>
                    <input type="hidden" name="date" value="{{ $currentDate }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Age</label>
                    <div class="w-full rounded-lg border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                        @if(isset($medicalChecklist) && $medicalChecklist->patient)
                            {{ $medicalChecklist->patient->age }}
                        @elseif(isset($patient))
                            {{ $patient->age }}
                        @elseif(isset($preEmploymentRecord))
                            {{ $preEmploymentRecord->age }}
                        @else
                            {{ old('age', $medicalChecklist->age ?? $age ?? '') }}
                        @endif
                    </div>
                    <input type="hidden" name="age" value="@if(isset($medicalChecklist) && $medicalChecklist->patient){{ $medicalChecklist->patient->age }}@elseif(isset($patient)){{ $patient->age }}@elseif(isset($preEmploymentRecord)){{ $preEmploymentRecord->age }}@else{{ old('age', $medicalChecklist->age ?? $age ?? '') }}@endif" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Number</label>
                    <div class="w-full rounded-lg border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                        {{ $generatedNumber ?: 'N/A' }}
                    </div>
                    <input type="hidden" name="number" value="{{ $generatedNumber }}" />
                </div>
            </div>

            <!-- Examinations Checklist -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="text-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Done By</h3>
                </div>
                
                <div class="space-y-4">
                    @foreach([
                        'chest_xray' => 'Chest X-Ray',
                        'stool_exam' => 'Stool Exam',
                        'urinalysis' => 'Urinalysis',
                        'drug_test' => 'Drug Test',
                        'blood_extraction' => 'Blood Extraction',
                        'ecg' => 'ElectroCardioGram (ECG)',
                        'physical_exam' => 'Physical Exam',
                    ] as $field => $examName)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-700 mr-4">{{ $loop->iteration }}.</span>
                                <span class="text-sm text-gray-700">{{ $examName }}</span>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-700">Completed by:</span>
                                <input type="text" name="{{ $field }}_done_by"
                                       value="{{ old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? '') }}"
                                       placeholder="Initials/Signature"
                                       @if($field !== 'blood_extraction') readonly disabled class="form-input w-32 rounded border-gray-300 text-sm bg-gray-100 cursor-not-allowed" @else class="form-input w-32 rounded border-gray-300 text-sm" @endif>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Optional Exam -->
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Optional</label>
                    <input type="text" name="optional_exam" value="{{ old('optional_exam', $medicalChecklist->optional_exam ?? $optionalExam ?? 'Audiometry/Ishihara') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-between">
                <a href="{{ $examinationType === 'pre-employment' ? route('plebo.pre-employment') : ($examinationType === 'opd' ? route('plebo.opd') : route('plebo.annual-physical')) }}" 
                   class="bg-gray-500 text-white px-8 py-3 rounded-lg shadow hover:bg-gray-600 transition-colors font-semibold tracking-wide">
                    Back to List
                </a>
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg shadow hover:bg-blue-700 transition-colors font-semibold tracking-wide">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
