@extends('layouts.doctor')

@section('title', 'Pre-Employment Examination')
@section('page-title', 'Pre-Employment Examination')
@section('page-description', 'View and manage pre-employment medical examination')

@section('content')
<div class="space-y-8" style="font-family: 'Poppins', sans-serif;">
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-violet-600">
        <div class="px-8 py-6 bg-violet-600">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-briefcase mr-3"></i>Pre-Employment Medical Examination
                    </h1>
                    <p class="text-violet-100">Employment medical screening and health assessment certificate</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-violet-700 rounded-lg px-4 py-2">
                        <p class="text-violet-200 text-sm font-medium">Exam ID</p>
                        <p class="text-white text-lg font-bold">#{{ $examination->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Applicant Information Section -->
        @if($examination->preEmploymentRecord)
        <div class="px-8 py-6 bg-violet-600 border-l-4 border-violet-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-user-tie mr-3"></i>Applicant Information
                    </h2>
                    <p class="text-violet-100 mt-1">Job applicant details and company information</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 bg-violet-50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-4 border-l-4 border-violet-600 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Full Name</label>
                    <div class="text-lg font-bold text-violet-900">{{ $examination->preEmploymentRecord->full_name ?? ($examination->preEmploymentRecord->first_name . ' ' . $examination->preEmploymentRecord->last_name) }}</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-emerald-600 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Age</label>
                    <div class="text-lg font-bold text-emerald-900">{{ $examination->preEmploymentRecord->age ?? 'N/A' }} years</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-blue-600 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Sex</label>
                    <div class="text-lg font-bold text-blue-900">{{ $examination->preEmploymentRecord->sex ? ucfirst($examination->preEmploymentRecord->sex) : 'N/A' }}</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-orange-600 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Company</label>
                    <div class="text-sm font-semibold text-orange-900 truncate">{{ $examination->preEmploymentRecord->company_name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Examination Details Section -->
        <div class="p-8">
            <!-- Examination Status -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-emerald-600 mb-8">
                <div class="px-6 py-4 bg-emerald-600">
                    <div class="flex items-center">
                        <i class="fas fa-clipboard-check text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Examination Status</h3>
                    </div>
                </div>
                <div class="p-6 bg-emerald-50">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Examination Date</label>
                            <p class="text-gray-900">{{ $examination->date ? \Carbon\Carbon::parse($examination->date)->format('F j, Y') : 'N/A' }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                {{ $examination->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($examination->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($examination->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($examination->status) }}
                            </span>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Examined By</label>
                            <p class="text-gray-900">{{ $examination->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical History -->
            @if($examination->illness_history || $examination->accidents_operations || $examination->past_medical_history)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-600 mb-8">
                <div class="px-6 py-4 bg-blue-600">
                    <div class="flex items-center">
                        <i class="fas fa-notes-medical text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Medical History</h3>
                    </div>
                </div>
                <div class="p-6 bg-blue-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if($examination->illness_history)
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Illness / Hospitalization</label>
                            <div class="prose max-w-none">
                                {!! nl2br(e($examination->illness_history)) !!}
                            </div>
                        </div>
                        @endif

                        @if($examination->accidents_operations)
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Accidents / Operations</label>
                            <div class="prose max-w-none">
                                {!! nl2br(e($examination->accidents_operations)) !!}
                            </div>
                        </div>
                        @endif

                        @if($examination->past_medical_history)
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Past Medical History</label>
                            <div class="prose max-w-none">
                                {!! nl2br(e($examination->past_medical_history)) !!}
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($examination->family_history)
                    <div class="mt-6 bg-white p-4 rounded-lg border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Family Medical History</label>
                        <div class="flex flex-wrap gap-2">
                            @if(is_array($examination->family_history) && !empty($examination->family_history))
                                @foreach($examination->family_history as $condition)
                                    @if(is_string($condition))
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                            {{ ucwords(str_replace('_', ' ', $condition)) }}
                                        </span>
                                    @endif
                                @endforeach
                            @elseif(is_string($examination->family_history) && !empty($examination->family_history))
                                <p class="text-gray-600">{{ $examination->family_history }}</p>
                            @else
                                <p class="text-gray-400 italic">No family history recorded</p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Personal Habits -->
            @if($examination->personal_habits)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-purple-600 mb-8">
                <div class="px-6 py-4 bg-purple-600">
                    <div class="flex items-center">
                        <i class="fas fa-user-check text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Personal Habits</h3>
                    </div>
                </div>
                <div class="p-6 bg-purple-50">
                    <div class="flex flex-wrap gap-4">
                        @if(is_array($examination->personal_habits))
                            @foreach($examination->personal_habits as $habit => $value)
                                @if($value)
                                    <div class="bg-white p-3 rounded-lg border border-gray-200 flex items-center">
                                        <i class="fas {{ 
                                            $habit === 'alcohol' ? 'fa-wine-bottle text-red-500' : 
                                            ($habit === 'cigarettes' ? 'fa-smoking text-orange-500' : 
                                            'fa-coffee text-amber-500') 
                                        }} mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ ucwords(str_replace('_', ' ', $habit)) }}
                                        </span>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p class="text-gray-600">{{ $examination->personal_habits }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Physical Examination -->
            @if($examination->physical_exam || $examination->skin_marks || $examination->visual || $examination->ishihara_test)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-orange-600 mb-8">
                <div class="px-6 py-4 bg-orange-600">
                    <div class="flex items-center">
                        <i class="fas fa-stethoscope text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Physical Examination</h3>
                    </div>
                </div>
                <div class="p-6 bg-orange-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if($examination->physical_exam && is_array($examination->physical_exam))
                            @foreach($examination->physical_exam as $key => $value)
                                @if(!empty($value) && !is_array($value))
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ str_replace('_', ' ', ucwords($key)) }}
                                    </label>
                                    <p class="text-gray-900">{{ $value }}</p>
                                </div>
                                @endif
                            @endforeach
                        @endif

                        @if($examination->skin_marks)
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Skin Identification Marks</label>
                            <p class="text-gray-900">{{ $examination->skin_marks }}</p>
                        </div>
                        @endif

                        @if($examination->visual)
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Visual Acuity</label>
                            <p class="text-gray-900">{{ $examination->visual }}</p>
                        </div>
                        @endif

                        @if($examination->ishihara_test)
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ishihara Test</label>
                            <p class="text-gray-900">{{ $examination->ishihara_test }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Laboratory and ECG -->
            @if($examination->lab_report || $examination->ecg)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-teal-600 mb-8">
                <div class="px-6 py-4 bg-teal-600">
                    <div class="flex items-center">
                        <i class="fas fa-flask text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Laboratory & ECG</h3>
                    </div>
                </div>
                <div class="p-6 bg-teal-50">
                    @if($examination->lab_report && is_array($examination->lab_report) && !empty($examination->lab_report))
                    <div class="mb-6">
                        <h4 class="text-md font-semibold text-gray-800 mb-3">Laboratory Report</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference Range</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($examination->lab_report as $test => $result)
                                        @if(is_array($result) || is_object($result))
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ is_string($test) ? ucwords(str_replace('_', ' ', $test)) : 'Test ' . $loop->iteration }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ is_array($result) ? ($result['result'] ?? 'N/A') : (is_object($result) ? ($result->result ?? 'N/A') : $result) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ is_array($result) ? ($result['range'] ?? 'N/A') : (is_object($result) ? ($result->range ?? 'N/A') : 'N/A') }}</td>
                                        </tr>
                                        @elseif(is_string($result) || is_numeric($result))
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ is_string($test) ? ucwords(str_replace('_', ' ', $test)) : 'Test ' . $loop->iteration }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900 font-medium" colspan="2">{{ $result }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @elseif(is_string($examination->lab_report) && !empty($examination->lab_report))
                    <div class="mb-6">
                        <h4 class="text-md font-semibold text-gray-800 mb-3">Laboratory Report</h4>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <div class="prose max-w-none">
                                {!! nl2br(e($examination->lab_report)) !!}
                            </div>
                        </div>
                    </div>
                    @else
                        <p class="text-gray-400 italic">No laboratory report available</p>
                    @endif

                    @if($examination->ecg)
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ECG Findings</label>
                        <div class="prose max-w-none">
                            {!! nl2br(e($examination->ecg)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Findings and Recommendations -->
            @if($examination->findings || $examination->physical_findings || $examination->lab_findings)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-red-600 mb-8">
                <div class="px-6 py-4 bg-red-600">
                    <div class="flex items-center">
                        <i class="fas fa-clipboard-check text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white" style="font-family: 'Poppins', sans-serif;">Findings & Recommendations</h3>
                    </div>
                </div>
                <div class="p-6 bg-red-50">
                    @if($examination->findings)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">General Findings</label>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 prose max-w-none">
                            @if(is_string($examination->findings))
                                {!! nl2br(e($examination->findings)) !!}
                            @elseif(is_array($examination->findings) || is_object($examination->findings))
                                <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ json_encode($examination->findings, JSON_PRETTY_PRINT) }}</pre>
                            @else
                                {{ $examination->findings }}
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($examination->physical_findings)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Physical Examination Findings</label>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 prose max-w-none">
                            @if(is_string($examination->physical_findings))
                                {!! nl2br(e($examination->physical_findings)) !!}
                            @elseif(is_array($examination->physical_findings) || is_object($examination->physical_findings))
                                <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ json_encode($examination->physical_findings, JSON_PRETTY_PRINT) }}</pre>
                            @else
                                {{ $examination->physical_findings }}
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($examination->lab_findings)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Laboratory Findings</label>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 prose max-w-none">
                            @if(is_string($examination->lab_findings))
                                {!! nl2br(e($examination->lab_findings)) !!}
                            @elseif(is_array($examination->lab_findings) || is_object($examination->lab_findings))
                                <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ json_encode($examination->lab_findings, JSON_PRETTY_PRINT) }}</pre>
                            @else
                                {{ $examination->lab_findings }}
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 mt-8">
                <a href="{{ route('doctor.pre-employment') }}" class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
                <a href="{{ route('doctor.pre-employment.edit', $examination->id) }}" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                    <i class="fas fa-edit mr-2"></i>Edit Examination
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
