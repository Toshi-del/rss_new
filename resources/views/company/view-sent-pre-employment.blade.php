@extends('layouts.company')

@section('title', 'Pre-Employment Examination Results')

@section('content')
<div class="min-h-screen" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-green-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('company.medical-results', ['status' => 'sent_results']) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-medium hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-600 transition-all duration-200 shadow-sm mr-6">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Results
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-briefcase mr-3"></i>Pre-Employment Examination
                            </h1>
                            <p class="text-green-100">Examination results sent by RSS Citi Health Services</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="bg-green-500 rounded-lg px-4 py-2">
                            <p class="text-green-100 text-sm font-medium">Status</p>
                            <p class="text-white text-lg font-bold">Completed</p>
                        </div>
                        <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-white text-green-600 rounded-lg text-sm font-bold hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-600 transition-all duration-200 shadow-sm no-print">
                            <i class="fas fa-print mr-2"></i>
                            Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Message -->
        @if(session('info'))
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-white text-xl mr-3"></i>
                    <span class="text-white font-medium">{{ session('info') }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Applicant Information -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-orange-600 to-orange-700 border-l-4 border-orange-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-user-tie mr-3"></i>Applicant Information
                </h2>
                <p class="text-orange-100 mt-1">Pre-employment examination details and company information</p>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-orange-50 rounded-xl p-6 border-l-4 border-orange-600">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-lg">
                                    {{ strtoupper(substr($examination->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-orange-900">{{ $examination->name }}</h3>
                                <p class="text-orange-700 text-sm">Job Applicant</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-600">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-building text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-blue-900">Company</h3>
                                <p class="text-blue-700 text-sm">{{ $examination->company_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-600">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-calendar text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-green-900">Examination Date</h3>
                                <p class="text-green-700 text-sm">{{ \Carbon\Carbon::parse($examination->date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical History Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-indigo-700 border-l-4 border-indigo-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-history mr-3"></i>Medical History
                </h2>
                <p class="text-indigo-100 mt-1">Applicant's medical background and history</p>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-indigo-50 rounded-xl p-6 border-l-4 border-indigo-600">
                        <h3 class="text-lg font-bold text-indigo-900 mb-3">
                            <i class="fas fa-notes-medical mr-2"></i>Illness History
                        </h3>
                        <p class="text-indigo-800 leading-relaxed">{{ $examination->illness_history ?? 'Not specified' }}</p>
                    </div>
                    <div class="bg-red-50 rounded-xl p-6 border-l-4 border-red-600">
                        <h3 class="text-lg font-bold text-red-900 mb-3">
                            <i class="fas fa-ambulance mr-2"></i>Accidents/Operations
                        </h3>
                        <p class="text-red-800 leading-relaxed">{{ $examination->accidents_operations ?? 'None reported' }}</p>
                    </div>
                    <div class="bg-amber-50 rounded-xl p-6 border-l-4 border-amber-600">
                        <h3 class="text-lg font-bold text-amber-900 mb-3">
                            <i class="fas fa-clipboard-list mr-2"></i>Past Medical History
                        </h3>
                        <p class="text-amber-800 leading-relaxed">{{ $examination->past_medical_history ?? 'No major medical issues' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Family History & Personal Habits -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-emerald-700 border-l-4 border-emerald-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-users mr-3"></i>Family History & Personal Habits
                </h2>
                <p class="text-emerald-100 mt-1">Hereditary conditions and lifestyle factors</p>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Family History -->
                    <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-600">
                        <h3 class="text-lg font-bold text-blue-900 mb-4">
                            <i class="fas fa-dna mr-2"></i>Family History
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @if($examination->family_history && count($examination->family_history) > 0)
                                @foreach($examination->family_history as $condition)
                                    <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-blue-600 text-white">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ $condition }}
                                    </span>
                                @endforeach
                            @else
                                <div class="text-center w-full py-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-check text-blue-600"></i>
                                    </div>
                                    <p class="text-blue-800 font-medium">No family history recorded</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Personal Habits -->
                    <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-600">
                        <h3 class="text-lg font-bold text-green-900 mb-4">
                            <i class="fas fa-leaf mr-2"></i>Personal Habits
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @if($examination->personal_habits && count($examination->personal_habits) > 0)
                                @foreach($examination->personal_habits as $habit)
                                    <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-green-600 text-white">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        {{ $habit }}
                                    </span>
                                @endforeach
                            @else
                                <div class="text-center w-full py-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-check text-green-600"></i>
                                    </div>
                                    <p class="text-green-800 font-medium">No personal habits recorded</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Physical Examination & Laboratory Results -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-teal-600 to-teal-700 border-l-4 border-teal-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-stethoscope mr-3"></i>Physical Examination & Laboratory Results
                </h2>
                <p class="text-teal-100 mt-1">Clinical examination findings and test results</p>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Physical Examination -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-eye mr-2 text-teal-600"></i>Physical Examination
                        </h3>
                        <div class="space-y-4">
                            <div class="bg-teal-50 rounded-xl p-4 border-l-4 border-teal-600">
                                <h4 class="font-semibold text-teal-900 mb-2">Visual Acuity</h4>
                                <p class="text-teal-800">{{ $examination->visual ?? 'Not tested' }}</p>
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 border-l-4 border-blue-600">
                                <h4 class="font-semibold text-blue-900 mb-2">Ishihara Test</h4>
                                <p class="text-blue-800">{{ $examination->ishihara_test ?? 'Not tested' }}</p>
                            </div>
                            <div class="bg-purple-50 rounded-xl p-4 border-l-4 border-purple-600">
                                <h4 class="font-semibold text-purple-900 mb-2">Skin Marks</h4>
                                <p class="text-purple-800">{{ $examination->skin_marks ?? 'None' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Laboratory Results -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-flask mr-2 text-teal-600"></i>Laboratory Results
                        </h3>
                        <div class="space-y-4">
                            <div class="bg-red-50 rounded-xl p-4 border-l-4 border-red-600">
                                <h4 class="font-semibold text-red-900 mb-2">ECG</h4>
                                <p class="text-red-800">{{ $examination->ecg ?? 'Not performed' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Final Findings -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-amber-600 to-amber-700 border-l-4 border-amber-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-clipboard-check mr-3"></i>Final Findings
                </h2>
                <p class="text-amber-100 mt-1">Overall examination conclusions and employment fitness assessment</p>
            </div>
            <div class="p-8">
                <div class="bg-amber-50 rounded-xl p-6 border-l-4 border-amber-600">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-amber-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-notes-medical text-white text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-amber-900 mb-3">Employment Fitness Assessment</h3>
                            <p class="text-amber-800 leading-relaxed">{{ $examination->findings ?? 'No findings recorded' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Footer -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-gray-600 to-gray-700 border-l-4 border-gray-800">
                <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-certificate mr-3"></i>Report Information
                </h2>
                <p class="text-gray-100 mt-1">Official pre-employment medical report certification and details</p>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-600">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-hospital text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-blue-900">Generated By</h3>
                                <p class="text-blue-700 text-sm">RSS Citi Health Services</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-600">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-check text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-green-900">Sent On</h3>
                                <p class="text-green-700 text-sm">{{ $examination->updated_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-emerald-50 rounded-xl p-6 border-l-4 border-emerald-600">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-check-circle text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-emerald-900">Status</h3>
                                <p class="text-emerald-700 text-sm font-semibold">Sent to Company</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Employment Notice -->
                <div class="mt-8 bg-orange-50 rounded-xl p-6 border-l-4 border-orange-600">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0 mt-1">
                            <i class="fas fa-briefcase text-white text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-orange-900 mb-2">Pre-Employment Medical Report</h4>
                            <p class="text-orange-800 text-sm leading-relaxed">
                                This pre-employment medical examination report is confidential and intended solely for employment screening purposes. 
                                The results are valid for the specific job position and company mentioned above. 
                                Any unauthorized disclosure, reproduction, or distribution of this document is strictly prohibited. 
                                For questions regarding this report, please contact RSS Citi Health Services directly.
                            </p>
                        </div>
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
