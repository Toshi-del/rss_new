@extends('layouts.pathologist')

@section('title', 'Edit Pre-Employment Examination')
@section('page-title', 'Edit Pre-Employment Examination')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300 text-center font-semibold shadow-sm">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300 text-center font-semibold shadow-sm">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300">
        <h4 class="font-semibold mb-2">
            <i class="fas fa-exclamation-triangle mr-2"></i>Please correct the following errors:
        </h4>
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-6xl mx-auto">
    <form action="{{ route('pathologist.pre-employment.update', $examination->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Employee Information Header -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Pre-Employment Examination</h2>
                    <p class="text-green-100">{{ $examination->name ?? $examination->preEmploymentRecord->full_name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-semibold">{{ $examination->date->format('M d, Y') }}</p>
                    <p class="text-green-100">{{ $examination->company_name ?? $examination->preEmploymentRecord->company_name }}</p>
                </div>
            </div>
        </div>

        <!-- Laboratory Examination Report -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-flask mr-2 text-teal-600"></i>Laboratory Examination Report
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Row 1 -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Urinalysis</label>
                    <input type="text" name="lab_report[urinalysis]" 
                           value="{{ old('lab_report.urinalysis', $examination->lab_report['urinalysis'] ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter urinalysis results">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">CBC</label>
                    <input type="text" name="lab_report[cbc]" 
                           value="{{ old('lab_report.cbc', $examination->lab_report['cbc'] ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter CBC results">
                </div>
                
                
                <!-- Row 2 -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Fecalysis</label>
                    <input type="text" name="lab_report[fecalysis]" 
                           value="{{ old('lab_report.fecalysis', $examination->lab_report['fecalysis'] ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter fecalysis results">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Blood Chemistry</label>
                    <input type="text" name="lab_report[blood_chemistry]" 
                           value="{{ old('lab_report.blood_chemistry', $examination->lab_report['blood_chemistry'] ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter blood chemistry results">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Others</label>
                    <input type="text" name="lab_report[others]" 
                           value="{{ old('lab_report.others', $examination->lab_report['others'] ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter other test results">
                </div>
            </div>
        </div>

        <!-- Additional Laboratory Tests -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-vial mr-2 text-teal-600"></i>Additional Laboratory Tests
            </h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">HBsAg Screening</label>
                        <input type="text" name="lab_report[hbsag_screening]" 
                               value="{{ old('lab_report.hbsag_screening', $examination->lab_report['hbsag_screening'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                               placeholder="Enter HBsAg screening results">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">HEPA A IGG & IGM</label>
                        <input type="text" name="lab_report[hepa_a_igg_igm]" 
                               value="{{ old('lab_report.hepa_a_igg_igm', $examination->lab_report['hepa_a_igg_igm'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                               placeholder="Enter HEPA A IGG & IGM results">
                    </div>
                </div>
            </div>
        </div>

        <!-- Laboratory Examinations Report Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-flask mr-2 text-teal-600"></i>Laboratory Examinations Report
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">TEST</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">RESULT</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">FINDINGS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">Urinalysis</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[urinalysis_result]" 
                                       value="{{ old('lab_report.urinalysis_result', $examination->lab_report['urinalysis_result'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter result">
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[urinalysis_findings]" 
                                       value="{{ old('lab_report.urinalysis_findings', $examination->lab_report['urinalysis_findings'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">Fecalysis</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[fecalysis_result]" 
                                       value="{{ old('lab_report.fecalysis_result', $examination->lab_report['fecalysis_result'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter result">
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[fecalysis_findings]" 
                                       value="{{ old('lab_report.fecalysis_findings', $examination->lab_report['fecalysis_findings'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">CBC</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[cbc_result]" 
                                       value="{{ old('lab_report.cbc_result', $examination->lab_report['cbc_result'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter result">
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[cbc_findings]" 
                                       value="{{ old('lab_report.cbc_findings', $examination->lab_report['cbc_findings'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">HBsAg Screening</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[hbsag_result]" 
                                       value="{{ old('lab_report.hbsag_result', $examination->lab_report['hbsag_result'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter result">
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[hbsag_findings]" 
                                       value="{{ old('lab_report.hbsag_findings', $examination->lab_report['hbsag_findings'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">HEPA A IGG & IGM</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[hepa_result]" 
                                       value="{{ old('lab_report.hepa_result', $examination->lab_report['hepa_result'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter result">
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[hepa_findings]" 
                                       value="{{ old('lab_report.hepa_findings', $examination->lab_report['hepa_findings'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">Others</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[others_result]" 
                                       value="{{ old('lab_report.others_result', $examination->lab_report['others_result'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter result">
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <input type="text" name="lab_report[others_findings]" 
                                       value="{{ old('lab_report.others_findings', $examination->lab_report['others_findings'] ?? '') }}"
                                       class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

     

        <!-- Status and Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <label class="block text-sm font-semibold text-gray-700">Status:</label>
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                        <option value="Pending" {{ old('status', $examination->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ old('status', $examination->status) == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="sent_to_company" {{ old('status', $examination->status) == 'sent_to_company' ? 'selected' : '' }}>Sent to Company</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('pathologist.pre-employment') }}" 
                       class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                    <button type="submit" class="bg-gradient-to-r from-green-600 to-teal-600 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-teal-700 transition-all font-semibold">
                        <i class="fas fa-save mr-2"></i>Update Examination
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // Auto-save functionality
    let autoSaveTimeout;
    document.querySelectorAll('input, textarea, select').forEach(field => {
        field.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Implement auto-save functionality here
                console.log('Auto-saving examination data...');
            }, 2000);
        });
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = ['status'];
        let isValid = true;
        
        requiredFields.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field.value.trim()) {
                field.classList.add('border-red-500');
                isValid = false;
            } else {
                field.classList.remove('border-red-500');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });

    // Real-time character count for textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        const maxLength = 1000;
        const counter = document.createElement('div');
        counter.className = 'text-sm text-gray-500 mt-1';
        textarea.parentNode.appendChild(counter);
        
        function updateCounter() {
            const remaining = maxLength - textarea.value.length;
            counter.textContent = `${remaining} characters remaining`;
            counter.className = `text-sm mt-1 ${remaining < 100 ? 'text-red-500' : 'text-gray-500'}`;
        }
        
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    });

    // Dynamic form sections
    function toggleSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            section.classList.toggle('hidden');
        }
    }
</script>
@endsection
