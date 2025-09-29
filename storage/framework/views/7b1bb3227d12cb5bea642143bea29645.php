<?php $__env->startSection('title', 'Edit Pre-Employment Examination'); ?>
<?php $__env->startSection('page-title', 'Edit Pre-Employment Examination'); ?>

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

<?php if($errors->any()): ?>
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300">
        <h4 class="font-semibold mb-2">
            <i class="fas fa-exclamation-triangle mr-2"></i>Please correct the following errors:
        </h4>
        <ul class="list-disc list-inside text-sm">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="max-w-6xl mx-auto">
    <form action="<?php echo e(route('pathologist.pre-employment.update', $examination->id)); ?>" method="POST" class="space-y-8">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <!-- Employee Information Header -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Pre-Employment Examination</h2>
                    <p class="text-green-100"><?php echo e($examination->name ?? $examination->preEmploymentRecord->full_name); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-semibold"><?php echo e($examination->date->format('M d, Y')); ?></p>
                    <p class="text-green-100"><?php echo e($examination->company_name ?? $examination->preEmploymentRecord->company_name); ?></p>
                </div>
            </div>
        </div>

        <!-- Pathologist Medical Tests -->
        <?php
            $pathologistTests = $examination->preEmploymentRecord->pathologist_tests ?? collect();
            $groupedTests = $pathologistTests->groupBy('category_name');
        ?>

        <?php if($pathologistTests->isNotEmpty()): ?>
            <?php $__currentLoopData = $groupedTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $tests): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fas fa-flask mr-2 text-teal-600"></i><?php echo e($categoryName); ?> Results
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $fieldName = 'lab_report[' . strtolower(str_replace([' ', '-', '&'], '_', $test['test_name'])) . ']';
                            ?>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <?php echo e($test['test_name']); ?>

                                    <?php if($test['is_package_component'] ?? false): ?>
                                        <div class="text-xs text-blue-600 font-medium mt-1">
                                            <i class="fas fa-box mr-1"></i>From: <?php echo e($test['package_name']); ?>

                                            <?php if($test['package_price'] > 0): ?>
                                                (Package: ₱<?php echo e(number_format($test['package_price'], 2)); ?>)
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif($test['price'] > 0): ?>
                                        <span class="text-xs text-emerald-600 font-medium">(₱<?php echo e(number_format($test['price'], 2)); ?>)</span>
                                    <?php endif; ?>
                                </label>
                                <?php
                                    $currentResult = old($fieldName, $examination->lab_report[strtolower(str_replace([' ', '-', '&'], '_', $test['test_name']))] ?? '');
                                    $isOthers = !in_array($currentResult, ['', 'Not available', 'Normal', 'Not normal']) && !empty($currentResult);
                                    $othersValue = $isOthers ? $currentResult : '';
                                    $selectValue = $isOthers ? 'Others' : ($currentResult ?: 'Not available');
                                    $testSlug = strtolower(str_replace([' ', '-', '&'], '_', $test['test_name']));
                                ?>
                                <select name="<?php echo e($fieldName); ?>" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 result-dropdown"
                                        data-test-slug="<?php echo e($testSlug); ?>">
                                    <option value="Not available" <?php echo e($selectValue == 'Not available' ? 'selected' : ''); ?>>Not available</option>
                                    <option value="Normal" <?php echo e($selectValue == 'Normal' ? 'selected' : ''); ?>>Normal</option>
                                    <option value="Not normal" <?php echo e($selectValue == 'Not normal' ? 'selected' : ''); ?>>Not normal</option>
                                    <option value="Others" <?php echo e($selectValue == 'Others' ? 'selected' : ''); ?>>Others (specify)</option>
                                </select>
                                <input type="text" 
                                       name="<?php echo e($fieldName); ?>_others" 
                                       value="<?php echo e($othersValue); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 mt-2 others-input" 
                                       data-test-slug="<?php echo e($testSlug); ?>"
                                       placeholder="Specify other result"
                                       style="<?php echo e($selectValue == 'Others' ? '' : 'display: none;'); ?>">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <!-- Fallback for records without selected tests data -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-flask mr-2 text-teal-600"></i>Laboratory Examination Report
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php if($examination->preEmploymentRecord->medicalTest): ?>
                        <?php
                            $testName = $examination->preEmploymentRecord->medicalTest->name;
                            $fieldName = 'lab_report[' . strtolower(str_replace([' ', '-', '&'], '_', $testName)) . ']';
                        ?>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700"><?php echo e($testName); ?></label>
                            <?php
                                $currentResult = old($fieldName, $examination->lab_report[strtolower(str_replace([' ', '-', '&'], '_', $testName))] ?? '');
                                $isOthers = !in_array($currentResult, ['', 'Not available', 'Normal', 'Not normal']) && !empty($currentResult);
                                $othersValue = $isOthers ? $currentResult : '';
                                $selectValue = $isOthers ? 'Others' : ($currentResult ?: 'Not available');
                                $testSlug = strtolower(str_replace([' ', '-', '&'], '_', $testName));
                            ?>
                            <select name="<?php echo e($fieldName); ?>" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 result-dropdown"
                                    data-test-slug="<?php echo e($testSlug); ?>">
                                <option value="Not available" <?php echo e($selectValue == 'Not available' ? 'selected' : ''); ?>>Not available</option>
                                <option value="Normal" <?php echo e($selectValue == 'Normal' ? 'selected' : ''); ?>>Normal</option>
                                <option value="Not normal" <?php echo e($selectValue == 'Not normal' ? 'selected' : ''); ?>>Not normal</option>
                                <option value="Others" <?php echo e($selectValue == 'Others' ? 'selected' : ''); ?>>Others (specify)</option>
                            </select>
                            <input type="text" 
                                   name="<?php echo e($fieldName); ?>_others" 
                                   value="<?php echo e($othersValue); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 mt-2 others-input" 
                                   data-test-slug="<?php echo e($testSlug); ?>"
                                   placeholder="Specify other result"
                                   style="<?php echo e($selectValue == 'Others' ? '' : 'display: none;'); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Additional Notes Section -->
        <?php if($examination->preEmploymentRecord->other_exams && !empty($examination->preEmploymentRecord->parsed_other_exams['additional_exams'])): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-clipboard-list mr-2 text-teal-600"></i>Additional Examinations
                </h3>
                
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <h4 class="text-sm font-semibold text-blue-800 mb-2">Requested Additional Exams:</h4>
                    <p class="text-sm text-blue-700"><?php echo e($examination->preEmploymentRecord->parsed_other_exams['additional_exams']); ?></p>
                </div>
                
                <div class="mt-4 space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Additional Examination Results</label>
                    <textarea name="lab_report[additional_exams_results]" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                              placeholder="Enter results for additional examinations"><?php echo e(old('lab_report.additional_exams_results', $examination->lab_report['additional_exams_results'] ?? '')); ?></textarea>
                </div>
            </div>
        <?php endif; ?>

        <!-- Laboratory Examinations Report Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-flask mr-2 text-teal-600"></i>Laboratory Examinations Report Summary
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
                        <?php if($pathologistTests->isNotEmpty()): ?>
                            <?php $__currentLoopData = $pathologistTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $testNameSlug = strtolower(str_replace([' ', '-', '&'], '_', $test['test_name']));
                                    $resultFieldName = 'lab_report[' . $testNameSlug . '_result]';
                                    $findingsFieldName = 'lab_report[' . $testNameSlug . '_findings]';
                                ?>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">
                                        <?php echo e($test['test_name']); ?>

                                        <?php if($test['is_package_component'] ?? false): ?>
                                            <div class="text-xs text-blue-600 mt-1">
                                                <i class="fas fa-box mr-1"></i><?php echo e($test['package_name']); ?>

                                            </div>
                                        <?php elseif($test['price'] > 0): ?>
                                            <div class="text-xs text-emerald-600">(₱<?php echo e(number_format($test['price'], 2)); ?>)</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <input type="text" 
                                               name="<?php echo e($resultFieldName); ?>" 
                                               value="<?php echo e(old($resultFieldName, $examination->lab_report[$testNameSlug . '_result'] ?? '')); ?>"
                                               class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm bg-gray-50 table-result-display"
                                               data-test-slug="<?php echo e($testNameSlug); ?>"
                                               readonly
                                               placeholder="Auto-filled from above">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <input type="text" name="<?php echo e($findingsFieldName); ?>" 
                                               value="<?php echo e(old($findingsFieldName, $examination->lab_report[$testNameSlug . '_findings'] ?? '')); ?>"
                                               class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                               placeholder="Enter findings">
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <!-- Fallback for records without selected tests data -->
                            <?php if($examination->preEmploymentRecord->medicalTest): ?>
                                <?php
                                    $testName = $examination->preEmploymentRecord->medicalTest->name;
                                    $testNameSlug = strtolower(str_replace([' ', '-', '&'], '_', $testName));
                                    $resultFieldName = 'lab_report[' . $testNameSlug . '_result]';
                                    $findingsFieldName = 'lab_report[' . $testNameSlug . '_findings]';
                                ?>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700"><?php echo e($testName); ?></td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <input type="text" 
                                               name="<?php echo e($resultFieldName); ?>" 
                                               value="<?php echo e(old($resultFieldName, $examination->lab_report[$testNameSlug . '_result'] ?? '')); ?>"
                                               class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm bg-gray-50 table-result-display"
                                               data-test-slug="<?php echo e($testNameSlug); ?>"
                                               readonly
                                               placeholder="Auto-filled from above">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <input type="text" name="<?php echo e($findingsFieldName); ?>" 
                                               value="<?php echo e(old($findingsFieldName, $examination->lab_report[$testNameSlug . '_findings'] ?? '')); ?>"
                                               class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm"
                                               placeholder="Enter findings">
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <!-- Additional row for any extra findings -->
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700">Additional Notes</td>
                            <td class="border border-gray-300 px-4 py-3" colspan="2">
                                <textarea name="lab_report[additional_notes]" rows="2"
                                          class="w-full px-2 py-1 border-0 focus:ring-0 focus:outline-none text-sm resize-none"
                                          placeholder="Enter any additional notes or observations"><?php echo e(old('lab_report.additional_notes', $examination->lab_report['additional_notes'] ?? '')); ?></textarea>
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
                        <option value="Pending" <?php echo e(old('status', $examination->status) == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="Approved" <?php echo e(old('status', $examination->status) == 'Approved' ? 'selected' : ''); ?>>Approved</option>
                        <option value="sent_to_company" <?php echo e(old('status', $examination->status) == 'sent_to_company' ? 'selected' : ''); ?>>Sent to Company</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="<?php echo e(route('pathologist.pre-employment')); ?>" 
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Result dropdown functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Function to update table result display
        function updateTableResult(testSlug) {
            const dropdown = document.querySelector(`.result-dropdown[data-test-slug="${testSlug}"]`);
            const othersInput = document.querySelector(`.others-input[data-test-slug="${testSlug}"]`);
            const tableResultDisplay = document.querySelector(`.table-result-display[data-test-slug="${testSlug}"]`);
            
            if (dropdown && tableResultDisplay) {
                let resultValue = dropdown.value;
                
                // If "Others" is selected and there's a value in the others input, use that
                if (dropdown.value === 'Others' && othersInput && othersInput.value.trim()) {
                    resultValue = othersInput.value.trim();
                }
                
                tableResultDisplay.value = resultValue;
            }
        }
        
        // Handle result dropdown changes
        document.querySelectorAll('.result-dropdown').forEach(dropdown => {
            const testSlug = dropdown.getAttribute('data-test-slug');
            
            // Initial sync on page load
            updateTableResult(testSlug);
            
            dropdown.addEventListener('change', function() {
                const othersInput = document.querySelector(`.others-input[data-test-slug="${testSlug}"]`);
                
                if (this.value === 'Others') {
                    othersInput.style.display = 'block';
                    othersInput.focus();
                } else {
                    othersInput.style.display = 'none';
                    othersInput.value = '';
                }
                
                // Update table result
                updateTableResult(testSlug);
            });
        });
        
        // Handle others input changes
        document.querySelectorAll('.others-input').forEach(othersInput => {
            othersInput.addEventListener('input', function() {
                const testSlug = this.getAttribute('data-test-slug');
                updateTableResult(testSlug);
            });
        });
        
        // Handle form submission to merge Others input with dropdown value
        document.querySelector('form').addEventListener('submit', function(e) {
            document.querySelectorAll('.result-dropdown').forEach(dropdown => {
                if (dropdown.value === 'Others') {
                    const testSlug = dropdown.getAttribute('data-test-slug');
                    const othersInput = document.querySelector(`.others-input[data-test-slug="${testSlug}"]`);
                    if (othersInput && othersInput.value.trim()) {
                        // Create a hidden input with the others value as the main result
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = dropdown.name;
                        hiddenInput.value = othersInput.value.trim();
                        dropdown.parentNode.appendChild(hiddenInput);
                        dropdown.disabled = true; // Disable dropdown so it doesn't submit
                    }
                }
            });
        });
    });

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pathologist', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/pathologist/pre-employment-edit.blade.php ENDPATH**/ ?>