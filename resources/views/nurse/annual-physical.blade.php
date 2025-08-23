@extends('layouts.nurse')

@section('title', 'Annual Physical Examination')

@section('page-title', 'Annual Physical Examination')

@section('content')
    <!-- Annual Physical Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Annual Physical Examination Patients</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PATIENT NAME</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEX</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EMAIL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PHONE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">APPOINTMENT ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EXAMINATION STATUS</th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->appointment_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    $annualPhysicalExam = \App\Models\AnnualPhysicalExamination::where('patient_id', $patient->id)->first();
                                @endphp
                                @if($annualPhysicalExam)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($annualPhysicalExam)
                                    <a href="{{ route('nurse.annual-physical.edit', $annualPhysicalExam->id) }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors mr-2" title="Edit Examination">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @else
                                    <span class="bg-gray-400 text-white px-3 py-1 rounded mr-2" title="No examination yet">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                @endif
                                <a href="{{ route('nurse.medical-checklist.annual-physical', $patient->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors mr-2" title="Medical Checklist">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                                <a href="#" class="bg-purple-600 text-white px-3 py-1 rounded hover:bg-purple-700 transition-colors" title="Assist">
                                    <i class="fas fa-hands-helping"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No annual physical examination patients found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
