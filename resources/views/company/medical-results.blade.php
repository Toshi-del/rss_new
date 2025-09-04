@extends('layouts.company')

@section('title', 'Medical Results')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Medical Results</h1>
            <p class="text-sm text-gray-600">View annual physical examination and pre-employment examination results.</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

   

        <!-- Filter Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="{{ route('company.medical-results') }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ !$statusFilter ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        All Results
                    </a>
                    <a href="{{ route('company.medical-results', ['status' => 'annual_physical']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ $statusFilter === 'annual_physical' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Annual Physical
                    </a>
                    <a href="{{ route('company.medical-results', ['status' => 'pre_employment']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ $statusFilter === 'pre_employment' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Pre-Employment
                    </a>
                    <a href="{{ route('company.medical-results', ['status' => 'sent_results']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ $statusFilter === 'sent_results' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Sent Results
                        @if($totalSentAnnualPhysical > 0 || $totalSentPreEmployment > 0)
                            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $totalSentAnnualPhysical + $totalSentPreEmployment }}
                            </span>
                        @endif
                    </a>
                </nav>
            </div>
        </div>

        <!-- Search and Export Section -->
        <div class="mb-6 bg-white p-4 rounded-lg shadow">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1 max-w-lg">
                    <label for="search" class="sr-only">Search results</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input id="search" name="search" type="text" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                               placeholder="Search by name, email, or status...">
                    </div>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-4 flex space-x-3">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-filter mr-2"></i>
                        Filter
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-download mr-2"></i>
                        Export
                    </button>
                </div>
            </div>
        </div>



        @if(!$statusFilter || $statusFilter === 'sent_results')
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-paper-plane text-purple-500 mr-2"></i>
                    Sent Examination Results
                    <span class="ml-2 text-sm text-gray-500">(Sent by Admin)</span>
                </h3>
            </div>
            
            @if($sentAnnualPhysicalResults->count() > 0 || $sentPreEmploymentResults->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient/Applicant Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Examination Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Sent Annual Physical Results -->
                        @foreach($sentAnnualPhysicalResults as $exam)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $exam->name }}</div>
                                <div class="text-sm text-gray-500">Patient ID: {{ $exam->patient_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-stethoscope mr-1"></i>
                                    Annual Physical
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $exam->updated_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $exam->updated_at->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Sent
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="viewSentResult('annual_physical', {{ $exam->id }})">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </button>
                                <button class="text-green-600 hover:text-green-900" onclick="downloadResult('annual_physical', {{ $exam->id }})">
                                    <i class="fas fa-download mr-1"></i>Download
                                </button>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Sent Pre-Employment Results -->
                        @foreach($sentPreEmploymentResults as $exam)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $exam->name }}</div>
                                <div class="text-sm text-gray-500">{{ $exam->company_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-briefcase mr-1"></i>
                                    Pre-Employment
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $exam->updated_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $exam->updated_at->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Sent
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="viewSentResult('pre_employment', {{ $exam->id }})">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </button>
                                <button class="text-green-600 hover:text-green-900" onclick="downloadResult('pre_employment', {{ $exam->id }})">
                                    <i class="fas fa-download mr-1"></i>Download
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-6 py-8 text-center">
                <i class="fas fa-paper-plane text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">No sent examination results found.</p>
                <p class="text-sm text-gray-400 mt-2">Results sent by admin will appear here.</p>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const tableRows = document.querySelectorAll('tbody tr');
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Export functionality
    document.querySelectorAll('button').forEach(button => {
        if (button.textContent.includes('Export')) {
            button.addEventListener('click', function() {
                // This would typically trigger a download of filtered results
                alert('Export functionality would be implemented here');
            });
        }
        if (button.textContent.includes('Filter')) {
            button.addEventListener('click', function() {
                // This would typically open a filter modal
                alert('Filter functionality would be implemented here');
            });
        }
    });
});

// Functions for sent results
function viewSentResult(type, id) {
    if (type === 'annual_physical') {
        // Open annual physical examination details in a modal or new page
        window.open(`/company/view-sent-annual-physical/${id}`, '_blank');
    } else if (type === 'pre_employment') {
        // Open pre-employment examination details in a modal or new page
        window.open(`/company/view-sent-pre-employment/${id}`, '_blank');
    }
}

function downloadResult(type, id) {
    if (type === 'annual_physical') {
        // Download annual physical examination results
        window.open(`/company/download-sent-annual-physical/${id}`, '_blank');
    } else if (type === 'pre_employment') {
        // Download pre-employment examination results
        window.open(`/company/download-sent-pre-employment/${id}`, '_blank');
    }
}
</script>
@endpush
@endsection
