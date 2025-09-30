@extends('layouts.admin')

@section('title', 'Notifications - RSS Citi Health Services')
@section('page-title', 'Notifications')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-bell text-blue-600 mr-3"></i>
                    System Notifications
                </h2>
                <p class="text-gray-600 mt-1">Monitor all medical workflow activities across departments</p>
            </div>
            <div class="flex items-center space-x-3">
                <button id="refresh-notifications" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-300 shadow-sm">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
                <button id="mark-all-read-btn" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-xl font-medium transition-all duration-300 shadow-sm">
                    <i class="fas fa-check-double mr-2"></i>
                    Mark All Read
                </button>
            </div>
        </div>
    </div>

    <!-- Modern Tab Navigation -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Tab Pills Container - Organized in Two Rows -->
        <div class="p-6 pb-0">
            <div class="space-y-3 mb-6">
                <!-- Row 1: Primary & System Tabs -->
                <div class="flex flex-wrap gap-3 justify-center">
                    <button class="notification-tab-pill {{ request()->get('status') === 'unread' ? '' : (request()->get('type') ? '' : 'active') }}" data-tab="all">
                        <i class="fas fa-list-ul"></i>
                        All Notifications
                        <span class="count-badge bg-gray-500">{{ $counts['all'] }}</span>
                    </button>
                    <button class="notification-tab-pill {{ request()->get('status') === 'unread' ? 'active' : '' }}" data-tab="unread">
                        <i class="fas fa-envelope"></i>
                        Unread
                        <span class="count-badge bg-red-500">{{ $counts['unread'] }}</span>
                    </button>
                    <button class="notification-tab-pill {{ in_array('appointment_created', explode(',', request()->get('type', ''))) || in_array('pre_employment_created', explode(',', request()->get('type', ''))) || in_array('patient_registered', explode(',', request()->get('type', ''))) ? 'active' : '' }}" data-tab="company">
                        <i class="fas fa-building"></i>
                        Company Actions
                        <span class="count-badge bg-blue-500">{{ $counts['company'] }}</span>
                    </button>
                    <button class="notification-tab-pill {{ in_array('checklist_completed', explode(',', request()->get('type', ''))) || in_array('annual_physical_created', explode(',', request()->get('type', ''))) ? 'active' : '' }}" data-tab="nurse">
                        <i class="fas fa-user-nurse"></i>
                        Nurse/Medtech
                        <span class="count-badge bg-emerald-500">{{ $counts['nurse'] }}</span>
                    </button>
                    <button class="notification-tab-pill {{ in_array('pathologist_report_submitted', explode(',', request()->get('type', ''))) ? 'active' : '' }}" data-tab="pathologist">
                        <i class="fas fa-microscope"></i>
                        Pathologist
                        <span class="count-badge bg-purple-500">{{ $counts['pathologist'] }}</span>
                    </button>
                </div>
                
                <!-- Row 2: Medical Specialists -->
                <div class="flex flex-wrap gap-3 justify-center">
                    <button class="notification-tab-pill {{ in_array('xray_completed', explode(',', request()->get('type', ''))) ? 'active' : '' }}" data-tab="radtech">
                        <i class="fas fa-x-ray"></i>
                        Radtech
                        <span class="count-badge bg-indigo-500">{{ $counts['radtech'] }}</span>
                    </button>
                    <button class="notification-tab-pill {{ in_array('xray_interpreted', explode(',', request()->get('type', ''))) ? 'active' : '' }}" data-tab="radiologist">
                        <i class="fas fa-search"></i>
                        Radiologist
                        <span class="count-badge bg-cyan-500">{{ $counts['radiologist'] }}</span>
                    </button>
                    <button class="notification-tab-pill {{ in_array('ecg_completed', explode(',', request()->get('type', ''))) ? 'active' : '' }}" data-tab="ecgtech">
                        <i class="fas fa-heartbeat"></i>
                        ECG Tech
                        <span class="count-badge bg-orange-500">{{ $counts['ecgtech'] }}</span>
                    </button>
                    <button class="notification-tab-pill {{ in_array('specimen_collected', explode(',', request()->get('type', ''))) ? 'active' : '' }}" data-tab="plebo">
                        <i class="fas fa-vial"></i>
                        Phlebotomist
                        <span class="count-badge bg-red-500">{{ $counts['plebo'] }}</span>
                    </button>
                    <button class="notification-tab-pill {{ in_array('examination_updated', explode(',', request()->get('type', ''))) ? 'active' : '' }}" data-tab="doctor">
                        <i class="fas fa-user-md"></i>
                        Doctor
                        <span class="count-badge bg-violet-500">{{ $counts['doctor'] }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Enhanced Filters -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <form method="GET" class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-flag mr-1 text-gray-500"></i>
                        Priority:
                    </label>
                    <select name="priority" class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm">
                        <option value="">All Priorities</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>🔴 High</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>🟢 Low</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-calendar mr-1 text-gray-500"></i>
                        Date Range:
                    </label>
                    <select name="date_range" class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm">
                        <option value="">All Time</option>
                        <option value="today" {{ request('date_range') === 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('date_range') === 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('date_range') === 'month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl text-sm font-semibold transition-all duration-300 shadow-sm">
                    <i class="fas fa-filter mr-2"></i>
                    Apply Filters
                </button>
                
                @if(request()->hasAny(['priority', 'date_range', 'status', 'type']))
                    <a href="{{ route('admin.notifications') }}" class="text-gray-600 hover:text-gray-800 text-sm font-semibold flex items-center">
                        <i class="fas fa-times mr-1"></i>
                        Clear Filters
                    </a>
                @endif
            </form>
        </div>

        <!-- Enhanced Notifications List -->
        <div class="divide-y divide-gray-100">
            @forelse($notifications as $notification)
                <div class="p-6 hover:bg-gray-50 transition-all duration-300 {{ !$notification->is_read ? 'bg-blue-50/50 border-l-4 border-l-blue-500' : '' }}">
                    <div class="flex items-start space-x-4">
                        <!-- Enhanced Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm {{ $notification->priority_color === 'red' ? 'bg-red-100 text-red-600 border border-red-200' : ($notification->priority_color === 'yellow' ? 'bg-yellow-100 text-yellow-600 border border-yellow-200' : 'bg-green-100 text-green-600 border border-green-200') }}">
                                <i class="fas {{ $notification->type_icon }} text-lg"></i>
                            </div>
                        </div>
                        
                        <!-- Enhanced Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $notification->title }}</h3>
                                        @if(!$notification->is_read)
                                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        @endif
                                    </div>
                                    <p class="text-gray-700 mb-3 leading-relaxed">{{ $notification->message }}</p>
                                    
                                    <!-- Enhanced Metadata -->
                                    <div class="flex items-center space-x-4 text-sm">
                                        <span class="flex items-center text-gray-500">
                                            <i class="fas fa-clock mr-1.5"></i>
                                            {{ $notification->time_ago }}
                                        </span>
                                        @if($notification->triggered_by_name)
                                            <span class="flex items-center text-gray-500">
                                                <i class="fas fa-user mr-1.5"></i>
                                                {{ $notification->triggered_by_name }}
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $notification->priority === 'high' ? 'bg-red-100 text-red-800 border border-red-200' : ($notification->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 'bg-green-100 text-green-800 border border-green-200') }}">
                                            {{ $notification->priority === 'high' ? '🔴' : ($notification->priority === 'medium' ? '🟡' : '🟢') }}
                                            {{ ucfirst($notification->priority) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Enhanced Actions -->
                                <div class="flex items-center space-x-2 ml-4">
                                    @if(!$notification->is_read)
                                        <button onclick="markAsRead({{ $notification->id }})" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300 border border-blue-200">
                                            <i class="fas fa-check mr-1"></i>
                                            Mark Read
                                        </button>
                                    @endif
                                    <button onclick="deleteNotification({{ $notification->id }})" class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300 border border-red-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-16 text-center">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-2xl flex items-center justify-center mb-6 border border-gray-200">
                        <i class="fas fa-bell-slash text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">No notifications found</h3>
                    <p class="text-gray-600 max-w-md mx-auto">You're all caught up! New notifications will appear here when there's activity across the medical workflow.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $notifications->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<style>
/* Modern Tab Pills */
.notification-tab-pill {
    display: inline-flex;
    align-items: center;
    padding: 10px 16px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
    background-color: #ffffff;
    color: #6b7280;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    cursor: pointer;
    text-decoration: none;
}

.notification-tab-pill:hover {
    background-color: #f9fafb;
    color: #1f2937;
    border-color: #d1d5db;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.notification-tab-pill.active {
    background-color: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.notification-tab-pill.active:hover {
    background-color: #1d4ed8;
    border-color: #1d4ed8;
    transform: translateY(-1px);
}

.notification-tab-pill .count-badge {
    margin-left: 8px;
    padding: 2px 8px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
    color: #ffffff;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-tab-pill.active .count-badge {
    background-color: rgba(255, 255, 255, 0.2);
    color: #ffffff;
}

.notification-tab-pill i {
    margin-right: 6px;
}

/* Enhanced animations */
.notification-tab-pill:active {
    transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .notification-tab-pill {
        padding: 8px 12px;
        font-size: 12px;
    }
    
    .notification-tab-pill i {
        margin-right: 6px;
    }
    
    .notification-tab-pill .count-badge {
        margin-left: 6px;
        padding: 1px 6px;
        font-size: 11px;
        min-width: 18px;
        height: 18px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced tab switching functionality
    const tabs = document.querySelectorAll('.notification-tab-pill');
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const tabType = this.dataset.tab;
            
            // Update active tab with smooth animation
            tabs.forEach(t => {
                t.classList.remove('active');
                t.style.transform = 'translateY(0)';
            });
            this.classList.add('active');
            
            // Add click animation
            this.style.transform = 'translateY(-2px)';
            setTimeout(() => {
                this.style.transform = 'translateY(-1px)';
            }, 150);
            
            // Update URL with tab filter and navigate
            const url = new URL(window.location);
            if (tabType === 'all') {
                url.searchParams.delete('type');
                url.searchParams.delete('status');
            } else if (tabType === 'unread') {
                url.searchParams.set('status', 'unread');
                url.searchParams.delete('type');
            } else {
                url.searchParams.delete('status');
                const typeMap = {
                    'company': 'appointment_created,pre_employment_created,patient_registered',
                    'nurse': 'checklist_completed,annual_physical_created',
                    'pathologist': 'pathologist_report_submitted',
                    'radtech': 'xray_completed',
                    'radiologist': 'xray_interpreted',
                    'ecgtech': 'ecg_completed',
                    'plebo': 'specimen_collected',
                    'doctor': 'examination_updated'
                };
                if (typeMap[tabType]) {
                    url.searchParams.set('type', typeMap[tabType]);
                }
            }
            
            window.location.href = url.toString();
        });
    });
    
    // Refresh notifications
    document.getElementById('refresh-notifications').addEventListener('click', function() {
        window.location.reload();
    });
    
    // Mark all as read
    document.getElementById('mark-all-read-btn').addEventListener('click', function() {
        markAllNotificationsAsRead();
    });
});

function markAsRead(notificationId) {
    fetch(`/admin/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function deleteNotification(notificationId) {
    if (confirm('Are you sure you want to delete this notification?')) {
        fetch(`/admin/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error deleting notification:', error);
        });
    }
}

function markAllNotificationsAsRead() {
    if (confirm('Mark all notifications as read?')) {
        fetch('/admin/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error marking all notifications as read:', error);
        });
    }
}
</script>
@endsection
