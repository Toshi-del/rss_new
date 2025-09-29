<?php $__env->startSection('title', 'Pre-Employment Record Details'); ?>
<?php $__env->startSection('page-title', 'Pre-Employment Record Details'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300 text-center font-semibold shadow-sm">
        <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300 text-center font-semibold shadow-sm">
        <i class="fas fa-exclamation-circle mr-2"></i><?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-teal-600 to-blue-600 rounded-xl shadow-lg p-6 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pre-Employment Record</h1>
                <p class="text-teal-100"><?php echo e($preEmployment->full_name); ?></p>
                <p class="text-sm text-teal-200">Record ID: #<?php echo e($preEmployment->id); ?></p>
            </div>
            <div class="text-right">
                <div class="flex items-center space-x-3">
                    <?php
                        $statusConfig = [
                            'approved' => ['bg-green-500', 'fas fa-check-circle', 'Approved'],
                            'declined' => ['bg-red-500', 'fas fa-times-circle', 'Declined'],
                            'pending' => ['bg-yellow-500', 'fas fa-clock', 'Pending'],
                        ];
                        $config = $statusConfig[$preEmployment->status] ?? ['bg-gray-500', 'fas fa-question-circle', 'Unknown'];
                    ?>
                    <span class="px-4 py-2 rounded-full text-sm font-bold text-white <?php echo e($config[0]); ?> flex items-center">
                        <i class="<?php echo e($config[1]); ?> mr-2"></i>
                        <?php echo e($config[2]); ?>

                    </span>
                </div>
                <p class="text-sm text-teal-200 mt-2">Created: <?php echo e($preEmployment->created_at->format('M d, Y')); ?></p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between mb-8">
        <a href="<?php echo e(route('pathologist.pre-employment')); ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to List
        </a>
        
        <div class="flex items-center space-x-3">
            <a href="<?php echo e(route('pathologist.pre-employment.edit', $preEmployment->id)); ?>" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Edit Lab Results
            </a>
            
            <a href="<?php echo e(route('pathologist.medical-checklist')); ?>?pre_employment_record_id=<?php echo e($preEmployment->id); ?>&examination_type=pre_employment" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-clipboard-list mr-2"></i>
                Medical Checklist
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-user mr-2 text-teal-600"></i>Personal Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Full Name</label>
                            <p class="text-lg font-semibold text-gray-900"><?php echo e($preEmployment->full_name); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Age</label>
                            <p class="text-gray-900"><?php echo e($preEmployment->age); ?> years old</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Sex</label>
                            <span class="px-3 py-1 text-sm font-medium rounded-full <?php echo e($preEmployment->sex === 'Male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800'); ?>">
                                <?php echo e($preEmployment->sex); ?>

                            </span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Email Address</label>
                            <p class="text-gray-900"><?php echo e($preEmployment->email); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                            <p class="text-gray-900"><?php echo e($preEmployment->phone_number ?? 'Not provided'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Company</label>
                            <p class="text-gray-900 font-medium"><?php echo e($preEmployment->company_name); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pathologist Medical Tests -->
            <?php
                $pathologistTests = $preEmployment->pathologist_tests ?? collect();
                $groupedTests = $pathologistTests->groupBy('category_name');
                $allSelectedTests = $preEmployment->all_selected_tests ?? collect();
            ?>

            <?php if($pathologistTests->isNotEmpty()): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fas fa-flask mr-2 text-teal-600"></i>Selected Medical Tests
                    </h3>
                    
                    <?php $__currentLoopData = $groupedTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $tests): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-6 last:mb-0">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-purple-100 text-purple-800 mr-3">
                                    <?php echo e($categoryName); ?>

                                </span>
                                <span class="text-sm text-gray-500">(<?php echo e($tests->count()); ?> test<?php echo e($tests->count() > 1 ? 's' : ''); ?>)</span>
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h5 class="font-semibold text-gray-900"><?php echo e($test['test_name']); ?></h5>
                                                <?php if(isset($test['category_name'])): ?>
                                                    <p class="text-sm text-gray-600 mt-1">Category: <?php echo e($test['category_name']); ?></p>
                                                <?php endif; ?>
                                                <?php if($test['is_package_component'] ?? false): ?>
                                                    <p class="text-sm text-blue-600 mt-1">
                                                        <i class="fas fa-box mr-1"></i>From package: <?php echo e($test['package_name']); ?>

                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($test['is_package_component'] ?? false): ?>
                                                <div class="ml-4">
                                                    <span class="px-2 py-1 text-xs font-bold bg-blue-100 text-blue-700 rounded">
                                                        Package Component
                                                    </span>
                                                </div>
                                            <?php elseif($test['price'] > 0): ?>
                                                <div class="ml-4">
                                                    <span class="px-2 py-1 text-xs font-bold bg-emerald-100 text-emerald-700 rounded">
                                                        ₱<?php echo e(number_format($test['price'], 2)); ?>

                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Total Price -->
                    <?php if($preEmployment->total_price > 0): ?>
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-semibold text-gray-700">Total Price:</span>
                                <span class="text-2xl font-bold text-emerald-600">₱<?php echo e(number_format($preEmployment->total_price, 2)); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Original Selected Packages (for context) -->
                <?php if($allSelectedTests->isNotEmpty()): ?>
                    <div class="mt-8 bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="text-md font-semibold text-gray-700 mb-3">
                            <i class="fas fa-info-circle mr-2 text-gray-600"></i>Original Package Selection
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <?php $__currentLoopData = $allSelectedTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $originalTest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-gray-200">
                                    <div>
                                        <span class="font-medium text-gray-900"><?php echo e($originalTest['test_name']); ?></span>
                                        <div class="text-xs text-gray-600"><?php echo e($originalTest['category_name']); ?></div>
                                    </div>
                                    <?php if($originalTest['price'] > 0): ?>
                                        <span class="text-sm font-bold text-emerald-600">₱<?php echo e(number_format($originalTest['price'], 2)); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <!-- Fallback for single test records -->
                <?php if($preEmployment->medicalTest): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            <i class="fas fa-flask mr-2 text-teal-600"></i>Medical Test
                        </h3>
                        
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900"><?php echo e($preEmployment->medicalTest->name); ?></h5>
                                    <?php if($preEmployment->medicalTestCategory): ?>
                                        <p class="text-sm text-gray-600 mt-1">Category: <?php echo e($preEmployment->medicalTestCategory->name); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if($preEmployment->medicalTest->price > 0): ?>
                                    <div class="ml-4">
                                        <span class="px-2 py-1 text-xs font-bold bg-emerald-100 text-emerald-700 rounded">
                                            ₱<?php echo e(number_format($preEmployment->medicalTest->price, 2)); ?>

                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Additional Examinations -->
            <?php if($preEmployment->other_exams && !empty($preEmployment->parsed_other_exams['additional_exams'])): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fas fa-clipboard-list mr-2 text-teal-600"></i>Additional Examinations
                    </h3>
                    
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <h4 class="text-sm font-semibold text-blue-800 mb-2">Requested Additional Exams:</h4>
                        <p class="text-sm text-blue-700"><?php echo e($preEmployment->parsed_other_exams['additional_exams']); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Laboratory Results -->
            <?php if($preEmployment->preEmploymentExamination && $preEmployment->preEmploymentExamination->lab_report): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fas fa-microscope mr-2 text-teal-600"></i>Laboratory Results
                    </h3>
                    
                    <?php
                        $labReport = $preEmployment->preEmploymentExamination->lab_report;
                    ?>
                    
                    <?php if(!empty($labReport)): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">Test</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">Result</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">Findings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $displayedTests = [];
                                        
                                        // Fix: Get the most recent examination record with actual data
                                        $allExaminations = \App\Models\PreEmploymentExamination::where('pre_employment_record_id', $preEmployment->id)
                                            ->orderBy('updated_at', 'desc')
                                            ->get();
                                        
                                        // Find the examination with actual data (not just "Not available")
                                        $actualExamination = null;
                                        foreach($allExaminations as $exam) {
                                            $labData = $exam->lab_report;
                                            if ($labData && is_array($labData)) {
                                                // Check if this examination has real data (not just "Not available")
                                                $hasRealData = false;
                                                foreach($labData as $key => $value) {
                                                    if (!empty($value) && $value !== 'Not available' && !str_contains($key, '_others')) {
                                                        $hasRealData = true;
                                                        break;
                                                    }
                                                }
                                                if ($hasRealData) {
                                                    $actualExamination = $exam;
                                                    break;
                                                }
                                            }
                                        }
                                        
                                        // Use the examination with real data, or fall back to the most recent one
                                        $examinationToUse = $actualExamination ?: $allExaminations->first();
                                        $dataToUse = $examinationToUse ? $examinationToUse->lab_report : [];
                                        
                                        
                                        // Collect all test results from the correct data source
                                        foreach($dataToUse as $key => $value) {
                                            // Skip empty values, "Not available", and helper fields
                                            if (empty($value) || $value === 'Not available' || str_contains($key, '_others')) {
                                                continue;
                                            }
                                            
                                            if (str_ends_with($key, '_result')) {
                                                // This is a result field like "cbc_result"
                                                $testSlug = str_replace('_result', '', $key);
                                                $displayedTests[$testSlug] = [
                                                    'name' => ucwords(str_replace('_', ' ', $testSlug)),
                                                    'result' => $value,
                                                    'findings' => $dataToUse[$testSlug . '_findings'] ?? ''
                                                ];
                                            } elseif (!str_contains($key, '_result') && !str_contains($key, '_findings')) {
                                                // This could be a direct result field (from upper section dropdowns)
                                                // Check if there's a corresponding _result field, if so, skip this one
                                                if (!isset($dataToUse[$key . '_result'])) {
                                                    $displayedTests[$key] = [
                                                        'name' => ucwords(str_replace('_', ' ', $key)),
                                                        'result' => $value,
                                                        'findings' => $dataToUse[$key . '_findings'] ?? ''
                                                    ];
                                                }
                                            }
                                        }
                                        
                                        // Remove any tests where result is still "Not available"
                                        $displayedTests = array_filter($displayedTests, function($test) {
                                            return !empty($test['result']) && $test['result'] !== 'Not available';
                                        });
                                    ?>
                                    
                                    <?php $__empty_1 = true; $__currentLoopData = $displayedTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testSlug => $testData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php if(!empty($testData['result']) && $testData['result'] !== 'Not available'): ?>
                                            <tr>
                                                <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">
                                                    <?php echo e($testData['name']); ?>

                                                </td>
                                                <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">
                                                    <?php echo e($testData['result']); ?>

                                                </td>
                                                <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">
                                                    <?php echo e(!empty($testData['findings']) ? $testData['findings'] : '-'); ?>

                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                                                <i class="fas fa-flask text-gray-300 text-2xl mb-2 block"></i>
                                                No test results have been entered yet.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    
                                    <?php if(isset($labReport['additional_notes']) && !empty($labReport['additional_notes'])): ?>
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">Additional Notes</td>
                                            <td colspan="2" class="border border-gray-300 px-4 py-3 text-sm text-gray-900">
                                                <?php echo e($labReport['additional_notes']); ?>

                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-flask text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">No laboratory results available yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-bolt mr-2 text-teal-600"></i>Quick Actions
                </h3>
                
                <div class="space-y-3">
                    <a href="<?php echo e(route('pathologist.pre-employment.edit', $preEmployment->id)); ?>" 
                       class="w-full flex items-center px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors">
                        <i class="fas fa-edit mr-3"></i>
                        Edit Lab Results
                    </a>
                    
                    <a href="<?php echo e(route('pathologist.medical-checklist')); ?>?pre_employment_record_id=<?php echo e($preEmployment->id); ?>&examination_type=pre_employment" 
                       class="w-full flex items-center px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors">
                        <i class="fas fa-clipboard-list mr-3"></i>
                        Medical Checklist
                    </a>
                </div>
            </div>

            <!-- Record Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2 text-teal-600"></i>Record Information
                </h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Record ID:</span>
                        <span class="font-medium text-gray-900">#<?php echo e($preEmployment->id); ?></span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium text-gray-900"><?php echo e($preEmployment->created_at->format('M d, Y')); ?></span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Updated:</span>
                        <span class="font-medium text-gray-900"><?php echo e($preEmployment->updated_at->format('M d, Y')); ?></span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Billing Type:</span>
                        <span class="font-medium text-gray-900"><?php echo e($preEmployment->billing_type); ?></span>
                    </div>
                    
                    <?php if($preEmployment->uploaded_file): ?>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Source File:</span>
                            <span class="font-medium text-gray-900 text-xs"><?php echo e($preEmployment->uploaded_file); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pathologist Test Summary -->
            <?php if($pathologistTests->isNotEmpty()): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-chart-pie mr-2 text-teal-600"></i>Pathologist Test Summary
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Your Tests:</span>
                            <span class="font-bold text-gray-900"><?php echo e($pathologistTests->count()); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Categories:</span>
                            <span class="font-bold text-gray-900"><?php echo e($groupedTests->count()); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Package Tests:</span>
                            <span class="font-bold text-blue-600"><?php echo e($pathologistTests->where('is_package_component', true)->count()); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Individual Tests:</span>
                            <span class="font-bold text-emerald-600"><?php echo e($pathologistTests->where('is_package_component', false)->count()); ?></span>
                        </div>
                        
                        <?php if($preEmployment->total_price > 0): ?>
                            <div class="flex justify-between pt-2 border-t border-gray-200">
                                <span class="text-gray-600">Total Cost:</span>
                                <span class="font-bold text-emerald-600">₱<?php echo e(number_format($preEmployment->total_price, 2)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Add any specific JavaScript for the show page here
    console.log('Pre-employment record details loaded');
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pathologist', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/pathologist/pre-employment-show.blade.php ENDPATH**/ ?>