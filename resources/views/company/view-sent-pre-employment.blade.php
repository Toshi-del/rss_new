@extends('layouts.company')

@section('title', 'Sent Pre-Employment Examination - RSS Citi Health Services')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Pre-Employment Examination Results</h1>
                    <p class="text-sm text-gray-600">Examination results sent by RSS Citi Health Services</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('company.medical-results', ['status' => 'sent_results']) }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Results
                    </a>
                    <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-print mr-2"></i>Print
                    </button>
                </div>
            </div>
        </div>

        @if(session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('info') }}</span>
        </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <!-- Header Section -->
            <div class="px-6 py-4 bg-blue-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">{{ $examination->name }}</h2>
                        <p class="text-sm text-gray-600">{{ $examination->company_name }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Examination Date</div>
                        <div class="text-lg font-medium text-gray-900">{{ \Carbon\Carbon::parse($examination->date)->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Medical History -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Medical History</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Illness History</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->illness_history ?? 'Not specified' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Accidents/Operations</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->accidents_operations ?? 'None reported' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Past Medical History</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->past_medical_history ?? 'No major medical issues' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Family History -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Family History</h3>
                            <div class="flex flex-wrap gap-2">
                                @if($examination->family_history && count($examination->family_history) > 0)
                                    @foreach($examination->family_history as $condition)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $condition }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-sm text-gray-500">No family history recorded</span>
                                @endif
                            </div>
                        </div>

                        <!-- Personal Habits -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Habits</h3>
                            <div class="flex flex-wrap gap-2">
                                @if($examination->personal_habits && count($examination->personal_habits) > 0)
                                    @foreach($examination->personal_habits as $habit)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            {{ $habit }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-sm text-gray-500">No personal habits recorded</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Physical Examination -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Physical Examination</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Visual Acuity</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->visual ?? 'Not tested' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ishihara Test</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->ishihara_test ?? 'Not tested' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Skin Marks</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->skin_marks ?? 'None' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Laboratory Results -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Laboratory Results</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">ECG</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->ecg ?? 'Not performed' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Final Findings -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Final Findings</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-900">{{ $examination->findings ?? 'No findings recorded' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <div>
                        <p>Report generated by RSS Citi Health Services</p>
                        <p>Sent on: {{ $examination->updated_at->format('M d, Y g:i A') }}</p>
                    </div>
                    <div class="text-right">
                        <p>Status: <span class="font-medium text-green-600">Sent to Company</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
}
</style>
@endsection
