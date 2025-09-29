@extends('layouts.radiologist')

@section('title', 'Pre-Employment X-Ray')
@section('page-title', 'Pre-Employment Chest X-Ray')
@section('page-description', 'Review and analyze pre-employment X-ray images')

@section('content')
<div class="space-y-8">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border-2 border-emerald-200 rounded-xl p-6 flex items-center space-x-4 shadow-lg">
            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600 text-lg"></i>
            </div>
            <div class="flex-1">
                <p class="text-emerald-800 font-semibold text-lg">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors p-2">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
    @endif

    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border-2 border-white/20">
                        <i class="fas fa-briefcase text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Pre-Employment X-Ray Services</h2>
                        <p class="text-purple-100 text-sm">X-Ray examinations for pre-employment medical records</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-sm">Total Records</div>
                    <div class="text-white font-bold text-3xl">{{ count($preEmployments) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- X-Ray Records Table -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Applicant</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Company</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Medical Test</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Age & Gender</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($preEmployments as $record)
                        <tr class="hover:bg-purple-50 transition-colors duration-150">
                            <!-- Applicant -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                        <span class="text-purple-600 font-bold text-sm">
                                            {{ substr($record->first_name, 0, 1) }}{{ substr($record->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $record->first_name }} {{ $record->last_name }}</div>
                                        <div class="text-xs text-gray-500">Record ID: #{{ $record->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Company -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $record->company_name ?? 'N/A' }}</div>
                            </td>

                            <!-- Medical Test -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $record->medicalTest->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $record->medicalTestCategory->name ?? '' }}</div>
                            </td>

                            <!-- Age & Gender -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $record->age }} years old</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($record->sex) }}</div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if($record->medicalChecklist && $record->medicalChecklist->xray_image_path)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        X-Ray Available
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Pending
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                @if($record->medicalChecklist && $record->medicalChecklist->xray_image_path)
                                    <a href="{{ route('radiologist.pre-employment.show', $record->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                        <i class="fas fa-eye mr-2"></i>
                                        View X-Ray
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-500 text-sm font-medium rounded-lg cursor-not-allowed">
                                        <i class="fas fa-ban mr-2"></i>
                                        No Image
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-x-ray text-gray-400 text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 font-medium text-lg">No X-ray images found</p>
                                        <p class="text-gray-400 text-sm mt-1">Pre-employment X-rays will appear here once uploaded by RadTech</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
