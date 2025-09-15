@extends('layouts.ecgtech')

@section('title', 'Edit Pre-Employment ECG Examination')
@section('page-title', 'Edit Pre-Employment ECG Examination')

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

<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 mb-8">
        <div class="bg-green-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">ECG EXAMINATION - PRE-EMPLOYMENT</h2>
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

        <form action="{{ route('ecgtech.pre-employment.update', $preEmployment->preEmploymentRecord->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')
            
            <!-- ECG Examination Section -->
            <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                <h3 class="text-lg font-semibold text-green-800 mb-4">ECG Examination Results</h3>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">ECG Results: <span class="text-red-500">*</span></label>
                    <textarea name="ecg" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="Enter ECG examination results..." required>{{ old('ecg', $preEmployment->ecg ?? '') }}</textarea>
                    @error('ecg')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Physical Examination Section -->
            <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                <h3 class="text-lg font-semibold text-blue-800 mb-4">PHYSICAL EXAMINATION</h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Temp</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm text-gray-600">{{ $preEmployment->physical_exam['temp'] ?? 'Not recorded' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Height</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm text-gray-600">{{ $preEmployment->physical_exam['height'] ?? 'Not recorded' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Heart Rate</label>
                        <input type="text" name="heart_rate" class="w-full p-2 border border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500" value="{{ old('heart_rate', $preEmployment->physical_exam['heart_rate'] ?? '') }}" placeholder="Enter heart rate">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Weight</label>
                        <div class="bg-white p-2 rounded-lg border border-gray-300 text-sm text-gray-600">{{ $preEmployment->physical_exam['weight'] ?? 'Not recorded' }}</div>
                    </div>
                </div> 
              

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-center mt-8 gap-6">
                <a href="{{ route('ecgtech.pre-employment') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-600 transition-colors font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Pre-Employment
                </a>
                <button type="submit" class="bg-green-600 text-white px-8 py-2 rounded-lg shadow hover:bg-green-700 transition-colors font-semibold">
                    <i class="fas fa-save mr-2"></i>Save ECG Results
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
