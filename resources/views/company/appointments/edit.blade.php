@extends('layouts.company')

@section('title', 'Edit Appointment')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Edit Appointment</h1>
        </div>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('company.appointments.update', $appointment) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <!-- Appointment Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('appointment_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Slot -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Time Slot</label>
                    <select name="time_slot" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Select a time slot</option>
                        @foreach($timeSlots as $slot)
                        <option value="{{ $slot }}" {{ old('time_slot', $appointment->time_slot) == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                        @endforeach
                    </select>
                    @error('time_slot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Appointment Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Type</label>
                    <select name="appointment_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Select appointment type</option>
                        <option value="ANNUAL MEDICAL EXAMINATION" {{ old('appointment_type', $appointment->appointment_type) == 'ANNUAL MEDICAL EXAMINATION' ? 'selected' : '' }}>Annual Medical Examination</option>
                        <option value="ANNUAL MEDICAL WITH DRUG TEST" {{ old('appointment_type', $appointment->appointment_type) == 'ANNUAL MEDICAL WITH DRUG TEST' ? 'selected' : '' }}>Annual Medical with Drug Test</option>
                        <option value="ANNUAL MEDICAL WITH ECG" {{ old('appointment_type', $appointment->appointment_type) == 'ANNUAL MEDICAL WITH ECG' ? 'selected' : '' }}>Annual Medical with ECG</option>
                        <option value="ANNUAL MEDICAL COMPLETE" {{ old('appointment_type', $appointment->appointment_type) == 'ANNUAL MEDICAL COMPLETE' ? 'selected' : '' }}>Annual Medical Complete</option>
                    </select>
                    @error('appointment_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Blood Chemistry -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tint mr-2"></i>Blood Chemistry
                    </label>
                    <div class="mt-2 space-y-2">
                        @foreach($bloodChemistry as $test)
                        <div class="flex items-center">
                            <input type="checkbox" name="blood_chemistry[]" value="{{ $test }}" id="blood{{ $loop->index + 1 }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                {{ in_array($test, old('blood_chemistry', $appointment->blood_chemistry ?? [])) ? 'checked' : '' }}>
                            <label for="blood{{ $loop->index + 1 }}" class="ml-2 block text-sm text-gray-900">{{ $test }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('blood_chemistry')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('notes', $appointment->notes) }}</textarea>
                    @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <a href="{{ route('company.appointments.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Appointment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection