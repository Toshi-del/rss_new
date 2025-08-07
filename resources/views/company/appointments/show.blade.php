@extends('layouts.company')

@section('title', 'Appointment Details')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900">Appointment Details</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('company.appointments.edit', $appointment) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Edit Appointment
                    </a>
                    <a href="{{ route('company.appointments.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Appointment Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Annual medical examination appointment details.</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Appointment ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $appointment->id }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Scheduled
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $appointment->formatted_date }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Time</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $appointment->formatted_time_slot }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Appointment Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $appointment->appointment_type }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Created By</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $appointment->creator->full_name }}</dd>
                    </div>
                    @if($appointment->blood_chemistry && count($appointment->blood_chemistry) > 0)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Blood Chemistry Tests</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <div class="flex flex-wrap gap-2">
                                @foreach($appointment->blood_chemistry as $test)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $test }}</span>
                                @endforeach
                            </div>
                        </dd>
                    </div>
                    @endif
                    @if($appointment->notes)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Notes</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $appointment->notes }}</dd>
                    </div>
                    @endif
                    @if($appointment->patients && $appointment->patients->count() > 0)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Patients ({{ $appointment->patients->count() }})</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Age/Sex</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($appointment->patients as $patient)
                                        <tr>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $patient->full_name }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $patient->age_sex }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $patient->email ?? $patient->phone ?? 'N/A' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </dd>
                    </div>
                    @endif
                    @if($appointment->excel_file_path)
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Uploaded File</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ basename($appointment->excel_file_path) }}</dd>
                    </div>
                    @endif
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $appointment->created_at->format('M d, Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection