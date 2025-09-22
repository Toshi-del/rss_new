@extends('layouts.doctor')

@section('title', 'Edit Annual Physical Examination')
@section('page-title', 'Edit Annual Physical Examination')
@section('page-description', 'Update and manage comprehensive health examination results')

@section('content')
<div class="space-y-8" style="font-family: 'Poppins', sans-serif;">
    
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-emerald-700">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-white text-xl mr-3"></i>
                <span class="text-white font-medium">{{ session('success') }}</span>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-emerald-600 to-emerald-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-file-medical mr-3"></i>Annual Physical Examination
                    </h1>
                    <p class="text-emerald-100">Comprehensive health assessment and medical evaluation</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-emerald-500 rounded-lg px-4 py-2">
                        <p class="text-emerald-100 text-sm font-medium">Patient ID</p>
                        <p class="text-white text-lg font-bold">#{{ $annualPhysical->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Form Container -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Patient Information Section -->
        @if($annualPhysical->patient)
        <div class="px-8 py-6 bg-gradient-to-r from-violet-600 to-violet-700 border-l-4 border-violet-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-user-injured mr-3"></i>Patient Information
                    </h2>
                    <p class="text-violet-100 mt-1">Basic patient details and contact information</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 bg-violet-50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-4 border-l-4 border-violet-600">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Patient Name</label>
                    <div class="text-lg font-bold text-violet-900">{{ $annualPhysical->patient->full_name }}</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-emerald-600">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Age</label>
                    <div class="text-lg font-bold text-emerald-900">{{ $annualPhysical->patient->age }} years</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-blue-600">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Sex</label>
                    <div class="text-lg font-bold text-blue-900">{{ $annualPhysical->patient->sex }}</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-orange-600">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Email</label>
                    <div class="text-sm font-semibold text-orange-900 truncate">{{ $annualPhysical->patient->email }}</div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Form Section -->
        <div class="p-8">
            <form action="{{ route('doctor.annual-physical.update', $annualPhysical->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PATCH')
                
                <!-- Medical History Section -->
                <div class="bg-emerald-50 rounded-xl p-6 border-l-4 border-emerald-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-notes-medical text-emerald-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-emerald-900" style="font-family: 'Poppins', sans-serif;">Medical History</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-hospital mr-2 text-emerald-600"></i>Illness / Hospitalization
                            </label>
                            <textarea name="illness_history" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Enter illness history or hospitalizations...">{{ old('illness_history', $annualPhysical->illness_history) }}</textarea>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user-injured mr-2 text-orange-600"></i>Accidents / Operations
                            </label>
                            <textarea name="accidents_operations" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Enter accidents or surgical operations...">{{ old('accidents_operations', $annualPhysical->accidents_operations) }}</textarea>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clipboard-list mr-2 text-blue-600"></i>Past Medical History
                            </label>
                            <textarea name="past_medical_history" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Enter past medical conditions...">{{ old('past_medical_history', $annualPhysical->past_medical_history) }}</textarea>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-4">
                            <i class="fas fa-users mr-2 text-violet-600"></i>Family Medical History
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @php
                                $family = $annualPhysical->family_history ?? [];
                                $options = ['asthma','arthritis','migraine','diabetes','heart_disease','tuberculosis','allergies','anemia','cancer','insanity','hypertension','epilepsy'];
                            @endphp
                            @foreach($options as $opt)
                                <label class="inline-flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-emerald-50 hover:border-emerald-300 cursor-pointer transition-colors duration-200">
                                    <input type="checkbox" name="family_history[]" value="{{ $opt }}" class="mr-3 text-emerald-600 focus:ring-emerald-500" {{ in_array($opt, $family ?? []) ? 'checked' : '' }}>
                                    <span class="text-sm font-medium text-gray-700">{{ str_replace('_', ' ', ucwords($opt)) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Personal History Section -->
                <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-user-check text-blue-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-blue-900" style="font-family: 'Poppins', sans-serif;">Personal History & Habits</h3>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @php
                                $habits = $annualPhysical->personal_habits ?? [];
                                $habitOptions = [
                                    'alcohol' => ['icon' => 'fas fa-wine-bottle', 'color' => 'red'],
                                    'cigarettes' => ['icon' => 'fas fa-smoking', 'color' => 'orange'],
                                    'coffee_tea' => ['icon' => 'fas fa-coffee', 'color' => 'amber']
                                ];
                            @endphp
                            @foreach($habitOptions as $habit => $config)
                                <label class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 cursor-pointer transition-colors duration-200">
                                    <input type="checkbox" name="personal_habits[]" value="{{ $habit }}" class="mr-4 text-blue-600 focus:ring-blue-500" {{ in_array($habit, $habits ?? []) ? 'checked' : '' }}>
                                    <i class="{{ $config['icon'] }} text-{{ $config['color'] }}-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">{{ str_replace('_', ' ', ucwords($habit)) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Physical Examination Section -->
                <div class="bg-orange-50 rounded-xl p-6 border-l-4 border-orange-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-stethoscope text-orange-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-orange-900" style="font-family: 'Poppins', sans-serif;">Physical Examination</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @php 
                            $phys = $annualPhysical->physical_exam ?? [];
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
                                <div class="relative">
                                    <input type="text" name="physical_exam[{{ $key }}]" class="w-full px-3 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" value="{{ old('physical_exam.'.$key, data_get($phys, $key, '')) }}" placeholder="Enter {{ strtolower($vital['label']) }}">
                                    <span class="absolute right-3 top-2 text-xs text-gray-500 font-medium">{{ $vital['unit'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Skin Identification Marks Section -->
                <div class="bg-pink-50 rounded-xl p-6 border-l-4 border-pink-600">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-search text-pink-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-pink-900" style="font-family: 'Poppins', sans-serif;">Skin Identification Marks</h3>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4">
                        <textarea name="skin_marks" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-sm" placeholder="Describe any visible scars, birthmarks, tattoos, or other identifying marks...">{{ old('skin_marks', $annualPhysical->skin_marks) }}</textarea>
                    </div>
                </div>
                <!-- Visual & Findings Section -->
                <div class="bg-indigo-50 rounded-xl p-6 border-l-4 border-indigo-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-eye text-indigo-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-indigo-900" style="font-family: 'Poppins', sans-serif;">Visual Assessment & Findings</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-glasses mr-2 text-blue-600"></i>Visual Acuity
                            </label>
                            <input type="text" name="visual" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="{{ old('visual', $annualPhysical->visual ?? '') }}" placeholder="e.g., 20/20, 20/40">
                        </div>
                        <div class="bg-white rounded-lg p-4 border-l-4 border-green-500">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-palette mr-2 text-green-600"></i>Ishihara Test
                            </label>
                            <input type="text" name="ishihara_test" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="{{ old('ishihara_test', $annualPhysical->ishihara_test ?? '') }}" placeholder="Color vision test results">
                        </div>
                        <div class="bg-white rounded-lg p-4 border-l-4 border-purple-500">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clipboard-check mr-2 text-purple-600"></i>General Findings
                            </label>
                            <input type="text" name="findings" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="{{ old('findings', $annualPhysical->findings ?? '') }}" placeholder="Overall examination findings">
                        </div>
                    </div>
                </div>
                <!-- Laboratory Examination Report Section -->
                <div class="bg-teal-50 rounded-xl p-6 border-l-4 border-teal-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-flask text-teal-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-teal-900" style="font-family: 'Poppins', sans-serif;">Laboratory Examination Report</h3>
                    </div>
                    
                    @php
                        $lab = $annualPhysical->lab_report ?? [];
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
                                    {{ data_get($lab, $field, 'Not available') }}
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
                                    {{ data_get($lab, 'hbsag_screening', 'Not available') }}
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-purple-500">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-virus text-purple-600 mr-2"></i>HEPA A IGG & IGM
                                </label>
                                <div class="bg-white p-3 rounded-lg border border-gray-200 text-sm text-gray-700">
                                    {{ data_get($lab, 'hepa_a_igg_igm', 'Not available') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Physical Findings Section -->
                <div class="bg-cyan-50 rounded-xl p-6 border-l-4 border-cyan-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-user-md text-cyan-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-cyan-900" style="font-family: 'Poppins', sans-serif;">Physical Examination Findings</h3>
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
                                    <input type="text" name="physical_findings[{{ $row }}][result]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-sm" value="{{ old('physical_findings.'.$row.'.result', data_get($annualPhysical->physical_findings, $row.'.result', '')) }}" placeholder="Enter result">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Findings</label>
                                    <input type="text" name="physical_findings[{{ $row }}][findings]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-sm" value="{{ old('physical_findings.'.$row.'.findings', data_get($annualPhysical->physical_findings, $row.'.findings', '')) }}" placeholder="Enter findings">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Laboratory Test Results Section -->
                <div class="bg-lime-50 rounded-xl p-6 border-l-4 border-lime-600">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-microscope text-lime-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-lime-900" style="font-family: 'Poppins', sans-serif;">Laboratory Test Results</h3>
                    </div>
                    
                    @php
                        $labRows = [
                            'Chest X-Ray' => ['icon' => 'fas fa-x-ray', 'color' => 'gray'],
                            'Urinalysis' => ['icon' => 'fas fa-vial', 'color' => 'yellow'],
                            'Fecalysis' => ['icon' => 'fas fa-microscope', 'color' => 'brown'],
                            'CBC' => ['icon' => 'fas fa-tint', 'color' => 'red'],
                            'Drug Test' => ['icon' => 'fas fa-pills', 'color' => 'orange'],
                            'HBsAg Screening' => ['icon' => 'fas fa-shield-virus', 'color' => 'purple'],
                            'HEPA A IGG & IGM' => ['icon' => 'fas fa-virus', 'color' => 'pink'],
                            'Others' => ['icon' => 'fas fa-plus-circle', 'color' => 'indigo']
                        ];
                    @endphp
                    
                    <div class="space-y-4">
                        @foreach($labRows as $row => $config)
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                <div class="flex items-center">
                                    <i class="{{ $config['icon'] }} text-{{ $config['color'] }}-600 mr-3"></i>
                                    <span class="font-semibold text-gray-700">{{ $row }}</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Result</label>
                                    @php
                                        $testKey = strtolower(str_replace([' ', '-', '&'], ['_', '_', '_'], $row));
                                        $testKey = str_replace('chest_x_ray', 'xray', $testKey);
                                        $testKey = str_replace('hepa_a_igg___igm', 'hepa_a_igg_igm', $testKey);
                                    @endphp
                                    <input type="text" name="lab_report[{{ $testKey }}]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 text-sm" value="{{ old('lab_report.'.$testKey, data_get($annualPhysical->lab_report, $testKey, '')) }}" placeholder="Enter test result">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Findings</label>
                                    @php
                                        $findingsKey = $testKey . '_findings';
                                    @endphp
                                    <input type="text" name="lab_report[{{ $findingsKey }}]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 text-sm" value="{{ old('lab_report.'.$findingsKey, data_get($annualPhysical->lab_report, $findingsKey, '')) }}" placeholder="Enter findings">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- ECG Section -->
                <div class="bg-red-50 rounded-xl p-6 border-l-4 border-red-600">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-heartbeat text-red-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-red-900" style="font-family: 'Poppins', sans-serif;">Electrocardiogram (ECG)</h3>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-chart-line text-red-600 mr-2"></i>ECG Results
                        </label>
                        <input type="text" name="ecg" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" value="{{ old('ecg', $annualPhysical->ecg ?? '') }}" placeholder="Enter ECG findings and interpretation">
                    </div>
                </div>
                
                <!-- Physician Signature & Submit Section -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-gray-600">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-user-md text-gray-600 mr-3"></i>Physician Authorization
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Complete examination and authorize results</p>
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
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-save mr-3"></i>
                                Save Examination Results
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
