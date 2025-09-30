<?php $__env->startSection('title', 'Medical Checklist'); ?>
<?php $__env->startSection('page-title', 'Medical Checklist'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300 text-center font-semibold">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300">
        <h4 class="font-semibold mb-2">Validation Errors:</h4>
        <ul class="list-disc list-inside">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>


<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="bg-teal-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">MEDICAL CHECKLIST</h2>
        </div>

        <?php
            $formAction = isset($medicalChecklist) && $medicalChecklist->id 
                ? route('pathologist.medical-checklist.update', $medicalChecklist->id) 
                : route('pathologist.medical-checklist.store');
            
            // Preserve URL parameters in form action
            if (request('pre_employment_record_id') || request('patient_id') || request('examination_type')) {
                $params = [];
                if (request('pre_employment_record_id')) $params['pre_employment_record_id'] = request('pre_employment_record_id');
                if (request('patient_id')) $params['patient_id'] = request('patient_id');
                if (request('examination_type')) $params['examination_type'] = request('examination_type');
                $formAction .= '?' . http_build_query($params);
            }
        ?>
        
        <form action="<?php echo e($formAction); ?>" method="POST" class="space-y-8">
            <?php echo csrf_field(); ?>
            <?php if(isset($medicalChecklist) && $medicalChecklist->id): ?>
                <?php echo method_field('PATCH'); ?>
            <?php endif; ?>
            
            <input type="hidden" name="examination_type" value="<?php echo e((isset($examinationType) && ($examinationType === 'pre-employment' || $examinationType === 'pre_employment')) ? 'pre_employment' : 'annual_physical'); ?>">
            
            
            <?php if(request('pre_employment_record_id')): ?>
                <input type="hidden" name="pre_employment_record_id" value="<?php echo e(request('pre_employment_record_id')); ?>">
            <?php elseif(isset($preEmploymentRecord) && $preEmploymentRecord): ?>
                <input type="hidden" name="pre_employment_record_id" value="<?php echo e($preEmploymentRecord->id); ?>">
            <?php endif; ?>
            
            <?php if(request('patient_id')): ?>
                <input type="hidden" name="patient_id" value="<?php echo e(request('patient_id')); ?>">
            <?php elseif(isset($patient) && $patient): ?>
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
                } elseif (isset($patient) && $patient) {
                    $generatedNumber = 'APEP-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                } elseif (isset($preEmploymentRecord) && $preEmploymentRecord) {
                    $generatedNumber = 'PPEP-' . str_pad($preEmploymentRecord->id, 4, '0', STR_PAD_LEFT);
                } else {
                    $generatedNumber = $number ?: old('number', '');
                }
            ?>

            <!-- Patient Information -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Name</label>
                    <div class="text-lg font-semibold text-gray-800">
                        <?php if(isset($medicalChecklist) && $medicalChecklist->patient): ?>
                            <?php echo e($medicalChecklist->patient->full_name); ?>

                        <?php elseif(isset($patient) && $patient): ?>
                            <?php echo e($patient->full_name); ?>

                        <?php elseif(isset($preEmploymentRecord) && $preEmploymentRecord): ?>
                            <?php echo e($preEmploymentRecord->first_name); ?> <?php echo e($preEmploymentRecord->last_name); ?>

                        <?php else: ?>
                            <?php echo e($name ?: old('name', '')); ?>

                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="name" value="<?php if(isset($medicalChecklist) && $medicalChecklist->patient): ?><?php echo e($medicalChecklist->patient->full_name); ?><?php elseif(isset($patient) && $patient): ?><?php echo e($patient->full_name); ?><?php elseif(isset($preEmploymentRecord) && $preEmploymentRecord): ?><?php echo e($preEmploymentRecord->first_name); ?> <?php echo e($preEmploymentRecord->last_name); ?><?php else: ?><?php echo e($name ?: old('name', '')); ?><?php endif; ?>" />
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Date</label>
                    <?php ($currentDate = old('date', $medicalChecklist->date ?? $date ?? now()->format('Y-m-d'))); ?>
                    <div class="text-lg font-semibold text-gray-800">
                        <?php echo e(\Carbon\Carbon::parse($currentDate)->format('M d, Y')); ?>

                    </div>
                    <input type="hidden" name="date" value="<?php echo e($currentDate); ?>" />
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Age</label>
                    <div class="text-lg font-semibold text-gray-800">
                        <?php if(isset($medicalChecklist) && $medicalChecklist->patient): ?>
                            <?php echo e($medicalChecklist->patient->age); ?>

                        <?php elseif(isset($patient) && $patient): ?>
                            <?php echo e($patient->age); ?>

                        <?php elseif(isset($preEmploymentRecord) && $preEmploymentRecord): ?>
                            <?php echo e($preEmploymentRecord->age); ?>

                        <?php else: ?>
                            <?php echo e($age ?: old('age', '')); ?>

                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="age" value="<?php if(isset($medicalChecklist) && $medicalChecklist->patient): ?><?php echo e($medicalChecklist->patient->age); ?><?php elseif(isset($patient) && $patient): ?><?php echo e($patient->age); ?><?php elseif(isset($preEmploymentRecord) && $preEmploymentRecord): ?><?php echo e($preEmploymentRecord->age); ?><?php else: ?><?php echo e($age ?: old('age', '')); ?><?php endif; ?>" />
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Record Number</label>
                    <div class="text-lg font-semibold text-gray-800 font-mono">
                        <?php echo e($generatedNumber ?: 'N/A'); ?>

                    </div>
                    <input type="hidden" name="number" value="<?php echo e($generatedNumber); ?>" />
                </div>
            </div>

            <!-- Laboratory Examinations -->
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-6 text-center">
                    <i class="fas fa-clipboard-check mr-2 text-teal-600"></i>Laboratory Examinations
                </h3>
                
                <div class="space-y-4">
                    <?php $__currentLoopData = [
                        'chest_xray' => ['Chest X-Ray', 'fas fa-x-ray'],
                        'stool_exam' => ['Stool Exam', 'fas fa-vial'],
                        'urinalysis' => ['Urinalysis', 'fas fa-tint'],
                        'drug_test' => ['Drug Test', 'fas fa-pills'],
                        'blood_extraction' => ['Blood Extraction', 'fas fa-syringe'],
                        'ecg' => ['ElectroCardioGram (ECG)', 'fas fa-heartbeat'],
                        'physical_exam' => ['Physical Exam', 'fas fa-stethoscope'],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $examData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                    <i class="<?php echo e($examData[1]); ?> text-teal-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700"><?php echo e($loop->iteration); ?>. <?php echo e($examData[0]); ?></span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-600">Completed by:</span>
                                <input type="text" name="<?php echo e($field); ?>_done_by"
                                       value="<?php echo e(old($field . '_done_by', $medicalChecklist->{$field . '_done_by'} ?? '')); ?>"
                                       placeholder="Initials/Signature"
                                       <?php if($field === 'stool_exam' || $field === 'urinalysis'): ?> 
                                           class="form-input w-32 rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500" 
                                       <?php else: ?> 
                                           readonly class="form-input w-32 rounded-lg border-gray-300 text-sm bg-gray-50 text-gray-700" 
                                       <?php endif; ?>>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Optional Exam -->
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-plus-circle mr-2 text-teal-600"></i>Additional Examinations
                </h3>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Optional Examinations</label>
                    <input type="text" name="optional_exam" 
                           value="<?php echo e(old('optional_exam', $medicalChecklist->optional_exam ?? $optionalExam ?? 'Audiometry/Ishihara')); ?>" 
                           class="form-input w-full rounded-lg border-gray-300 focus:ring-teal-500 focus:border-teal-500" 
                           placeholder="Enter additional examinations if any" />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="<?php echo e($examinationType === 'pre-employment' ? route('pathologist.pre-employment') : route('pathologist.annual-physical')); ?>" 
                   class="bg-gray-500 text-white px-8 py-3 rounded-lg shadow hover:bg-gray-600 transition-colors font-semibold tracking-wide">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
                <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-3 rounded-lg shadow hover:from-green-700 hover:to-green-800 transition-all font-semibold tracking-wide transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Submit Checklist
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Form validation and debugging
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = ['stool_exam_done_by', 'urinalysis_done_by'];
        let isValid = true;
        
        
        requiredFields.forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields (Stool Exam and Urinalysis).');
            return false;
        }
        
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pathologist', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/pathologist/medical-checklist.blade.php ENDPATH**/ ?>