@extends('layouts.doctor')

@section('title', 'Medical Checklist')
@section('page-title', 'Medical Checklist')
@section('page-description', 'Track and manage medical examination procedures and completion status')

@section('content')
<div class="space-y-8" style="font-family: 'Poppins', sans-serif;">
    
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-emerald-700">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-white text-xl mr-3"></i>
                <span class="text-white font-medium">{{ session('success') }}</span>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-violet-600 to-violet-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-clipboard-list mr-3"></i>Medical Examination Checklist
                    </h1>
                    <p class="text-violet-100">Track medical procedures and examination completion status</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-violet-500 rounded-lg px-4 py-2">
                        <p class="text-violet-100 text-sm font-medium">Exam Type</p>
                        <p class="text-white text-lg font-bold">{{ ucwords(str_replace('_', ' ', $examinationType)) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Form Container -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">

        <!-- Patient Information Section -->
        <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700 border-l-4 border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-user-circle mr-3"></i>Patient Information
                    </h2>
                    <p class="text-blue-100 mt-1">Basic patient details for medical examination tracking</p>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <form action="{{ isset($medicalChecklist) && $medicalChecklist->id ? route('doctor.medical-checklist.update', $medicalChecklist->id) : route('doctor.medical-checklist.store') }}" method="POST" class="space-y-8">
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

                <!-- Patient Information Fields -->
                <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-id-card text-blue-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-blue-900" style="font-family: 'Poppins', sans-serif;">Patient Details</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-blue-600"></i>Patient Name
                            </label>
                            <input type="text" name="name" value="{{ old('name', $medicalChecklist->name ?? $name ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" required placeholder="Enter patient name">
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 text-green-600"></i>Examination Date
                            </label>
                            @php($currentDate = old('date', $medicalChecklist->date ?? $date ?? now()->format('Y-m-d')))
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($currentDate)->format('M d, Y') }}
                            </div>
                            <input type="hidden" name="date" value="{{ $currentDate }}">
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-birthday-cake mr-2 text-orange-600"></i>Age
                            </label>
                            <input type="number" name="age" value="{{ old('age', $medicalChecklist->age ?? $age ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" required placeholder="Enter age">
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-hashtag mr-2 text-purple-600"></i>Patient Number
                            </label>
                            @php($displayNumber = old('number', $medicalChecklist->number ?? $number ?? ''))
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                {{ $displayNumber ?: 'Not assigned' }}
                            </div>
                            <input type="hidden" name="number" value="{{ $displayNumber }}">
                        </div>
                    </div>
                </div>

                <!-- Medical Examinations Checklist -->
                <div class="bg-emerald-50 rounded-xl p-6 border-l-4 border-emerald-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-tasks text-emerald-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-emerald-900" style="font-family: 'Poppins', sans-serif;">Medical Examination Procedures</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @php
                            $examinations = [
                                'chest_xray' => ['name' => 'Chest X-Ray', 'icon' => 'fas fa-x-ray', 'color' => 'blue'],
                                'stool_exam' => ['name' => 'Stool Examination', 'icon' => 'fas fa-microscope', 'color' => 'yellow'],
                                'urinalysis' => ['name' => 'Urinalysis', 'icon' => 'fas fa-vial', 'color' => 'green'],
                                'drug_test' => ['name' => 'Drug Test', 'icon' => 'fas fa-pills', 'color' => 'red'],
                                'blood_extraction' => ['name' => 'Blood Extraction', 'icon' => 'fas fa-tint', 'color' => 'pink'],
                                'ecg' => ['name' => 'ElectroCardioGram (ECG)', 'icon' => 'fas fa-heartbeat', 'color' => 'purple'],
                                'physical_exam' => ['name' => 'Physical Examination', 'icon' => 'fas fa-stethoscope', 'color' => 'teal']
                            ];
                        @endphp
                        
                        @foreach($examinations as $field => $exam)
                        <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <div class="w-8 h-8 bg-{{ $exam['color'] }}-100 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-{{ $exam['color'] }}-600 font-bold text-sm">{{ $loop->iteration }}</span>
                                    </div>
                                    <div class="flex items-center flex-1">
                                        <i class="{{ $exam['icon'] }} text-{{ $exam['color'] }}-600 mr-3"></i>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $exam['name'] }}</h4>
                                            <p class="text-xs text-gray-500">Medical procedure completion tracking</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-4">
                                    <div class="text-right">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Completed By</label>
                                        <input type="text" name="{{ $field }}_done_by" 
                                               value="{{ old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? '') }}" 
                                               placeholder="Enter initials or signature" 
                                               class="w-40 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                    </div>
                                    @if(old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? ''))
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-green-600"></i>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-clock text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="bg-orange-50 rounded-xl p-6 border-l-4 border-orange-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-plus-circle text-orange-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-orange-900" style="font-family: 'Poppins', sans-serif;">Additional Information</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clipboard-check mr-2 text-orange-600"></i>Optional Examinations
                            </label>
                            <input type="text" name="optional_exam" value="{{ old('optional_exam', $medicalChecklist->optional_exam ?? $optionalExam ?? 'Audiometry/Ishihara') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="Enter optional examinations">
                            <p class="text-xs text-gray-500 mt-1">Additional tests or examinations if required</p>
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-signature mr-2 text-violet-600"></i>Doctor's Signature
                            </label>
                            <input type="text" name="doctor_signature" value="{{ old('doctor_signature', $medicalChecklist->doctor_signature ?? $doctorSignature ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="Enter doctor's signature or initials">
                            <p class="text-xs text-gray-500 mt-1">Physician's signature for checklist authorization</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-gray-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-check-double text-gray-600 mr-3"></i>Checklist Completion
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Review and submit the medical examination checklist</p>
                        </div>
                        
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="window.history.back()" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-violet-600 text-white rounded-lg font-semibold hover:bg-violet-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-save mr-3"></i>
                                {{ isset($medicalChecklist) && $medicalChecklist->id ? 'Update Checklist' : 'Save Checklist' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
