@extends('layouts.nurse')

@section('title', 'Edit OPD Examination - RSS Citi Health Services')
@section('page-title', 'Edit OPD Examination')
@section('page-description', 'Update outpatient department consultation and medical examination')

@section('content')
<div class="space-y-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-edit text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Edit OPD Examination</h2>
                        <p class="text-amber-100 text-sm">Update outpatient consultation and medical assessment</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-sm">Examination ID</div>
                    <div class="text-white font-bold text-lg">#{{ $opdExamination->id }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Information Card -->
    <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user text-amber-600"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Patient Information</h3>
                <p class="text-gray-600 text-sm">Walk-in patient details for examination</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Patient Name</label>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                        <span class="text-amber-600 font-semibold text-sm">
                            {{ substr($opdExamination->user->fname, 0, 1) }}{{ substr($opdExamination->user->lname, 0, 1) }}
                        </span>
                    </div>
                    <div class="text-lg font-semibold text-gray-900">{{ $opdExamination->user->fname }} {{ $opdExamination->user->lname }}</div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Age</label>
                <div class="text-lg font-semibold text-gray-900">{{ $opdExamination->user->age }} years old</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Email</label>
                <div class="text-sm font-medium text-gray-900">{{ $opdExamination->user->email }}</div>
            </div>
        </div>
    </div>

            <form action="{{ route('nurse.opd.update', $opdExamination->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Medical History Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Medical History</h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="illness_history" class="block text-sm font-medium text-gray-700 mb-2">Illness History</label>
                            <textarea name="illness_history" id="illness_history" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter illness history...">{{ old('illness_history', $opdExamination->illness_history) }}</textarea>
                            @error('illness_history')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="accidents_operations" class="block text-sm font-medium text-gray-700 mb-2">Accidents/Operations</label>
                            <textarea name="accidents_operations" id="accidents_operations" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter accidents/operations history...">{{ old('accidents_operations', $opdExamination->accidents_operations) }}</textarea>
                            @error('accidents_operations')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="past_medical_history" class="block text-sm font-medium text-gray-700 mb-2">Past Medical History</label>
                            <textarea name="past_medical_history" id="past_medical_history" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter past medical history...">{{ old('past_medical_history', $opdExamination->past_medical_history) }}</textarea>
                            @error('past_medical_history')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Physical Examination Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Physical Examination</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="temp" class="block text-sm font-medium text-gray-700 mb-2">Temperature</label>
                            <input type="text" name="physical_exam[temp]" id="temp" value="{{ old('physical_exam.temp', $opdExamination->physical_exam['temp'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 36.5°C">
                            @error('physical_exam.temp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Height</label>
                            <input type="text" name="physical_exam[height]" id="height" value="{{ old('physical_exam.height', $opdExamination->physical_exam['height'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 170 cm">
                            @error('physical_exam.height')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight</label>
                            <input type="text" name="physical_exam[weight]" id="weight" value="{{ old('physical_exam.weight', $opdExamination->physical_exam['weight'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 70 kg">
                            @error('physical_exam.weight')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="heart_rate" class="block text-sm font-medium text-gray-700 mb-2">Heart Rate</label>
                            <input type="text" name="physical_exam[heart_rate]" id="heart_rate" value="{{ old('physical_exam.heart_rate', $opdExamination->physical_exam['heart_rate'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 72 bpm">
                            @error('physical_exam.heart_rate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Clinical Findings Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Clinical Findings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="skin_marks" class="block text-sm font-medium text-gray-700 mb-2">Skin Marks/Tattoos</label>
                            <textarea name="skin_marks" id="skin_marks" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describe any skin marks, tattoos, or scars...">{{ old('skin_marks', $opdExamination->skin_marks) }}</textarea>
                            @error('skin_marks')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="visual" class="block text-sm font-medium text-gray-700 mb-2">Visual Acuity</label>
                            <textarea name="visual" id="visual" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter visual acuity results...">{{ old('visual', $opdExamination->visual) }}</textarea>
                            @error('visual')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ishihara_test" class="block text-sm font-medium text-gray-700 mb-2">Ishihara Test</label>
                            <textarea name="ishihara_test" id="ishihara_test" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Ishihara test results...">{{ old('ishihara_test', $opdExamination->ishihara_test) }}</textarea>
                            @error('ishihara_test')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="findings" class="block text-sm font-medium text-gray-700 mb-2">General Findings</label>
                            <textarea name="findings" id="findings" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter general findings...">{{ old('findings', $opdExamination->findings) }}</textarea>
                            @error('findings')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Additional Information</h3>
                    
                    <div>
                        <label for="ecg" class="block text-sm font-medium text-gray-700 mb-2">ECG Results</label>
                        <textarea name="ecg" id="ecg" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter ECG results if available...">{{ old('ecg', $opdExamination->ecg) }}</textarea>
                        @error('ecg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('nurse.opd') }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Examination
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
