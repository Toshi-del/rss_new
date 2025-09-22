@extends('layouts.nurse')

@section('title', 'Dashboard')

@section('page-title', 'Overview')

@section('content')
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Patients Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Patients</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $patientCount }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-injured text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pre-Employment Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Pre-Employment</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $preEmploymentCount }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-md text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- OPD Walk-ins Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">OPD Walk-ins</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $opdCount }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-walking text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Annual Physical Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Annual Physical</h3>
                    <p class="text-3xl font-bold text-orange-600">{{ $annualPhysicalCount }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- OPD Walk-ins Actions -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">OPD Walk-ins</h3>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-walking text-blue-600"></i>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('nurse.opd') }}" class="block w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center">
                    <i class="fas fa-stethoscope mr-2"></i>Examination
                </a>
                <a href="{{ route('nurse.opd') }}" class="block w-full bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200 transition-colors text-center">
                    <i class="fas fa-clipboard-list mr-2"></i>Medical Checklist
                </a>
            </div>
        </div>

        <!-- Pre-Employment Actions -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pre-Employment</h3>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-md text-purple-600"></i>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('nurse.pre-employment') }}" class="block w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors text-center">
                    <i class="fas fa-stethoscope mr-2"></i>Examination
                </a>
                <a href="{{ route('nurse.pre-employment') }}" class="block w-full bg-purple-100 text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-200 transition-colors text-center">
                    <i class="fas fa-clipboard-list mr-2"></i>Medical Checklist
                </a>
            </div>
        </div>

        <!-- Annual Physical Actions -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Annual Physical</h3>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-orange-600"></i>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('nurse.annual-physical') }}" class="block w-full bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors text-center">
                    <i class="fas fa-stethoscope mr-2"></i>Examination
                </a>
                <a href="{{ route('nurse.annual-physical') }}" class="block w-full bg-orange-100 text-orange-700 px-4 py-2 rounded-lg hover:bg-orange-200 transition-colors text-center">
                    <i class="fas fa-clipboard-list mr-2"></i>Medical Checklist
                </a>
            </div>
        </div>
    </div>

    <!-- Appointments Section -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Recent Annual Physical Patients</h2>
                <a href="{{ route('nurse.appointments') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    View All
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medical Test</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                       
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                        @foreach($appointment->patients as $patient)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($appointment->medicalTestCategory)
                                        {{ $appointment->medicalTestCategory->name }}
                                        @if($appointment->medicalTest)
                                            - {{ $appointment->medicalTest->name }}
                                        @endif
                                    @else
                                        {{ $appointment->appointment_type ?? 'N/A' }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $appointment->formatted_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $appointment->formatted_time_slot }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($appointment->status === 'completed') bg-green-100 text-green-800
                                        @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($appointment->status ?? 'pending') }}
                                    </span>
                                </td>
                             
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                No appointments found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection 