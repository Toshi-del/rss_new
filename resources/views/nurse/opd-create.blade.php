@extends('layouts.nurse')

@section('title', 'Create OPD Examination')

@section('page-title', 'Create OPD Examination')

@section('content')
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Create OPD Examination</h2>
                <a href="{{ route('nurse.opd') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to OPD List
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Patient Information -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Patient Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-blue-700">Name:</span>
                        <span class="text-blue-600">{{ $opdPatient->fname }} {{ $opdPatient->lname }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-blue-700">Age:</span>
                        <span class="text-blue-600">{{ $opdPatient->age }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-blue-700">Email:</span>
                        <span class="text-blue-600">{{ $opdPatient->email }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('nurse.opd.store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $opdPatient->id }}">

                <!-- Medical History Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Medical History</h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="illness_history" class="block text-sm font-medium text-gray-700 mb-2">Illness History</label>
                            <textarea name="illness_history" id="illness_history" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter illness history...">{{ old('illness_history') }}</textarea>
                            @error('illness_history')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="accidents_operations" class="block text-sm font-medium text-gray-700 mb-2">Accidents/Operations</label>
                            <textarea name="accidents_operations" id="accidents_operations" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter accidents/operations history...">{{ old('accidents_operations') }}</textarea>
                            @error('accidents_operations')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="past_medical_history" class="block text-sm font-medium text-gray-700 mb-2">Past Medical History</label>
                            <textarea name="past_medical_history" id="past_medical_history" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter past medical history...">{{ old('past_medical_history') }}</textarea>
                            @error('past_medical_history')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Physical Examination Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Physical Examination <span class="text-red-500">*</span></h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="temp" class="block text-sm font-medium text-gray-700 mb-2">Temperature <span class="text-red-500">*</span></label>
                            <input type="text" name="physical_exam[temp]" id="temp" value="{{ old('physical_exam.temp') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 36.5°C" required>
                            @error('physical_exam.temp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Height <span class="text-red-500">*</span></label>
                            <input type="text" name="physical_exam[height]" id="height" value="{{ old('physical_exam.height') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 170 cm" required>
                            @error('physical_exam.height')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight <span class="text-red-500">*</span></label>
                            <input type="text" name="physical_exam[weight]" id="weight" value="{{ old('physical_exam.weight') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 70 kg" required>
                            @error('physical_exam.weight')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="heart_rate" class="block text-sm font-medium text-gray-700 mb-2">Heart Rate <span class="text-red-500">*</span></label>
                            <input type="text" name="physical_exam[heart_rate]" id="heart_rate" value="{{ old('physical_exam.heart_rate') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 72 bpm" required>
                            @error('physical_exam.heart_rate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Clinical Findings Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Clinical Findings <span class="text-red-500">*</span></h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="skin_marks" class="block text-sm font-medium text-gray-700 mb-2">Skin Marks/Tattoos <span class="text-red-500">*</span></label>
                            <textarea name="skin_marks" id="skin_marks" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describe any skin marks, tattoos, or scars..." required>{{ old('skin_marks') }}</textarea>
                            @error('skin_marks')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="visual" class="block text-sm font-medium text-gray-700 mb-2">Visual Acuity <span class="text-red-500">*</span></label>
                            <textarea name="visual" id="visual" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter visual acuity results..." required>{{ old('visual') }}</textarea>
                            @error('visual')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ishihara_test" class="block text-sm font-medium text-gray-700 mb-2">Ishihara Test <span class="text-red-500">*</span></label>
                            <textarea name="ishihara_test" id="ishihara_test" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Ishihara test results..." required>{{ old('ishihara_test') }}</textarea>
                            @error('ishihara_test')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="findings" class="block text-sm font-medium text-gray-700 mb-2">General Findings <span class="text-red-500">*</span></label>
                            <textarea name="findings" id="findings" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter general findings..." required>{{ old('findings') }}</textarea>
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
                        <textarea name="ecg" id="ecg" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter ECG results if available...">{{ old('ecg') }}</textarea>
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
                        <i class="fas fa-save mr-2"></i>Save Examination
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
