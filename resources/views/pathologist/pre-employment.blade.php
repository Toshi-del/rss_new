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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-flask mr-2"></i>Lab Status
                    </th>
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
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @php
                                $selectedTests = $preEmployment->all_selected_tests ?? collect();
                                $groupedTests = $selectedTests->groupBy('category_name');
                            @endphp
                            @if($groupedTests->isNotEmpty())
                                <div class="space-y-1">
                                    @foreach($groupedTests as $categoryName => $tests)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 inline-block mr-1 mb-1">
                                            {{ $categoryName }}
                                        </span>
                                    @endforeach
                                </div>
                            @elseif($preEmployment->medicalTestCategory)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                    {{ $preEmployment->medicalTestCategory->name }}
                                </span>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if($selectedTests->isNotEmpty())
                                <div class="space-y-1">
                                    @foreach($selectedTests as $test)
                                        <div class="text-xs bg-gray-100 px-2 py-1 rounded mb-1">
                                            {{ $test['test_name'] }}
                                            @if($test['price'] > 0)
                                                <span class="text-emerald-600 font-medium">(₱{{ number_format($test['price'], 2) }})</span>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($selectedTests->count() > 3)
                                        <div class="text-xs text-blue-600 font-medium">
                                            +{{ $selectedTests->count() - 3 }} more tests
                                        </div>
                                    @endif
                                </div>
                            @elseif($preEmployment->medicalTest)
                                <div class="text-xs bg-gray-100 px-2 py-1 rounded">
                                    {{ $preEmployment->medicalTest->name }}
                                </div>
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                // Check for examination records with actual data
                                $examinations = \App\Models\PreEmploymentExamination::where('pre_employment_record_id', $preEmployment->id)
                                    ->orderBy('updated_at', 'desc')
                                    ->get();
                                
                                $hasSubmittedData = false;
                                $latestExamination = null;
                                
                                foreach($examinations as $exam) {
                                    $labData = $exam->lab_report;
                                    if ($labData && is_array($labData)) {
                                        foreach($labData as $key => $value) {
                                            if (!empty($value) && $value !== 'Not available' && !str_contains($key, '_others')) {
                                                $hasSubmittedData = true;
                                                $latestExamination = $exam;
                                                break 2;
                                            }
                                        }
                                    }
                                }
                                
                                // Check if medical checklist is completed (pathologist tasks: stool exam and urinalysis)
                                // First, let's check without examination_type filter to see if that's the issue
                                $medicalChecklist = \App\Models\MedicalChecklist::where('pre_employment_record_id', $preEmployment->id)
                                    ->where(function($query) {
                                        $query->whereNotNull('stool_exam_done_by')
                                              ->where('stool_exam_done_by', '!=', '')
                                              ->orWhere(function($q) {
                                                  $q->whereNotNull('urinalysis_done_by')
                                                    ->where('urinalysis_done_by', '!=', '');
                                              });
                                    })
                                    ->first();
                                
                                $isChecklistCompleted = $medicalChecklist !== null;
                                
                            @endphp
                            
                            @if($hasSubmittedData)
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Submitted
                                    </span>
                                    <div class="text-xs text-gray-500">
                                        {{ $latestExamination->updated_at->format('M d, Y') }}
                                    </div>
                                </div>
                            @elseif(!$isChecklistCompleted)
                                <div class="flex flex-col space-y-1">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Blocked
                                    </span>
                                    <div class="text-xs text-gray-500">
                                        Checklist required
                                    </div>
                                </div>
                            @elseif($examinations->isNotEmpty())
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    Ready
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 flex items-center">
                                    <i class="fas fa-play mr-1"></i>
                                    Ready
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-wrap gap-2">
                                <!-- View Record Details -->
                                <a href="{{ route('pathologist.pre-employment.show', $preEmployment->id) }}" 
                                   class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-full transition-all duration-200 flex items-center text-sm font-medium shadow-sm hover:shadow-md" 
                                   title="View Record Details">
                                    <i class="fas fa-eye mr-2 text-sm"></i>
                                    View
                                </a>
                                
                                <!-- Edit Lab Results with checklist validation -->
                                @if(!$isChecklistCompleted)
                                    <!-- Disabled Edit Button - Checklist Not Completed -->
                                    <button class="bg-gray-400 text-white px-3 py-2 rounded-full cursor-not-allowed flex items-center text-sm font-medium shadow-sm opacity-60" 
                                            title="Medical checklist must be completed first (stool exam or urinalysis required)"
                                            disabled>
                                        <i class="fas fa-lock mr-2 text-sm"></i>
                                        Edit
                                    </button>
                                @elseif($hasSubmittedData)
                                    <!-- Edit Button - Has Data -->
                                    <a href="{{ route('pathologist.pre-employment.edit', $preEmployment->id) }}" 
                                       class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-full transition-all duration-200 flex items-center text-sm font-medium shadow-sm hover:shadow-md" 
                                       title="Edit Lab Results (Has Data)">
                                        <i class="fas fa-edit mr-2 text-sm"></i>
                                        <i class="fas fa-check-circle ml-1 text-xs"></i>
                                        Edit
                                    </a>
                                @else
                                    <!-- Edit Button - Ready for Data Entry -->
                                    <a href="{{ route('pathologist.pre-employment.edit', $preEmployment->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-full transition-all duration-200 flex items-center text-sm font-medium shadow-sm hover:shadow-md" 
                                       title="Edit Lab Results">
                                        <i class="fas fa-edit mr-2 text-sm"></i>
                                        Edit
                                    </a>
                                @endif
                                
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
                        <td colspan="11" class="px-6 py-12 text-center">
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

</script>
@endsection