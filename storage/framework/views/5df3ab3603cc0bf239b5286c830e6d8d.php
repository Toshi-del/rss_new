<?php $__env->startSection('title', 'Create Pre-Employment Medical Examination - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Create Pre-Employment Examination'); ?>
<?php $__env->startSection('page-description', 'New employment medical screening and health assessment'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Validation Errors -->
    <?php if($errors->any()): ?>
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-red-800 font-semibold mb-2">Please complete all required fields:</h3>
                    <ul class="text-sm text-red-700 space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center space-x-2">
                                <i class="fas fa-circle text-xs text-red-500"></i>
                                <span><?php echo e($error); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-plus-circle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Create Pre-Employment Medical Examination</h2>
                        <p class="text-blue-100 text-sm">Certificate of medical examination for employment screening</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-white/90 text-sm">Form Type</div>
                    <div class="text-white font-bold text-lg">Pre-Employment</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employment Record Information Card -->
    <?php if($preEmploymentRecord): ?>
    <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-briefcase text-blue-600"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Employment Record Information</h3>
                <p class="text-gray-600 text-sm">Candidate details for pre-employment medical screening</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Candidate Name</label>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-semibold text-sm">
                            <?php echo e(substr($preEmploymentRecord->first_name ?? 'C', 0, 1)); ?><?php echo e(substr($preEmploymentRecord->last_name ?? 'A', 0, 1)); ?>

                        </span>
                    </div>
                    <div class="text-lg font-semibold text-gray-900"><?php echo e($preEmploymentRecord->full_name ?? ($preEmploymentRecord->first_name . ' ' . $preEmploymentRecord->last_name)); ?></div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Age</label>
                <div class="text-lg font-semibold text-gray-900"><?php echo e($preEmploymentRecord->age); ?> years old</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Gender</label>
                <div class="text-lg font-semibold text-gray-900"><?php echo e(ucfirst($preEmploymentRecord->sex)); ?></div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Company</label>
                <div class="text-sm font-medium text-gray-900"><?php echo e($preEmploymentRecord->company_name); ?></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Examination Form -->
    <form action="<?php echo e(route('nurse.pre-employment.store')); ?>" method="POST" class="space-y-8">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="pre_employment_record_id" value="<?php echo e($preEmploymentRecord->id); ?>">
        
        <?php
            $medicalTestName = $preEmploymentRecord->medicalTest->name ?? '';
            $isAudiometryIshiharaOnly = strtolower($medicalTestName) === 'audiometry and ishihara only';
            $hasDrugTest = in_array(strtolower($medicalTestName), [
                'pre-employment with drug test',
                'pre-employment with ecg and drug test',
                'pre-employment with drug test and audio and ishihara',
                'drug test only (bring valid i.d)'
            ]);
        ?>

        <?php if(!$isAudiometryIshiharaOnly): ?>
        <!-- Physical Examination Card -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-stethoscope text-emerald-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Physical Examination</h3>
                    <p class="text-gray-600 text-sm">Vital signs and basic physical measurements</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php $phys = old('physical_exam', []); ?>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Temperature <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="physical_exam[temp]" value="<?php echo e($phys['temp'] ?? ''); ?>" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['physical_exam.temp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               placeholder="e.g., 36.5°C" required />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-thermometer-half text-gray-400"></i>
                        </div>
                    </div>
                    <?php $__errorArgs = ['physical_exam.temp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Height <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="physical_exam[height]" value="<?php echo e($phys['height'] ?? ''); ?>" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['physical_exam.height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               placeholder="e.g., 170 cm" required />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-ruler-vertical text-gray-400"></i>
                        </div>
                    </div>
                    <?php $__errorArgs = ['physical_exam.height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Weight <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="physical_exam[weight]" value="<?php echo e($phys['weight'] ?? ''); ?>" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['physical_exam.weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               placeholder="e.g., 65 kg" required />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-weight text-gray-400"></i>
                        </div>
                    </div>
                    <?php $__errorArgs = ['physical_exam.weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Heart Rate <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="physical_exam[heart_rate]" value="<?php echo e($phys['heart_rate'] ?? ''); ?>" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['physical_exam.heart_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               placeholder="e.g., 72 bpm" required />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-heartbeat text-gray-400"></i>
                        </div>
                    </div>
                    <?php $__errorArgs = ['physical_exam.heart_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Hidden inputs for physical examination when Audiometry and Ishihara Only -->
        <input type="hidden" name="physical_exam[temp]" value="N/A - Not required for Audiometry and Ishihara Only" />
        <input type="hidden" name="physical_exam[height]" value="N/A - Not required for Audiometry and Ishihara Only" />
        <input type="hidden" name="physical_exam[weight]" value="N/A - Not required for Audiometry and Ishihara Only" />
        <input type="hidden" name="physical_exam[heart_rate]" value="N/A - Not required for Audiometry and Ishihara Only" />
        <?php endif; ?>
        
        <?php if(!$isAudiometryIshiharaOnly): ?>
        <!-- Skin Identification Marks Card -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-search text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Skin Marks & Tattoos</h3>
                    <p class="text-gray-600 text-sm">Notable skin marks, scars, tattoos, or identifying features</p>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">
                    Skin Marks Description <span class="text-red-500">*</span>
                </label>
                <textarea name="skin_marks" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['skin_marks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                          placeholder="Describe any visible skin marks, scars, tattoos, or identifying features..." required><?php echo e(old('skin_marks')); ?></textarea>
                <?php $__errorArgs = ['skin_marks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                    </p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <?php else: ?>
        <!-- Hidden input for skin marks when Audiometry and Ishihara Only -->
        <input type="hidden" name="skin_marks" value="N/A - Not required for Audiometry and Ishihara Only" />
        <?php endif; ?>
        
        <!-- Vision Tests Card - Show for Audiometry and Ishihara Only (for Ishihara test) or other tests (for visual acuity) -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-purple-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">
                        <?php if($isAudiometryIshiharaOnly): ?>
                            Ishihara Color Vision Test
                        <?php else: ?>
                            Vision Tests
                        <?php endif; ?>
                    </h3>
                    <p class="text-gray-600 text-sm">
                        <?php if($isAudiometryIshiharaOnly): ?>
                            Color vision assessment using Ishihara test
                        <?php else: ?>
                            Visual acuity and color vision assessments
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 <?php if(!$isAudiometryIshiharaOnly): ?> md:grid-cols-2 <?php endif; ?> gap-6">
                <?php if(!$isAudiometryIshiharaOnly): ?>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Visual Acuity <span class="text-red-500">*</span>
                    </label>
                    <textarea name="visual" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['visual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              placeholder="Record visual acuity test results (e.g., 20/20, corrected/uncorrected vision)" required><?php echo e(old('visual')); ?></textarea>
                    <?php $__errorArgs = ['visual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <?php else: ?>
                <!-- Hidden input for visual acuity when Audiometry and Ishihara Only -->
                <input type="hidden" name="visual" value="N/A - Not required for Audiometry and Ishihara Only" />
                <?php endif; ?>

                <?php if($isAudiometryIshiharaOnly || in_array(strtolower($medicalTestName), ['pre-employment with drug test and audio and ishihara'])): ?>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Ishihara Test <span class="text-red-500">*</span>
                    </label>
                    <textarea name="ishihara_test" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['ishihara_test'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              placeholder="Record color vision test results (e.g., Normal, Color blind - specify type)" required><?php echo e(old('ishihara_test')); ?></textarea>
                    <?php $__errorArgs = ['ishihara_test'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <?php else: ?>
                <!-- Ishihara test hidden for other pre-employment medical tests -->
                <input type="hidden" name="ishihara_test" value="N/A - Not required for this medical test" />
                <?php endif; ?>
            </div>
        </div>
        
        <?php if($hasDrugTest): ?>
        <!-- Drug Test Form Card -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-pills text-red-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Drug Test Result (DT Form 2)</h3>
                    <p class="text-gray-600 text-sm">Urine drug screening examination form</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Patient Information Section -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Patient Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="drug_test[patient_name]" 
                                   value="<?php echo e(old('drug_test.patient_name', ($preEmploymentRecord->full_name ?? ($preEmploymentRecord->first_name . ' ' . $preEmploymentRecord->last_name)))); ?>" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['drug_test.patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Full name" required />
                            <?php $__errorArgs = ['drug_test.patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="drug_test[address]" value="<?php echo e(old('drug_test.address')); ?>" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['drug_test.address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Patient address" required />
                            <?php $__errorArgs = ['drug_test.address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Age <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="drug_test[age]" 
                                   value="<?php echo e(old('drug_test.age', $preEmploymentRecord->age ?? '')); ?>" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['drug_test.age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Age" required />
                            <?php $__errorArgs = ['drug_test.age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Gender <span class="text-red-500">*</span>
                            </label>
                            <select name="drug_test[gender]" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['drug_test.gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?php echo e(old('drug_test.gender', ucfirst($preEmploymentRecord->sex ?? '')) == 'Male' ? 'selected' : ''); ?>>Male</option>
                                <option value="Female" <?php echo e(old('drug_test.gender', ucfirst($preEmploymentRecord->sex ?? '')) == 'Female' ? 'selected' : ''); ?>>Female</option>
                            </select>
                            <?php $__errorArgs = ['drug_test.gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Examination Details Section -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Examination Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Date and Time of Examination <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="drug_test[examination_datetime]" 
                                   value="<?php echo e(old('drug_test.examination_datetime', now()->format('Y-m-d\TH:i'))); ?>" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['drug_test.examination_datetime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   required />
                            <?php $__errorArgs = ['drug_test.examination_datetime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Date of Admission to the Program
                            </label>
                            <input type="date" name="drug_test[admission_date]" 
                                   value="<?php echo e(old('drug_test.admission_date')); ?>" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['drug_test.admission_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" />
                            <?php $__errorArgs = ['drug_test.admission_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Date of Last Intake of Substance
                            </label>
                            <input type="date" name="drug_test[last_intake_date]" 
                                   value="<?php echo e(old('drug_test.last_intake_date')); ?>" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['drug_test.last_intake_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" />
                            <?php $__errorArgs = ['drug_test.last_intake_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Test Method <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="drug_test[test_method]" 
                                   value="<?php echo e(old('drug_test.test_method', 'URINE TEST KIT')); ?>" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['drug_test.test_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   required />
                            <?php $__errorArgs = ['drug_test.test_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Drug Test Results Section -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Drug Test Results</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-900">Drug/Metabolites</th>
                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-900">Result</th>
                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-900">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-3 font-medium">METHAMPHETAMINE (Meth)</td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <select name="drug_test[methamphetamine_result]" 
                                                class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['drug_test.methamphetamine_result'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                required>
                                            <option value="">Select Result</option>
                                            <option value="Negative" <?php echo e(old('drug_test.methamphetamine_result') == 'Negative' ? 'selected' : ''); ?>>Negative</option>
                                            <option value="Positive" <?php echo e(old('drug_test.methamphetamine_result') == 'Positive' ? 'selected' : ''); ?>>Positive</option>
                                        </select>
                                        <?php $__errorArgs = ['drug_test.methamphetamine_result'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <input type="text" name="drug_test[methamphetamine_remarks]" 
                                               value="<?php echo e(old('drug_test.methamphetamine_remarks')); ?>" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                               placeholder="Optional remarks" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-3 font-medium">TETRAHYDROCANNABINOL (Marijuana)</td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <select name="drug_test[marijuana_result]" 
                                                class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['drug_test.marijuana_result'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                required>
                                            <option value="">Select Result</option>
                                            <option value="Negative" <?php echo e(old('drug_test.marijuana_result') == 'Negative' ? 'selected' : ''); ?>>Negative</option>
                                            <option value="Positive" <?php echo e(old('drug_test.marijuana_result') == 'Positive' ? 'selected' : ''); ?>>Positive</option>
                                        </select>
                                        <?php $__errorArgs = ['drug_test.marijuana_result'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <input type="text" name="drug_test[marijuana_remarks]" 
                                               value="<?php echo e(old('drug_test.marijuana_remarks')); ?>" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                               placeholder="Optional remarks" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Signatures Section -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Signatures</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Test Conducted by:
                            </label>
                            <div class="border-b-2 border-gray-400 pb-2 mb-2">
                                <p class="text-center font-medium"><?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?></p>
                            </div>
                            <p class="text-xs text-gray-500 text-center">Signature over Printed Name of Staff</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Conforme:
                            </label>
                            <div class="border-b-2 border-gray-400 pb-2 mb-2 h-8">
                                <!-- Empty space for patient signature -->
                            </div>
                            <p class="text-xs text-gray-500 text-center">Signature over Printed Name of Client</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Medical Findings Card -->
        <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-indigo-600"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Medical Findings</h3>
                    <p class="text-gray-600 text-sm">Overall examination findings and recommendations</p>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">
                    Examination Findings <span class="text-red-500">*</span>
                </label>
                <textarea name="findings" rows="5" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['findings'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                          placeholder="Record overall medical findings, any abnormalities, recommendations, or fitness for employment assessment..." required><?php echo e(old('findings')); ?></textarea>
                <?php $__errorArgs = ['findings'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                    </p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <p class="text-gray-600 text-sm">Examination completed by: <?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?></p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Medical Technologist</p>
                        <div class="border-b-2 border-gray-400 w-64 mt-3 mb-2"></div>
                        <p class="text-xs text-gray-500"><?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?></p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Date</p>
                        <div class="border-b-2 border-gray-400 w-32 mt-3 mb-2"></div>
                        <p class="text-xs text-gray-500"><?php echo e(now()->format('M d, Y')); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-end pt-8 border-t border-gray-200 space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="<?php echo e(route('nurse.pre-employment')); ?>" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-lg">
                <i class="fas fa-save mr-2"></i>Create Examination
            </button>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
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
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                } else {
                    this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                    this.classList.add('border-emerald-500', 'ring-2', 'ring-emerald-200');
                }
            });

            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('border-red-500', 'ring-red-200');
                    this.classList.add('border-emerald-500', 'ring-emerald-200');
                }
            });
        });

        // Form submission confirmation
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('input[required], textarea[required]');
            let hasErrors = false;
            
            requiredFields.forEach(field => {
                if (field.value.trim() === '') {
                    hasErrors = true;
                    field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                }
            });
            
            if (hasErrors) {
                e.preventDefault();
                alert('Please fill in all required fields before submitting.');
                return;
            }
            
            if (!confirm('Are you sure you want to create this pre-employment medical examination?')) {
                e.preventDefault();
            }
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nurse', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/nurse/pre-employment-create.blade.php ENDPATH**/ ?>