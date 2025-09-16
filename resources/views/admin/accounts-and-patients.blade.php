@extends('layouts.admin')

@section('title', 'Company Accounts & Patients')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="content-card rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Company Accounts & Patients</h1>
                    <p class="text-sm text-gray-600">Manage company accounts and their associated patients</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <input type="text" 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Search companies...">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button onclick="openAddCompanyModal()" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Add Company</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Companies List -->
    <div class="space-y-4">
        @foreach($companyData as $idx => $entry)
            <div class="content-card rounded-lg overflow-hidden hover:shadow-lg transition-all duration-200">
                <!-- Company Header -->
                <div class="bg-blue-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-white">{{ $entry['company']->company ?? $entry['company']->name ?? 'N/A' }}</h3>
                                <p class="text-blue-100 text-sm">{{ $entry['company']->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <!-- Stats -->
                            <div class="flex items-center space-x-4 text-white">
                                <div class="text-center">
                                    <div class="text-2xl font-bold">{{ count($entry['patients']) }}</div>
                                    <div class="text-xs text-blue-100">Patients</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold">{{ count($entry['preEmployments']) }}</div>
                                    <div class="text-xs text-blue-100">Records</div>
                                </div>
                            </div>
                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <button onclick="openEditCompanyModal({{ $idx }})" 
                                        class="p-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors duration-200" 
                                        title="Edit Company">
                                    <i class="fas fa-edit text-white"></i>
                                </button>
                                <button onclick="openDeleteCompanyModal({{ $idx }})" 
                                        class="p-2 bg-white/10 hover:bg-red-500/20 rounded-lg transition-colors duration-200" 
                                        title="Delete Company">
                                    <i class="fas fa-trash text-white"></i>
                                </button>
                                <button onclick="toggleCompanyDetails({{ $idx }})" 
                                        class="p-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors duration-200" 
                                        title="View Details">
                                    <i class="fas fa-chevron-down text-white company-toggle-{{ $idx }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Details (Collapsible) -->
                <div id="company-details-{{ $idx }}" class="hidden">
                    <div class="p-6">
                        <!-- Tabs Navigation -->
                        <div class="flex border-b border-gray-200 mb-6">
                            <button onclick="switchTab({{ $idx }}, 'patients')" 
                                    class="tab-button-{{ $idx }} px-6 py-3 text-sm font-medium border-b-2 border-blue-600 text-blue-600 bg-blue-50 rounded-t-lg" 
                                    data-tab="patients">
                                <i class="fas fa-users mr-2"></i>Patients
                            </button>
                            <button onclick="switchTab({{ $idx }}, 'records')" 
                                    class="tab-button-{{ $idx }} px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 rounded-t-lg ml-2" 
                                    data-tab="records">
                                <i class="fas fa-briefcase-medical mr-2"></i>Pre-Employment Records
                            </button>
                        </div>

                        <!-- Patients Tab -->
                        <div id="patients-tab-content-{{ $idx }}" class="tab-content-{{ $idx }}">
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg font-semibold text-gray-900">Patients ({{ count($entry['patients']) }})</h4>
                                    <button onclick="openAddPatientModal({{ $idx }})" 
                                            class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-200 flex items-center space-x-2">
                                        <i class="fas fa-user-plus"></i>
                                        <span>Add Patient</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Full Name</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Age/Sex</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Phone</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse($entry['patients'] as $patientIdx => $patient)
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                                            {{ strtoupper(substr($patient->getFullNameAttribute(), 0, 2)) }}
                                                        </div>
                                                        <div class="font-medium text-gray-900">{{ $patient->getFullNameAttribute() }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $patient->getAgeSexAttribute() }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $patient->email }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $patient->phone }}</td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center space-x-2">
                                                        <button onclick="openEditPatientModal({{ $idx }}, {{ $patientIdx }})" 
                                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                                                title="Edit Patient">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="openDeletePatientModal({{ $idx }}, {{ $patientIdx }})" 
                                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                                title="Delete Patient">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                                    <p>No patients found for this company.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Records Tab -->
                        <div id="records-tab-content-{{ $idx }}" class="tab-content-{{ $idx }} hidden">
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg font-semibold text-gray-900">Pre-Employment Records ({{ count($entry['preEmployments']) }})</h4>
                                    <button onclick="openAddRecordModal({{ $idx }})" 
                                            class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 flex items-center space-x-2">
                                        <i class="fas fa-file-plus"></i>
                                        <span>Add Record</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Full Name</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Age/Sex</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Phone</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse($entry['preEmployments'] as $recordIdx => $pre)
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white font-semibold">
                                                            {{ strtoupper(substr($pre->full_name, 0, 2)) }}
                                                        </div>
                                                        <div class="font-medium text-gray-900">{{ $pre->full_name }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $pre->age }} / {{ $pre->sex }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $pre->email }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $pre->phone_number }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                        @if(strtolower($pre->status) === 'approved') bg-green-100 text-green-800
                                                        @elseif(strtolower($pre->status) === 'pending') bg-yellow-100 text-yellow-800
                                                        @elseif(strtolower($pre->status) === 'declined') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        <i class="fas fa-circle text-xs mr-1"></i>
                                                        {{ ucfirst($pre->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center space-x-2">
                                                        <button onclick="openEditRecordModal({{ $idx }}, {{ $recordIdx }})" 
                                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                                                title="Edit Record">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="openDeleteRecordModal({{ $idx }}, {{ $recordIdx }})" 
                                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                                title="Delete Record">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                    <i class="fas fa-briefcase-medical text-4xl text-gray-300 mb-4"></i>
                                                    <p>No pre-employment records found for this company.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modals -->
<!-- Add Company Modal -->
<div id="addCompanyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Add New Company</h3>
                <button onclick="closeModal('addCompanyModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addCompanyForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                        <input type="text" name="company_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('addCompanyModal')" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">Add Company</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Company Modal -->
<div id="deleteCompanyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Delete Company</h3>
                <button onclick="closeModal('deleteCompanyModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-900 font-medium">Are you sure you want to delete this company?</p>
                        <p class="text-sm text-gray-500">This action cannot be undone.</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('deleteCompanyModal')" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">Cancel</button>
                <button type="button" onclick="confirmDeleteCompany()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle company details
function toggleCompanyDetails(idx) {
    const details = document.getElementById(`company-details-${idx}`);
    const toggle = document.querySelector(`.company-toggle-${idx}`);
    
    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        toggle.classList.remove('fa-chevron-down');
        toggle.classList.add('fa-chevron-up');
    } else {
        details.classList.add('hidden');
        toggle.classList.remove('fa-chevron-up');
        toggle.classList.add('fa-chevron-down');
    }
}

// Switch tabs
function switchTab(companyIdx, tabName) {
    // Hide all tab contents
    document.querySelectorAll(`.tab-content-${companyIdx}`).forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tab buttons
    document.querySelectorAll(`.tab-button-${companyIdx}`).forEach(button => {
        button.classList.remove('border-blue-600', 'text-blue-600', 'bg-blue-50');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(`${tabName}-tab-content-${companyIdx}`).classList.remove('hidden');
    
    // Add active state to selected tab button
    const activeButton = document.querySelector(`.tab-button-${companyIdx}[data-tab="${tabName}"]`);
    activeButton.classList.add('border-blue-600', 'text-blue-600', 'bg-blue-50');
    activeButton.classList.remove('border-transparent', 'text-gray-500');
}

// Modal functions
function openAddCompanyModal() {
    document.getElementById('addCompanyModal').classList.remove('hidden');
    document.getElementById('addCompanyModal').classList.add('flex');
}

function openDeleteCompanyModal(idx) {
    document.getElementById('deleteCompanyModal').classList.remove('hidden');
    document.getElementById('deleteCompanyModal').classList.add('flex');
    window.currentDeleteCompanyIdx = idx;
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId).classList.remove('flex');
}

function confirmDeleteCompany() {
    // Add your delete logic here
    console.log('Deleting company:', window.currentDeleteCompanyIdx);
    closeModal('deleteCompanyModal');
}

// Placeholder functions for other modals
function openEditCompanyModal(idx) { console.log('Edit company:', idx); }
function openAddPatientModal(idx) { console.log('Add patient to company:', idx); }
function openEditPatientModal(companyIdx, patientIdx) { console.log('Edit patient:', companyIdx, patientIdx); }
function openDeletePatientModal(companyIdx, patientIdx) { console.log('Delete patient:', companyIdx, patientIdx); }
function openAddRecordModal(idx) { console.log('Add record to company:', idx); }
function openEditRecordModal(companyIdx, recordIdx) { console.log('Edit record:', companyIdx, recordIdx); }
function openDeleteRecordModal(companyIdx, recordIdx) { console.log('Delete record:', companyIdx, recordIdx); }
</script>

@endsection
