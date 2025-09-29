@extends('layouts.ecgtech')

@section('title', 'Pre-Employment with ECG & Drug Test')

@section('page-title', 'Pre-Employment with ECG & Drug Test')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

<!-- Search and Filter Section -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div class="flex-1 max-w-md">
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Search by name, company..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <select id="statusFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                <option value="">All Status</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="declined">Declined</option>
            </select>
            
            <button onclick="clearFilters()" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                <i class="fas fa-times mr-2"></i>Clear
            </button>
        </div>
    </div>
</div>

<!-- Records Table -->
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Pre-Employment with ECG & Drug Test</h2>
        <p class="text-gray-600 text-sm mt-1">Manage ECG examinations for pre-employment records requiring ECG and drug test</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full" id="recordsTable">
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
                    <tr class="hover:bg-gray-50 record-row" data-name="{{ strtolower($preEmployment->first_name . ' ' . $preEmployment->last_name) }}" data-company="{{ strtolower($preEmployment->company_name) }}" data-status="{{ $preEmployment->status }}">
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
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('ecgtech.pre-employment.send-to-doctor', $preEmployment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition-colors" title="Send to Doctor">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                                <a href="{{ route('ecgtech.medical-checklist-page.pre-employment', $preEmployment->id) }}" class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded-lg transition-colors inline-block" title="ECG Checklist">
                                    <i class="fas fa-heartbeat"></i>
                                </a>
                                <a href="{{ route('ecgtech.pre-employment.edit', $preEmployment->id) }}" class="text-purple-600 hover:text-purple-900 p-2 hover:bg-purple-50 rounded-lg transition-colors inline-block" title="Edit ECG">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No pre-employment records with ECG and drug test found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($preEmployments->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $preEmployments->links() }}
        </div>
    @endif
</div>

<script>
// Search and filter functionality
document.getElementById('searchInput').addEventListener('input', filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);

function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.record-row');
    
    rows.forEach(row => {
        const name = row.dataset.name;
        const company = row.dataset.company;
        const status = row.dataset.status;
        
        const matchesSearch = name.includes(searchTerm) || company.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;
        
        if (matchesSearch && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    filterTable();
}
</script>
@endsection
