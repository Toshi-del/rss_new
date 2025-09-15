    @extends('layouts.ecgtech')

@section('title', 'ECG Medical Checklist')

@section('page-title', 'ECG Medical Checklist')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="bg-green-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">ECG MEDICAL CHECKLIST</h2>
        </div>

        <form action="{{ route('ecgtech.medical-checklist.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="examination_type" value="{{ $examinationType }}">
            @if($examinationType === 'annual-physical')
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            @else
                <input type="hidden" name="pre_employment_record_id" value="{{ $record->id }}">
            @endif

            <!-- Patient Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Name</label>
                    <div class="text-lg font-semibold text-gray-800">{{ $name }}</div>
                    <input type="hidden" name="name" value="{{ $name }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Date</label>
                    <div class="text-lg font-semibold text-gray-800">{{ $date }}</div>
                    <input type="hidden" name="date" value="{{ $date }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Age</label>
                    <div class="text-lg font-semibold text-gray-800">{{ $age }}</div>
                    <input type="hidden" name="age" value="{{ $age }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Number</label>
                    <div class="text-lg font-semibold text-gray-800">{{ $number ?? 'N/A' }}</div>
                    <input type="hidden" name="number" value="{{ $number ?? '' }}" />
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
                                @if($field === 'ecg')
                                    <!-- ECG Tech can fill this field -->
                                    <input type="text" name="{{ $field }}_done_by" 
                                           value="{{ old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? Auth::user()->fname . ' ' . Auth::user()->lname) }}" 
                                           placeholder="ECG Tech Initials" 
                                           class="form-input w-32 rounded border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                                @else
                                    <!-- Other fields are read-only for ECG Tech -->
                                    <input type="text" name="{{ $field }}_done_by" 
                                           value="{{ old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? '') }}" 
                                           placeholder="Not completed" 
                                           class="form-input w-32 rounded border-gray-300 text-sm bg-gray-100 text-gray-500" 
                                           readonly>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Optional Exam and Doctor Signature (Read-only for ECG Tech) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Optional</label>
                    <input type="text" name="optional_exam" value="{{ old('optional_exam', $medicalChecklist->optional_exam ?? 'Audiometry/Ishihara') }}" class="form-input w-full rounded-lg border-gray-300 bg-gray-100 text-gray-500" readonly />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Doctor's Signature</label>
                    <input type="text" name="doctor_signature" value="{{ old('doctor_signature', $medicalChecklist->doctor_signature ?? '') }}" class="form-input w-full rounded-lg border-gray-300 bg-gray-100 text-gray-500" readonly />
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ url()->previous() }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg shadow hover:bg-green-700 transition-colors font-semibold tracking-wide">
                    <i class="fas fa-save mr-2"></i>Submit ECG Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        
        // The form will submit normally and redirect via the controller
    });
});
</script>
@endsection
