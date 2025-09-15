@extends('layouts.ecgtech')

@section('title', 'ECG Tech Dashboard')

@section('page-title', 'ECG Tech Dashboard')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Pre-Employment Records Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pre-Employment Records</h3>
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $preEmploymentCount }}</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">Manage ECG information for pre-employment examinations</p>
        <a href="#pre-employment-section" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Records →</a>
    </div>

    <!-- Annual Physical Patients Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Annual Physical Patients</h3>
            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $patientCount }}</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">Manage ECG information for annual physical examinations</p>
        <a href="#annual-physical-section" class="text-green-600 hover:text-green-800 text-sm font-medium">View Patients →</a>
    </div>

    <!-- ECG Reports Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">ECG Reports</h3>
            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $ecgReportCount }}</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">Total ECG reports completed today</p>
        <a href="#ecg-reports-section" class="text-purple-600 hover:text-purple-800 text-sm font-medium">View Reports →</a>
    </div>
</div>

<!-- Pre-Employment Records Section -->
<div id="pre-employment-section" class="bg-white rounded-lg shadow-sm mb-8">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Pre-Employment Records</h2>
        <p class="text-gray-600 text-sm mt-1">Click on a record to access the medical checklist and add ECG information</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAME</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEX</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">COMPANY</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($preEmployments as $preEmployment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $preEmployment->first_name }} {{ $preEmployment->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preEmployment->age }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preEmployment->sex }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preEmployment->company_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = match($preEmployment->status) {
                                    'approved' => 'bg-green-100 text-green-800',
                                    'declined' => 'bg-red-100 text-red-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($preEmployment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <form action="{{ route('ecgtech.pre-employment.send-to-doctor', $preEmployment->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors mr-2" title="Send to Doctor">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                            <a href="{{ route('ecgtech.medical-checklist-page.pre-employment', $preEmployment->id) }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors inline-block" title="ECG Checklist">
                                <i class="fas fa-heartbeat"></i> ECG Checklist
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No pre-employment records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Annual Physical Patients Section -->
<div id="annual-physical-section" class="bg-white rounded-lg shadow-sm mb-8">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Annual Physical Patients</h2>
        <p class="text-gray-600 text-sm mt-1">Click on a patient to access the medical checklist and add ECG information</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PATIENT NAME</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEX</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EMAIL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $patient->first_name }} {{ $patient->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->age }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->sex }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <form action="{{ route('ecgtech.annual-physical.send-to-doctor', $patient->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors mr-2" title="Send to Doctor">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                            <a href="{{ route('ecgtech.medical-checklist-page.annual-physical', $patient->id) }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors inline-block" title="ECG Checklist">
                                <i class="fas fa-heartbeat"></i> ECG Checklist
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No annual physical patients found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ECG Reports Section -->
<div id="ecg-reports-section" class="bg-white rounded-lg shadow-sm mb-8">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Recent ECG Reports</h2>
        <p class="text-gray-600 text-sm mt-1">View recent ECG examination activities</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PATIENT</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DATE</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ECG RESULT</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ecgReports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $report->patient_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report->date ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report->ecg_result ?? 'Pending' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = match($report->status ?? 'pending') {
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($report->status ?? 'pending') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            No ECG reports found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
