@extends('layouts.plebo')

@section('title', 'Phlebo Dashboard')

@section('page-title', 'Phlebo Dashboard')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pre-Employment Records</h3>
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $preEmploymentCount }}</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">Manage medical checklist for pre-employment</p>
        <a href="#pre-employment-section" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Records →</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Annual Physical Patients</h3>
            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $patientCount }}</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">Manage medical checklist for annual physical</p>
        <a href="#annual-physical-section" class="text-green-600 hover:text-green-800 text-sm font-medium">View Patients →</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">OPD Walk-ins</h3>
            <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $opdCount }}</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">Manage medical checklist for OPD patients</p>
        <a href="#opd-section" class="text-orange-600 hover:text-orange-800 text-sm font-medium">View Patients →</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Recent Appointments</h3>
            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $appointmentCount }}</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">Review recent activities</p>
        <a href="#appointments-section" class="text-purple-600 hover:text-purple-800 text-sm font-medium">View Appointments →</a>
    </div>
</div>

<div id="pre-employment-section" class="bg-white rounded-lg shadow-sm mb-8">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Pre-Employment Patients</h2>
        
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAME</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEX</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">COMPANY</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MEDICAL CATEGORY</th>
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
                                {{ $preEmployment->medicalTestCategory->name }}
                            @else
                                {{ $preEmployment->medical_exam_type ?? 'N/A' }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($preEmployment->medicalTest)
                                {{ $preEmployment->medicalTest->name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $hasMedicalChecklist = \App\Models\MedicalChecklist::where('pre_employment_record_id', $preEmployment->id)->exists();
                                
                                if ($hasMedicalChecklist) {
                                    $statusClass = 'bg-green-100 text-green-800';
                                    $statusText = 'Completed';
                                } else {
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    $statusText = 'Pending';
                                }
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('plebo.medical-checklist.pre-employment', $preEmployment->id) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-clipboard-list"></i> Checklist
                                </a>
                                @if($hasMedicalChecklist)
                                    <form action="{{ route('plebo.pre-employment.send-to-doctor', $preEmployment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-900 ml-3"
                                                onclick="return confirm('Are you sure you want to send this to the doctor?')">
                                            <i class="fas fa-paper-plane"></i> Send
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                            No pre-employment records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="annual-physical-section" class="bg-white rounded-lg shadow-sm mb-8">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Annual Physical Patients</h2>
        
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PATIENT NAME</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEX</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EMAIL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MEDICAL CATEGORY</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MEDICAL TEST</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
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
                            @if($patient->appointment && $patient->appointment->medicalTestCategory)
                                {{ $patient->appointment->medicalTestCategory->name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($patient->appointment && $patient->appointment->medicalTest)
                                {{ $patient->appointment->medicalTest->name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $hasMedicalChecklist = \App\Models\MedicalChecklist::where('patient_id', $patient->id)->exists();
                                
                                if ($hasMedicalChecklist) {
                                    $statusClass = 'bg-green-100 text-green-800';
                                    $statusText = 'Completed';
                                } else {
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    $statusText = 'Pending';
                                }
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('plebo.medical-checklist.annual-physical', $patient->id) }}" 
                                   class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-clipboard-list"></i> Checklist
                                </a>
                                @if($hasMedicalChecklist)
                                    <form action="{{ route('plebo.annual-physical.send-to-doctor', $patient->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-900 ml-3"
                                                onclick="return confirm('Are you sure you want to send this to the doctor?')">
                                            <i class="fas fa-paper-plane"></i> Send
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                            No annual physical patients found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="opd-section" class="bg-white rounded-lg shadow-sm mb-8">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">OPD Walk-in Patients</h2>
        
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($opdPatients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $patient->first_name }} {{ $patient->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->age }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->sex }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $hasExamination = $patient->opdExamination;
                                $hasMedicalChecklist = \App\Models\MedicalChecklist::where('opd_examination_id', optional($patient->opdExamination)->id)->exists();
                                
                                if ($hasExamination && $hasMedicalChecklist) {
                                    $statusClass = 'bg-green-100 text-green-800';
                                    $statusText = 'Completed';
                                } elseif ($hasExamination || $hasMedicalChecklist) {
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    $statusText = 'In Progress';
                                } else {
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    $statusText = 'Pending';
                                }
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openMedicalChecklistModal('opd', {{ $patient->id }})" 
                                    class="text-orange-600 hover:text-orange-900 mr-3">
                                <i class="fas fa-clipboard-list"></i> Checklist
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No OPD patients found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="medicalChecklistModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Medical Checklist</h3>
                <button onclick="closeMedicalChecklistModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="modalContent"></div>
        </div>
    </div>
</div>

<script>
function openMedicalChecklistModal(type, id) {
    const modal = document.getElementById('medicalChecklistModal');
    const modalContent = document.getElementById('modalContent');
    const modalTitle = document.getElementById('modalTitle');

    if (type === 'pre-employment') {
        modalTitle.textContent = 'Pre-Employment Medical Checklist';
    } else if (type === 'opd') {
        modalTitle.textContent = 'OPD Medical Checklist';
    } else {
        modalTitle.textContent = 'Annual Physical Medical Checklist';
    }

    const url = type === 'pre-employment'
        ? `/plebo/medical-checklist/pre-employment/${id}`
        : type === 'opd'
        ? `/plebo/medical-checklist/opd/${id}`
        : `/plebo/medical-checklist/annual-physical/${id}`;

    fetch(url)
        .then(response => response.text())
        .then(html => {
            modalContent.innerHTML = html;
            modal.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error loading modal content:', error);
            modalContent.innerHTML = '<p class="text-red-600">Error loading content</p>';
            modal.classList.remove('hidden');
        });
}

function closeMedicalChecklistModal() {
    document.getElementById('medicalChecklistModal').classList.add('hidden');
}

document.getElementById('medicalChecklistModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMedicalChecklistModal();
    }
});
</script>
@endsection


