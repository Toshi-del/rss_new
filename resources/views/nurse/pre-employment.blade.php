@extends('layouts.nurse')

@section('title', 'Pre-Employment Records')
@section('page-title', 'Pre-Employment Records')
@section('page-description', 'Manage pre-employment examinations and medical assessments')

@section('content')
<div class="space-y-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600"></i>
            </div>
            <div>
                <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-emerald-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-file-medical text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Pre-Employment Management</h3>
                        <p class="text-emerald-100 text-sm">Manage pre-employment examinations and medical assessments</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Request Equipment Button -->
                    <a href="{{ route('nurse.equipment-requests.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white/10 text-white font-medium rounded-xl hover:bg-white/20 transition-all duration-200 border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-box mr-2"></i>
                        Request Equipment
                    </a>
                    
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-white/60 text-sm"></i>
                        </div>
                        <input type="text" id="searchInput" onkeyup="searchRecords()"
                               class="glass-morphism pl-12 pr-4 py-2 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 w-72 text-sm border border-white/20" 
                               placeholder="Search by name, company, or test...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pre-Employment Records Table -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full" id="preEmploymentTable">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Patient Name</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Age/Sex</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Company</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Medical Test</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($preEmployments as $preEmployment)
                        <tr class="hover:bg-emerald-50 transition-all duration-200 border-l-4 border-transparent hover:border-emerald-400 record-card">
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center shadow-md">
                                        <span class="text-white font-bold text-sm">
                                            {{ strtoupper(substr($preEmployment->first_name, 0, 1) . substr($preEmployment->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $preEmployment->first_name }} {{ $preEmployment->last_name }}
                                        </div>
                                        <div class="text-xs text-gray-500">ID: #{{ $preEmployment->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="space-y-1">
                                    <div class="bg-blue-50 px-2 py-1 rounded text-xs font-medium text-blue-700">
                                        {{ $preEmployment->age }} years
                                    </div>
                                    <div class="bg-purple-50 px-2 py-1 rounded text-xs font-medium text-purple-700">
                                        {{ ucfirst($preEmployment->sex) }}
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="bg-gray-50 px-3 py-2 rounded-lg">
                                    <div class="text-sm font-medium text-gray-800">{{ $preEmployment->company_name }}</div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="bg-amber-50 px-3 py-2 rounded-lg">
                                    <div class="text-sm font-medium text-amber-800">
                                        @if($preEmployment->medicalTests && $preEmployment->medicalTests->count() > 0)
                                            @foreach($preEmployment->medicalTests as $index => $test)
                                                @if($index > 0), @endif
                                                {{ $test->name }}
                                            @endforeach
                                        @else
                                            {{ $preEmployment->medical_exam_type ?? 'N/A' }}
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border
                                    @if($preEmployment->status === 'approved') bg-green-100 text-green-800 border-green-200
                                    @elseif($preEmployment->status === 'declined') bg-red-100 text-red-800 border-red-200
                                    @else bg-yellow-100 text-yellow-800 border-yellow-200 @endif">
                                    <i class="fas fa-circle text-xs mr-1.5"></i>
                                    {{ ucfirst($preEmployment->status) }}
                                </span>
                            </td>
                            <td class="py-5 px-6">
                                @php
                                    $preEmploymentExam = \App\Models\PreEmploymentExamination::where('pre_employment_record_id', $preEmployment->id)->first();
                                    $medicalChecklist = \App\Models\MedicalChecklist::where('pre_employment_record_id', $preEmployment->id)->where('examination_type', 'pre-employment')->first();
                                    $canSendToDoctor = $preEmploymentExam && $medicalChecklist && !empty($medicalChecklist->physical_exam_done_by);
                                @endphp
                                <div class="flex items-center space-x-2">
                                    @if($canSendToDoctor)
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-medium transition-all duration-150 border border-blue-200"
                                            onclick="openSendToDoctorModal({{ $preEmployment->id }}, '{{ $preEmployment->first_name }} {{ $preEmployment->last_name }}')">
                                        <i class="fas fa-paper-plane mr-1"></i>
                                        Send
                                    </button>
                                    @endif

                                    @if($preEmploymentExam)
                                    <a href="{{ route('nurse.pre-employment.edit', $preEmploymentExam->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg text-xs font-medium transition-all duration-150 border border-emerald-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    @else
                                    <a href="{{ route('nurse.pre-employment.create', ['record_id' => $preEmployment->id]) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg text-xs font-medium transition-all duration-150 border border-green-200">
                                        <i class="fas fa-plus mr-1"></i>
                                        Create
                                    </a>
                                    @endif

                                    <a href="{{ route('nurse.medical-checklist.pre-employment', $preEmployment->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg text-xs font-medium transition-all duration-150 border border-purple-200">
                                        <i class="fas fa-clipboard-list mr-1"></i>
                                        Checklist
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-file-medical text-gray-400 text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Pre-Employment Records</h3>
                                        <p class="text-sm text-gray-500">No pre-employment records found in the system.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Send to Doctor Modal -->
<div id="sendToDoctorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-paper-plane text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Send to Doctor</h3>
                </div>
                <button onclick="closeModal('sendToDoctorModal')" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4 mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-md text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Confirm Action</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Are you sure you want to send <span id="sendToDoctor-patient-name" class="font-semibold"></span>'s examination to the doctor for review?
                    </p>
                </div>
            </div>
            <form id="sendToDoctorForm" method="POST">
                @csrf
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal('sendToDoctorModal')" 
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send to Doctor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal functions
function openSendToDoctorModal(recordId, patientName) {
    document.getElementById('sendToDoctor-patient-name').textContent = patientName;
    document.getElementById('sendToDoctorForm').action = `/nurse/pre-employment/send-to-doctor/${recordId}`;
    document.getElementById('sendToDoctorModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Search function
function searchRecords() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('preEmploymentTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < cells.length - 1; j++) {
            const cellText = cells[j].textContent || cells[j].innerText;
            if (cellText.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        row.style.display = found ? '' : 'none';
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['sendToDoctorModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            closeModal(modalId);
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = ['sendToDoctorModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (!modal.classList.contains('hidden')) {
                closeModal(modalId);
            }
        });
    }
});
</script>
@endsection