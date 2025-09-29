<?php $__env->startSection('content'); ?>
<?php
    // Determine which test should be unlocked (first incomplete test)
    $unlockedTest = null;
    foreach($examinations as $field => $exam) {
        $completedBy = isset($medicalChecklist) ? ($medicalChecklist->{$field . '_done_by'} ?? null) : null;
        if (!$completedBy) {
            $unlockedTest = $field;
            break;
        }
    }
?>

<div class="max-w-5xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-t-xl px-8 py-6 shadow-lg">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-clipboard-check text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white">Medical Checklist</h1>
                <p class="text-teal-100 text-sm">Complete examinations in sequential order</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-b-xl shadow-lg">
        <form action="<?php echo e(isset($medicalChecklist) && $medicalChecklist->id ? route('radtech.medical-checklist.update', $medicalChecklist->id) : route('radtech.medical-checklist.store')); ?>" method="POST" enctype="multipart/form-data">
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

            <!-- Patient Information -->
            <div class="p-8 border-b border-gray-200">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">Patient Information</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2 uppercase">Patient Name</label>
                        <input type="text" name="name" value="<?php echo e(old('name', $medicalChecklist->name ?? (isset($preEmploymentRecord) ? ($preEmploymentRecord->first_name . ' ' . $preEmploymentRecord->last_name) : (isset($patient) ? ($patient->first_name . ' ' . $patient->last_name) : '')) )); ?>" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2 uppercase">Examination Date</label>
                        <?php
                            $currentDate = old('date', ($medicalChecklist->date ?? now()->format('Y-m-d')));
                        ?>
                        <div class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 bg-gray-50 text-gray-700">
                            <?php echo e(\Carbon\Carbon::parse($currentDate)->format('M d, Y')); ?>

                        </div>
                        <input type="hidden" name="date" value="<?php echo e($currentDate); ?>" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2 uppercase">Age</label>
                        <input type="number" name="age" value="<?php echo e(old('age', $medicalChecklist->age ?? (isset($preEmploymentRecord) ? $preEmploymentRecord->age : (isset($patient) ? $patient->age : '')) )); ?>" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2 uppercase">Record Number</label>
                        <?php($displayNumber = old('number', $medicalChecklist->number ?? ($number ?? '')))
                        @if($displayNumber)
                            <div class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 bg-gray-50 text-gray-700">
                                {{ $displayNumber }}
                            </div>
                        @else
                            <div class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 bg-gray-50 text-gray-500">
                                N/A
                            </div>
                        @endif
                        <input type="hidden" name="number" value="{{ $displayNumber }}" />
                    </div>
                </div>
            </div>

            <!-- Medical Examinations Checklist -->
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-tasks text-purple-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Medical Examinations Checklist</h2>
                        <p class="text-sm text-gray-500">Tests must be completed in order</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach($examinations as $field => $exam)
                        @php
                            $completedBy = isset($medicalChecklist) ? ($medicalChecklist->{$field . '_done_by'} ?? null) : null;
                            $isUnlocked = ($field === $unlockedTest);
                            $isCompleted = !empty($completedBy);
                        ?>
                        
                        <div class="flex items-center justify-between p-4 rounded-lg border-2 <?php echo e($isCompleted ? 'bg-green-50 border-green-300' : ($isUnlocked ? 'bg-blue-50 border-blue-400 shadow-md' : 'bg-gray-50 border-gray-200')); ?>">
                            <!-- Left Side: Number, Icon, Name -->
                            <div class="flex items-center space-x-4 flex-1">
                                <!-- Number Badge -->
                                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold <?php echo e($isCompleted ? 'bg-green-500 text-white' : ($isUnlocked ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600')); ?>">
                                    <?php echo e($loop->iteration); ?>

                                </div>
                                
                                <!-- Icon -->
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center <?php echo e($isCompleted ? 'bg-green-200' : ($isUnlocked ? 'bg-blue-200' : 'bg-gray-200')); ?>">
                                    <i class="<?php echo e($exam['icon']); ?> <?php echo e($isCompleted ? 'text-green-700' : ($isUnlocked ? 'text-blue-700' : 'text-gray-500')); ?> text-lg"></i>
                                </div>
                                
                                <!-- Test Name & Status -->
                                <div class="flex-1">
                                    <h4 class="font-semibold <?php echo e($isCompleted ? 'text-green-900' : ($isUnlocked ? 'text-blue-900' : 'text-gray-500')); ?>">
                                        <?php echo e($loop->iteration); ?>. <?php echo e($exam['name']); ?>

                                    </h4>
                                    <p class="text-xs <?php echo e($isCompleted ? 'text-green-600' : ($isUnlocked ? 'text-blue-600' : 'text-gray-400')); ?>">
                                        <?php if($isCompleted): ?>
                                            Completed by <?php echo e($completedBy); ?>

                                        <?php elseif($isUnlocked): ?>
                                            Ready to complete
                                        <?php else: ?>
                                            Locked - Complete previous tests first
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Right Side: Status/Input -->
                            <div class="flex items-center">
                                <?php if($isCompleted): ?>
                                    <span class="px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg flex items-center">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Completed
                                    </span>
                                <?php elseif($isUnlocked): ?>
                                    <?php if($field === 'chest_xray'): ?>
                                        <input type="text" name="chest_xray_done_by" value="<?php echo e(old('chest_xray_done_by', '')); ?>" placeholder="Enter your initials" class="w-48 px-4 py-2 text-sm rounded-lg border-2 border-blue-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <?php else: ?>
                                        <span class="px-4 py-2 bg-gray-200 text-gray-600 text-sm font-medium rounded-lg flex items-center">
                                            <i class="fas fa-user-md mr-2"></i>
                                            Other Staff
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="px-4 py-2 bg-gray-200 text-gray-500 text-sm font-medium rounded-lg flex items-center">
                                        <i class="fas fa-lock mr-2"></i>
                                        Locked
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Physical Examination Section -->
            <div class="px-8 pb-8">
                <div class="bg-teal-50 rounded-lg p-6 border border-teal-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-heartbeat text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Physical Examination</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-2">Optional Examinations</label>
                            <input type="text" name="optional_exam" value="<?php echo e(old('optional_exam', isset($medicalChecklist) ? $medicalChecklist->optional_exam : 'Audiometry/Ishihara')); ?>" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-2">Nurse Signature</label>
                            <input type="text" name="nurse_signature" value="<?php echo e(old('nurse_signature', isset($medicalChecklist) ? $medicalChecklist->nurse_signature : '')); ?>" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500" placeholder="Nurse initials" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- X-Ray Image Upload -->
            <?php if($unlockedTest === 'chest_xray' || (isset($medicalChecklist) && $medicalChecklist->chest_xray_done_by)): ?>
            <div class="px-8 pb-8">
                <div class="bg-cyan-50 rounded-lg p-6 border border-cyan-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-x-ray text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">X-Ray Image</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload X-Ray Image</label>
                            <input type="file" name="xray_image" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-cyan-100 file:text-cyan-700 hover:file:bg-cyan-200">
                            <p class="text-xs text-gray-500 mt-2">JPG, PNG, GIF (Max: 25MB)</p>
                        </div>
                        <?php if(isset($medicalChecklist) && $medicalChecklist->xray_image_path): ?>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Current Image</label>
                            <img src="<?php echo e(asset('storage/' . $medicalChecklist->xray_image_path)); ?>" alt="X-Ray" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Submit Buttons -->
            <div class="px-8 pb-8">
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <button type="button" onclick="window.history.back()" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-teal-500 to-teal-600 text-white px-8 py-3 rounded-lg shadow-lg hover:from-teal-600 hover:to-teal-700 font-semibold">
                        <i class="fas fa-save mr-2"></i><?php echo e(isset($medicalChecklist) && $medicalChecklist->id ? 'Update Checklist' : 'Save Checklist'); ?>

                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .content-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.radtech', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/radtech/medical-checklist.blade.php ENDPATH**/ ?>