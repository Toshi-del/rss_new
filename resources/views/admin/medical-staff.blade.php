@extends('layouts.admin')

@section('title', 'Medical Staff Management')

@section('content')
<<<<<<< Updated upstream
<div class="space-y-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-green-600"></i>
            </div>
            <div>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Stats Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="content-card rounded-xl p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Staff</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $staff->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-md text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>
        
        <div class="content-card rounded-xl p-6 border-l-4 border-emerald-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Doctors</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $staff->where('role', 'doctor')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-stethoscope text-emerald-600 text-lg"></i>
                </div>
            </div>
        </div>
        
        <div class="content-card rounded-xl p-6 border-l-4 border-amber-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Nurses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $staff->where('role', 'nurse')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-nurse text-amber-600 text-lg"></i>
                </div>
            </div>
        </div>
        
        <div class="content-card rounded-xl p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Technicians</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $staff->whereIn('role', ['radtech', 'ecgtech', 'plebo'])->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-microscope text-purple-600 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-user-md text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Medical Staff Management</h3>
                        <p class="text-blue-100 text-sm">Manage medical staff accounts and roles</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Role Filter -->
                    <form method="GET" action="{{ route('admin.medical-staff') }}" class="flex items-center space-x-3">
                        <div class="relative">
                            <select name="role" class="glass-morphism px-4 py-2 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 border border-white/20" onchange="this.form.submit()">
                                <option value="" class="text-gray-900">All Roles</option>
                                @php
                                    $roles = [
                                        'doctor' => 'Doctor',
                                        'nurse' => 'Nurse (Medtech)',
                                        'plebo' => 'Plebo',
                                        'pathologist' => 'Pathologist',
                                        'ecgtech' => 'ECG Tech',
=======
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Modern Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif;">Medical Staff Management</h1>
                    <p class="text-sm text-gray-600">Manage your medical team and staff members efficiently</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-lg text-xs font-medium text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" data-bs-toggle="modal" data-bs-target="#createStaffModal">
                        <i class="fas fa-user-plus mr-1.5 text-xs"></i>
                        Add Staff Member
                    </button>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl mr-4">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Staff</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ isset($staff) ? $staff->count() : 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl mr-4">
                        <i class="fas fa-user-md text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Doctors</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ isset($staff) ? $staff->where('role', 'doctor')->count() : 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-xl mr-4">
                        <i class="fas fa-user-nurse text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nurses</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ isset($staff) ? $staff->where('role', 'nurse')->count() : 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-xl mr-4">
                        <i class="fas fa-microscope text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Technicians</p>
                        <p class="text-2xl font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">{{ isset($staff) ? $staff->whereIn('role', ['radtech', 'ecgtech', 'plebo'])->count() : 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">Staff Directory</h3>
                <p class="text-sm text-gray-600 mt-1">Search and filter your medical staff</p>
            </div>
            <div class="mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Search Input -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Staff</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Search by name or email..." 
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            </div>
                        </div>
                        
                        <!-- Role Filter -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Filter by Role</label>
                            <select id="role" 
                                    name="role" 
                                    class="block w-full px-3 py-3 border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">All roles</option>
                                @php
                                    $roles = [
                                        'doctor' => 'Doctor',
                                        'nurse' => 'Nurse',
                                        'pathologist' => 'Pathologist',
                                        'technician' => 'Technician',
                                        'admin' => 'Admin',
                                        'receptionist' => 'Receptionist',
                                        'pharmacist' => 'Pharmacist',
>>>>>>> Stashed changes
                                        'radtech' => 'Radtech',
                                        'radiologist' => 'Radiologist',
                                    ];
                                @endphp
                                @foreach($roles as $key => $label)
<<<<<<< Updated upstream
                                    <option value="{{ $key }}" {{ request('role') === $key ? 'selected' : '' }} class="text-gray-900">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Search Bar -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-white/60 text-sm"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="glass-morphism pl-12 pr-4 py-2 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 w-64 text-sm border border-white/20" 
                                   placeholder="Search staff...">
                        </div>
                        <button type="submit" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 border border-white/20 backdrop-blur-sm">
                            <i class="fas fa-filter text-sm"></i>
                        </button>
                        @if(request()->hasAny(['search','role']))
                            <a href="{{ route('admin.medical-staff') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 border border-white/20 backdrop-blur-sm">
                                <i class="fas fa-times text-sm"></i>
                            </a>
                        @endif
                    </form>
                    <!-- Add Staff Button -->
                    <button onclick="openAddStaffModal()" class="bg-white/10 hover:bg-white/20 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-plus text-sm"></i>
                        <span>Add Staff</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Staff Table -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full" id="staffTable">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">ID</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Staff Name</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Email</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Role</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
=======
                                    <option value="{{ $key }}" {{ request('role') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Staff Table -->
        <div class="overflow-hidden rounded-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
>>>>>>> Stashed changes
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($staff ?? [] as $user)
<<<<<<< Updated upstream
                        <tr class="hover:bg-blue-50 transition-all duration-200 border-l-4 border-transparent hover:border-blue-400 staff-card" data-staff-id="{{ $user->id }}">
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-bold text-gray-700">
                                        {{ $user->id }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                                        <span class="text-white font-bold text-sm">
                                            {{ strtoupper(substr($user->fname, 0, 1) . substr($user->lname, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $user->fname }} {{ $user->lname }}
                                        </div>
                                        <div class="text-xs text-gray-500">Staff ID: #{{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-envelope text-gray-400 text-xs"></i>
                                    <span class="text-sm text-gray-700">{{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border
                                    @if($user->role === 'doctor') bg-emerald-100 text-emerald-800 border-emerald-200
                                    @elseif($user->role === 'nurse') bg-blue-100 text-blue-800 border-blue-200
                                    @elseif($user->role === 'pathologist') bg-purple-100 text-purple-800 border-purple-200
                                    @elseif($user->role === 'radiologist') bg-indigo-100 text-indigo-800 border-indigo-200
                                    @else bg-amber-100 text-amber-800 border-amber-200 @endif">
                                    <i class="fas fa-circle text-xs mr-1.5"></i>
                                    {{ ucfirst($roles[$user->role] ?? $user->role) }}
                                </span>
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex items-center space-x-2">
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-medium transition-all duration-150 border border-blue-200"
                                            onclick="openViewStaffModal({{ $user->id }}, '{{ $user->fname }}', '{{ $user->lname }}', '{{ $user->email }}', '{{ $user->role }}')">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </button>
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg text-xs font-medium transition-all duration-150 border border-emerald-200"
                                            onclick="openEditStaffModal({{ $user->id }}, '{{ $user->fname }}', '{{ $user->lname }}', '{{ $user->email }}', '{{ $user->role }}')">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition-all duration-150 border border-red-200"
                                            onclick="openDeleteStaffModal({{ $user->id }}, '{{ $user->fname }} {{ $user->lname }}')">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
=======
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($user->fname, 0, 1) }}{{ substr($user->lname, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->fname }} {{ $user->lname }}</div>
                                        <div class="text-sm text-gray-500">Staff ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    @if($user->role === 'doctor') bg-blue-100 text-blue-800
                                    @elseif($user->role === 'nurse') bg-green-100 text-green-800
                                    @elseif($user->role === 'pathologist') bg-purple-100 text-purple-800
                                    @elseif(in_array($user->role, ['radtech', 'ecgtech', 'plebo'])) bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button 
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                                        title="Edit Staff"
                                        data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                        data-id="{{ $user->id }}"
                                        data-fname="{{ $user->fname }}"
                                        data-lname="{{ $user->lname }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.medical-staff.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this staff member?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200" title="Delete Staff">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
>>>>>>> Stashed changes
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
<<<<<<< Updated upstream
                            <td colspan="5" class="py-16 text-center border-2 border-dashed border-gray-300">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center border-4 border-blue-300">
                                        <i class="fas fa-user-md text-blue-500 text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 font-semibold text-lg">No medical staff found</p>
                                        <p class="text-gray-500 text-sm mt-1">Get started by adding your first staff member</p>
                                    </div>
                                    <button onclick="openAddStaffModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 flex items-center space-x-2 shadow-lg">
                                        <i class="fas fa-plus text-sm"></i>
                                        <span>Add First Staff</span>
=======
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No staff members found</h3>
                                    <p class="text-gray-500 mb-4">Get started by adding your first staff member.</p>
                                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" data-bs-toggle="modal" data-bs-target="#createStaffModal">
                                        <i class="fas fa-plus mr-2"></i>
                                        Add Staff Member
>>>>>>> Stashed changes
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
<<<<<<< Updated upstream
    </div>

    <!-- Pagination -->
    @if(isset($staff) && method_exists($staff, 'links'))
    <div class="flex justify-center">
        {{ $staff->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Modals -->
<!-- Add Staff Modal -->
<div id="addStaffModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Add Medical Staff</h3>
                </div>
                <button onclick="closeModal('addStaffModal')" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <form id="addStaffForm" action="{{ route('admin.medical-staff.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="fname" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="lname" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        @php
                            $roles = [
                                'doctor' => 'Doctor',
                                'nurse' => 'Nurse (Medtech)',
                                'plebo' => 'Plebo',
                                'pathologist' => 'Pathologist',
                                'ecgtech' => 'ECG Tech',
                                'radtech' => 'Radtech',
                                'radiologist' => 'Radiologist',
                            ];
                        @endphp
                        @foreach($roles as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Temporary Password</label>
                    <input type="password" name="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeModal('addStaffModal')" 
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                        <i class="fas fa-plus mr-2"></i>
                        Add Staff
                    </button>
                </div>
            </form>
        </div>
=======

                @if(isset($staff) && method_exists($staff, 'links'))
                    <div class="mt-6">
                        {{ $staff->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Create Staff Modal -->
<div class="modal fade" id="createStaffModal" tabindex="-1" role="dialog" aria-labelledby="createStaffLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content rounded-2xl border-0 shadow-2xl">
      <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-2xl border-0 p-6">
        <div class="flex items-center">
          <div class="p-2 bg-white bg-opacity-20 rounded-lg mr-3">
            <i class="fas fa-user-plus text-xl"></i>
          </div>
          <div>
            <h5 class="modal-title text-lg font-semibold mb-0" id="createStaffLabel">Add Medical Staff</h5>
            <p class="text-blue-100 text-sm mt-1 mb-0">Create a new staff member account</p>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.medical-staff.store') }}" method="POST">
        @csrf
        <div class="modal-body p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="fname" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="lname" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                <select name="role" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                    <option value="">Select a role</option>
                    @php
                        $roles = [
                            'doctor' => 'Doctor',
                            'nurse' => 'Nurse (Medtech)',
                            'plebo' => 'Plebo',
                            'pathologist' => 'Pathologist',
                            'ecgtech' => 'ECG Tech',
                            'radtech' => 'Radtech',
                            'radiologist' => 'Radiologist',
                        ];
                    @endphp
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Temporary Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                <p class="text-sm text-gray-500 mt-2">The staff member can change this password after first login.</p>
            </div>
        </div>
        <div class="modal-footer bg-gray-50 rounded-b-2xl border-0 p-6">
          <button type="button" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 font-medium mr-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 font-medium">
            <i class="fas fa-user-plus mr-2"></i>Create Staff Member
          </button>
        </div>
      </form>
>>>>>>> Stashed changes
    </div>
</div>

<!-- Edit Staff Modal -->
<<<<<<< Updated upstream
<div id="editStaffModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-emerald-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Edit Medical Staff</h3>
                </div>
                <button onclick="closeModal('editStaffModal')" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <form id="editStaffForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="fname" id="edit-fname" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="lname" id="edit-lname" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit-email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" id="edit-role" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm">
                        @foreach($roles as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reset Password (optional)</label>
                    <input type="password" name="password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm"
                           placeholder="Leave blank to keep current">
                </div>
                <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeModal('editStaffModal')" 
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Staff Modal -->
<div id="viewStaffModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Staff Details</h3>
                </div>
                <button onclick="closeModal('viewStaffModal')" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">First Name</h5>
                        <p id="view-fname" class="text-gray-700"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-gray-900 mb-2">Last Name</h5>
                        <p id="view-lname" class="text-gray-700"></p>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-900 mb-2">Email</h5>
                    <p id="view-email" class="text-gray-700"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-900 mb-2">Role</h5>
                    <p id="view-role" class="text-gray-700"></p>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('viewStaffModal')" 
                        class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Staff Modal -->
<div id="deleteStaffModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-red-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-trash text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Delete Medical Staff</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4 mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Confirm Deletion</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Are you sure you want to delete <span id="delete-staff-name" class="font-semibold"></span>? This action will permanently remove their account and cannot be undone.
                    </p>
                </div>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center space-x-2 text-red-800">
                    <i class="fas fa-exclamation-triangle text-sm"></i>
                    <span class="text-sm font-medium">This action cannot be undone</span>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" onclick="closeModal('deleteStaffModal')" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                    Cancel
                </button>
                <button type="button" onclick="confirmDeleteStaff()" 
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                    <i class="fas fa-trash mr-2"></i>
                    Delete Staff
                </button>
            </div>
        </div>
=======
<div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content rounded-2xl border-0 shadow-2xl">
      <div class="modal-header bg-gradient-to-r from-green-600 to-green-700 text-white rounded-t-2xl border-0 p-6">
        <div class="flex items-center">
          <div class="p-2 bg-white bg-opacity-20 rounded-lg mr-3">
            <i class="fas fa-user-edit text-xl"></i>
          </div>
          <div>
            <h5 class="modal-title text-lg font-semibold mb-0" id="editStaffLabel">Edit Medical Staff</h5>
            <p class="text-green-100 text-sm mt-1 mb-0">Update staff member information</p>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editStaffForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body p-6">
            <input type="hidden" name="id" id="edit-id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="fname" id="edit-fname" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="lname" id="edit-lname" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="edit-email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                <select name="role" id="edit-role" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reset Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Leave blank to keep current password">
                <p class="text-sm text-gray-500 mt-2">Only enter a new password if you want to reset it.</p>
            </div>
        </div>
        <div class="modal-footer bg-gray-50 rounded-b-2xl border-0 p-6">
          <button type="button" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 font-medium mr-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 font-medium">
            <i class="fas fa-save mr-2"></i>Save Changes
          </button>
        </div>
      </form>
>>>>>>> Stashed changes
    </div>
</div>

<script>
// Global variables
let currentStaffId = null;

// Modal functions
function openAddStaffModal() {
    document.getElementById('addStaffModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openEditStaffModal(id, fname, lname, email, role) {
    currentStaffId = id;
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-fname').value = fname;
    document.getElementById('edit-lname').value = lname;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-role').value = role;
    
    // Set form action
    document.getElementById('editStaffForm').action = `{{ url('admin/medical-staff') }}/${id}`;
    
    document.getElementById('editStaffModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openViewStaffModal(id, fname, lname, email, role) {
    const roles = {
        'doctor': 'Doctor',
        'nurse': 'Nurse (Medtech)',
        'plebo': 'Plebo',
        'pathologist': 'Pathologist',
        'ecgtech': 'ECG Tech',
        'radtech': 'Radtech',
        'radiologist': 'Radiologist'
    };
    
    document.getElementById('view-fname').textContent = fname;
    document.getElementById('view-lname').textContent = lname;
    document.getElementById('view-email').textContent = email;
    document.getElementById('view-role').textContent = roles[role] || role;
    
    document.getElementById('viewStaffModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openDeleteStaffModal(id, name) {
    currentStaffId = id;
    document.getElementById('delete-staff-name').textContent = name;
    document.getElementById('deleteStaffModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentStaffId = null;
}

function confirmDeleteStaff() {
    if (currentStaffId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('admin/medical-staff') }}/${currentStaffId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['addStaffModal', 'editStaffModal', 'viewStaffModal', 'deleteStaffModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            closeModal(modalId);
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = ['addStaffModal', 'editStaffModal', 'viewStaffModal', 'deleteStaffModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (!modal.classList.contains('hidden')) {
                closeModal(modalId);
            }
        });
    }

    // Auto-search and auto-filter functionality
    const searchInput = document.getElementById('search');
    const roleSelect = document.getElementById('role');
    let searchTimeout;

    // Auto-search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                performSearch();
            }, 500); // 500ms delay to avoid too many requests
        });
    }

    // Auto-filter functionality for role dropdown
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            performSearch();
        });
    }

    function performSearch() {
        const searchValue = searchInput ? searchInput.value : '';
        const roleValue = roleSelect ? roleSelect.value : '';
        
        // Build URL with parameters
        const url = new URL('{{ route("admin.medical-staff") }}', window.location.origin);
        
        if (searchValue.trim()) {
            url.searchParams.set('search', searchValue);
        }
        
        if (roleValue) {
            url.searchParams.set('role', roleValue);
        }
        
        // Redirect to the new URL
        window.location.href = url.toString();
    }
});

// Make functions globally available
window.openAddStaffModal = openAddStaffModal;
window.openEditStaffModal = openEditStaffModal;
window.openViewStaffModal = openViewStaffModal;
window.openDeleteStaffModal = openDeleteStaffModal;
</script>

@endsection
