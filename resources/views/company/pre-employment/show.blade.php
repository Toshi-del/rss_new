@extends('layouts.company')

@section('title', 'Pre-Employment Record Details')
@section('page-description', 'View detailed information for ' . $record->full_name)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('company.pre-employment.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $record->full_name }}</h1>
                <p class="text-gray-600 mt-1">Pre-Employment Medical Record #{{ $record->id }}</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            @php
                $status = $record->status ?? 'pending';
                $statusConfig = [
                    'completed' => ['bg-emerald-100', 'text-emerald-800', 'fas fa-check-circle'],
                    'pending' => ['bg-yellow-100', 'text-yellow-800', 'fas fa-clock'],
                    'in_progress' => ['bg-blue-100', 'text-blue-800', 'fas fa-spinner'],
                    'cancelled' => ['bg-red-100', 'text-red-800', 'fas fa-times-circle'],
                    'approved' => ['bg-green-100', 'text-green-800', 'fas fa-check-double']
                ];
                $config = $statusConfig[$status] ?? $statusConfig['pending'];
            @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold {{ $config[0] }} {{ $config[1] }}">
                <i class="{{ $config[2] }} mr-2"></i>
                {{ ucfirst($status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Employee Overview -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-user mr-3 text-blue-600"></i>
                        Employee Information
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Profile -->
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-bold text-2xl">{{ substr($record->first_name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $record->full_name }}</p>
                                <p class="text-sm text-gray-600">{{ $record->age }} years old • {{ $record->sex }}</p>
                            </div>
                        </div>
                        
                        <!-- Contact -->
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                    <i class="fas fa-envelope text-emerald-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Email</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $record->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                    <i class="fas fa-phone text-emerald-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Phone</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $record->phone_number }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Billing -->
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Billing Type</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-medium {{ $record->billing_type === 'Company' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }}">
                                    <i class="fas fa-{{ $record->billing_type === 'Company' ? 'building' : 'user' }} mr-1"></i>
                                    {{ $record->billing_type }}
                                </span>
                            </div>
                            @if($record->company_name)
                            <div>
                                <p class="text-xs text-gray-500">Company</p>
                                <p class="text-sm font-medium text-gray-900">{{ $record->company_name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Tests -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-flask mr-3 text-purple-600"></i>
                            Medical Tests
                        </h2>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Total Cost</p>
                            <p class="text-xl font-bold text-emerald-600">₱{{ number_format($record->total_price, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @if($record->medicalTests && $record->medicalTests->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($record->medicalTests as $test)
                                @php
                                    $pivotData = $record->preEmploymentMedicalTests->where('medical_test_id', $test->id)->first();
                                    $category = $pivotData ? $pivotData->medicalTestCategory : null;
                                @endphp
                                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                                    <i class="fas fa-vial text-purple-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $test->name }}</h3>
                                                    @if($category)
                                                        <p class="text-xs text-purple-600 font-medium">{{ $category->name }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($test->description)
                                                <p class="text-xs text-gray-600 ml-11 line-clamp-2">{{ $test->description }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right ml-4">
                                            <p class="text-sm font-bold text-emerald-600">₱{{ number_format($pivotData->test_price ?? $test->price ?? 0, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-flask text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500">No medical tests assigned</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Information -->
            @if($record->other_exams)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-clipboard-list mr-3 text-amber-600"></i>
                        Additional Examinations
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed">{{ $record->other_exams }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- File Information -->
            @if($record->uploaded_file)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <i class="fas fa-file-excel mr-3 text-green-600"></i>
                        Uploaded File
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-xl">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                            <i class="fas fa-file-excel text-green-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $record->uploaded_file }}</p>
                            <p class="text-xs text-gray-500">Excel Spreadsheet</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('company.pre-employment.download', $record->id) }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>
                        Download Excel File
                    </a>
                </div>
            </div>
            @endif

            <!-- Record Details -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-3 text-gray-600"></i>
                        Record Details
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Record ID</p>
                        <p class="font-mono text-sm bg-gray-100 px-3 py-2 rounded-lg">#{{ $record->id }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Created Date</p>
                        <p class="text-sm text-gray-900">{{ $record->created_at->format('F d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $record->created_at->format('h:i A') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Last Updated</p>
                        <p class="text-sm text-gray-900">{{ $record->updated_at->format('F d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $record->updated_at->format('h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-3 text-indigo-600"></i>
                        Actions
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    @php
                        $canEdit = !in_array($status, ['approved', 'completed']);
                    @endphp
                    
                    @if($canEdit)
                        <a href="{{ route('company.pre-employment.edit', $record->id) }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Record
                        </a>
                    @else
                        <div class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-300 text-gray-500 font-medium rounded-xl cursor-not-allowed">
                            <i class="fas fa-lock mr-2"></i>
                            Record Locked
                        </div>
                        <p class="text-xs text-gray-500 text-center">This record cannot be edited because it has been {{ $status }}.</p>
                    @endif
                    
                    @if($canEdit)
                        <button onclick="openDeleteModal()" class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Record
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
        <div class="p-6">
            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Delete Pre-Employment Record</h3>
            <p class="text-gray-600 text-center mb-6">
                Are you sure you want to delete the pre-employment record for <strong>{{ $record->full_name }}</strong>? This action cannot be undone.
            </p>
            
            <div class="flex space-x-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                    Cancel
                </button>
                <form action="{{ route('company.pre-employment.destroy', $record->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors duration-200">
                        Delete Record
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteModalContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger animation
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteModalContent');
        
        content.classList.add('scale-95', 'opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
    
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection