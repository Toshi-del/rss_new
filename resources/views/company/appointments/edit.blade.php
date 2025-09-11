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
                    <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Duplicate Prevention:</strong> Appointments for the same date and time slot are not allowed.
                        </p>
                    </div>
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

             

                <!-- Medical Tests -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-vials mr-2"></i>Medical Tests
                    </label>
                    <div class="mt-4 space-y-8">
                        @php
                            $selectedTests = old('medical_tests', $appointment->blood_chemistry ?? []);
                        @endphp
                        @foreach($medicalTestCategories as $category)
                            @php $categoryName = strtolower(trim($category->name)); @endphp
                            @if($categoryName === 'pre-employment')
                                @continue
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-red-800 mb-3">{{ $category->name }}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                                    @foreach($category->medicalTests as $test)
                                        <label for="test{{ $test->id }}" class="cursor-pointer block border rounded-xl p-5 hover:shadow transition bg-white">
                                            <div class="flex items-start">
                                                <input
                                                    id="test{{ $test->id }}"
                                                    type="checkbox"
                                                    name="medical_tests[]"
                                                    value="{{ $test->id }}"
                                                    class="mt-1 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                    {{ in_array($test->id, $selectedTests) ? 'checked' : '' }}
                                                >
                                                <div class="ml-3">
                                                    <p class="text-base font-semibold text-gray-900">{{ $test->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $test->description ?? $category->name }}</p>
                                                    <p class="mt-2 text-sm font-semibold text-emerald-600">₱{{ number_format((float)($test->price ?? 0), 2) }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('medical_tests')
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