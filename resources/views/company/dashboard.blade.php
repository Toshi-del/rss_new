@extends('layouts.company')

@section('title', 'Medical Examination Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Pending Appointments -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Pending Appointments</h3>
            <div class="h-12 w-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $pendingAppointmentsCount ?? 156 }}</p>
    </div>

    <!-- Approved Appointments -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Approved Appointments</h3>
            <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $approvedAppointmentsCount ?? 892 }}</p>
    </div>

    <!-- Total Appointments -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Total Appointments</h3>
            <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalAppointmentsCount ?? 1247 }}</p>
    </div>

    <!-- Pre-Employment Records -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Pre-Employment Records</h3>
            <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-md text-purple-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalPreEmploymentCount ?? 45 }}</p>
    </div>
</div>

<!-- Scheduled Appointments -->
<div class="mt-8">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">Scheduled Appointments</h2>
            <a href="{{ route('company.appointments.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Schedule New
            </a>
        </div>
        
        @if(isset($appointments) && count($appointments) > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($appointments as $appointment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->formatted_date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->formatted_time_slot }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ optional($appointment->medicalTestCategory)->name }}
                            @if($appointment->medicalTest)
                                - {{ $appointment->medicalTest->name }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($appointment->total_price ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->notes ?? 'No notes' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = 'bg-gray-100 text-gray-800';
                                $status = $appointment->status ?? 'pending';
                                if ($status === 'approved') {
                                    $statusClass = 'bg-green-100 text-green-800';
                                } elseif ($status === 'failed') {
                                    $statusClass = 'bg-red-100 text-red-800';
                                } elseif ($status === 'pending') {
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                }
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <a href="{{ route('company.appointments.show', $appointment->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('company.appointments.edit', $appointment->id) }}" class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-6 text-center text-sm text-gray-600">
            No appointments scheduled.
        </div>
        @endif
    </div>
</div>

<!-- Recent Pre-Employment Records -->
<div class="mt-8">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">Recent Pre-Employment Records</h2>
            <a href="{{ route('company.pre-employment.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                + New Record
            </a>
        </div>
        
        @if(isset($preEmploymentRecords) && count($preEmploymentRecords) > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medical Exam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($preEmploymentRecords as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $record->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $record->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ optional($record->medicalTestCategory)->name }}
                            @if($record->medicalTest)
                                - {{ $record->medicalTest->name }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($record->total_price ?? 0, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = 'bg-gray-100 text-gray-800';
                                $status = $record->status ?? 'pending';
                                if ($status === 'passed') {
                                    $statusClass = 'bg-green-100 text-green-800';
                                } elseif ($status === 'failed') {
                                    $statusClass = 'bg-red-100 text-red-800';
                                } elseif ($status === 'pending') {
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                }
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <a href="{{ route('company.pre-employment.show', $record->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($record->uploaded_file)
                                <a href="{{ asset('storage/' . $record->uploaded_file) }}" class="text-gray-600 hover:text-gray-900" download>
                                    <i class="fas fa-download"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-6 text-center text-sm text-gray-600">
            No pre-employment records found.
        </div>
        @endif
    </div>
</div>
@endsection 