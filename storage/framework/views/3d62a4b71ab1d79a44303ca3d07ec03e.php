<?php $__env->startSection('title', 'Pre-Employment Examination'); ?>
<?php $__env->startSection('page-title', 'Pre-Employment Examination'); ?>
<?php $__env->startSection('page-description', 'View and manage pre-employment medical examination'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-600">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2">
                        <i class="fas fa-briefcase mr-3"></i>Pre-Employment Medical Examination
                    </h1>
                    <p class="text-blue-100">Employment medical screening and health assessment certificate</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-800 bg-opacity-50 rounded-lg px-4 py-2 border border-blue-500">
                        <p class="text-blue-200 text-sm font-medium">Exam ID</p>
                        <p class="text-white text-lg font-bold">#<?php echo e($examination->id); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Applicant Information Section -->
        <?php if($examination->preEmploymentRecord): ?>
        <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-green-700 border-l-4 border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-user-tie mr-3"></i>Applicant Information
                    </h2>
                    <p class="text-green-100 mt-1">Job applicant details and company information</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 bg-green-50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Full Name</label>
                    <div class="text-lg font-bold text-blue-800"><?php echo e($examination->preEmploymentRecord->full_name ?? ($examination->preEmploymentRecord->first_name . ' ' . $examination->preEmploymentRecord->last_name)); ?></div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-green-500 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Age</label>
                    <div class="text-lg font-bold text-green-800"><?php echo e($examination->preEmploymentRecord->age ?? 'N/A'); ?> years</div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-indigo-500 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Sex</label>
                    <div class="text-lg font-bold text-indigo-800"><?php echo e($examination->preEmploymentRecord->sex ? ucfirst($examination->preEmploymentRecord->sex) : 'N/A'); ?></div>
                </div>
                <div class="bg-white rounded-lg p-4 border-l-4 border-yellow-500 hover:shadow-md transition-shadow duration-200">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Company</label>
                    <div class="text-sm font-semibold text-yellow-800 truncate"><?php echo e($examination->preEmploymentRecord->company_name ?? 'N/A'); ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Examination Details Section -->
        <div class="p-8">
            <!-- Examination Status -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500 mb-8">
                <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
                    <div class="flex items-center">
                        <i class="fas fa-clipboard-check text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white">Examination Status</h3>
                    </div>
                </div>
                <div class="p-6 bg-green-50">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Examination Date</label>
                            <p class="text-gray-900"><?php echo e($examination->date ? \Carbon\Carbon::parse($examination->date)->format('F j, Y') : 'N/A'); ?></p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                <?php echo e($examination->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($examination->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($examination->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'))); ?>">
                                <?php echo e(ucfirst($examination->status)); ?>

                            </span>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Examined By</label>
                            <p class="text-gray-900"><?php echo e($examination->user->name ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical History -->
            <?php if($examination->illness_history || $examination->accidents_operations || $examination->past_medical_history): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500 mb-8">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <div class="flex items-center">
                        <i class="fas fa-notes-medical text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white">Medical History</h3>
                    </div>
                </div>
                <div class="p-6 bg-blue-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php if($examination->illness_history): ?>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Illness / Hospitalization</label>
                            <div class="prose max-w-none">
                                <?php echo nl2br(e($examination->illness_history)); ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($examination->accidents_operations): ?>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Accidents / Operations</label>
                            <div class="prose max-w-none">
                                <?php echo nl2br(e($examination->accidents_operations)); ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($examination->past_medical_history): ?>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Past Medical History</label>
                            <div class="prose max-w-none">
                                <?php echo nl2br(e($examination->past_medical_history)); ?>

                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($examination->family_history): ?>
                    <div class="mt-6 bg-white p-4 rounded-lg border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Family Medical History</label>
                        <div class="flex flex-wrap gap-2">
                            <?php if(is_array($examination->family_history) && !empty($examination->family_history)): ?>
                                <?php $__currentLoopData = $examination->family_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(is_string($condition)): ?>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                            <?php echo e(ucwords(str_replace('_', ' ', $condition))); ?>

                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php elseif(is_string($examination->family_history) && !empty($examination->family_history)): ?>
                                <p class="text-gray-600"><?php echo e($examination->family_history); ?></p>
                            <?php else: ?>
                                <p class="text-gray-400 italic">No family history recorded</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Personal Habits -->
            <?php if($examination->personal_habits): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-purple-500 mb-8">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
                    <div class="flex items-center">
                        <i class="fas fa-user-check text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white">Personal Habits</h3>
                    </div>
                </div>
                <div class="p-6 bg-purple-50">
                    <div class="flex flex-wrap gap-4">
                        <?php if(is_array($examination->personal_habits)): ?>
                            <?php $__currentLoopData = $examination->personal_habits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $habit => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($value): ?>
                                    <div class="bg-white p-3 rounded-lg border border-gray-200 flex items-center">
                                        <i class="fas <?php echo e($habit === 'alcohol' ? 'fa-wine-bottle text-red-500' : 
                                            ($habit === 'cigarettes' ? 'fa-smoking text-orange-500' : 
                                            'fa-coffee text-amber-500')); ?> mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">
                                            <?php echo e(ucwords(str_replace('_', ' ', $habit))); ?>

                                        </span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p class="text-gray-600"><?php echo e($examination->personal_habits); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Physical Examination -->
            <?php if($examination->physical_exam || $examination->skin_marks || $examination->visual || $examination->ishihara_test): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-yellow-500 mb-8">
                <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600">
                    <div class="flex items-center">
                        <i class="fas fa-stethoscope text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white">Physical Examination</h3>
                    </div>
                </div>
                <div class="p-6 bg-yellow-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php if($examination->physical_exam && is_array($examination->physical_exam)): ?>
                            <?php $__currentLoopData = $examination->physical_exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($value) && !is_array($value)): ?>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <?php echo e(str_replace('_', ' ', ucwords($key))); ?>

                                    </label>
                                    <p class="text-gray-900"><?php echo e($value); ?></p>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <?php if($examination->skin_marks): ?>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Skin Identification Marks</label>
                            <p class="text-gray-900"><?php echo e($examination->skin_marks); ?></p>
                        </div>
                        <?php endif; ?>

                        <?php if($examination->visual): ?>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Visual Acuity</label>
                            <p class="text-gray-900"><?php echo e($examination->visual); ?></p>
                        </div>
                        <?php endif; ?>

                        <?php if($examination->ishihara_test): ?>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ishihara Test</label>
                            <p class="text-gray-900"><?php echo e($examination->ishihara_test); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Laboratory and ECG -->
            <?php
                $labReport = null;
                if($examination->lab_report) {
                    if(is_string($examination->lab_report)) {
                        // Try to decode JSON
                        $decoded = json_decode($examination->lab_report, true);
                        if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $labReport = $decoded;
                        } else {
                            // It's a plain string
                            $labReport = $examination->lab_report;
                        }
                    } elseif(is_array($examination->lab_report)) {
                        $labReport = $examination->lab_report;
                    }
                }
            ?>
            
            <?php if($labReport || $examination->ecg): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-indigo-500 mb-8">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600">
                    <div class="flex items-center">
                        <i class="fas fa-flask text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white">Laboratory & ECG Results</h3>
                    </div>
                </div>
                <div class="p-6 bg-indigo-50">
                    <?php if($labReport): ?>
                        <?php if(is_array($labReport)): ?>
                        <div class="mb-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-3">Laboratory Results</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200">
                                    <thead class="bg-gradient-to-r from-indigo-500 to-indigo-600">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Test</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Result</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Reference Range</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Findings</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <?php
                                            $testResults = [];
                                            foreach($labReport as $key => $value) {
                                                if($value !== null && $value !== '') {
                                                    // Group results and findings
                                                    if(str_ends_with($key, '_result')) {
                                                        $testName = str_replace('_result', '', $key);
                                                        $testResults[$testName]['result'] = $value;
                                                    } elseif(str_ends_with($key, '_findings')) {
                                                        $testName = str_replace('_findings', '', $key);
                                                        $testResults[$testName]['findings'] = $value;
                                                    } elseif(!str_contains($key, '_') && !in_array($key, ['additional_notes'])) {
                                                        // Direct test values (like cbc: 33)
                                                        $testResults[$key]['result'] = $value;
                                                    }
                                                }
                                            }
                                        ?>
                                        
                                        <?php $__currentLoopData = $testResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testName => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            // Find medical test by name to get reference ranges
                                            $medicalTest = \App\Models\MedicalTest::with('referenceRanges')
                                                ->where('name', 'LIKE', '%' . ucwords(str_replace('_', ' ', $testName)) . '%')
                                                ->first();
                                            
                                            // If not found by name, try alternative matching
                                            if (!$medicalTest) {
                                                $searchTerms = [
                                                    'cbc' => 'CBC',
                                                    'fecalysis' => 'Fecalysis',
                                                    'urinalysis' => 'Urinalysis',
                                                    'papsmear' => 'Papsmear',
                                                    'ca_72_3' => 'CA-72-3'
                                                ];
                                                
                                                $searchTerm = $searchTerms[strtolower($testName)] ?? ucwords(str_replace('_', ' ', $testName));
                                                $medicalTest = \App\Models\MedicalTest::with('referenceRanges')
                                                    ->where('name', 'LIKE', '%' . $searchTerm . '%')
                                                    ->first();
                                            }
                                        ?>
                                        <tr class="hover:bg-indigo-50 transition-colors duration-200">
                                            <td class="px-4 py-4 text-sm font-semibold text-gray-900">
                                                <div class="flex items-center">
                                                    <i class="fas fa-vial text-indigo-500 mr-2"></i>
                                                    <?php echo e(ucwords(str_replace('_', ' ', $testName))); ?>

                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                    <?php echo e($data['result'] ?? 'N/A'); ?>

                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700">
                                                <?php if($medicalTest && $medicalTest->referenceRanges->count() > 0): ?>
                                                    <div class="space-y-1">
                                                        <?php $__currentLoopData = $medicalTest->referenceRanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="text-xs">
                                                                <span class="font-medium text-gray-600"><?php echo e($range->reference_name); ?>:</span>
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 ml-1">
                                                                    <?php echo e($range->reference_range); ?>

                                                                </span>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-gray-400 italic text-xs">No reference ranges</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700">
                                                <?php if(isset($data['findings'])): ?>
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                                        <?php if(strtolower($data['findings']) === 'ok' || strtolower($data['findings']) === 'normal'): ?>
                                                            bg-green-100 text-green-800 border border-green-200
                                                        <?php else: ?>
                                                            bg-yellow-100 text-yellow-800 border border-yellow-200
                                                        <?php endif; ?>">
                                                        <?php if(strtolower($data['findings']) === 'ok' || strtolower($data['findings']) === 'normal'): ?>
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                        <?php else: ?>
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                        <?php endif; ?>
                                                        <?php echo e($data['findings']); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 italic">No findings</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                        <?php if(isset($labReport['additional_notes']) && $labReport['additional_notes']): ?>
                                        <tr class="bg-gray-50">
                                            <td class="px-4 py-4 text-sm font-semibold text-gray-900">
                                                <div class="flex items-center">
                                                    <i class="fas fa-sticky-note text-indigo-500 mr-2"></i>
                                                    Additional Notes
                                                </div>
                                            </td>
                                            <td colspan="3" class="px-4 py-4 text-sm text-gray-700">
                                                <?php echo e($labReport['additional_notes']); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="mb-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-3">Laboratory Report Summary</h4>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <div class="prose max-w-none">
                                    <?php echo nl2br(e($labReport)); ?>

                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-gray-400 italic">No laboratory results available</p>
                    <?php endif; ?>

                    <?php if($examination->ecg): ?>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ECG Findings</label>
                        <div class="prose max-w-none">
                            <?php echo nl2br(e($examination->ecg)); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>


            <!-- Findings and Recommendations -->
            <?php if($examination->findings || $examination->physical_findings || $examination->lab_findings): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-red-500 mb-8">
                <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-red-600">
                    <div class="flex items-center">
                        <i class="fas fa-clipboard-check text-white text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-white">Findings & Recommendations</h3>
                    </div>
                </div>
                <div class="p-6 bg-red-50">
                    <?php if($examination->findings): ?>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">General Findings</label>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 prose max-w-none">
                            <?php if(is_string($examination->findings)): ?>
                                <?php echo nl2br(e($examination->findings)); ?>

                            <?php elseif(is_array($examination->findings) || is_object($examination->findings)): ?>
                                <pre class="text-sm text-gray-700 whitespace-pre-wrap"><?php echo e(json_encode($examination->findings, JSON_PRETTY_PRINT)); ?></pre>
                            <?php else: ?>
                                <?php echo e($examination->findings); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($examination->physical_findings): ?>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Physical Examination Findings</label>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 prose max-w-none">
                            <?php if(is_string($examination->physical_findings)): ?>
                                <?php echo nl2br(e($examination->physical_findings)); ?>

                            <?php elseif(is_array($examination->physical_findings) || is_object($examination->physical_findings)): ?>
                                <pre class="text-sm text-gray-700 whitespace-pre-wrap"><?php echo e(json_encode($examination->physical_findings, JSON_PRETTY_PRINT)); ?></pre>
                            <?php else: ?>
                                <?php echo e($examination->physical_findings); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($examination->lab_findings): ?>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Laboratory Findings</label>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 prose max-w-none">
                            <?php if(is_string($examination->lab_findings)): ?>
                                <?php echo nl2br(e($examination->lab_findings)); ?>

                            <?php elseif(is_array($examination->lab_findings) || is_object($examination->lab_findings)): ?>
                                <pre class="text-sm text-gray-700 whitespace-pre-wrap"><?php echo e(json_encode($examination->lab_findings, JSON_PRETTY_PRINT)); ?></pre>
                            <?php else: ?>
                                <?php echo e($examination->lab_findings); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4 mt-8">
                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('doctor.pre-employment')); ?>" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if($examination->preEmploymentRecord): ?>
                        <form action="<?php echo e(route('doctor.pre-employment.by-record.submit', $examination->preEmploymentRecord->id)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                <i class="fas fa-paper-plane mr-2"></i>Submit to Admin
                            </button>
                        </form>
                    <?php endif; ?>
                    <?php if($examination->preEmploymentRecord): ?>
                        <a href="<?php echo e(route('doctor.pre-employment.edit', $examination->preEmploymentRecord->id)); ?>" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>Edit Examination
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Update status based on findings input
function updateStatus(input, rangeId) {
    const statusElement = document.getElementById(`status_${rangeId}`);
    const value = input.value.trim();
    
    if (value === '') {
        statusElement.innerHTML = '<i class="fas fa-clock mr-1"></i>Pending';
        statusElement.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600';
    } else if (value.toLowerCase().includes('normal') || value.toLowerCase().includes('within') || value.toLowerCase().includes('negative')) {
        statusElement.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Normal';
        statusElement.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
    } else {
        statusElement.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Abnormal';
        statusElement.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
    }
    
    updateCompletionStatus(input);
}

// Mark all findings as normal for a specific test
function markAllNormal(testId) {
    const inputs = document.querySelectorAll(`input[name^="findings[${testId}]"]`);
    inputs.forEach(input => {
        input.value = 'Normal';
        const rangeId = input.id.split('_')[2];
        updateStatus(input, rangeId);
    });
}

// Clear all findings for a specific test
function clearAllFindings(testId) {
    const inputs = document.querySelectorAll(`input[name^="findings[${testId}]"]`);
    inputs.forEach(input => {
        input.value = '';
        const rangeId = input.id.split('_')[2];
        updateStatus(input, rangeId);
    });
}

// Update completion status
function updateCompletionStatus(input) {
    const testId = input.name.match(/findings\[(\d+)\]/)[1];
    const allInputs = document.querySelectorAll(`input[name^="findings[${testId}]"]`);
    const completedInputs = Array.from(allInputs).filter(inp => inp.value.trim() !== '');
    
    const completionElement = document.getElementById(`completion_${testId}`);
    if (completionElement) {
        completionElement.textContent = `${completedInputs.length} of ${allInputs.length} parameters completed`;
    }
}

// Auto-save functionality (optional)
document.addEventListener('DOMContentLoaded', function() {
    const findingInputs = document.querySelectorAll('input[name^="findings["]');
    
    findingInputs.forEach(input => {
        // Load saved data from localStorage if available
        const savedValue = localStorage.getItem(input.name);
        if (savedValue) {
            input.value = savedValue;
            const rangeId = input.id.split('_')[2];
            updateStatus(input, rangeId);
        }
        
        // Save to localStorage on change
        input.addEventListener('input', function() {
            localStorage.setItem(this.name, this.value);
        });
        
        // Enhanced input styling on focus
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-purple-500');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-purple-500');
        });
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + Shift + N = Mark all normal for focused test
    if (e.ctrlKey && e.shiftKey && e.key === 'N') {
        const focusedInput = document.activeElement;
        if (focusedInput && focusedInput.name && focusedInput.name.includes('findings[')) {
            const testId = focusedInput.name.match(/findings\[(\d+)\]/)[1];
            markAllNormal(testId);
            e.preventDefault();
        }
    }
    
    // Ctrl + Shift + C = Clear all for focused test
    if (e.ctrlKey && e.shiftKey && e.key === 'C') {
        const focusedInput = document.activeElement;
        if (focusedInput && focusedInput.name && focusedInput.name.includes('findings[')) {
            const testId = focusedInput.name.match(/findings\[(\d+)\]/)[1];
            clearAllFindings(testId);
            e.preventDefault();
        }
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/doctor/pre-employment-examination.blade.php ENDPATH**/ ?>