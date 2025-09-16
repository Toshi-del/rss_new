@extends('layouts.admin')

@section('title', 'Dashboard - RSS Citi Health Services')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Patients Card -->
        <div class="stat-card content-card rounded-3xl p-6 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wider">Total Patients</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-3xl font-bold text-gray-900">2,847</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            +12.5%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">vs last month</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center floating-icon">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Appointments Today Card -->
        <div class="stat-card content-card rounded-3xl p-6 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wider">Today's Appointments</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-3xl font-bold text-gray-900">67</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            +8.2%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">15 pending approval</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center pulse-icon">
                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Tests Card -->
        <div class="stat-card content-card rounded-3xl p-6 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wider">Pending Tests</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-3xl font-bold text-gray-900">34</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                            <i class="fas fa-arrow-down text-xs mr-1"></i>
                            -5.1%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">awaiting results</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center floating-icon">
                    <i class="fas fa-vial text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="stat-card content-card rounded-3xl p-6 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wider">Monthly Revenue</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-3xl font-bold text-gray-900">₱156K</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            +18.7%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">target: ₱180K</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center pulse-icon">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Recent Appointments -->
        <div class="xl:col-span-2">
            <div class="content-card rounded-3xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Recent Appointments</h3>
                            <p class="text-indigo-100 text-sm">Latest patient bookings and schedules</p>
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Content -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="content-card rounded-3xl overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-5">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-bolt text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Quick Actions</h3>
                            <p class="text-purple-100 text-xs">Frequently used functions</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <button class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-2xl font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-plus-circle mr-3 text-lg"></i>
                        New Appointment
                    </button>
                    
                    <button class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-2xl font-semibold hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-user-plus mr-3 text-lg"></i>
                        Add Patient
                    </button>
                    
                    <button class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-2xl font-semibold hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-vial mr-3 text-lg"></i>
                        Schedule Test
                    </button>
                    
                    <button class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-2xl font-semibold hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-file-alt mr-3 text-lg"></i>
                        Generate Report
                    </button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="content-card rounded-3xl overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-activity text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Recent Activity</h3>
                            <p class="text-emerald-100 text-xs">Latest system updates</p>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
