@extends('layouts.nurse')

@section('title', 'Medical Checklist')
@section('page-title', 'Medical Checklist')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="bg-green-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">MEDICAL CHECKLIST</h2>
        </div>

        <form action="{{ isset($medicalChecklist) && $medicalChecklist->id ? route('nurse.medical-checklist.update', $medicalChecklist->id) : route('nurse.medical-checklist.store') }}" method="POST" class="space-y-8">
            @csrf
            @if(isset($medicalChecklist) && $medicalChecklist->id)
                @method('PATCH')
            @endif
            <input type="hidden" name="examination_type" value="{{ $examinationType }}">
            @if(isset($preEmploymentRecord))
                <input type="hidden" name="pre_employment_record_id" value="{{ $preEmploymentRecord->id }}">
            @endif
            @if(isset($patient))
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            @endif
            @if(isset($annualPhysicalExamination))
                <input type="hidden" name="annual_physical_examination_id" value="{{ $annualPhysicalExamination->id }}">
            @endif

            <!-- Patient Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $medicalChecklist->name ?? $name ?? '') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" required />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Date</label>
                    @php($currentDate = old('date', $medicalChecklist->date ?? $date ?? now()->format('Y-m-d')))
                    <a class="text-green-700 hover:underline cursor-default">{{ \Carbon\Carbon::parse($currentDate)->format('Y-m-d') }}</a>
                    <input type="hidden" name="date" value="{{ $currentDate }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Age</label>
                    <input type="number" name="age" value="{{ old('age', $medicalChecklist->age ?? $age ?? '') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" required />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Number</label>
                    @php($displayNumber = old('number', $medicalChecklist->number ?? $number ?? ''))
                    @if($displayNumber)
                        <a class="text-green-700 hover:underline cursor-default">{{ $displayNumber }}</a>
                    @else
                        <span class="text-sm text-gray-500">N/A</span>
                    @endif
                    <input type="hidden" name="number" value="{{ $displayNumber }}" />
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
                                       class="form-input w-32 rounded border-gray-300 text-sm">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Optional Exam and Nurse Signature -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Optional</label>
                    <input type="text" name="optional_exam" value="{{ old('optional_exam', $medicalChecklist->optional_exam ?? $optionalExam ?? 'Audiometry/Ishihara') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Nurse's Signature</label>
                    <input type="text" name="nurse_signature" value="{{ old('nurse_signature', $medicalChecklist->nurse_signature ?? $nurseSignature ?? '') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg shadow hover:bg-green-700 transition-colors font-semibold tracking-wide">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
