@extends('layouts.ecgtech')

@section('title', 'Annual Physical Patients')

@section('page-title', 'Annual Physical Patients')

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
                <input type="text" id="searchInput" placeholder="Search by name, email..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <select id="ageFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                <option value="">All Ages</option>
                <option value="18-30">18-30</option>
                <option value="31-45">31-45</option>
                <option value="46-60">46-60</option>
                <option value="60+">60+</option>
            </select>
            
            <select id="sexFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                <option value="">All Genders</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            
            <button onclick="clearFilters()" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                <i class="fas fa-times mr-2"></i>Clear
            </button>
        </div>
    </div>
</div>

<!-- Patients Table -->
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Annual Physical Patients</h2>
        <p class="text-gray-600 text-sm mt-1">Manage ECG examinations for annual physical patients</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full" id="patientsTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PATIENT NAME</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEX</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EMAIL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50 patient-row" data-name="{{ strtolower($patient->first_name . ' ' . $patient->last_name) }}" data-email="{{ strtolower($patient->email) }}" data-age="{{ $patient->age }}" data-sex="{{ $patient->sex }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $patient->first_name }} {{ $patient->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->age }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->sex }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('ecgtech.annual-physical.send-to-doctor', $patient->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition-colors" title="Send to Doctor">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                                <a href="{{ route('ecgtech.medical-checklist-page.annual-physical', $patient->id) }}" class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded-lg transition-colors" title="ECG Checklist">
                                    <i class="fas fa-heartbeat"></i>
                                </a>
                                <a href="{{ route('ecgtech.annual-physical.edit', $patient->id) }}" class="text-purple-600 hover:text-purple-900 p-2 hover:bg-purple-50 rounded-lg transition-colors" title="Edit ECG">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No annual physical patients found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($patients->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $patients->links() }}
        </div>
    @endif
</div>


<script>

// Search and filter functionality
document.getElementById('searchInput').addEventListener('input', filterTable);
document.getElementById('ageFilter').addEventListener('change', filterTable);
document.getElementById('sexFilter').addEventListener('change', filterTable);

function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const ageFilter = document.getElementById('ageFilter').value;
    const sexFilter = document.getElementById('sexFilter').value;
    const rows = document.querySelectorAll('.patient-row');
    
    rows.forEach(row => {
        const name = row.dataset.name;
        const email = row.dataset.email;
        const age = parseInt(row.dataset.age);
        const sex = row.dataset.sex;
        
        const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
        const matchesAge = !ageFilter || checkAgeRange(age, ageFilter);
        const matchesSex = !sexFilter || sex === sexFilter;
        
        if (matchesSearch && matchesAge && matchesSex) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function checkAgeRange(age, range) {
    switch(range) {
        case '18-30': return age >= 18 && age <= 30;
        case '31-45': return age >= 31 && age <= 45;
        case '46-60': return age >= 46 && age <= 60;
        case '60+': return age > 60;
        default: return true;
    }
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('ageFilter').value = '';
    document.getElementById('sexFilter').value = '';
    filterTable();
}

</script>
@endsection
