<?php $__env->startSection('opd-content'); ?>
<div class="bg-gradient-to-b from-blue-50 to-white border border-blue-100 rounded-xl p-5 mb-6">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <div class="w-14 h-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
        <i class="fa-solid fa-user"></i>
      </div>
      <div>
        <h2 class="text-xl font-semibold text-gray-900">Welcome, <?php echo e(Auth::user()->fname ?? 'OPD'); ?>!</h2>
        <p class="text-gray-500 text-sm">Walk‑in patient portal</p>
      </div>
    </div>
    <div class="flex gap-2">
      <a href="<?php echo e(route('opd.medical-test-categories')); ?>" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700 transition">
        <i class="fa-solid fa-compass mr-2"></i> Start browsing
      </a>
      <a href="<?php echo e(route('opd.incoming-tests')); ?>" class="inline-flex items-center px-3 py-2 rounded-lg border border-blue-600 text-blue-700 text-sm hover:bg-blue-50 transition">
        <i class="fa-solid fa-inbox mr-2"></i> View Incoming
      </a>
      
    </div>
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
  <a href="<?php echo e(route('opd.medical-test-categories')); ?>" class="block group">
    <div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition h-full">
      <div class="flex items-center gap-3">
        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
          <i class="fa-solid fa-folder-tree"></i>
        </div>
        <div class="flex-1">
          <p class="text-gray-500 text-xs">Browse</p>
          <h3 class="text-base font-semibold text-gray-900">Medical Test Categories</h3>
          <p class="text-gray-500 text-sm">Explore tests available for walk‑in patients</p>
        </div>
      </div>
    </div>
  </a>

  <a href="<?php echo e(route('opd.incoming-tests')); ?>" class="block group">
    <div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition h-full">
      <div class="flex items-center gap-3">
        <div class="w-14 h-14 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
          <i class="fa-solid fa-inbox"></i>
        </div>
        <div class="flex-1">
          <p class="text-gray-500 text-xs">Queue</p>
          <h3 class="text-base font-semibold text-gray-900">Incoming Tests</h3>
          <p class="text-gray-500 text-sm">Review and manage tests you added</p>
          <div class="mt-2 flex items-center gap-2">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700"><?php echo e(is_countable($incoming ?? []) ? count($incoming ?? []) : 0); ?></span>
            <span class="text-xs text-gray-500">Items</span>
          </div>
        </div>
        <div class="text-right">
          <div class="text-xs text-gray-500">Estimated Total</div>
          <div class="font-semibold">₱<?php echo e(number_format($total ?? 0, 2)); ?></div>
        </div>
      </div>
    </div>
  </a>

  <a href="<?php echo e(route('opd.result')); ?>" class="block group">
    <div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition h-full">
      <div class="flex items-center gap-3">
        <div class="w-14 h-14 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
          <i class="fa-solid fa-file-medical"></i>
        </div>
        <div class="flex-1">
          <p class="text-gray-500 text-xs">Preview</p>
          <h3 class="text-base font-semibold text-gray-900">Result Template</h3>
          <p class="text-gray-500 text-sm">UI-only sample of result card</p>
        </div>
        <div>
          <span class="inline-flex items-center px-3 py-1 rounded-lg border text-sm text-gray-700 border-gray-300"><i class="fa-solid fa-file-lines mr-2"></i> Open</span>
        </div>
      </div>
    </div>
  </a>

 
<?php $__env->stopSection(); ?>





  

<?php echo $__env->make('layouts.opd', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/opd/dashboard.blade.php ENDPATH**/ ?>