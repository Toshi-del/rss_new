@extends('layouts.nurse')

@section('title', 'Equipment Requests')
@section('page-title', 'Equipment Requests')
@section('page-description', 'View and manage your equipment requests')

@section('content')
<div class="space-y-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600"></i>
            </div>
            <div>
                <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-emerald-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-list text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Equipment Requests</h3>
                        <p class="text-emerald-100 text-sm">View and manage your equipment requests</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('nurse.equipment-requests.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white/10 text-white font-medium rounded-xl hover:bg-white/20 transition-all duration-200 border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-plus mr-2"></i>
                        New Request
                    </a>
                    
                    <a href="{{ route('nurse.pre-employment') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white/10 text-white font-medium rounded-xl hover:bg-white/20 transition-all duration-200 border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Pre-Employment
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Requests Table -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Request #</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Purpose</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Priority</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Date Needed</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $request)
                        <tr class="hover:bg-emerald-50 transition-all duration-200">
                            <td class="py-5 px-6">
                                <div class="text-sm font-semibold text-gray-900">{{ $request->request_number }}</div>
                                <div class="text-xs text-gray-500">{{ $request->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="text-sm text-gray-900">{{ $request->purpose }}</div>
                                <div class="text-xs text-gray-500">{{ $request->department_name }}</div>
                            </td>
                            <td class="py-5 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    @if($request->priority === 'high') bg-red-100 text-red-800
                                    @elseif($request->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $request->priority_name }}
                                </span>
                            </td>
                            <td class="py-5 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status === 'approved') bg-blue-100 text-blue-800
                                    @elseif($request->status === 'fulfilled') bg-green-100 text-green-800
                                    @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    <i class="fas fa-circle text-xs mr-1"></i>
                                    {{ $request->status_name }}
                                </span>
                            </td>
                            <td class="py-5 px-6">
                                <div class="text-sm text-gray-900">{{ $request->date_needed->format('M d, Y') }}</div>
                                @if($request->date_needed->isPast() && $request->status === 'pending')
                                    <div class="text-xs text-red-500">Overdue</div>
                                @endif
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('nurse.equipment-requests.show', $request) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg text-xs font-medium transition-all duration-150">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </a>
                                    
                                    @if($request->status === 'pending')
                                        <a href="{{ route('nurse.equipment-requests.edit', $request) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-medium transition-all duration-150">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('nurse.equipment-requests.cancel', $request) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to cancel this request?')"
                                                    class="inline-flex items-center px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition-all duration-150">
                                                <i class="fas fa-times mr-1"></i>
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400 text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Equipment Requests</h3>
                                        <p class="text-sm text-gray-500 mb-4">You haven't submitted any equipment requests yet.</p>
                                        <a href="{{ route('nurse.equipment-requests.create') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition-colors duration-200">
                                            <i class="fas fa-plus mr-2"></i>
                                            Create First Request
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($requests->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
