@extends('layouts.nurse')

@section('title', 'Edit OPD Examination')
@section('page-title', 'Edit OPD Examination')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 mb-8">
        <div class="bg-green-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">EDIT OPD EXAMINATION</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Customer Name</label>
                <div class="text-lg font-semibold">{{ $opdExamination->customer_name }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Email</label>
                <div class="text-lg font-semibold">{{ $opdExamination->customer_email }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Medical Test</label>
                <div class="text-lg font-semibold">{{ $opdExamination->medical_test }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Date</label>
                <div class="text-lg font-semibold">{{ \Carbon\Carbon::parse($opdExamination->date)->format('M j, Y') }}</div>
            </div>
        </div>
        
        <form action="{{ route('nurse.opd-examinations.update', $opdExamination->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')
           
            <!-- Physical Examination -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Physical Examination</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php $phys = old('physical_exam', $opdExamination->physical_exam ?? []); @endphp
                    <div>
                        <label class="block text-xs mb-1">Temp</label>
                        <input type="text" name="physical_exam[temp]" value="{{ $phys['temp'] ?? '' }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Height</label>
                        <input type="text" name="physical_exam[height]" value="{{ $phys['height'] ?? '' }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Heart Rate</label>
                        <input type="text" name="physical_exam[heart_rate]" value="{{ $phys['heart_rate'] ?? '' }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Weight</label>
                        <input type="text" name="physical_exam[weight]" value="{{ $phys['weight'] ?? '' }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                    </div>
                </div>
            </div>
            
            <!-- Skin Identification Marks -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Skin Identification Marks</label>
                <input type="text" name="skin_marks" value="{{ old('skin_marks', $opdExamination->skin_marks) }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
            </div>
            
            <!-- Visual, Ishihara, Findings -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Visual</label>
                        <input type="text" name="visual" value="{{ old('visual', $opdExamination->visual) }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Ishihara Test</label>
                        <input type="text" name="ishihara_test" value="{{ old('ishihara_test', $opdExamination->ishihara_test) }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Findings</label>
                        <input type="text" name="findings" value="{{ old('findings', $opdExamination->findings) }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" />
                    </div>
                </div>
            </div>

            <!-- Test Results and Recommendations -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Test Results</label>
                        <textarea name="test_results" rows="4" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" placeholder="Enter test results...">{{ old('test_results', $opdExamination->test_results) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Recommendations</label>
                        <textarea name="recommendations" rows="4" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" placeholder="Enter recommendations...">{{ old('recommendations', $opdExamination->recommendations) }}</textarea>
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
                    SAVE CHANGES
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
