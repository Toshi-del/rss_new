@extends('layouts.nurse')

@section('title', 'Create Pre-Employment Examination')
@section('page-title', 'Create Pre-Employment Examination')

@section('content')
@if($errors->any())
    <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300 text-center font-semibold">
        <h3 class="font-bold mb-2">Please complete all required fields:</h3>
        <ul class="text-sm text-left">
            @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 mb-8">
        <div class="bg-green-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">CERTIFICATE OF MEDICAL EXAMINATION</h2>
        </div>
        @if($preEmploymentRecord)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Full Name</label>
                <div class="text-lg font-semibold">{{ $preEmploymentRecord->full_name ?? ($preEmploymentRecord->first_name . ' ' . $preEmploymentRecord->last_name) }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Age</label>
                <div class="text-lg font-semibold">{{ $preEmploymentRecord->age }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Sex</label>
                <div class="text-lg font-semibold">{{ $preEmploymentRecord->sex }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Company Name</label>
                <div class="text-lg font-semibold">{{ $preEmploymentRecord->company_name }}</div>
            </div>
        </div>
        @endif
        <form action="{{ route('nurse.pre-employment.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="pre_employment_record_id" value="{{ $preEmploymentRecord->id }}">
            
          
          
            <!-- Physical Examination -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Physical Examination</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php $phys = old('physical_exam', []); @endphp
                    <div>
                        <label class="block text-xs mb-1">Temp <span class="text-red-500">*</span></label>
                        <input type="text" name="physical_exam[temp]" value="{{ $phys['temp'] ?? '' }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('physical_exam.temp') border-red-500 @enderror" required />
                        @error('physical_exam.temp')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Height <span class="text-red-500">*</span></label>
                        <input type="text" name="physical_exam[height]" value="{{ $phys['height'] ?? '' }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('physical_exam.height') border-red-500 @enderror" required />
                        @error('physical_exam.height')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Weight <span class="text-red-500">*</span></label>
                        <input type="text" name="physical_exam[weight]" value="{{ $phys['weight'] ?? '' }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('physical_exam.weight') border-red-500 @enderror" required />
                        @error('physical_exam.weight')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Heart Rate <span class="text-red-500">*</span></label>
                        <input type="text" name="physical_exam[heart_rate]" value="{{ $phys['heart_rate'] ?? '' }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('physical_exam.heart_rate') border-red-500 @enderror" required />
                        @error('physical_exam.heart_rate')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                  
                </div>
            </div>
            
            <!-- Skin Marks -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Skin Marks / Tattoos <span class="text-red-500">*</span></label>
                <textarea name="skin_marks" class="form-textarea w-full h-16 rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('skin_marks') border-red-500 @enderror" required>{{ old('skin_marks') }}</textarea>
                @error('skin_marks')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Visual Acuity -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-2">Visual Acuity <span class="text-red-500">*</span></label>
                        <textarea name="visual" class="form-textarea w-full h-16 rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('visual') border-red-500 @enderror" required>{{ old('visual') }}</textarea>
                        @error('visual')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-2">Ishihara Test <span class="text-red-500">*</span></label>
                        <textarea name="ishihara_test" class="form-textarea w-full h-16 rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('ishihara_test') border-red-500 @enderror" required>{{ old('ishihara_test') }}</textarea>
                        @error('ishihara_test')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Findings -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Findings <span class="text-red-500">*</span></label>
                <textarea name="findings" class="form-textarea w-full h-24 rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('findings') border-red-500 @enderror" required>{{ old('findings') }}</textarea>
                @error('findings')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            
          
          
            
          
          
            
            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('nurse.pre-employment') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    Create Examination
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
