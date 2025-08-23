@extends('layouts.doctor')

@section('title', 'Annual Physical Examination')

@section('page-title', 'Annual Physical Examination')

@section('content')
    <!-- Patients Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Patients</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PATIENT NAME</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEX</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">APPOINTMENT ID</th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->appointment_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors mr-2" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('doctor.annual-physical.edit', $patient->id) }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors mr-2" title="Update Results">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('doctor.medical-checklist.annual-physical', $patient->id) }}" class="bg-purple-600 text-white px-3 py-1 rounded hover:bg-purple-700 transition-colors" title="Medical Checklist">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                No patients found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection 