@extends('layouts.nurse')

@section('title', 'Pre-Employment Records')

@section('page-title', 'Pre-Employment Records')

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    <!-- Pre-Employment Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Pre-Employment Records</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAME</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEX</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">COMPANY</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MEDICAL TEST</th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($preEmployment->medicalTestCategory)
                                    {{ optional($preEmployment->medicalTestCategory)->name }}
                                    @if($preEmployment->medicalTest)
                                        - {{ $preEmployment->medicalTest->name }}
                                    @endif
                                @else
                                    {{ $preEmployment->medical_exam_type ?? 'N/A' }}
                                @endif
                            </td>
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
                                @php
                                    $preEmploymentExam = \App\Models\PreEmploymentExamination::where('pre_employment_record_id', $preEmployment->id)->first();
                                    $medicalChecklist = \App\Models\MedicalChecklist::where('pre_employment_record_id', $preEmployment->id)
                                        ->where('examination_type', 'pre-employment')
                                        ->first();
                                @endphp
                                @php
                                    $canSendToDoctor = $preEmploymentExam && $medicalChecklist && !empty($medicalChecklist->physical_exam_done_by);
                                @endphp
                                @if($canSendToDoctor)
                                    <form action="{{ route('nurse.pre-employment.send-to-doctor', $preEmployment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors mr-2" title="Send to Doctor">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed mr-2" title="Complete examination and medical checklist first" disabled>
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                @endif
                                @if($preEmploymentExam)
                                    <a href="{{ route('nurse.pre-employment.edit', $preEmploymentExam->id) }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors mr-2" title="Edit Examination">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @else
                                    <a href="{{ route('nurse.pre-employment.create', ['record_id' => $preEmployment->id]) }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors mr-2" title="Create Examination">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endif
                                <a href="{{ route('nurse.medical-checklist.pre-employment', $preEmployment->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors mr-2" title="Medical Checklist">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                                
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                                No pre-employment records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection