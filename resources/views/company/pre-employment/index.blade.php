@extends('layouts.company')

@section('title', 'Pre-Employment Files')
@section('page-description', 'Manage and view all pre-employment medical records')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pre-Employment Files</h1>
            <p class="text-gray-600 mt-1">Manage medical examination records for your employees</p>
        </div>
        <a href="{{ route('company.pre-employment.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-2xl hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            New Pre-Employment File
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl shadow-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3 text-emerald-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-2xl bg-blue-100">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Records</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $files->total() ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-2xl bg-emerald-100">
                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $files->where('status', 'completed')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-2xl bg-yellow-100">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $files->where('status', 'pending')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-2xl bg-purple-100">
                    <i class="fas fa-peso-sign text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Value</p>
                    <p class="text-2xl font-bold text-gray-900">₱{{ number_format($files->sum('total_price'), 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Records Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Pre-Employment Records</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact Info</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Medical Tests</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Billing</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($files as $file)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-lg">{{ substr($file->first_name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $file->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $file->age }} years old • {{ $file->sex }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                    {{ $file->email }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                                    {{ $file->phone_number }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                @if($file->medicalTests && $file->medicalTests->count() > 0)
                                    @foreach($file->medicalTests as $test)
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">
                                            <i class="fas fa-flask mr-1"></i>
                                            {{ $test->name }}
                                        </div>
                                    @endforeach
                                    <div class="text-xs text-gray-500 mt-1">
                                        Total: ₱{{ number_format($file->total_price, 2) }}
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400 italic">No tests assigned</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="flex items-center mb-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $file->billing_type === 'Company' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas fa-{{ $file->billing_type === 'Company' ? 'building' : 'user' }} mr-1"></i>
                                        {{ $file->billing_type }}
                                    </span>
                                </div>
                                @if($file->company_name)
                                    <div class="text-xs text-gray-500">{{ $file->company_name }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $status = $file->status ?? 'pending';
                                $statusConfig = [
                                    'completed' => ['bg-emerald-100', 'text-emerald-800', 'fas fa-check-circle'],
                                    'pending' => ['bg-yellow-100', 'text-yellow-800', 'fas fa-clock'],
                                    'in_progress' => ['bg-blue-100', 'text-blue-800', 'fas fa-spinner'],
                                    'cancelled' => ['bg-red-100', 'text-red-800', 'fas fa-times-circle']
                                ];
                                $config = $statusConfig[$status] ?? $statusConfig['pending'];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config[0] }} {{ $config[1] }}">
                                <i class="{{ $config[2] }} mr-1"></i>
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('company.pre-employment.show', $file) }}" 
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors duration-200">
                                    <i class="fas fa-eye mr-1"></i>
                                    View
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-folder-open text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No records found</h3>
                                <p class="text-gray-500 mb-4">Get started by creating your first pre-employment record.</p>
                                <a href="{{ route('company.pre-employment.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Create First Record
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(isset($files) && $files instanceof \Illuminate\Pagination\LengthAwarePaginator && $files->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $files->links() }}
        </div>
        @endif
    </div>
</div>
@endsection