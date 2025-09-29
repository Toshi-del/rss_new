@extends('layouts.pathologist')

@section('title', 'Pre-Employment Records')
@section('page-title', 'Pre-Employment Records')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300 text-center font-semibold shadow-sm">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300 text-center font-semibold shadow-sm">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
@endif

<!-- Header Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">
                    <i class="fas fa-briefcase mr-3 text-teal-600"></i>Pre-Employment Records
                </h2>
                <p class="text-gray-600 text-sm mt-1">Manage pre-employment medical examination records</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search records..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <button class="bg-gradient-to-r from-teal-600 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-teal-700 hover:to-blue-700 transition-all">
                    <i class="fas fa-plus mr-2"></i>Add Record
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="p-6 bg-gray-50 border-b border-gray-200">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Filter by:</label>
            </div>
            
            <div class="flex items-center space-x-2">
                <select id="statusFilter" class="form-select text-sm border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                    <option value="">All Status</option>
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="declined">Declined</option>
                </select>
            </div>
            
            <div class="flex items-center space-x-2">
                <select id="companyFilter" class="form-select text-sm border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                    <option value="">All Companies</option>
                    @foreach($companies as $company)
                        <option value="{{ $company }}">{{ $company }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-center space-x-2">
                <button id="clearFilters" class="text-sm text-gray-600 hover:text-gray-800 px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Records Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-user mr-2"></i>Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sex</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-building mr-2"></i>Company
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($preEmployments as $preEmployment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-teal-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $preEmployment->first_name }} {{ $preEmployment->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">ID: {{ $preEmployment->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preEmployment->age }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $preEmployment->sex === 'Male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ $preEmployment->sex }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preEmployment->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preEmployment->phone_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <i class="fas fa-building text-gray-400 mr-2"></i>
                                {{ $preEmployment->company_name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($preEmployment->medicalTestCategory)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                    {{ $preEmployment->medicalTestCategory->name }}
                                </span>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($preEmployment->medicalTest)
                                {{ $preEmployment->medicalTest->name }}
                            @else
                                <span class="text-gray-400">N/A</span>
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-wrap gap-2">
                                <!-- View Record Details -->
                                <button onclick="openRecordModal({{ $preEmployment->id }})" 
                                        class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-full transition-all duration-200 flex items-center text-sm font-medium shadow-sm hover:shadow-md" 
                                        title="View Record Details">
                                    <i class="fas fa-eye mr-2 text-sm"></i>
                                    View
                                </button>
                                
                                <!-- Edit Lab Results -->
                                <a href="{{ route('pathologist.pre-employment.edit', $preEmployment->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-full transition-all duration-200 flex items-center text-sm font-medium shadow-sm hover:shadow-md" 
                                   title="Edit Lab Results">
                                    <i class="fas fa-edit mr-2 text-sm"></i>
                                    Edit
                                </a>
                                
                                
                                
                                <!-- Medical Checklist -->
                                <a href="{{ route('pathologist.medical-checklist') }}?pre_employment_record_id={{ $preEmployment->id }}&examination_type=pre_employment" 
                                   class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-2 rounded-full transition-all duration-200 flex items-center text-sm font-medium shadow-sm hover:shadow-md" 
                                   title="Medical Checklist">
                                    <i class="fas fa-clipboard-list mr-2 text-sm"></i>
                                    Checklist
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-briefcase text-gray-300 text-4xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No pre-employment records found</h3>
                                <p class="text-gray-500">Try adjusting your search criteria or add a new record.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($preEmployments->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $preEmployments->links() }}
        </div>
    @endif
</div>

<!-- Record Details Modal -->
<div id="recordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-briefcase mr-2 text-teal-600"></i>Pre-Employment Record Details
                </h3>
                <button onclick="closeRecordModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="recordContent">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2">Loading record details...</h4>
                        <p class="text-sm text-gray-600">Please wait while we load the information.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('companyFilter').addEventListener('change', applyFilters);
    
    function applyFilters() {
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const companyFilter = document.getElementById('companyFilter').value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const statusCell = row.querySelector('td:nth-child(9)');
            const companyCell = row.querySelector('td:nth-child(6)');
            
            const statusMatch = !statusFilter || statusCell.textContent.toLowerCase().includes(statusFilter);
            const companyMatch = !companyFilter || companyCell.textContent.toLowerCase().includes(companyFilter);
            
            if (statusMatch && companyMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Clear filters
    document.getElementById('clearFilters').addEventListener('click', function() {
        document.getElementById('statusFilter').value = '';
        document.getElementById('companyFilter').value = '';
        document.getElementById('searchInput').value = '';
        
        // Show all rows
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    });

    // Modal functions
    function openRecordModal(id) {
        const modal = document.getElementById('recordModal');
        const modalContent = document.getElementById('recordContent');
        
        // Simulate loading record details
        modalContent.innerHTML = `
            <div class="space-y-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-user mr-2 text-teal-600"></i>Personal Information
                    </h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-600">Record ID:</span>
                            <span class="text-gray-800">${id}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Status:</span>
                            <span class="text-green-600 font-medium">Approved</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-building mr-2 text-teal-600"></i>Company Information
                    </h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-600">Company:</span>
                            <span class="text-gray-800">Loading...</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Position:</span>
                            <span class="text-gray-800">Loading...</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-stethoscope mr-2 text-teal-600"></i>Medical Test Details
                    </h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-600">Category:</span>
                            <span class="text-gray-800">Loading...</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Test Type:</span>
                            <span class="text-gray-800">Loading...</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button onclick="closeRecordModal()" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                        Close
                    </button>
                    <button onclick="editRecord(${id})" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                        Edit Record
                    </button>
                </div>
            </div>
        `;
        modal.classList.remove('hidden');
    }

    function closeRecordModal() {
        document.getElementById('recordModal').classList.add('hidden');
    }

    function editRecord(id) {
        // Implement edit record functionality
        alert('Edit record ' + id);
        closeRecordModal();
    }

    function sendToDoctor(id) {
        if (confirm('Are you sure you want to send this pre-employment record to the doctor?')) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/pathologist/pre-employment/${id}/send-to-doctor`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fixed')) {
            e.target.classList.add('hidden');
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('recordModal');
            if (modal && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
            }
        }
    });
</script>
@endsection