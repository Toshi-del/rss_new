@extends('layouts.company')

@section('title', 'Pre-Employment Examination Results')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Modern Header Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="relative px-8 py-8 bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600">
                <!-- Decorative background elements -->
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24"></div>
                
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('company.medical-results', ['status' => 'sent_results']) }}" 
                           class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white rounded-xl text-sm font-semibold hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-300 shadow-lg border border-white/20">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Results
                        </a>
                        <div>
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-briefcase text-white text-xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                                        Pre-Employment Medical Report
                                    </h1>
                                    <p class="text-emerald-100 text-lg">Complete examination results and billing summary</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl px-6 py-4 border border-white/20">
                            <p class="text-emerald-100 text-sm font-medium">Report Status</p>
                            <div class="flex items-center mt-1">
                                <div class="w-2 h-2 bg-green-300 rounded-full mr-2 animate-pulse"></div>
                                <p class="text-white text-lg font-bold">Completed & Sent</p>
                            </div>
                        </div>
                        <button onclick="window.print()" class="inline-flex items-center px-6 py-4 bg-white text-emerald-600 rounded-xl text-sm font-bold hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-300 shadow-lg no-print">
                            <i class="fas fa-print mr-2"></i>
                            Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Message -->
        @if(session('info'))
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-blue-100">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-info-circle text-white text-lg"></i>
                    </div>
                    <span class="text-white font-semibold text-lg">{{ session('info') }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Billing Summary & Applicant Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Billing Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 h-full">
                    <div class="px-6 py-6 bg-gradient-to-r from-emerald-600 to-green-600">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-receipt text-white text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Billing Summary</h2>
                                <p class="text-emerald-100">Medical examination costs</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        @php
                            $totalAmount = 0;
                            $selectedTests = [];
                            
                            // Get tests from the new pivot table system
                            if ($examination->preEmploymentRecord && $examination->preEmploymentRecord->preEmploymentMedicalTests->count() > 0) {
                                foreach ($examination->preEmploymentRecord->preEmploymentMedicalTests as $pivotTest) {
                                    if ($pivotTest->medicalTest) {
                                        $selectedTests[] = [
                                            'category' => $pivotTest->medicalTestCategory->name ?? 'Unknown Category',
                                            'test' => $pivotTest->medicalTest->name,
                                            'price' => $pivotTest->medicalTest->price ?? 0
                                        ];
                                        $totalAmount += $pivotTest->medicalTest->price ?? 0;
                                    }
                                }
                            }
                            
                            // Fallback to old system if no pivot tests found
                            if (empty($selectedTests) && $examination->preEmploymentRecord) {
                                if ($examination->preEmploymentRecord->medicalTest) {
                                    $selectedTests[] = [
                                        'category' => $examination->preEmploymentRecord->medicalTestCategory->name ?? 'Unknown Category',
                                        'test' => $examination->preEmploymentRecord->medicalTest->name,
                                        'price' => $examination->preEmploymentRecord->medicalTest->price ?? 0
                                    ];
                                    $totalAmount += $examination->preEmploymentRecord->medicalTest->price ?? 0;
                                }
                                
                                // Add other exams if they exist
                                $parsedOtherExams = $examination->preEmploymentRecord->parsed_other_exams ?? null;
                                if ($parsedOtherExams && isset($parsedOtherExams['selected_tests'])) {
                                    foreach ($parsedOtherExams['selected_tests'] as $test) {
                                        if (isset($test['test_name']) && $test['test_name'] !== $examination->preEmploymentRecord->medicalTest->name) {
                                            $selectedTests[] = [
                                                'category' => $test['category_name'] ?? 'Additional Tests',
                                                'test' => $test['test_name'],
                                                'price' => $test['price'] ?? 0
                                            ];
                                            $totalAmount += $test['price'] ?? 0;
                                        }
                                    }
                                }
                            }
                            
                            // Use stored total_price if available and different
                            if ($examination->preEmploymentRecord && $examination->preEmploymentRecord->total_price > 0) {
                                $totalAmount = $examination->preEmploymentRecord->total_price;
                            }
                        @endphp
                        
                        <div class="space-y-4">
                            @if(!empty($selectedTests))
                                @foreach($selectedTests as $test)
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $test['test'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $test['category'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-emerald-600">₱{{ number_format($test['price'], 2) }}</p>
                                    </div>
                                </div>
                                @endforeach
                                
                                <div class="pt-4 border-t-2 border-emerald-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-lg font-bold text-gray-900">Total Amount</p>
                                            <p class="text-sm text-gray-500">All medical examinations</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-emerald-600">₱{{ number_format($totalAmount, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($examination->preEmploymentRecord && $examination->preEmploymentRecord->billing_type)
                                <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-credit-card text-blue-600 mr-2"></i>
                                        <div>
                                            <p class="font-semibold text-blue-900">Billing Type</p>
                                            <p class="text-blue-700 capitalize">{{ $examination->preEmploymentRecord->billing_type }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-receipt text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No billing information available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applicant Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 h-full">
                    <div class="px-6 py-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-user-tie text-white text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Applicant Information</h2>
                                <p class="text-blue-100">Pre-employment examination details</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Applicant Details -->
                            <div class="space-y-6">
                                <div class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <span class="text-white font-bold text-xl">
                                            {{ strtoupper(substr($examination->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $examination->name }}</h3>
                                        <p class="text-blue-600 font-medium">Job Applicant</p>
                                        @if($examination->preEmploymentRecord)
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $examination->preEmploymentRecord->age }} years old • {{ ucfirst($examination->preEmploymentRecord->sex) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($examination->preEmploymentRecord && $examination->preEmploymentRecord->email)
                                <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                    <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Email Address</p>
                                        <p class="text-gray-900 font-semibold">{{ $examination->preEmploymentRecord->email }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                @if($examination->preEmploymentRecord && $examination->preEmploymentRecord->phone_number)
                                <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Phone Number</p>
                                        <p class="text-gray-900 font-semibold">{{ $examination->preEmploymentRecord->phone_number }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Company & Date Details -->
                            <div class="space-y-6">
                                <div class="flex items-center p-4 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-100">
                                    <div class="w-12 h-12 bg-gradient-to-r from-emerald-600 to-green-600 rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-building text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Company</p>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $examination->company_name }}</h3>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-100">
                                    <div class="w-12 h-12 bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-calendar text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Examination Date</p>
                                        <h3 class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($examination->date)->format('M d, Y') }}</h3>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-100">
                                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-clock text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Report Sent</p>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $examination->updated_at->format('M d, Y g:i A') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical History Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                            Medical History
                        </h2>
                        <p class="text-indigo-100 mt-1">Applicant's medical background and history</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-6 border border-indigo-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-notes-medical text-white"></i>
                            </div>
                            <h3 class="text-lg font-bold text-indigo-900">Illness History</h3>
                        </div>
                        <p class="text-indigo-800 leading-relaxed">{{ $examination->illness_history ?? 'Not specified' }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-6 border border-red-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-ambulance text-white"></i>
                            </div>
                            <h3 class="text-lg font-bold text-red-900">Accidents/Operations</h3>
                        </div>
                        <p class="text-red-800 leading-relaxed">{{ $examination->accidents_operations ?? 'None reported' }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-amber-600 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-clipboard-list text-white"></i>
                            </div>
                            <h3 class="text-lg font-bold text-amber-900">Past Medical History</h3>
                        </div>
                        <p class="text-amber-800 leading-relaxed">{{ $examination->past_medical_history ?? 'No major medical issues' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Family History & Personal Habits -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-teal-600">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                            Family History & Personal Habits
                        </h2>
                        <p class="text-emerald-100 mt-1">Hereditary conditions and lifestyle factors</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Family History -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-dna text-white text-lg"></i>
                            </div>
                            <h3 class="text-xl font-bold text-blue-900">Family History</h3>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @if($examination->family_history && count($examination->family_history) > 0)
                                @foreach($examination->family_history as $condition)
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-blue-600 text-white shadow-sm hover:bg-blue-700 transition-colors duration-200">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        {{ $condition }}
                                    </span>
                                @endforeach
                            @else
                                <div class="text-center w-full py-8">
                                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-check text-blue-600 text-xl"></i>
                                    </div>
                                    <p class="text-blue-800 font-semibold text-lg">No family history recorded</p>
                                    <p class="text-blue-600 text-sm mt-1">Clean family medical history</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Personal Habits -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-leaf text-white text-lg"></i>
                            </div>
                            <h3 class="text-xl font-bold text-green-900">Personal Habits</h3>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @if($examination->personal_habits && count($examination->personal_habits) > 0)
                                @foreach($examination->personal_habits as $habit)
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-green-600 text-white shadow-sm hover:bg-green-700 transition-colors duration-200">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        {{ $habit }}
                                    </span>
                                @endforeach
                            @else
                                <div class="text-center w-full py-8">
                                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-check text-green-600 text-xl"></i>
                                    </div>
                                    <p class="text-green-800 font-semibold text-lg">No personal habits recorded</p>
                                    <p class="text-green-600 text-sm mt-1">Healthy lifestyle indicated</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Physical Examination & Laboratory Results -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 bg-gradient-to-r from-teal-600 to-cyan-600">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-stethoscope text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                            Physical Examination & Laboratory Results
                        </h2>
                        <p class="text-teal-100 mt-1">Clinical examination findings and test results</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Physical Examination -->
                    <div class="space-y-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-eye text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Physical Examination</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-2xl p-6 border border-teal-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-eye text-white text-sm"></i>
                                    </div>
                                    <h4 class="font-bold text-teal-900">Visual Acuity</h4>
                                </div>
                                <p class="text-teal-800 font-medium">{{ $examination->visual ?? 'Not tested' }}</p>
                            </div>
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-palette text-white text-sm"></i>
                                    </div>
                                    <h4 class="font-bold text-blue-900">Ishihara Test</h4>
                                </div>
                                <p class="text-blue-800 font-medium">{{ $examination->ishihara_test ?? 'Not tested' }}</p>
                            </div>
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-hand-paper text-white text-sm"></i>
                                    </div>
                                    <h4 class="font-bold text-purple-900">Skin Marks</h4>
                                </div>
                                <p class="text-purple-800 font-medium">{{ $examination->skin_marks ?? 'None' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Laboratory Results -->
                    <div class="space-y-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-flask text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Laboratory Results</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-2xl p-6 border border-red-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-heartbeat text-white text-sm"></i>
                                    </div>
                                    <h4 class="font-bold text-red-900">ECG Results</h4>
                                </div>
                                <p class="text-red-800 font-medium">{{ $examination->ecg ?? 'Not performed' }}</p>
                            </div>
                            
                            @if($examination->lab_report && is_array($examination->lab_report))
                                @foreach($examination->lab_report as $key => $value)
                                    @if($value && $value !== 'Not available')
                                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-2xl p-6 border border-emerald-100 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center mb-3">
                                            <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-vial text-white text-sm"></i>
                                            </div>
                                            <h4 class="font-bold text-emerald-900">{{ ucwords(str_replace('_', ' ', $key)) }}</h4>
                                        </div>
                                        <p class="text-emerald-800 font-medium">{{ $value }}</p>
                                    </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Final Findings -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 bg-gradient-to-r from-amber-600 to-orange-600">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-clipboard-check text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                            Final Findings
                        </h2>
                        <p class="text-amber-100 mt-1">Overall examination conclusions and employment fitness assessment</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-8 border border-amber-100 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start">
                        <div class="w-16 h-16 bg-gradient-to-r from-amber-600 to-orange-600 rounded-2xl flex items-center justify-center mr-6 flex-shrink-0">
                            <i class="fas fa-notes-medical text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-amber-900 mb-4">Employment Fitness Assessment</h3>
                            <div class="prose prose-amber max-w-none">
                                <p class="text-amber-800 leading-relaxed text-lg font-medium">{{ $examination->findings ?? 'No findings recorded' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Footer -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 bg-gradient-to-r from-slate-700 to-gray-800">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-certificate text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                            Report Information
                        </h2>
                        <p class="text-gray-100 mt-1">Official pre-employment medical report certification and details</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mr-4">
                                <i class="fas fa-hospital text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-blue-900">Generated By</h3>
                                <p class="text-blue-700 font-semibold">RSS Citi Health Services</p>
                                <p class="text-blue-600 text-sm">Certified Medical Center</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-check text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-green-900">Report Sent</h3>
                                <p class="text-green-700 font-semibold">{{ $examination->updated_at->format('M d, Y') }}</p>
                                <p class="text-green-600 text-sm">{{ $examination->updated_at->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl flex items-center justify-center mr-4">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-emerald-900">Report Status</h3>
                                <p class="text-emerald-700 font-semibold">Completed</p>
                                <p class="text-emerald-600 text-sm">Sent to Company</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Employment Notice -->
                <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl p-8 border border-orange-200">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-600 to-amber-600 rounded-2xl flex items-center justify-center mr-6 flex-shrink-0">
                            <i class="fas fa-shield-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-orange-900 mb-4">Confidential Medical Report</h4>
                            <div class="prose prose-orange max-w-none">
                                <p class="text-orange-800 leading-relaxed font-medium">
                                    This pre-employment medical examination report is <strong>confidential</strong> and intended solely for employment screening purposes. 
                                    The results are valid for the specific job position and company mentioned above.
                                </p>
                                <p class="text-orange-700 leading-relaxed mt-4">
                                    Any unauthorized disclosure, reproduction, or distribution of this document is strictly prohibited. 
                                    For questions regarding this report, please contact <strong>RSS Citi Health Services</strong> directly.
                                </p>
                            </div>
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
    
    /* Print-specific styles for better readability */
    body {
        background: white !important;
    }
    
    .bg-gradient-to-br,
    .bg-gradient-to-r {
        background: #f8fafc !important;
        color: #1f2937 !important;
    }
    
    .shadow-xl,
    .shadow-lg {
        box-shadow: none !important;
        border: 1px solid #e5e7eb !important;
    }
    
    .text-white {
        color: #1f2937 !important;
    }
    
    .rounded-2xl,
    .rounded-xl {
        border-radius: 8px !important;
    }
    
    /* Ensure proper page breaks */
    .bg-white {
        page-break-inside: avoid;
        margin-bottom: 1rem;
    }
}

/* Enhanced animations and transitions */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bg-white {
    animation: fadeInUp 0.6s ease-out;
}

.bg-white:nth-child(2) { animation-delay: 0.1s; }
.bg-white:nth-child(3) { animation-delay: 0.2s; }
.bg-white:nth-child(4) { animation-delay: 0.3s; }
.bg-white:nth-child(5) { animation-delay: 0.4s; }
.bg-white:nth-child(6) { animation-delay: 0.5s; }

/* Glass morphism effect */
.glass-morphism {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

/* Hover effects */
.hover\:shadow-lg:hover {
    transform: translateY(-2px);
}

/* Custom scrollbar for better UX */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection
