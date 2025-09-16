@extends('layouts.nurse')

@section('title', 'OPD Medical Checklist')
@section('page-title', 'OPD Medical Checklist')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="bg-green-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">OPD MEDICAL CHECKLIST</h2>
        </div>

        <form action="{{ isset($medicalChecklist) && $medicalChecklist->id ? route('nurse.medical-checklist.update', $medicalChecklist->id) : route('nurse.medical-checklist.store') }}" method="POST" class="space-y-8">
            @csrf
            @if(isset($medicalChecklist) && $medicalChecklist->id)
                @method('PATCH')
            @endif
            <input type="hidden" name="examination_type" value="opd">
            @if(isset($opdTest))
                <input type="hidden" name="opd_test_id" value="{{ $opdTest->id }}">
            @endif

            @php
                // Generate number for OPD tests
                $generatedNumber = null;
                if (isset($medicalChecklist) && ($medicalChecklist->number ?? null)) {
                    $generatedNumber = $medicalChecklist->number;
                } elseif (isset($opdTest)) {
                    $generatedNumber = 'OPD-' . str_pad($opdTest->id, 4, '0', STR_PAD_LEFT);
                } else {
                    $generatedNumber = old('number', $number ?? '');
                }
            @endphp

            <!-- Patient Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Customer Name</label>
                    <div class="w-full rounded-lg border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                        @if(isset($medicalChecklist) && $medicalChecklist->customer_name)
                            {{ $medicalChecklist->customer_name }}
                        @elseif(isset($opdTest))
                            {{ $opdTest->customer_name }}
                        @else
                            {{ old('name', $medicalChecklist->name ?? $name ?? '') }}
                        @endif
                    </div>
                    <input type="hidden" name="name" value="@if(isset($medicalChecklist) && $medicalChecklist->customer_name){{ $medicalChecklist->customer_name }}@elseif(isset($opdTest)){{ $opdTest->customer_name }}@else{{ old('name', $medicalChecklist->name ?? $name ?? '') }}@endif" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Date</label>
                    @php($currentDate = old('date', $medicalChecklist->date ?? $date ?? now()->format('Y-m-d')))
                    <a class="text-green-700 hover:underline cursor-default">{{ \Carbon\Carbon::parse($currentDate)->format('Y-m-d') }}</a>
                    <input type="hidden" name="date" value="{{ $currentDate }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Email</label>
                    <div class="w-full rounded-lg border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                        @if(isset($medicalChecklist) && $medicalChecklist->customer_email)
                            {{ $medicalChecklist->customer_email }}
                        @elseif(isset($opdTest))
                            {{ $opdTest->customer_email }}
                        @else
                            {{ old('email', $medicalChecklist->email ?? $email ?? '') }}
                        @endif
                    </div>
                    <input type="hidden" name="email" value="@if(isset($medicalChecklist) && $medicalChecklist->customer_email){{ $medicalChecklist->customer_email }}@elseif(isset($opdTest)){{ $opdTest->customer_email }}@else{{ old('email', $medicalChecklist->email ?? $email ?? '') }}@endif" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Number</label>
                    <div class="w-full rounded-lg border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                        {{ $generatedNumber ?: 'N/A' }}
                    </div>
                    <input type="hidden" name="number" value="{{ $generatedNumber }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Medical Test</label>
                    <div class="w-full rounded-lg border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                        @if(isset($opdTest))
                            {{ $opdTest->medical_test }}
                        @else
                            {{ old('medical_test', $medicalChecklist->medical_test ?? '') }}
                        @endif
                    </div>
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

            <!-- Optional Exam -->
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Optional</label>
                    <input type="text" name="optional_exam" value="{{ old('optional_exam', $medicalChecklist->optional_exam ?? $optionalExam ?? 'Audiometry/Ishihara') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                </div>
            </div>

            <!-- Test Results Section -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Test Results & Notes</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Test Results</label>
                        <textarea name="test_results" rows="4" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" placeholder="Enter test results...">{{ old('test_results', $medicalChecklist->test_results ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Recommendations</label>
                        <textarea name="recommendations" rows="4" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" placeholder="Enter recommendations...">{{ old('recommendations', $medicalChecklist->recommendations ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-between">
                <a href="{{ route('nurse.opd-examinations') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                    Back to OPD Examinations
                </a>
                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg shadow hover:bg-green-700 transition-colors font-semibold tracking-wide">
                    Submit Checklist
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
