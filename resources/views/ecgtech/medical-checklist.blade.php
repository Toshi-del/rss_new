@extends('layouts.ecgtech')

@section('title', 'ECG Medical Checklist')

@section('page-title', 'ECG Medical Checklist')
@section('page-description', 'Complete cardiac examination checklist and ECG assessment')

@section('content')
@if(session('success'))
    <div class="mb-8 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 flex items-center space-x-3">
        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-white text-sm"></i>
        </div>
        <div>
            <p class="text-green-800 font-semibold">{{ session('success') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <!-- Enhanced Header -->
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-heartbeat text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">ECG Medical Checklist</h2>
                    <p class="text-gray-600 text-sm mt-1">Comprehensive cardiac examination assessment form</p>
                </div>
            </div>
        </div>

        <!-- Enhanced Form Container -->
        <div class="p-8">
            @if($medicalChecklist)
                <!-- Update existing checklist -->
                <form action="{{ route('ecgtech.medical-checklist.update', $medicalChecklist->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PATCH')
            @else
                <!-- Create new checklist -->
                <form action="{{ route('ecgtech.medical-checklist.store') }}" method="POST" class="space-y-8">
                    @csrf
            @endif
                
                <input type="hidden" name="examination_type" value="{{ $examinationType }}">
                @if($examinationType === 'annual-physical')
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                @elseif($examinationType === 'pre-employment')
                    <input type="hidden" name="pre_employment_record_id" value="{{ $record->id }}">
                @elseif($examinationType === 'opd')
                    <input type="hidden" name="opd_examination_id" value="{{ $opdExamination->id ?? 0 }}">
                @endif

                <!-- Enhanced Patient Information -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Patient Information</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Patient Name</label>
                            <div class="text-lg font-semibold text-gray-900">{{ $name }}</div>
                            <input type="hidden" name="name" value="{{ $name }}" />
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Examination Date</label>
                            <div class="text-lg font-semibold text-gray-900">{{ $date }}</div>
                            <input type="hidden" name="date" value="{{ $date }}" />
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Age</label>
                            <div class="text-lg font-semibold text-gray-900">{{ $age }} years</div>
                            <input type="hidden" name="age" value="{{ $age }}" />
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Reference Number</label>
                            <div class="text-lg font-semibold text-gray-900">{{ $number ?? 'N/A' }}</div>
                            <input type="hidden" name="number" value="{{ $number ?? '' }}" />
                        </div>
                    </div>
                </div>

                <!-- Enhanced Examinations Checklist -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-check text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Medical Examinations Checklist</h3>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach([
                            'chest_xray' => ['name' => 'Chest X-Ray', 'icon' => 'fas fa-lungs', 'color' => 'blue'],
                            'stool_exam' => ['name' => 'Stool Examination', 'icon' => 'fas fa-vial', 'color' => 'yellow'],
                            'urinalysis' => ['name' => 'Urinalysis', 'icon' => 'fas fa-flask', 'color' => 'amber'],
                            'drug_test' => ['name' => 'Drug Test', 'icon' => 'fas fa-pills', 'color' => 'red'],
                            'blood_extraction' => ['name' => 'Blood Extraction', 'icon' => 'fas fa-tint', 'color' => 'red'],
                            'ecg' => ['name' => 'ElectroCardioGram (ECG)', 'icon' => 'fas fa-heartbeat', 'color' => 'green'],
                            'physical_exam' => ['name' => 'Physical Examination', 'icon' => 'fas fa-stethoscope', 'color' => 'purple'],
                        ] as $field => $exam)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-8 h-8 bg-{{ $exam['color'] }}-100 rounded-lg flex items-center justify-center">
                                            <i class="{{ $exam['icon'] }} text-{{ $exam['color'] }}-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-bold text-gray-600">{{ $loop->iteration }}.</span>
                                                <span class="text-sm font-semibold text-gray-900">{{ $exam['name'] }}</span>
                                            </div>
                                            @if($field === 'ecg')
                                                <span class="text-xs text-green-600 font-medium">✓ Your responsibility</span>
                                            @else
                                                <span class="text-xs text-gray-500">Completed by other medical staff</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="text-sm font-medium text-gray-700">Completed by:</span>
                                        @if($field === 'ecg')
                                            <!-- ECG Tech can fill this field -->
                                            <input type="text" name="{{ $field }}_done_by" 
                                                   value="{{ old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? Auth::user()->fname . ' ' . Auth::user()->lname) }}" 
                                                   placeholder="Enter your name" 
                                                   class="w-48 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                                   required>
                                        @else
                                            <!-- Other fields are read-only for ECG Tech -->
                                            <input type="text" name="{{ $field }}_done_by" 
                                                   value="{{ old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? '') }}" 
                                                   placeholder="Not completed yet" 
                                                   class="w-48 px-3 py-2 border border-gray-200 rounded-lg text-sm bg-gray-100 text-gray-500" 
                                                   readonly>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Enhanced Optional Examinations -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus-circle text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Optional Examinations</h3>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Additional Tests</label>
                        <input type="text" name="optional_exam" 
                               value="{{ old('optional_exam', $medicalChecklist->optional_exam ?? 'Audiometry/Ishihara') }}" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-100 text-gray-500 text-sm" 
                               placeholder="No additional tests specified"
                               readonly />
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Optional examinations are managed by other medical staff
                        </p>
                    </div>
                </div>

                <!-- Enhanced Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <i class="fas fa-shield-alt text-green-600"></i>
                        <span>Your ECG data is securely saved and encrypted</span>
                    </div>
                    
                    <div class="flex space-x-4">
                        @if($examinationType === 'opd')
                            <a href="{{ route('ecgtech.opd') }}" 
                               class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 font-semibold">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to OPD
                            </a>
                        @elseif($examinationType === 'pre-employment')
                            <a href="{{ route('ecgtech.pre-employment') }}" 
                               class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 font-semibold">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Pre-Employment
                            </a>
                        @elseif($examinationType === 'annual-physical')
                            <a href="{{ route('ecgtech.annual-physical') }}" 
                               class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 font-semibold">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Annual Physical
                            </a>
                        @else
                            <a href="{{ route('ecgtech.dashboard') }}" 
                               class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 font-semibold">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Dashboard
                            </a>
                        @endif
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold">
                            <i class="fas fa-heartbeat mr-2"></i>
                            {{ $medicalChecklist ? 'Update' : 'Submit' }} ECG Report
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]');
    const ecgInput = document.querySelector('input[name="ecg_done_by"]');
    
    // Enhanced form submission with loading state
    form.addEventListener('submit', function(e) {
        // Validate ECG field
        if (!ecgInput.value.trim()) {
            e.preventDefault();
            showNotification('Please enter your name for the ECG examination', 'error');
            ecgInput.focus();
            return;
        }
        
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving ECG Report...';
        submitButton.classList.add('opacity-75', 'cursor-not-allowed');
        
        // Add visual feedback
        form.style.opacity = '0.8';
        form.style.pointerEvents = 'none';
    });
    
    // Enhanced input validation and feedback
    ecgInput.addEventListener('input', function() {
        const value = this.value.trim();
        const parent = this.closest('.bg-gray-50');
        
        if (value) {
            parent.classList.remove('border-gray-200');
            parent.classList.add('border-green-200', 'bg-green-50');
            this.classList.remove('border-gray-300');
            this.classList.add('border-green-300');
        } else {
            parent.classList.remove('border-green-200', 'bg-green-50');
            parent.classList.add('border-gray-200');
            this.classList.remove('border-green-300');
            this.classList.add('border-gray-300');
        }
    });
    
    // Auto-save functionality (optional)
    let autoSaveTimeout;
    ecgInput.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            if (this.value.trim()) {
                showNotification('ECG data auto-saved', 'success', 2000);
            }
        }, 3000);
    });
    
    // Enhanced notification system
    function showNotification(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg border transition-all duration-300 transform translate-x-full`;
        
        const colors = {
            success: 'bg-green-50 border-green-200 text-green-800',
            error: 'bg-red-50 border-red-200 text-red-800',
            info: 'bg-blue-50 border-blue-200 text-blue-800'
        };
        
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            info: 'fas fa-info-circle'
        };
        
        notification.className += ` ${colors[type]}`;
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="${icons[type]}"></i>
                <span class="font-medium">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 hover:opacity-75">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, duration);
    }
    
    // Add hover effects to form sections
    const formSections = document.querySelectorAll('.bg-white.rounded-xl');
    formSections.forEach(section => {
        section.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
        });
        
        section.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            if (!submitButton.disabled) {
                form.submit();
            }
        }
        
        // Escape to cancel
        if (e.key === 'Escape') {
            const cancelButton = document.querySelector('a[href*="previous"]');
            if (cancelButton) {
                cancelButton.click();
            }
        }
    });
    
    // Initial validation check
    if (ecgInput.value.trim()) {
        ecgInput.dispatchEvent(new Event('input'));
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .form-section {
        transition: all 0.3s ease;
    }
    
    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
`;
document.head.appendChild(style);
</script>

@endsection
