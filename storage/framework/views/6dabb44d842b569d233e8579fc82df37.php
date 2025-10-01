<?php $__env->startSection('title', 'X-Ray Medical Checklist - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'X-Ray Medical Checklist'); ?>
<?php $__env->startSection('page-description', 'X-Ray examination checklist and image upload'); ?>

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
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-700 px-10 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border-2 border-white/20">
                        <i class="fas fa-x-ray text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white">X-Ray Medical Checklist</h2>
                        <p class="text-cyan-100 text-base mt-1">X-Ray examination and image documentation</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-base">Examination Type</div>
                    <div class="text-white font-bold text-xl"><?php echo e(ucfirst($examinationType ?? 'General')); ?></div>
                </div>
            </div>
        </div>
    </div>

        <form action="<?php echo e(isset($medicalChecklist) && $medicalChecklist->id ? route('radtech.medical-checklist.update', $medicalChecklist->id) : route('radtech.medical-checklist.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
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
                if (isset($medicalChecklist) && $medicalChecklist->number) {
                    $generatedNumber = $medicalChecklist->number;
                } elseif (isset($patient)) {
                    $generatedNumber = 'APEP-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                } elseif (isset($preEmploymentRecord)) {
                    $generatedNumber = 'PPEP-' . str_pad($preEmploymentRecord->id, 4, '0', STR_PAD_LEFT);
                } else {
                    $generatedNumber = old('number', isset($number) ? $number : '');
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
                        <?php
                            $patientName = '';
                            if (isset($medicalChecklist) && $medicalChecklist->name) {
                                $patientName = $medicalChecklist->name;
                            } elseif (isset($patient)) {
                                $patientName = $patient->first_name . ' ' . $patient->last_name;
                            } elseif (isset($preEmploymentRecord)) {
                                $patientName = $preEmploymentRecord->first_name . ' ' . $preEmploymentRecord->last_name;
                            } else {
                                $patientName = old('name', isset($name) ? $name : '');
                            }
                        ?>
                        <div class="w-full rounded-xl border-2 border-gray-300 bg-gray-50 px-5 py-4 text-gray-800 font-medium text-base shadow-inner">
                            <?php echo e($patientName); ?>

                        </div>
                        <input type="hidden" name="name" value="<?php echo e($patientName); ?>" />
                    </div>
                    
                    <div class="space-y-3">
                        <label class="block text-sm font-bold uppercase tracking-wide text-gray-700">Examination Date</label>
                        <?php
                            $currentDate = old('date', isset($medicalChecklist) && $medicalChecklist->date ? $medicalChecklist->date : (isset($date) ? $date : now()->format('Y-m-d')));
                        ?>
                        <div class="w-full rounded-xl border-2 border-gray-300 bg-gray-50 px-5 py-4 text-gray-800 font-medium text-base shadow-inner">
                            <?php echo e(\Carbon\Carbon::parse($currentDate)->format('F j, Y')); ?>

                        </div>
                        <input type="hidden" name="date" value="<?php echo e($currentDate); ?>" />
                    </div>
                    
                    <div class="space-y-3">
                        <label class="block text-sm font-bold uppercase tracking-wide text-gray-700">Patient Age</label>
                        <?php
                            $patientAge = '';
                            if (isset($medicalChecklist) && $medicalChecklist->age) {
                                $patientAge = $medicalChecklist->age;
                            } elseif (isset($patient)) {
                                $patientAge = $patient->age;
                            } elseif (isset($preEmploymentRecord)) {
                                $patientAge = $preEmploymentRecord->age;
                            } else {
                                $patientAge = old('age', isset($age) ? $age : '');
                            }
                        ?>
                        <div class="w-full rounded-xl border-2 border-gray-300 bg-gray-50 px-5 py-4 text-gray-800 font-medium text-base shadow-inner">
                            <?php echo e($patientAge ? $patientAge . ' years' : 'N/A'); ?>

                        </div>
                        <input type="hidden" name="age" value="<?php echo e($patientAge); ?>" />
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
                    <?php
                        $examinations = [
                            'chest_xray' => ['name' => 'Chest X-Ray', 'icon' => 'fas fa-x-ray', 'color' => 'cyan'],
                            'stool_exam' => ['name' => 'Stool Examination', 'icon' => 'fas fa-vial', 'color' => 'amber'],
                            'urinalysis' => ['name' => 'Urinalysis', 'icon' => 'fas fa-flask', 'color' => 'blue'],
                            'drug_test' => ['name' => 'Drug Test', 'icon' => 'fas fa-pills', 'color' => 'red'],
                            'blood_extraction' => ['name' => 'Blood Extraction', 'icon' => 'fas fa-tint', 'color' => 'rose'],
                            'ecg' => ['name' => 'ElectroCardioGram (ECG)', 'icon' => 'fas fa-heartbeat', 'color' => 'green'],
                            'physical_exam' => ['name' => 'Physical Examination', 'icon' => 'fas fa-stethoscope', 'color' => 'purple'],
                        ];
                    ?>
                    <?php $__currentLoopData = $examinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isCompleted = isset($medicalChecklist) && !empty($medicalChecklist->{$field . '_done_by'});
                            $isChestXray = ($field === 'chest_xray');
                        ?>
                        <div class="bg-white rounded-xl border-2 <?php echo e($isChestXray ? 'border-cyan-400 bg-cyan-50' : 'border-gray-200'); ?> p-6 hover:shadow-lg transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-<?php echo e($isChestXray ? 'cyan' : 'gray'); ?>-100 rounded-lg flex items-center justify-center">
                                        <i class="<?php echo e($exam['icon']); ?> text-<?php echo e($isChestXray ? 'cyan' : 'gray'); ?>-600"></i>
                                    </div>
                                    <div>
                                        <span class="text-lg font-bold <?php echo e($isChestXray ? 'text-cyan-900' : 'text-gray-900'); ?>"><?php echo e($loop->iteration); ?>. <?php echo e($exam['name']); ?></span>
                                        <div class="text-sm <?php echo e($isChestXray ? 'text-cyan-700' : 'text-gray-600'); ?> mt-1">
                                            <?php if($isChestXray): ?>
                                                RadTech responsibility - X-Ray imaging
                                            <?php else: ?>
                                                Medical examination requirement
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-6">
                                    <div class="text-right">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Completed by:</label>
                                        <?php if($isChestXray): ?>
                                            <input type="text" name="<?php echo e($field); ?>_done_by"
                                                   value="<?php echo e(old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? '')); ?>"
                                                   placeholder="Enter your initials"
                                                   class="w-48 px-4 py-3 rounded-xl border-2 border-cyan-400 bg-white text-gray-900 font-medium text-center focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors shadow-sm"
                                                   <?php echo e($isCompleted ? 'readonly' : ''); ?>>
                                        <?php else: ?>
                                            <div class="w-48 px-4 py-3 rounded-xl border-2 border-gray-300 bg-gray-100 text-gray-600 font-medium text-center shadow-inner">
                                                <?php echo e($medicalChecklist->{$field . '_done_by'} ?? 'Not completed'); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if(!$isChestXray): ?>
                                        <div class="flex items-center space-x-2 text-gray-500">
                                            <i class="fas fa-user-md text-sm"></i>
                                            <span class="text-sm font-medium">Other Staff</span>
                                        </div>
                                    <?php elseif($isCompleted): ?>
                                        <div class="flex items-center space-x-2 text-green-600">
                                            <i class="fas fa-check-circle text-sm"></i>
                                            <span class="text-sm font-medium">Completed</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- X-Ray Image Upload Card -->
            <div class="content-card rounded-xl shadow-xl border-2 border-gray-200 p-8">
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-x-ray text-cyan-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">X-Ray Image Upload</h3>
                        <p class="text-gray-600 text-base">Upload chest X-ray images for patient records</p>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-xl border-2 border-cyan-200 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Upload Section -->
                        <div>
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-upload text-cyan-600"></i>
                                </div>
                                <label class="text-lg font-bold text-gray-900">Upload X-Ray Image</label>
                            </div>
                            
                            <input type="file" 
                                   name="xray_image" 
                                   accept="image/*"
                                   class="w-full text-sm file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-100 file:text-cyan-700 hover:file:bg-cyan-200 transition-colors cursor-pointer">
                            
                            <div class="mt-4 text-sm text-gray-600">
                                <p><strong>Accepted formats:</strong> JPG, PNG, GIF</p>
                                <p><strong>Maximum size:</strong> 25MB</p>
                            </div>
                        </div>
                        
                        <!-- Current Image Section -->
                        <div>
                            <?php if(isset($medicalChecklist) && $medicalChecklist->xray_image_path): ?>
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-green-600"></i>
                                    </div>
                                    <label class="text-lg font-bold text-gray-900">Current X-Ray Image</label>
                                </div>
                                
                                <div class="relative group">
                                    <img src="<?php echo e(asset('storage/' . $medicalChecklist->xray_image_path)); ?>" 
                                         alt="X-Ray Image" 
                                         class="w-full h-48 object-cover rounded-xl border-2 border-gray-300 shadow-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <a href="<?php echo e(asset('storage/' . $medicalChecklist->xray_image_path)); ?>" 
                                           target="_blank" 
                                           class="px-4 py-2 bg-white text-gray-900 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                                            <i class="fas fa-expand mr-2"></i>View Full Size
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                    <label class="text-lg font-bold text-gray-500">No Image Uploaded</label>
                                </div>
                                
                                <div class="w-full h-48 bg-gray-100 rounded-xl border-2 border-gray-300 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-x-ray text-gray-400 text-4xl mb-2"></i>
                                        <p class="text-gray-500">No X-ray image available</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-6">
                <a href="<?php echo e(route('radtech.dashboard')); ?>" 
                   class="inline-flex items-center px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors shadow-lg border-2 border-gray-300">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Back to Dashboard
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white font-bold rounded-xl transition-all duration-200 shadow-xl border-2 border-cyan-500 transform hover:scale-105">
                    <i class="fas fa-save mr-3"></i>
                    <?php echo e(isset($medicalChecklist) && $medicalChecklist->id ? 'Update X-Ray Data' : 'Save X-Ray Data'); ?>

                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.radtech', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/radtech/medical-checklist.blade.php ENDPATH**/ ?>