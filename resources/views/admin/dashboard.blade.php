@extends('layouts.admin')

@section('title', 'Dashboard - RSS Citi Health Services')
@section('page-title', 'Dashboard Overview')

@section('content')
<<<<<<< Updated upstream
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Total Patients Card -->
        <div class="stat-card content-card rounded-lg p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 uppercase tracking-wide">Total Patients</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-2xl font-semibold text-gray-900">2,847</p>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            +12.5%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">vs last month</p>
                </div>
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Appointments Today Card -->
        <div class="stat-card content-card rounded-lg p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 uppercase tracking-wide">Today's Appointments</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-2xl font-semibold text-gray-900">67</p>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            +8.2%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">15 pending approval</p>
                </div>
                <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Pending Tests Card -->
        <div class="stat-card content-card rounded-lg p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 uppercase tracking-wide">Pending Tests</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-2xl font-semibold text-gray-900">34</p>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-50 text-orange-700">
                            <i class="fas fa-arrow-down text-xs mr-1"></i>
                            -5.1%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">awaiting results</p>
                </div>
                <div class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-vial text-white text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="stat-card content-card rounded-lg p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 uppercase tracking-wide">Monthly Revenue</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-2xl font-semibold text-gray-900">₱156K</p>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            +18.7%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">target: ₱180K</p>
                </div>
                <div class="w-12 h-12 bg-cyan-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Recent Appointments -->
        <div class="xl:col-span-2">
            <div class="content-card rounded-lg overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Recent Appointments</h3>
                            <p class="text-blue-100 text-sm">Latest patient bookings and schedules</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Patient</th>
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Time</th>
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Service</th>
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="text-left py-4 px-2 text-sm font-bold text-gray-700 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="py-4 px-2">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-lg">
                                                JD
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">John Doe</div>
                                                <div class="text-sm text-gray-500">john.doe@email.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <div class="font-medium text-gray-900">09:30 AM</div>
                                        <div class="text-sm text-gray-500">Today</div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <div class="font-medium text-gray-900">Blood Test</div>
                                        <div class="text-sm text-gray-500">CBC + Lipid Panel</div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Confirmed
                                        </span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <button class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">View Details</button>
                                    </td>
                                </tr>
                                
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="py-4 px-2">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white font-bold text-lg">
                                                MS
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">Maria Santos</div>
                                                <div class="text-sm text-gray-500">maria.santos@email.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <div class="font-medium text-gray-900">11:00 AM</div>
                                        <div class="text-sm text-gray-500">Today</div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <div class="font-medium text-gray-900">X-Ray</div>
                                        <div class="text-sm text-gray-500">Chest X-Ray</div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Pending
                                        </span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <button class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">View Details</button>
                                    </td>
                                </tr>
                                
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="py-4 px-2">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center text-white font-bold text-lg">
                                                RG
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">Robert Garcia</div>
                                                <div class="text-sm text-gray-500">robert.garcia@email.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <div class="font-medium text-gray-900">02:15 PM</div>
                                        <div class="text-sm text-gray-500">Today</div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <div class="font-medium text-gray-900">ECG</div>
                                        <div class="text-sm text-gray-500">Electrocardiogram</div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Scheduled
                                        </span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <button class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">View Details</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
=======
    
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Modern Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif;">Admin Dashboard</h1>
                    <p class="text-lg text-gray-600">Welcome back! Here's what's happening with your medical center today.</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl mr-4">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Patients</p>
                        <p class="text-3xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $totalPatients }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl mr-4">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Approved Appointments</p>
                        <p class="text-3xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $approvedAppointments }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-xl mr-4">
                        <i class="fas fa-clipboard-list text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tests Today</p>
                        <p class="text-3xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $testsToday }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-xl mr-4">
                        <i class="fas fa-file-medical text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pre-Employment Records</p>
                        <p class="text-3xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ $totalPreEmployment }}</p>
>>>>>>> Stashed changes
                    </div>
                </div>
            </div>
        </div>

<<<<<<< Updated upstream
        <!-- Sidebar Content -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="content-card rounded-lg overflow-hidden">
                <div class="bg-emerald-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bolt text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Quick Actions</h3>
                            <p class="text-emerald-100 text-xs">Frequently used functions</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-3">
                    <button class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-plus-circle mr-2 text-sm"></i>
                        New Appointment
                    </button>
                    
                    <button class="w-full flex items-center justify-center px-4 py-3 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition-colors duration-200">
                        <i class="fas fa-user-plus mr-2 text-sm"></i>
                        Add Patient
                    </button>
                    
                    <button class="w-full flex items-center justify-center px-4 py-3 bg-amber-600 text-white rounded-lg font-medium hover:bg-amber-700 transition-colors duration-200">
                        <i class="fas fa-vial mr-2 text-sm"></i>
                        Schedule Test
                    </button>
                    
                    <button class="w-full flex items-center justify-center px-4 py-3 bg-slate-600 text-white rounded-lg font-medium hover:bg-slate-700 transition-colors duration-200">
                        <i class="fas fa-file-alt mr-2 text-sm"></i>
                        Generate Report
                    </button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="content-card rounded-lg overflow-hidden">
                <div class="bg-cyan-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-activity text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Recent Activity</h3>
                            <p class="text-cyan-100 text-xs">Latest system updates</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-5">
                    <div class="flex items-start space-x-4">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full mt-2 pulse-icon"></div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">New patient registered</p>
                            <p class="text-xs text-gray-500 mt-1">Sarah Johnson completed registration</p>
                            <p class="text-xs text-gray-400">2 minutes ago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Appointment confirmed</p>
                            <p class="text-xs text-gray-500 mt-1">Dr. Martinez confirmed 3:00 PM slot</p>
                            <p class="text-xs text-gray-400">8 minutes ago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-3 h-3 bg-amber-500 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Test results uploaded</p>
                            <p class="text-xs text-gray-500 mt-1">Blood work for Patient #2847</p>
                            <p class="text-xs text-gray-400">15 minutes ago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Monthly report generated</p>
                            <p class="text-xs text-gray-500 mt-1">October 2024 analytics ready</p>
                            <p class="text-xs text-gray-400">1 hour ago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-3 h-3 bg-red-500 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">System maintenance</p>
                            <p class="text-xs text-gray-500 mt-1">Scheduled for tonight 11:00 PM</p>
                            <p class="text-xs text-gray-400">2 hours ago</p>
                        </div>
=======
@php
    // Build Top Categories (Last 90 Days) for dashboard
    $dashboardSince = \Carbon\Carbon::now()->subDays(90);
    $dashboardCategoryData = \App\Models\MedicalTestCategory::select('id','name')
        ->get()
        ->map(function ($cat) use ($dashboardSince) {
            $per = \App\Models\PreEmploymentRecord::where('medical_test_categories_id', $cat->id)
                ->where('created_at', '>=', $dashboardSince)
                ->count();
            $appt = \App\Models\Appointment::where('medical_test_categories_id', $cat->id)
                ->where('created_at', '>=', $dashboardSince)
                ->count();
            return [ 'name' => $cat->name, 'count' => $per + $appt ];
        })
        ->sortByDesc('count')
        ->take(6)
        ->values();
@endphp

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">Top Categories (Last 90 Days)</h3>
                    <p class="text-sm text-gray-600 mt-1">Most popular medical test categories</p>
                </div>
                <div class="p-6" style="height: 280px; overflow: hidden;">
                    <canvas id="dashTopCategoriesChart" height="200" tabindex="-1"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">Quick Actions</h3>
                    <p class="text-sm text-gray-600 mt-1">Common administrative tasks</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('admin.appointments') }}" class="flex items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors duration-200">
                            <i class="fas fa-calendar-alt text-blue-600 text-xl mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Appointments</p>
                                <p class="text-sm text-gray-600">Manage bookings</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.medical-staff') }}" class="flex items-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors duration-200">
                            <i class="fas fa-user-md text-green-600 text-xl mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Staff</p>
                                <p class="text-sm text-gray-600">Manage team</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.pre-employment') }}" class="flex items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors duration-200">
                            <i class="fas fa-briefcase text-purple-600 text-xl mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Pre-Employment</p>
                                <p class="text-sm text-gray-600">Review tests</p>
                            </div>
                        </a>
                        <a href="{{ route('inventory.index') }}" class="flex items-center p-4 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-colors duration-200">
                            <i class="fas fa-boxes text-yellow-600 text-xl mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Inventory</p>
                                <p class="text-sm text-gray-600">Manage supplies</p>
                            </div>
                        </a>
>>>>>>> Stashed changes
                    </div>
                </div>
            </div>
        </div>
<<<<<<< Updated upstream
    </div>
</div>
=======

        <!-- Recent Appointments Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">Recent Annual Physical Examinations</h3>
                        <p class="text-sm text-gray-600 mt-1">Latest patient appointments and examinations</p>
                    </div>
                    <a href="{{ route('admin.appointments') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-eye mr-2"></i>View All
                    </a>
                </div>
            </div>
            <div class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Type</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($patients as $patient)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#{{ $patient->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                                    {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if($patient->appointment && $patient->appointment->creator)
                                                {{ $patient->appointment->creator->company ?? 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $patient->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if($patient->appointment)
                                                {{ Carbon\Carbon::parse($patient->appointment->appointment_date)->format('M d, Y') }}
                                                @if($patient->appointment->time_slot)
                                                    <div class="text-xs text-gray-500">{{ $patient->appointment->time_slot }}</div>
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                            @if($patient->appointment)
                                {{ $patient->appointment->time_slot ?? 'N/A' }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($patient->appointment)
                                {{ optional($patient->appointment->medicalTestCategory)->name }}
                                @if($patient->appointment->medicalTest)
                                    - {{ $patient->appointment->medicalTest->name }}
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-users text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No recent patients</h3>
                                <p class="text-gray-500">Patient appointments will appear here once scheduled.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pre-Employment Tests -->
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Pre-Employment Tests</h5>
        <a href="{{ route('admin.pre-employment') }}" class="btn btn-sm btn-outline-info">View All</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="preEmploymentTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Medical Exam</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($preEmployments as $preEmployment)
                        <tr>
                            <td>{{ $preEmployment->id }}</td>
                            <td>{{ $preEmployment->full_name }}</td>
                            <td>{{ $preEmployment->email }}</td>
                            <td>
                                {{ optional($preEmployment->medicalTestCategory)->name }}
                                @if($preEmployment->medicalTest)
                                    - {{ $preEmployment->medicalTest->name }}
                                @endif
                            </td>
                            <td>₱{{ number_format($preEmployment->total_price ?? 0, 2) }}</td>
                            <td>
                                @php
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    $status = $preEmployment->status ?? 'pending';
                                    if ($status === 'passed') {
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } elseif ($status === 'failed') {
                                        $statusClass = 'bg-red-100 text-red-800';
                                    } elseif ($status === 'pending') {
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                    }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No recent pre-employment tests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



>>>>>>> Stashed changes
@endsection
