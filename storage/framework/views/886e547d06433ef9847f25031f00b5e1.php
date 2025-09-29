<?php $__env->startSection('opd-content'); ?>
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4">
  <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex items-start justify-between">
    <div>
      <h2 class="text-base font-semibold text-gray-900 m-0">Examination Result</h2>
      <p class="text-xs text-gray-500">Preview</p>
    </div>
    <div class="flex gap-2">
      <a href="<?php echo e(route('opd.dashboard')); ?>" class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Back
      </a>
      <button type="button" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700 transition" onclick="window.print()">
        <i class="fa-solid fa-print mr-2"></i> Print
      </button>
    </div>
  </div>
  <div class="p-0">
    <!-- Header strip -->
    <div class="px-4 sm:px-6 py-3 border-b border-gray-200 bg-blue-50 flex items-start justify-between">
      <div>
        <div class="font-semibold text-gray-900"><?php echo e($patientName ?? 'Patient Name'); ?></div>
        <div class="text-xs text-gray-600">Patient ID: <?php echo e($patientId ?? '—'); ?></div>
      </div>
      <div class="text-right">
        <div class="text-xs text-gray-600">Examination Date</div>
        <div class="font-semibold text-gray-900"><?php echo e($examDate ?? now()->format('M d, Y')); ?></div>
      </div>
    </div>

    <div class="p-4 sm:p-6">
      <?php
        $hasHistory = !empty($illness_history ?? null) || !empty($accidents_operations ?? null) || !empty($past_medical_history ?? null);
        $hasPhysicalSummary = !empty($visual ?? null) || !empty($ishihara_test ?? null) || !empty($skin_marks ?? null);
      ?>

      <?php if($hasHistory || $hasPhysicalSummary): ?>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <?php if($hasHistory): ?>
        <!-- Medical History -->
        <div>
          <div class="border border-gray-200 rounded-xl overflow-hidden h-full">
            <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Medical History</strong></div>
            <div class="p-4">
              <?php if(!empty($illness_history)): ?>
              <div class="mb-3">
                <div class="text-xs text-gray-500">Illness History</div>
                <div class="text-sm text-gray-900"><?php echo e($illness_history); ?></div>
              </div>
              <?php endif; ?>
              <?php if(!empty($accidents_operations)): ?>
              <div class="mb-3">
                <div class="text-xs text-gray-500">Accidents/Operations</div>
                <div class="text-sm text-gray-900"><?php echo e($accidents_operations); ?></div>
              </div>
              <?php endif; ?>
              <?php if(!empty($past_medical_history)): ?>
              <div>
                <div class="text-xs text-gray-500">Past Medical History</div>
                <div class="text-sm text-gray-900"><?php echo e($past_medical_history); ?></div>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <?php if($hasPhysicalSummary): ?>
        <!-- Physical Examination -->
        <div>
          <div class="border border-gray-200 rounded-xl overflow-hidden h-full">
            <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Physical Examination</strong></div>
            <div class="p-4">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <?php if(!empty($visual)): ?>
                <div>
                  <div class="text-xs text-gray-500">Visual Acuity</div>
                  <div class="text-sm text-gray-900"><?php echo e($visual); ?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($ishihara_test)): ?>
                <div>
                  <div class="text-xs text-gray-500">Ishihara Test</div>
                  <div class="text-sm text-gray-900"><?php echo e($ishihara_test); ?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($skin_marks)): ?>
                <div>
                  <div class="text-xs text-gray-500">Skin Marks</div>
                  <div class="text-sm text-gray-900"><?php echo e($skin_marks); ?></div>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <!-- Laboratory Results + Final Findings -->
      <?php
        $hasLabResults = !empty($ecg ?? null);
        $hasFinalFindings = !empty($final_findings ?? null);
      ?>
      <?php if($hasLabResults || $hasFinalFindings): ?>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-2">
        <?php if($hasLabResults): ?>
        <div>
          <div class="border border-gray-200 rounded-xl overflow-hidden h-full">
            <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Laboratory Results</strong></div>
            <div class="p-4">
              <?php if(!empty($ecg)): ?>
              <div class="mb-2 flex items-center justify-between">
                <div class="text-sm text-gray-900">ECG</div>
                <span class="text-xs text-gray-600"><?php echo e($ecg); ?></span>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if($hasFinalFindings): ?>
        <div>
          <div class="border border-gray-200 rounded-xl overflow-hidden h-full">
            <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Final Findings</strong></div>
            <div class="p-4">
              <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-900"><?php echo e($final_findings); ?></div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <!-- Physical Findings Grid -->
      <?php if(!empty($physical_findings ?? [])): ?>
      <div class="border border-gray-200 rounded-xl overflow-hidden mt-3">
        <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Physical Findings</strong></div>
        <div class="p-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <?php $__currentLoopData = ($physical_findings ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area => $finding): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
              <div class="border border-gray-200 rounded-lg p-3 h-full">
                <div class="flex items-center justify-between mb-1">
                  <div class="font-semibold text-sm text-gray-900"><?php echo e($area); ?></div>
                  <?php $ok = ($finding['result'] ?? '') === 'Normal'; ?>
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold <?php echo e($ok ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'); ?>"><?php echo e($finding['result'] ?? '—'); ?></span>
                </div>
                <?php if(!empty($finding['findings'])): ?>
                  <div class="text-xs text-gray-500"><?php echo e($finding['findings']); ?></div>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!-- Laboratory Findings Grid -->
      <?php if(!empty($lab_findings ?? [])): ?>
      <div class="border border-gray-200 rounded-xl overflow-hidden mt-3">
        <div class="px-4 py-3 border-b border-gray-200 bg-white"><strong class="text-gray-900">Laboratory Findings</strong></div>
        <div class="p-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <?php $__currentLoopData = ($lab_findings ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
              <div class="border border-gray-200 rounded-lg p-3 h-full">
                <div class="flex items-center justify-between mb-1">
                  <div class="font-semibold text-sm text-gray-900"><?php echo e($test); ?></div>
                  <?php $ok2 = ($result['result'] ?? '') === 'Normal'; ?>
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold <?php echo e($ok2 ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'); ?>"><?php echo e($result['result'] ?? '—'); ?></span>
                </div>
                <?php if(!empty($result['findings'])): ?>
                  <div class="text-xs text-gray-500"><?php echo e($result['findings']); ?></div>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<style>
@media print {
  .navbar, .sidebar, .btn, .breadcrumb { display: none !important; }
}
</style>
<?php $__env->stopSection(); ?>







<?php echo $__env->make('layouts.opd', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/opd/result.blade.php ENDPATH**/ ?>