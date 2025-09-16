@extends('layouts.admin')

@section('title', 'Tests - RSS Citi Health Services')
@section('page-title', 'Tests')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Pre-Employment Examinations Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-blue-600 px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-briefcase text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Pre-Employment Examinations</h2>
                        <p class="text-blue-100 text-sm mt-1">Medical examinations for employment candidates</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                    <span>ID</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-gray-400"></i>
                                    <span>Name</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-building text-gray-400"></i>
                                    <span>Company</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                    <span>Date</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-info-circle text-gray-400"></i>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-cogs text-gray-400"></i>
                                    <span>Action</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($preEmploymentResults as $exam)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold">
                                            {{ $exam->id }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $exam->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-building text-gray-400 text-sm"></i>
                                        <span class="text-sm text-gray-700 font-medium">{{ $exam->company_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                                        <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    @php
                                        $status = $exam->status ?? 'Pending';
                                    @endphp
                                    @if($status === 'Completed')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                            <i class="fas fa-check-circle mr-1.5 text-xs"></i>
                                            Completed
                                        </span>
                                    @elseif($status === 'In Progress')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                            <i class="fas fa-clock mr-1.5 text-xs"></i>
                                            In Progress
                                        </span>
                                    @elseif($status === 'Sent')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 border border-purple-200">
                                            <i class="fas fa-paper-plane mr-1.5 text-xs"></i>
                                            Sent
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <i class="fas fa-clock mr-1.5 text-xs"></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <button onclick="openPreEmploymentViewModal({{ $exam->id }})" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-all duration-150 shadow-md hover:shadow-lg">
                                        <i class="fas fa-eye mr-2 text-xs"></i>
                                        View & Send
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-briefcase text-gray-400 text-2xl"></i>
                                        </div>
                                        <div class="text-gray-500 text-sm">No pre-employment examinations found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Annual Physical Examinations Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-emerald-600 px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Annual Physical Examinations</h2>
                        <p class="text-emerald-100 text-sm mt-1">Yearly health checkups and medical assessments</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                    <span>ID</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-gray-400"></i>
                                    <span>Name</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                    <span>Date</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-info-circle text-gray-400"></i>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-cogs text-gray-400"></i>
                                    <span>Action</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($annualPhysicalResults as $exam)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-semibold">
                                            {{ $exam->id }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $exam->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                                        <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-r border-gray-100">
                                    @php
                                        $status = $exam->status ?? 'Pending';
                                    @endphp
                                    @if($status === 'Completed')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                            <i class="fas fa-check-circle mr-1.5 text-xs"></i>
                                            Completed
                                        </span>
                                    @elseif($status === 'In Progress')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                            <i class="fas fa-clock mr-1.5 text-xs"></i>
                                            In Progress
                                        </span>
                                    @elseif($status === 'Sent')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 border border-purple-200">
                                            <i class="fas fa-paper-plane mr-1.5 text-xs"></i>
                                            Sent
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <i class="fas fa-clock mr-1.5 text-xs"></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <button onclick="openAnnualPhysicalViewModal({{ $exam->id }})" 
                                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-all duration-150 shadow-md hover:shadow-lg">
                                        <i class="fas fa-eye mr-2 text-xs"></i>
                                        View & Send
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-heartbeat text-gray-400 text-2xl"></i>
                                        </div>
                                        <div class="text-gray-500 text-sm">No annual physical examinations found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pre-Employment View Modal -->
<div id="preEmploymentExamModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300">
        <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-briefcase text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Pre-Employment Examination Details</h3>
                </div>
                <button onclick="closePreEmploymentExamModal()" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-briefcase text-blue-600 text-2xl"></i>
                </div>
                <p class="text-gray-600">Pre-employment examination details will be displayed here.</p>
                <p class="text-sm text-gray-500 mt-2">This modal will show examination results and allow sending to company.</p>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closePreEmploymentExamModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Close
                </button>
                <button type="button" 
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send to Company
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Annual Physical View Modal -->
<div id="annualPhysicalExamModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300">
        <div class="bg-emerald-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Annual Physical Examination Details</h3>
                </div>
                <button onclick="closeAnnualPhysicalExamModal()" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heartbeat text-emerald-600 text-2xl"></i>
                </div>
                <p class="text-gray-600">Annual physical examination details will be displayed here.</p>
                <p class="text-sm text-gray-500 mt-2">This modal will show examination results and allow sending to company.</p>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="closeAnnualPhysicalExamModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Close
                </button>
                <button type="button" 
                        class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send to Company
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentExamId = null;

function openPreEmploymentViewModal(examId) {
    currentExamId = examId;
    document.getElementById('preEmploymentExamModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePreEmploymentExamModal() {
    document.getElementById('preEmploymentExamModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentExamId = null;
}

function openAnnualPhysicalViewModal(examId) {
    currentExamId = examId;
    document.getElementById('annualPhysicalExamModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAnnualPhysicalExamModal() {
    document.getElementById('annualPhysicalExamModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentExamId = null;
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['preEmploymentExamModal', 'annualPhysicalExamModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentExamId = null;
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = ['preEmploymentExamModal', 'annualPhysicalExamModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (!modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                currentExamId = null;
            }
        });
    }
});
</script>
@endsection
