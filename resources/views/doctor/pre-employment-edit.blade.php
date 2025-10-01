@extends('layouts.doctor')

@section('title', 'Edit Pre-Employment Examination')
@section('page-title', 'Edit Pre-Employment Examination')
@section('page-description', 'Update and manage employment medical screening results')

@section('content')
<div class="space-y-8">
    
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500">
        <div class="px-8 py-6 bg-gradient-to-r from-green-500 to-green-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-white font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="text-green-200 hover:text-white transition-colors duration-200" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-600">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2">
                        <i class="fas fa-briefcase mr-3"></i>Pre-Employment Medical Examination
                    </h1>
                    <p class="text-blue-100">Employment medical screening and health assessment certificate</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-800 bg-opacity-50 rounded-lg px-4 py-2 border border-blue-500">
                        <p class="text-blue-200 text-sm font-medium">Exam ID</p>
                        <p class="text-white text-lg font-bold">#{{ $preEmployment->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Form Container -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Applicant Information Section -->
        @if($preEmployment->preEmploymentRecord)
        <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-green-700 border-l-4 border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-user-tie mr-3"></i>Applicant Information
                    </h2>
                    <p class="text-green-100 mt-1">Job applicant details and company information</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 bg-green-50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Full Name</label>
                    <div class="text-lg font-bold text-blue-800">{{ $preEmployment->preEmploymentRecord->full_name ?? ($preEmployment->preEmploymentRecord->first_name . ' ' . $preEmployment->preEmploymentRecord->last_name) }}</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-green-500 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Age</label>
                    <div class="text-lg font-bold text-green-800">{{ $preEmployment->preEmploymentRecord->age }} years</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-indigo-500 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Sex</label>
                    <div class="text-lg font-bold text-indigo-800">{{ $preEmployment->preEmploymentRecord->sex }}</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-yellow-500 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Company</label>
                    <div class="text-sm font-semibold text-yellow-800 truncate">{{ $preEmployment->preEmploymentRecord->company_name }}</div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Form Section -->
        <div class="p-8">
            <form action="{{ route('doctor.pre-employment.update', $preEmployment->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PATCH')
                
                <!-- Medical History Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
                        <div class="flex items-center">
                            <i class="fas fa-notes-medical text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white">Medical History Review</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-green-50">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-hospital mr-2 text-green-600"></i>Illness / Hospitalization
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 min-h-[4rem] text-sm text-gray-700">
                                {{ $preEmployment->illness_history ?: 'No illness or hospitalization history recorded' }}
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user-injured mr-2 text-orange-600"></i>Accidents / Operations
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 min-h-[4rem] text-sm text-gray-700">
                                {{ $preEmployment->accidents_operations ?: 'No accidents or surgical operations recorded' }}
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clipboard-list mr-2 text-blue-600"></i>Past Medical History
                            </label>
                            <textarea name="past_medical_history" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 min-h-[4rem] text-sm text-gray-700" placeholder="Enter past medical conditions">{{ old('past_medical_history', $preEmployment->past_medical_history) }}</textarea>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-gray-700 mb-4">
                            <i class="fas fa-users mr-2 text-purple-600"></i>Family Medical History
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @php
                                $family = is_array($preEmployment->family_history) ? $preEmployment->family_history : [];
                                $options = ['asthma','arthritis','migraine','diabetes','heart_disease','tuberculosis','allergies','anemia','cancer','insanity','hypertension','epilepsy'];
                            @endphp
                            @foreach($options as $opt)
                                @php
                                    $isChecked = is_array($family) && in_array($opt, $family, true);
                                @endphp
                                <label class="inline-flex items-center p-3 rounded-lg border transition-colors duration-200 {{ $isChecked ? 'bg-green-100 border-green-300 text-green-800' : 'bg-gray-50 border-gray-200 text-gray-600' }}">
                                    <input type="checkbox" name="family_history[]" value="{{ $opt }}" class="mr-3 text-green-600 focus:ring-green-500" {{ $isChecked ? 'checked' : '' }}>
                                    <span class="text-sm font-medium">{{ str_replace('_', ' ', ucwords($opt)) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Personal History Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                        <div class="flex items-center">
                            <i class="fas fa-user-check text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white">Personal History & Habits</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-blue-50">
                    
                    <div class="bg-white rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @php
                                // Ensure $habits is an array and properly decoded if it's a JSON string
                                $habits = [];
                                if (isset($preEmployment->personal_habits)) {
                                    if (is_string($preEmployment->personal_habits)) {
                                        $habits = json_decode($preEmployment->personal_habits, true) ?? [];
                                    } elseif (is_array($preEmployment->personal_habits)) {
                                        $habits = $preEmployment->personal_habits;
                                    }
                                }
                                
                                $habitOptions = [
                                    'alcohol' => ['icon' => 'fas fa-wine-bottle', 'color' => 'red'],
                                    'cigarettes' => ['icon' => 'fas fa-smoking', 'color' => 'orange'],
                                    'coffee_tea' => ['icon' => 'fas fa-coffee', 'color' => 'amber']
                                ];
                            @endphp
                            @foreach($habitOptions as $habit => $config)
                                @php
                                    $hasHabit = is_array($habits) && array_key_exists($habit, $habits) && $habits[$habit];
                                @endphp
                                <label class="flex items-center p-4 rounded-lg border transition-colors duration-200 {{ $hasHabit ? 'bg-blue-100 border-blue-300' : 'bg-gray-50 border-gray-200' }}">
                                    <input type="hidden" name="personal_habits[{{ $habit }}]" value="0">
                                    <input type="checkbox" name="personal_habits[{{ $habit }}]" value="1" class="hidden" {{ $hasHabit ? 'checked' : '' }}>
                                    <span class="flex items-center">
                                        <i class="{{ $config['icon'] }} text-{{ $config['color'] }}-600 mr-3"></i>
                                        <span class="text-sm font-medium text-gray-700 mr-3">{{ str_replace('_', ' ', ucwords($habit)) }}</span>
                                        <i class="fas {{ $hasHabit ? 'fa-check-circle text-green-600' : 'fa-times-circle text-gray-400' }}"></i>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Physical Examination Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-yellow-500">
                    <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600">
                        <div class="flex items-center">
                            <i class="fas fa-stethoscope text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white">Physical Examination Results</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-yellow-50">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @php 
                            $phys = $preEmployment->physical_exam ?? [];
                            $vitals = [
                                'temp' => ['label' => 'Temperature', 'icon' => 'fas fa-thermometer-half', 'unit' => '°C', 'color' => 'red'],
                                'height' => ['label' => 'Height', 'icon' => 'fas fa-ruler-vertical', 'unit' => 'cm', 'color' => 'blue'],
                                'heart_rate' => ['label' => 'Heart Rate', 'icon' => 'fas fa-heartbeat', 'unit' => 'bpm', 'color' => 'pink'],
                                'weight' => ['label' => 'Weight', 'icon' => 'fas fa-weight', 'unit' => 'kg', 'color' => 'green']
                            ];
                        @endphp
                        @foreach($vitals as $key => $vital)
                            <div class="bg-white rounded-lg p-4 border-l-4 border-{{ $vital['color'] }}-500">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="{{ $vital['icon'] }} text-{{ $vital['color'] }}-600 mr-2"></i>{{ $vital['label'] }}
                                </label>
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                    {{ $phys[$key] ?? 'Not recorded' }}
                                    @if(isset($phys[$key]) && $phys[$key])
                                        <span class="text-xs text-gray-500 ml-1">{{ $vital['unit'] }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    </div>
                </div>
                <!-- Skin Identification Marks Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-pink-500">
                    <div class="px-6 py-4 bg-gradient-to-r from-pink-500 to-pink-600">
                        <div class="flex items-center">
                            <i class="fas fa-search text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white">Skin Identification Marks</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-pink-50">
                    
                    <div class="bg-white rounded-lg p-4">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-sm text-gray-700 min-h-[4rem]">
                            {{ $preEmployment->skin_marks ?: 'No identifying marks, scars, or tattoos recorded' }}
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Visual Assessment & Findings Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-indigo-500">
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600">
                        <div class="flex items-center">
                            <i class="fas fa-eye text-white text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-white">Visual Assessment & General Findings</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-indigo-50">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-glasses mr-2 text-blue-600"></i>Visual Acuity
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                {{ $preEmployment->visual ?: 'Visual acuity not tested' }}
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-l-4 border-green-500">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-palette mr-2 text-green-600"></i>Ishihara Test
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                {{ $preEmployment->ishihara_test ?: 'Color vision test not performed' }}
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-l-4 border-purple-500">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clipboard-check mr-2 text-purple-600"></i>General Findings
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                {{ $preEmployment->findings ?: 'No significant findings recorded' }}
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Laboratory Examination Report Section -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-gray-500">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-flask text-gray-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-gray-800">Laboratory Examination Report</h3>
                    </div>
                    
                    @php
                        $lab = $preEmployment->lab_report ?? [];
                        $labFields = [
                            'urinalysis' => ['icon' => 'fas fa-vial', 'color' => 'yellow'],
                            'cbc' => ['icon' => 'fas fa-tint', 'color' => 'red'],
                            'xray' => ['icon' => 'fas fa-x-ray', 'color' => 'gray'],
                            'fecalysis' => ['icon' => 'fas fa-microscope', 'color' => 'brown'],
                            'blood_chemistry' => ['icon' => 'fas fa-heartbeat', 'color' => 'pink'],
                            'others' => ['icon' => 'fas fa-plus-circle', 'color' => 'indigo']
                        ];
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        @foreach($labFields as $field => $config)
                            <div class="bg-white rounded-lg p-4 border-l-4 border-{{ $config['color'] }}-500">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="{{ $config['icon'] }} text-{{ $config['color'] }}-600 mr-2"></i>{{ str_replace('_', ' ', ucwords($field)) }}
                                </label>
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                    {{ data_get($lab, $field, 'Test not performed') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Additional Laboratory Tests -->
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-700 mb-4">
                            <i class="fas fa-plus-square text-teal-600 mr-2"></i>Additional Laboratory Tests
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-orange-500">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-shield-virus text-orange-600 mr-2"></i>HBsAg Screening
                                </label>
                                <div class="bg-white p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                    {{ data_get($lab, 'hbsag_screening', 'Screening not performed') }}
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-purple-500">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-virus text-purple-600 mr-2"></i>HEPA A IGG & IGM
                                </label>
                                <div class="bg-white p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                    {{ data_get($lab, 'hepa_a_igg_igm', 'Test not performed') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Physical Findings Section -->
                <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-500">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-user-md text-blue-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-blue-800">Physical Examination Findings</h3>
                    </div>
                    
                    @php
                        $physicalRows = [
                            'Neck' => ['icon' => 'fas fa-head-side-cough', 'color' => 'blue'],
                            'Chest-Breast Axilla' => ['icon' => 'fas fa-lungs', 'color' => 'green'],
                            'Lungs' => ['icon' => 'fas fa-lungs-virus', 'color' => 'teal'],
                            'Heart' => ['icon' => 'fas fa-heartbeat', 'color' => 'red'],
                            'Abdomen' => ['icon' => 'fas fa-stomach', 'color' => 'orange'],
                            'Extremities' => ['icon' => 'fas fa-hand-paper', 'color' => 'purple'],
                            'Anus-Rectum' => ['icon' => 'fas fa-circle', 'color' => 'gray'],
                            'GUT' => ['icon' => 'fas fa-pills', 'color' => 'yellow'],
                            'Inguinal / Genital' => ['icon' => 'fas fa-user-circle', 'color' => 'pink']
                        ];
                    @endphp
                    
                    <div class="space-y-4">
                        @foreach($physicalRows as $row => $config)
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                <div class="flex items-center">
                                    <i class="{{ $config['icon'] }} text-{{ $config['color'] }}-600 mr-3"></i>
                                    <span class="font-semibold text-gray-700">{{ $row }}</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Result</label>
                                    <input type="text" name="physical_findings[{{ $row }}][result]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" value="{{ old('physical_findings.'.$row.'.result', data_get($preEmployment->physical_findings, $row.'.result', '')) }}" placeholder="Enter result">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Findings</label>
                                    <input type="text" name="physical_findings[{{ $row }}][findings]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" value="{{ old('physical_findings.'.$row.'.findings', data_get($preEmployment->physical_findings, $row.'.findings', '')) }}" placeholder="Enter findings">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Laboratory Test Results Section (Read-only) -->
                <!-- Laboratory Test Results Section (Read-only) -->
                <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-microscope text-green-600 text-xl mr-3"></i>
                            <h3 class="text-lg font-bold text-green-800">Laboratory Test Results</h3>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                            <i class="fas fa-lock mr-1"></i> Staff Entry
                        </span>
                    </div>
                    
                    @php
                        $labRows = [
                            'Chest X-Ray' => ['icon' => 'fas fa-x-ray', 'color' => 'gray', 'key' => 'xray'],
                            'Urinalysis' => ['icon' => 'fas fa-vial', 'color' => 'yellow', 'key' => 'urinalysis'],
                            'Fecalysis' => ['icon' => 'fas fa-microscope', 'color' => 'brown', 'key' => 'fecalysis'],
                            'CBC' => ['icon' => 'fas fa-tint', 'color' => 'red', 'key' => 'cbc'],
                            'Drug Test' => ['icon' => 'fas fa-pills', 'color' => 'orange', 'key' => 'drug_test'],
                            'HBsAg Screening' => ['icon' => 'fas fa-shield-virus', 'color' => 'purple', 'key' => 'hbsag_screening'],
                            'HEPA A IGG & IGM' => ['icon' => 'fas fa-virus', 'color' => 'pink', 'key' => 'hepa_a_igg_igm'],
                            'Others' => ['icon' => 'fas fa-plus-circle', 'color' => 'indigo', 'key' => 'others']
                        ];
                    @endphp
                    
                    <div class="space-y-4">
                        @foreach($labRows as $row => $config)
                            @php
                                $testKey = $config['key'];
                                $findingsKey = $testKey . '_findings';
                                $result = data_get($preEmployment->lab_report, $testKey, null);
                                $findings = data_get($preEmployment->lab_report, $findingsKey, null);
                            @endphp
                            
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <div class="flex items-center">
                                        <i class="{{ $config['icon'] }} text-{{ $config['color'] }}-600 mr-3"></i>
                                        <span class="font-semibold text-gray-700">{{ $row }}</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Result</label>
                                        <div class="p-2 bg-gray-50 rounded border border-gray-200 text-sm text-gray-700 min-h-[2.5rem]">
                                            {{ $result ?? 'Not recorded' }}
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Findings</label>
                                        <div class="p-2 bg-gray-50 rounded border border-gray-200 text-sm text-gray-700 min-h-[2.5rem]">
                                            {{ $findings ?? 'No findings' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- ECG Section -->
                <div class="bg-red-50 rounded-xl p-6 border-l-4 border-red-500">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-heartbeat text-red-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-red-800">Electrocardiogram (ECG)</h3>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-chart-line text-red-600 mr-2"></i>ECG Results
                        </label>
                        <input type="text" name="ecg" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" value="{{ old('ecg', $preEmployment->ecg ?? '') }}" placeholder="Enter ECG findings and interpretation">
                    </div>
                </div>
                
                <!-- Physician Signature & Submit Section -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-gray-500">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                <i class="fas fa-user-md text-gray-600 mr-3"></i>Physician Authorization
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Complete employment medical screening and authorize certificate</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                        <div class="bg-white rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-signature text-gray-600 mr-2"></i>Physician's Signature
                            </label>
                            <div class="border-b-2 border-gray-300 pb-4">
                                <p class="text-xs text-gray-500">Digital signature will be applied upon submission</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-save mr-3"></i>
                                Save Medical Certificate
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

