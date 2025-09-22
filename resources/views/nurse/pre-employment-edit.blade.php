@extends('layouts.nurse')

@section('title', 'Edit Pre-Employment Medical Examination - RSS Citi Health Services')
@section('page-title', 'Edit Pre-Employment Examination')
@section('page-description', 'Update employment medical screening and health assessment')

@section('content')
<div class="space-y-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-edit text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Edit Pre-Employment Medical Examination</h2>
                        <p class="text-blue-100 text-sm">Update certificate of medical examination for employment screening</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-sm">Examination ID</div>
                    <div class="text-white font-bold text-lg">#{{ $preEmployment->id }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employment Record Information Card -->
    @if($preEmployment->preEmploymentRecord)
    <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-briefcase text-blue-600"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Employment Record Information</h3>
                <p class="text-gray-600 text-sm">Candidate details for this examination</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Candidate Name</label>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-semibold text-sm">
                            {{ substr($preEmployment->preEmploymentRecord->first_name ?? 'C', 0, 1) }}{{ substr($preEmployment->preEmploymentRecord->last_name ?? 'A', 0, 1) }}
                        </span>
                    </div>
                    <div class="text-lg font-semibold text-gray-900">{{ $preEmployment->preEmploymentRecord->full_name ?? ($preEmployment->preEmploymentRecord->first_name . ' ' . $preEmployment->preEmploymentRecord->last_name) }}</div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Age</label>
                <div class="text-lg font-semibold text-gray-900">{{ $preEmployment->preEmploymentRecord->age }} years old</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Gender</label>
                <div class="text-lg font-semibold text-gray-900">{{ ucfirst($preEmployment->preEmploymentRecord->sex) }}</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Company</label>
                <div class="text-sm font-medium text-gray-900">{{ $preEmployment->preEmploymentRecord->company_name }}</div>
            </div>
        </div>
    </div>
    @endif
    <!-- Edit Form -->
    <form action="{{ route('nurse.pre-employment.update', $preEmployment->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PATCH')
        
        <!-- Physical Examination Card -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-stethoscope text-emerald-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Physical Examination</h3>
                    <p class="text-gray-600 text-sm">Update vital signs and basic physical measurements</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php $phys = old('physical_exam', $preEmployment->physical_exam ?? []); @endphp
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Temperature</label>
                    <div class="relative">
                        <input type="text" name="physical_exam[temp]" value="{{ $phys['temp'] ?? '' }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="e.g., 36.5°C" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-thermometer-half text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Height</label>
                    <div class="relative">
                        <input type="text" name="physical_exam[height]" value="{{ $phys['height'] ?? '' }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="e.g., 170 cm" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-ruler-vertical text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Heart Rate</label>
                    <div class="relative">
                        <input type="text" name="physical_exam[heart_rate]" value="{{ $phys['heart_rate'] ?? '' }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="e.g., 72 bpm" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-heartbeat text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Weight</label>
                    <div class="relative">
                        <input type="text" name="physical_exam[weight]" value="{{ $phys['weight'] ?? '' }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="e.g., 65 kg" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-weight text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Skin Identification Marks Card -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-search text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Skin Marks & Tattoos</h3>
                    <p class="text-gray-600 text-sm">Update notable skin marks, scars, tattoos, or identifying features</p>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Skin Marks Description</label>
                <textarea name="skin_marks" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                          placeholder="Describe any visible skin marks, scars, tattoos, or identifying features...">{{ old('skin_marks', $preEmployment->skin_marks) }}</textarea>
            </div>
        </div>
        
        <!-- Vision Tests Card -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-purple-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Vision Tests</h3>
                    <p class="text-gray-600 text-sm">Update visual acuity and color vision assessments</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Visual Acuity</label>
                    <textarea name="visual" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                              placeholder="Record visual acuity test results (e.g., 20/20, corrected/uncorrected vision)">{{ old('visual', $preEmployment->visual) }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Ishihara Test</label>
                    <textarea name="ishihara_test" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                              placeholder="Record color vision test results (e.g., Normal, Color blind - specify type)">{{ old('ishihara_test', $preEmployment->ishihara_test) }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Medical Findings Card -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-indigo-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Medical Findings</h3>
                    <p class="text-gray-600 text-sm">Update overall examination findings and recommendations</p>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Examination Findings</label>
                <textarea name="findings" rows="5" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                          placeholder="Record overall medical findings, any abnormalities, recommendations, or fitness for employment assessment...">{{ old('findings', $preEmployment->findings) }}</textarea>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-signature text-gray-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Medical Technologist Signature</h3>
                    <p class="text-gray-600 text-sm">Examination updated by: {{ Auth::user()->fname }} {{ Auth::user()->lname }}</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Medical Technologist</p>
                        <div class="border-b-2 border-gray-400 w-64 mt-3 mb-2"></div>
                        <p class="text-xs text-gray-500">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Date Updated</p>
                        <div class="border-b-2 border-gray-400 w-32 mt-3 mb-2"></div>
                        <p class="text-xs text-gray-500">{{ now()->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-end pt-8 border-t border-gray-200 space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('nurse.pre-employment') }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-lg">
                <i class="fas fa-save mr-2"></i>Update Examination
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth animations to content cards
        const contentCards = document.querySelectorAll('.content-card');
        contentCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in-up');
        });

        // Form validation enhancement
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('border-gray-300');
                    this.classList.add('border-emerald-500', 'ring-2', 'ring-emerald-200');
                } else {
                    this.classList.remove('border-emerald-500', 'ring-2', 'ring-emerald-200');
                    this.classList.add('border-gray-300');
                }
            });
        });

        // Form submission confirmation
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to update this pre-employment medical examination?')) {
                e.preventDefault();
            }
        });

        // Auto-hide success messages after 5 seconds
        const alerts = document.querySelectorAll('[class*="bg-emerald-50"], [class*="bg-red-50"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    });
</script>

<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }
</style>
@endpush
@endsection
