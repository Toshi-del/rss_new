<?php $__env->startSection('title', 'Medical Checklist - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Medical Checklist'); ?>
<?php $__env->startSection('page-description', 'Medical examination checklist and completion tracking'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="bg-emerald-50 border-2 border-emerald-200 rounded-xl p-6 flex items-center space-x-4 shadow-lg">
            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600 text-lg"></i>
            </div>
            <div class="flex-1">
                <p class="text-emerald-800 font-semibold text-lg"><?php echo e(session('success')); ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors p-2">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border-2 border-red-200 rounded-xl p-6 flex items-center space-x-4 shadow-lg">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-semibold text-lg"><?php echo e(session('error')); ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors p-2">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-xl border-2 border-gray-200">
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-10 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border-2 border-white/20">
                        <i class="fas fa-clipboard-check text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white">Medical Checklist</h2>
                        <p class="text-teal-100 text-base mt-1">Medical examination completion tracking and verification</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-base">Examination Type</div>
                    <div class="text-white font-bold text-xl"><?php echo e(ucfirst($examinationType ?? 'General')); ?></div>
                </div>
            </div>
        </div>
    </div>

        <form action="<?php echo e(isset($medicalChecklist) && $medicalChecklist->id ? route('nurse.medical-checklist.update', $medicalChecklist->id) : route('nurse.medical-checklist.store')); ?>" method="POST" class="space-y-8">
            <?php echo csrf_field(); ?>
            <?php if(isset($medicalChecklist) && $medicalChecklist->id): ?>
                <?php echo method_field('PATCH'); ?>
            <?php endif; ?>
            <input type="hidden" name="examination_type" value="<?php echo e($examinationType); ?>">
            <?php if(isset($preEmploymentRecord)): ?>
                <input type="hidden" name="pre_employment_record_id" value="<?php echo e($preEmploymentRecord->id); ?>">
            <?php endif; ?>
            <?php if(isset($patient)): ?>
                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
            <?php endif; ?>
            <?php if(isset($annualPhysicalExamination)): ?>
                <input type="hidden" name="annual_physical_examination_id" value="<?php echo e($annualPhysicalExamination->id); ?>">
            <?php endif; ?>

            <?php
                // Precompute generated number once for reuse
                $generatedNumber = null;
                if (isset($medicalChecklist) && ($medicalChecklist->number ?? null)) {
                    $generatedNumber = $medicalChecklist->number;
                } elseif (isset($patient)) {
                    $generatedNumber = 'APEP-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                } elseif (isset($preEmploymentRecord)) {
                    $generatedNumber = 'PPEP-' . str_pad($preEmploymentRecord->id, 4, '0', STR_PAD_LEFT);
                } else {
                    $generatedNumber = old('number', $number ?? '');
                }
            ?>

            <!-- Patient Information Card -->
            <div class="content-card rounded-xl shadow-xl border-2 border-gray-200 p-8">
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-md text-teal-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Patient Information</h3>
                        <p class="text-gray-600 text-base">Medical examination details and patient data</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="space-y-3">
                        <label class="block text-sm font-bold uppercase tracking-wide text-gray-700">Patient Name</label>
                        <div class="w-full rounded-xl border-2 border-gray-300 bg-gray-50 px-5 py-4 text-gray-800 font-medium text-base shadow-inner">
                            <?php if(isset($medicalChecklist) && $medicalChecklist->patient): ?>
                                <?php echo e($medicalChecklist->patient->full_name); ?>

                            <?php elseif(isset($patient)): ?>
                                <?php echo e($patient->full_name); ?>

                            <?php elseif(isset($preEmploymentRecord)): ?>
                                <?php echo e($preEmploymentRecord->first_name); ?> <?php echo e($preEmploymentRecord->last_name); ?>

                            <?php else: ?>
                                <?php echo e(old('name', $medicalChecklist->name ?? $name ?? '')); ?>

                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="name" value="<?php if(isset($medicalChecklist) && $medicalChecklist->patient): ?><?php echo e($medicalChecklist->patient->full_name); ?><?php elseif(isset($patient)): ?><?php echo e($patient->full_name); ?><?php elseif(isset($preEmploymentRecord)): ?><?php echo e($preEmploymentRecord->first_name); ?> <?php echo e($preEmploymentRecord->last_name); ?><?php else: ?><?php echo e(old('name', $medicalChecklist->name ?? $name ?? '')); ?><?php endif; ?>" />
                    </div>
                    
                    <div class="space-y-3">
                        <label class="block text-sm font-bold uppercase tracking-wide text-gray-700">Examination Date</label>
                        <?php ($currentDate = old('date', $medicalChecklist->date ?? $date ?? now()->format('Y-m-d'))); ?>
                        <div class="w-full rounded-xl border-2 border-gray-300 bg-gray-50 px-5 py-4 text-gray-800 font-medium text-base shadow-inner">
                            <?php echo e(\Carbon\Carbon::parse($currentDate)->format('F j, Y')); ?>

                        </div>
                        <input type="hidden" name="date" value="<?php echo e($currentDate); ?>" />
                    </div>
                    
                    <div class="space-y-3">
                        <label class="block text-sm font-bold uppercase tracking-wide text-gray-700">Patient Age</label>
                        <div class="w-full rounded-xl border-2 border-gray-300 bg-gray-50 px-5 py-4 text-gray-800 font-medium text-base shadow-inner">
                            <?php if(isset($medicalChecklist) && $medicalChecklist->patient): ?>
                                <?php echo e($medicalChecklist->patient->age); ?> years
                            <?php elseif(isset($patient)): ?>
                                <?php echo e($patient->age); ?> years
                            <?php elseif(isset($preEmploymentRecord)): ?>
                                <?php echo e($preEmploymentRecord->age); ?> years
                            <?php else: ?>
                                <?php echo e(old('age', $medicalChecklist->age ?? $age ?? '')); ?> years
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="age" value="<?php if(isset($medicalChecklist) && $medicalChecklist->patient): ?><?php echo e($medicalChecklist->patient->age); ?><?php elseif(isset($patient)): ?><?php echo e($patient->age); ?><?php elseif(isset($preEmploymentRecord)): ?><?php echo e($preEmploymentRecord->age); ?><?php else: ?><?php echo e(old('age', $medicalChecklist->age ?? $age ?? '')); ?><?php endif; ?>" />
                    </div>
                    
                    <div class="space-y-3">
                        <label class="block text-sm font-bold uppercase tracking-wide text-gray-700">Checklist Number</label>
                        <div class="w-full rounded-xl border-2 border-teal-300 bg-teal-50 px-5 py-4 text-teal-800 font-bold text-base shadow-inner">
                            <?php echo e($generatedNumber ?: 'N/A'); ?>

                        </div>
                        <input type="hidden" name="number" value="<?php echo e($generatedNumber); ?>" />
                    </div>
                </div>
            </div>

            <!-- Medical Examinations Checklist Card -->
            <div class="content-card rounded-xl shadow-xl border-2 border-gray-200 p-8">
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-tasks text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Medical Examinations Checklist</h3>
                        <p class="text-gray-600 text-base">Track completion status and responsible medical staff</p>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <?php $__currentLoopData = [
                        'chest_xray' => ['name' => 'Chest X-Ray', 'icon' => 'fas fa-lungs', 'color' => 'blue'],
                        'stool_exam' => ['name' => 'Stool Examination', 'icon' => 'fas fa-vial', 'color' => 'amber'],
                        'urinalysis' => ['name' => 'Urinalysis', 'icon' => 'fas fa-flask', 'color' => 'yellow'],
                        'drug_test' => ['name' => 'Drug Test', 'icon' => 'fas fa-pills', 'color' => 'red'],
                        'blood_extraction' => ['name' => 'Blood Extraction', 'icon' => 'fas fa-tint', 'color' => 'red'],
                        'ecg' => ['name' => 'ElectroCardioGram (ECG)', 'icon' => 'fas fa-heartbeat', 'color' => 'pink'],
                        'physical_exam' => ['name' => 'Physical Examination', 'icon' => 'fas fa-stethoscope', 'color' => 'emerald'],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-xl border-2 border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-<?php echo e($exam['color']); ?>-100 rounded-lg flex items-center justify-center">
                                        <i class="<?php echo e($exam['icon']); ?> text-<?php echo e($exam['color']); ?>-600"></i>
                                    </div>
                                    <div>
                                        <span class="text-lg font-bold text-gray-900"><?php echo e($loop->iteration); ?>. <?php echo e($exam['name']); ?></span>
                                        <div class="text-sm text-gray-600 mt-1">Medical examination requirement</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-6">
                                    <div class="text-right">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Completed by:</label>
                                        <input type="text" name="<?php echo e($field); ?>_done_by"
                                               value="<?php echo e(old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? '')); ?>"
                                               placeholder="Enter initials or signature"
                                               <?php if($field !== 'physical_exam'): ?> 
                                                   readonly disabled 
                                                   class="w-48 px-4 py-3 rounded-xl border-2 border-gray-300 bg-gray-100 text-gray-600 font-medium text-center cursor-not-allowed shadow-inner"
                                               <?php else: ?> 
                                                   class="w-48 px-4 py-3 rounded-xl border-2 border-teal-300 bg-white text-gray-900 font-medium text-center focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors shadow-sm"
                                               <?php endif; ?>>
                                    </div>
                                    
                                    <?php if($field !== 'physical_exam'): ?>
                                        <div class="flex items-center space-x-2 text-gray-500">
                                            <i class="fas fa-lock text-sm"></i>
                                            <span class="text-sm font-medium">Locked</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Optional Examinations Card -->
            <div class="content-card rounded-xl shadow-xl border-2 border-gray-200 p-8">
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus-circle text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Optional Examinations</h3>
                        <p class="text-gray-600 text-base">Additional medical tests and examinations as needed</p>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl border-2 border-purple-200 p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye text-purple-600"></i>
                        </div>
                        <label class="text-lg font-bold text-gray-900">Additional Tests</label>
                    </div>
                    
                    <input type="text" 
                           name="optional_exam" 
                           value="<?php echo e(old('optional_exam', $medicalChecklist->optional_exam ?? $optionalExam ?? 'Audiometry/Ishihara')); ?>" 
                           placeholder="Enter additional examinations (e.g., Audiometry, Ishihara, etc.)"
                           class="w-full px-6 py-4 rounded-xl border-2 border-purple-300 bg-white text-gray-900 font-medium text-base focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors shadow-sm" />
                    
                    <div class="mt-4 text-sm text-gray-600">
                        <p><strong>Common optional tests:</strong> Audiometry, Ishihara Color Vision Test, Spirometry, Vision Screening</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-6">
                <a href="<?php echo e(route('nurse.dashboard')); ?>" 
                   class="inline-flex items-center px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors shadow-lg border-2 border-gray-300">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Back to Dashboard
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold rounded-xl transition-all duration-200 shadow-xl border-2 border-teal-500 transform hover:scale-105">
                    <i class="fas fa-save mr-3"></i>
                    <?php echo e(isset($medicalChecklist) && $medicalChecklist->id ? 'Update Checklist' : 'Submit Checklist'); ?>

                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nurse', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/nurse/medical-checklist.blade.php ENDPATH**/ ?>