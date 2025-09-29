@extends('layouts.pathologist')

@section('title', 'OPD Walk-in Patients')

@section('page-title', 'OPD Walk-in Patients')

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('pathologist.opd') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by name or email..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <button type="submit" class="bg-gradient-to-r from-teal-600 to-teal-700 text-white px-6 py-2 rounded-lg hover:from-teal-700 hover:to-teal-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            @if(request()->hasAny(['search']))
                <a href="{{ route('pathologist.opd') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-2 rounded-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            @endif
        </form>
    </div>

    <!-- OPD Walk-ins Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">OPD Walk-in Patients - Laboratory Tests</h2>
                <div class="text-sm text-gray-600">
                    Total: {{ $opdPatients->total() }} patients
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PATIENT NAME</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EMAIL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PHONE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">REGISTRATION DATE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">LAB STATUS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($opdPatients as $patient)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $patient->fname }} {{ $patient->lname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->age }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    $opdExam = $patient->opdExamination;
                                    $medicalChecklist = \App\Models\MedicalChecklist::where('user_id', $patient->id)
                                        ->where('examination_type', 'opd')
                                        ->first();
                                @endphp
                                @if($opdExam && $opdExam->lab_report && !empty(array_filter($opdExam->lab_report)))
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Lab Completed
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Lab Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $canSendToDoctor = $opdExam && $opdExam->lab_report && !empty(array_filter($opdExam->lab_report));
                                    @endphp
                                    <!-- View Patient Details -->
                                    <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-full transition-all duration-200 flex items-center text-sm font-medium shadow-sm hover:shadow-md" title="View Patient Details">
                                        <i class="fas fa-eye mr-2 text-sm"></i>
                                        View
                                    </button>
                                    
                                    <!-- Edit Lab Results -->
                                    <a href="{{ route('pathologist.opd.edit', $patient->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-full transition-all duration-200 flex items-center text-sm font-medium shadow-sm hover:shadow-md" title="Edit Lab Results">
                                        <i class="fas fa-edit mr-2 text-sm"></i>
                                        Edit
                                    </a>
                                    
                                   
                                    
                                    <!-- Medical Checklist -->
                                    <a href="{{ route('pathologist.medical-checklist.opd', $patient->id) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-2 rounded-full transition-all duration-200 flex items-center text-sm font-medium shadow-sm hover:shadow-md" title="Medical Checklist">
                                        <i class="fas fa-clipboard-list mr-2 text-sm"></i>
                                        Checklist
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                @if(request()->hasAny(['search']))
                                    No OPD walk-in patients found matching your search criteria.
                                @else
                                    No OPD walk-in patients found.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($opdPatients->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $opdPatients->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
