<?php $__env->startSection('title', 'Edit OPD Examination'); ?>
<?php $__env->startSection('page-title', 'Edit OPD Examination'); ?>

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
    <form action="<?php echo e(route('pathologist.opd.update', $examination->id)); ?>" method="POST" class="space-y-8">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <!-- Patient Information Header -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">OPD Walk-in Examination</h2>
                    <p class="text-gray-600"><?php echo e($examination->name ?? ($opdPatient->fname . ' ' . $opdPatient->lname)); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-semibold text-gray-800"><?php echo e($examination->date ? \Carbon\Carbon::parse($examination->date)->format('M d, Y') : now()->format('M d, Y')); ?></p>
                    <p class="text-gray-600">Patient ID: OPD-<?php echo e(str_pad($opdPatient->id, 4, '0', STR_PAD_LEFT)); ?></p>
                </div>
            </div>
        </div>

        <!-- Laboratory Examination Report -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-flask mr-2 text-teal-600"></i>Laboratory Examination Report
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Urinalysis</label>
                    <input type="text" name="lab_report[urinalysis]" 
                           value="<?php echo e(old('lab_report.urinalysis', $examination->lab_report['urinalysis'] ?? '')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter urinalysis results">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">CBC</label>
                    <input type="text" name="lab_report[cbc]" 
                           value="<?php echo e(old('lab_report.cbc', $examination->lab_report['cbc'] ?? '')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter CBC results">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Fecalysis</label>
                    <input type="text" name="lab_report[fecalysis]" 
                           value="<?php echo e(old('lab_report.fecalysis', $examination->lab_report['fecalysis'] ?? '')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter fecalysis results">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Blood Chemistry</label>
                    <input type="text" name="lab_report[blood_chemistry]" 
                           value="<?php echo e(old('lab_report.blood_chemistry', $examination->lab_report['blood_chemistry'] ?? '')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter blood chemistry results">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Others</label>
                    <input type="text" name="lab_report[others]" 
                           value="<?php echo e(old('lab_report.others', $examination->lab_report['others'] ?? '')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter other test results">
                </div>
            </div>

            <!-- Additional Laboratory Tests -->
            <h4 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-vial mr-2 text-teal-600"></i>Additional Laboratory Tests
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">HBsAg Screening</label>
                    <input type="text" name="lab_report[hbsag_screening]" 
                           value="<?php echo e(old('lab_report.hbsag_screening', $examination->lab_report['hbsag_screening'] ?? '')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter HBsAg screening results">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">HEPA A IgG & IgM</label>
                    <input type="text" name="lab_report[hepa_a_igg_igm]" 
                           value="<?php echo e(old('lab_report.hepa_a_igg_igm', $examination->lab_report['hepa_a_igg_igm'] ?? '')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Enter HEPA A IgG & IgM results">
                </div>
            </div>

            <!-- Laboratory Examinations Report Table -->
            <h4 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-table mr-2 text-teal-600"></i>Laboratory Examinations Report
            </h4>
            
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">TEST</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">RESULT</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">FINDINGS</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">Urinalysis</td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[urinalysis_result]" 
                                       value="<?php echo e(old('lab_results.urinalysis_result', $examination->lab_results['urinalysis_result'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter result">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[urinalysis_findings]" 
                                       value="<?php echo e(old('lab_results.urinalysis_findings', $examination->lab_results['urinalysis_findings'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">Fecalysis</td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[fecalysis_result]" 
                                       value="<?php echo e(old('lab_results.fecalysis_result', $examination->lab_results['fecalysis_result'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter result">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[fecalysis_findings]" 
                                       value="<?php echo e(old('lab_results.fecalysis_findings', $examination->lab_results['fecalysis_findings'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">CBC</td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[cbc_result]" 
                                       value="<?php echo e(old('lab_results.cbc_result', $examination->lab_results['cbc_result'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter result">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[cbc_findings]" 
                                       value="<?php echo e(old('lab_results.cbc_findings', $examination->lab_results['cbc_findings'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">HBsAg Screening</td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[hbsag_result]" 
                                       value="<?php echo e(old('lab_results.hbsag_result', $examination->lab_results['hbsag_result'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter result">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[hbsag_findings]" 
                                       value="<?php echo e(old('lab_results.hbsag_findings', $examination->lab_results['hbsag_findings'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">HEPA A IgG & IgM</td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[hepa_result]" 
                                       value="<?php echo e(old('lab_results.hepa_result', $examination->lab_results['hepa_result'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter result">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[hepa_findings]" 
                                       value="<?php echo e(old('lab_results.hepa_findings', $examination->lab_results['hepa_findings'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">Others</td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[others_result]" 
                                       value="<?php echo e(old('lab_results.others_result', $examination->lab_results['others_result'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter result">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="lab_results[others_findings]" 
                                       value="<?php echo e(old('lab_results.others_findings', $examination->lab_results['others_findings'] ?? '')); ?>"
                                       class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Enter findings">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        

        <!-- Status and Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Examination Status</label>
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                        <option value="pending" <?php echo e(old('status', $examination->status) === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="completed" <?php echo e(old('status', $examination->status) === 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="sent_to_company" <?php echo e(old('status', $examination->status) === 'sent_to_company' ? 'selected' : ''); ?>>Sent to Company</option>
                    </select>
                </div>
                
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('pathologist.opd')); ?>" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors font-semibold">
                        <i class="fas fa-save mr-2"></i>Update Examination
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pathologist', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/pathologist/opd-edit.blade.php ENDPATH**/ ?>