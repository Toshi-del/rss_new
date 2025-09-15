@extends('layouts.pathologist')

@section('title', 'Pathologist Dashboard')
@section('page-title', 'Pathologist Dashboard')

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

<!-- Welcome Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-teal-600 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->fname }}!</h2>
                <p class="text-teal-100">Here's what's happening in your laboratory today.</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold">{{ now()->format('M d, Y') }}</p>
                <p class="text-teal-100">{{ now()->format('l') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Key Metrics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 card-hover border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Patients</p>
                <p class="text-3xl font-bold text-gray-900">{{ $metrics['total_patients'] }}</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>+12% from last month
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 card-hover border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pre-Employment Records</p>
                <p class="text-3xl font-bold text-gray-900">{{ $metrics['total_pre_employment'] }}</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>+8% from last month
                </p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-briefcase text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 card-hover border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pending Lab Requests</p>
                <p class="text-3xl font-bold text-gray-900">{{ $metrics['pending_lab_requests'] }}</p>
                <p class="text-sm text-yellow-600 mt-1">
                    <i class="fas fa-clock mr-1"></i>Awaiting processing
                </p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-flask text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 card-hover border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Completed Today</p>
                <p class="text-3xl font-bold text-gray-900">{{ $metrics['completed_today'] }}</p>
                <p class="text-sm text-purple-600 mt-1">
                    <i class="fas fa-check-circle mr-1"></i>Lab results ready
                </p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-double text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Lab Statistics -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Lab Performance</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Samples in Process</span>
                <span class="text-lg font-semibold text-yellow-600">{{ $metrics['blood_samples_in_process'] }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Results to Review</span>
                <span class="text-lg font-semibold text-purple-600">{{ $metrics['results_to_review'] }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Monthly Completed</span>
                <span class="text-lg font-semibold text-green-600">{{ $metrics['monthly_completed'] }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Avg. Processing Time</span>
                <span class="text-lg font-semibold text-blue-600">{{ $metrics['average_processing_time'] }}h</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Blood Chemistry Tests</h3>
        <div class="space-y-3">
            @forelse($bloodChemistryTests->take(5) as $test)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">{{ $test->name }}</p>
                        @if($test->normal_range)
                            <p class="text-xs text-gray-500">{{ $test->normal_range }}</p>
                        @endif
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $test->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $test->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No blood chemistry tests available</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pending Tasks</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-user-check text-blue-600 mr-3"></i>
                    <span class="text-sm font-medium text-gray-800">Annual Physical</span>
                </div>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                    {{ $pendingTasks['pending_annual_physical'] }}
                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-briefcase text-green-600 mr-3"></i>
                    <span class="text-sm font-medium text-gray-800">Pre-Employment</span>
                </div>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                    {{ $pendingTasks['pending_pre_employment'] }}
                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-flask text-yellow-600 mr-3"></i>
                    <span class="text-sm font-medium text-gray-800">Lab Requests</span>
                </div>
                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">
                    {{ $pendingTasks['pending_lab_requests'] }}
                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-clipboard-check text-purple-600 mr-3"></i>
                    <span class="text-sm font-medium text-gray-800">Results Review</span>
                </div>
                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full">
                    {{ $pendingTasks['results_to_review'] }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="bg-white rounded-xl shadow-sm mb-8">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Recent Activities</h2>
            <a href="#" class="text-teal-600 hover:text-teal-800 text-sm font-medium">View All</a>
        </div>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            @forelse($recentActivities as $activity)
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center">
                        <i class="{{ $activity['icon'] }} text-{{ $activity['color'] }}-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">{{ $activity['title'] }}</h4>
                        <p class="text-sm text-gray-600">{{ $activity['description'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ $activity['time']->diffForHumans() }}</p>
                        <p class="text-xs text-gray-400">{{ $activity['time']->format('M d, h:i A') }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-history text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">No recent activities</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('pathologist.annual-physical') }}" class="bg-white rounded-xl shadow-sm p-6 card-hover border border-gray-200 hover:border-teal-300 transition-all">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-check text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Annual Physical</h3>
                <p class="text-sm text-gray-600">Manage patient examinations</p>
            </div>
        </div>
    </a>

    <a href="{{ route('pathologist.pre-employment') }}" class="bg-white rounded-xl shadow-sm p-6 card-hover border border-gray-200 hover:border-teal-300 transition-all">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-briefcase text-green-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Pre-Employment</h3>
                <p class="text-sm text-gray-600">Process employment records</p>
            </div>
        </div>
    </a>

    <a href="{{ route('pathologist.medical-checklist') }}" class="bg-white rounded-xl shadow-sm p-6 card-hover border border-gray-200 hover:border-teal-300 transition-all">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clipboard-list text-purple-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Medical Checklist</h3>
                <p class="text-sm text-gray-600">Create and manage checklists</p>
            </div>
        </div>
    </a>
</div>

@endsection

@section('scripts')
<script>
    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        // You can implement AJAX refresh here if needed
        console.log('Dashboard data refresh...');
    }, 300000);

    // Add click handlers for quick actions
    document.querySelectorAll('.card-hover').forEach(card => {
        card.addEventListener('click', function(e) {
            if (this.tagName === 'A') return; // Let links work normally
            
            // Add visual feedback
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
</script>
@endsection