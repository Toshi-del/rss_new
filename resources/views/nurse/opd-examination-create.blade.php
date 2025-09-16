@extends('layouts.nurse')

@section('title', 'Create OPD Examination')
@section('page-title', 'Create OPD Examination')

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
            <h2 class="text-xl font-bold tracking-wide">OPD EXAMINATION</h2>
        </div>
        
        @if($opdTest)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Customer Name</label>
                <div class="text-lg font-semibold">{{ $opdTest->customer_name }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Email</label>
                <div class="text-lg font-semibold">{{ $opdTest->customer_email }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Medical Test</label>
                <div class="text-lg font-semibold">{{ $opdTest->medical_test }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Appointment Date</label>
                <div class="text-lg font-semibold">
                    {{ $opdTest->appointment_date ? \Carbon\Carbon::parse($opdTest->appointment_date)->format('M j, Y') : 'N/A' }}
                </div>
            </div>
        </div>
        @endif
        
        <form action="{{ route('nurse.opd-examinations.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="opd_test_id" value="{{ $opdTest->id }}">
           
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
                        <label class="block text-xs mb-1">Heart Rate <span class="text-red-500">*</span></label>
                        <input type="text" name="physical_exam[heart_rate]" value="{{ $phys['heart_rate'] ?? '' }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('physical_exam.heart_rate') border-red-500 @enderror" required />
                        @error('physical_exam.heart_rate')
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
                </div>
            </div>
            
            <!-- Skin Identification Marks -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Skin Identification Marks <span class="text-red-500">*</span></label>
                <input type="text" name="skin_marks" value="{{ old('skin_marks') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('skin_marks') border-red-500 @enderror" required />
                @error('skin_marks')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Visual, Ishihara, Findings -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Visual <span class="text-red-500">*</span></label>
                        <input type="text" name="visual" value="{{ old('visual') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('visual') border-red-500 @enderror" required />
                        @error('visual')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Ishihara Test <span class="text-red-500">*</span></label>
                        <input type="text" name="ishihara_test" value="{{ old('ishihara_test') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('ishihara_test') border-red-500 @enderror" required />
                        @error('ishihara_test')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Findings <span class="text-red-500">*</span></label>
                        <input type="text" name="findings" value="{{ old('findings') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 @error('findings') border-red-500 @enderror" required />
                        @error('findings')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Test Results and Recommendations -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Test Results</label>
                        <textarea name="test_results" rows="4" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" placeholder="Enter test results...">{{ old('test_results') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Recommendations</label>
                        <textarea name="recommendations" rows="4" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" placeholder="Enter recommendations...">{{ old('recommendations') }}</textarea>
                    </div>
                </div>
            </div>
          
            <!-- NURSE'S SIGNATURE -->
            <div class="flex flex-col md:flex-row justify-between items-center mt-8 gap-6">
                <div class="text-xs text-gray-500 w-full md:w-auto">
                    <div>NURSE'S SIGNATURE</div>
                    <div class="border-b border-gray-400 w-48 mt-2"></div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('nurse.opd-examinations') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-green-600 text-white px-8 py-2 rounded-lg shadow hover:bg-green-700 transition-colors font-semibold tracking-wide">
                    CREATE EXAMINATION
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
