<?php $__env->startSection('title', 'Create Pre-Employment Examination'); ?>
<?php $__env->startSection('page-title', 'Create Pre-Employment Examination'); ?>

<?php $__env->startSection('content'); ?>
<?php if($errors->any()): ?>
    <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300 text-center font-semibold">
        <h3 class="font-bold mb-2">Please complete all required fields:</h3>
        <ul class="text-sm text-left">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>• <?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 mb-8">
        <div class="bg-green-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">CERTIFICATE OF MEDICAL EXAMINATION</h2>
        </div>
        <?php if($preEmploymentRecord): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Full Name</label>
                <div class="text-lg font-semibold"><?php echo e($preEmploymentRecord->full_name ?? ($preEmploymentRecord->first_name . ' ' . $preEmploymentRecord->last_name)); ?></div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Age</label>
                <div class="text-lg font-semibold"><?php echo e($preEmploymentRecord->age); ?></div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Sex</label>
                <div class="text-lg font-semibold"><?php echo e($preEmploymentRecord->sex); ?></div>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase mb-1">Company Name</label>
                <div class="text-lg font-semibold"><?php echo e($preEmploymentRecord->company_name); ?></div>
            </div>
        </div>
        <?php endif; ?>
        <form action="<?php echo e(route('nurse.pre-employment.store')); ?>" method="POST" class="space-y-8">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="pre_employment_record_id" value="<?php echo e($preEmploymentRecord->id); ?>">
            
          
          
            <!-- Physical Examination -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Physical Examination</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <?php $phys = old('physical_exam', []); ?>
                    <div>
                        <label class="block text-xs mb-1">Temp <span class="text-red-500">*</span></label>
                        <input type="text" name="physical_exam[temp]" value="<?php echo e($phys['temp'] ?? ''); ?>" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['physical_exam.temp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required />
                        <?php $__errorArgs = ['physical_exam.temp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Height <span class="text-red-500">*</span></label>
                        <input type="text" name="physical_exam[height]" value="<?php echo e($phys['height'] ?? ''); ?>" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['physical_exam.height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required />
                        <?php $__errorArgs = ['physical_exam.height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Weight <span class="text-red-500">*</span></label>
                        <input type="text" name="physical_exam[weight]" value="<?php echo e($phys['weight'] ?? ''); ?>" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['physical_exam.weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required />
                        <?php $__errorArgs = ['physical_exam.weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Heart Rate <span class="text-red-500">*</span></label>
                        <input type="text" name="physical_exam[heart_rate]" value="<?php echo e($phys['heart_rate'] ?? ''); ?>" class="form-input w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['physical_exam.heart_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required />
                        <?php $__errorArgs = ['physical_exam.heart_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                  
                </div>
            </div>
            
            <!-- Skin Marks -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Skin Marks / Tattoos <span class="text-red-500">*</span></label>
                <textarea name="skin_marks" class="form-textarea w-full h-16 rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['skin_marks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('skin_marks')); ?></textarea>
                <?php $__errorArgs = ['skin_marks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <!-- Visual Acuity -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-2">Visual Acuity <span class="text-red-500">*</span></label>
                        <textarea name="visual" class="form-textarea w-full h-16 rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['visual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('visual')); ?></textarea>
                        <?php $__errorArgs = ['visual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-2">Ishihara Test <span class="text-red-500">*</span></label>
                        <textarea name="ishihara_test" class="form-textarea w-full h-16 rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['ishihara_test'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('ishihara_test')); ?></textarea>
                        <?php $__errorArgs = ['ishihara_test'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
            
            <!-- Findings -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-xs font-semibold uppercase mb-2">Findings <span class="text-red-500">*</span></label>
                <textarea name="findings" class="form-textarea w-full h-24 rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['findings'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('findings')); ?></textarea>
                <?php $__errorArgs = ['findings'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
          
          
            
          
          
            
            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="<?php echo e(route('nurse.pre-employment')); ?>" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    Create Examination
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nurse', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/nurse/pre-employment-create.blade.php ENDPATH**/ ?>