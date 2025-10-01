<?php $__env->startSection('title', 'Pre-Employment Laboratory Records - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Pre-Employment Laboratory Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="content-card rounded-lg p-4 bg-green-50 border border-green-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-green-800 font-medium"><?php echo e(session('success')); ?></p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="content-card rounded-lg p-4 bg-red-50 border border-red-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-red-800 font-medium"><?php echo e(session('error')); ?></p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-microscope text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Pre-Employment Laboratory Management</h3>
                        <p class="text-purple-100 text-sm">Manage laboratory examinations for pre-employment medical screening</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Search Form -->
                    <form method="GET" action="<?php echo e(route('pathologist.pre-employment')); ?>" class="flex items-center space-x-3">
                        <!-- Preserve current filter -->
                        <?php if(request('lab_status')): ?>
                            <input type="hidden" name="lab_status" value="<?php echo e(request('lab_status')); ?>">
                        <?php endif; ?>
                        <?php if(request('company')): ?>
                            <input type="hidden" name="company" value="<?php echo e(request('company')); ?>">
                        <?php endif; ?>
                        <?php if(request('status')): ?>
                            <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                        <?php endif; ?>
                        
                        <!-- Search Bar -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-white/60 text-sm"></i>
                            </div>
                            <input type="text" 
                                   name="search"
                                   value="<?php echo e(request('search')); ?>"
                                   class="glass-morphism pl-12 pr-4 py-2 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 w-72 text-sm border border-white/20" 
                                   placeholder="Search by name, email...">
                        </div>
                        
                        <!-- Search Button -->
                        <button type="submit" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 border border-white/20 backdrop-blur-sm">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Lab Status Tabs -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <?php
            $currentTab = request('lab_status', 'needs_attention');
        ?>
        
        <!-- Tab Navigation -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex space-x-1">
                    <a href="<?php echo e(request()->fullUrlWithQuery(['lab_status' => 'needs_attention'])); ?>" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 <?php echo e($currentTab === 'needs_attention' ? 'bg-purple-600 text-white' : 'text-gray-600 hover:text-purple-600 hover:bg-purple-50'); ?>">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Needs Attention
                        <?php
                            $needsAttentionCount = \App\Models\PreEmploymentRecord::where('status', 'approved')
                                ->whereDoesntHave('preEmploymentExamination', function($q) {
                                    $q->where(function($subQuery) {
                                        $subQuery->whereNotNull('lab_report')
                                                 ->where('lab_report', '!=', '[]')
                                                 ->where('lab_report', '!=', '{}');
                                    });
                                })
                                ->count();
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?php echo e($currentTab === 'needs_attention' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                            <?php echo e($needsAttentionCount); ?>

                        </span>
                    </a>
                    
                    <a href="<?php echo e(request()->fullUrlWithQuery(['lab_status' => 'lab_completed'])); ?>" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 <?php echo e($currentTab === 'lab_completed' ? 'bg-purple-600 text-white' : 'text-gray-600 hover:text-purple-600 hover:bg-purple-50'); ?>">
                        <i class="fas fa-check-circle mr-2"></i>
                        Lab Completed
                        <?php
                            $completedCount = \App\Models\PreEmploymentRecord::where('status', 'approved')
                                ->whereHas('preEmploymentExamination', function($q) {
                                    $q->where(function($subQuery) {
                                        $subQuery->whereNotNull('lab_report')
                                                 ->where('lab_report', '!=', '[]')
                                                 ->where('lab_report', '!=', '{}');
                                    });
                                })
                                ->count();
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?php echo e($currentTab === 'lab_completed' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                            <?php echo e($completedCount); ?>

                        </span>
                    </a>
                </div>
                
                <a href="<?php echo e(route('pathologist.pre-employment')); ?>" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-times mr-1"></i>Clear All Filters
                </a>
            </div>
        </div>

        <!-- Additional Filters -->
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('pathologist.pre-employment')); ?>" class="space-y-6">
                <!-- Preserve current tab -->
                <input type="hidden" name="lab_status" value="<?php echo e($currentTab); ?>">
                
                <!-- Preserve search query -->
                <?php if(request('search')): ?>
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <?php endif; ?>
                
                <!-- Filter Row: Company and Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Company Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                        <select name="company" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm">
                            <option value="">All Companies</option>
                            <?php
                                $companies = $preEmployments->pluck('company_name')->filter()->unique()->sort()->values();
                            ?>
                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($company); ?>" <?php echo e(request('company') === $company ? 'selected' : ''); ?>>
                                    <?php echo e($company); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Record Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm">
                            <option value="">All Statuses</option>
                            <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Approved</option>
                            <option value="declined" <?php echo e(request('status') === 'declined' ? 'selected' : ''); ?>>Declined</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>Apply Filters
                        </button>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['company' => null, 'status' => null, 'search' => null])); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-undo mr-2"></i>Reset Filters
                        </a>
                    </div>
                    
                    <!-- Active Filters Display -->
                    <?php if(request()->hasAny(['company', 'status', 'search'])): ?>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Active filters:</span>
                            <?php if(request('search')): ?>
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">
                                    Search: "<?php echo e(request('search')); ?>"
                                    <a href="<?php echo e(request()->fullUrlWithQuery(['search' => null])); ?>" class="ml-1 text-purple-600 hover:text-purple-800">×</a>
                                </span>
                            <?php endif; ?>
                            <?php if(request('company')): ?>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                    Company: <?php echo e(request('company')); ?>

                                    <a href="<?php echo e(request()->fullUrlWithQuery(['company' => null])); ?>" class="ml-1 text-blue-600 hover:text-blue-800">×</a>
                                </span>
                            <?php endif; ?>
                            <?php if(request('status')): ?>
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                    Status: <?php echo e(ucfirst(request('status'))); ?>

                                    <a href="<?php echo e(request()->fullUrlWithQuery(['status' => null])); ?>" class="ml-1 text-green-600 hover:text-green-800">×</a>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Pre-Employment Records Table -->
    <div class="content-card rounded-xl shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-table text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Pre-Employment Laboratory Records</h3>
                        <p class="text-purple-100 text-sm">Laboratory examination records and test results</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-0">
            <?php if($preEmployments->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Demographics</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Medical Test</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Lab Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php $__currentLoopData = $preEmployments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preEmployment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Check for examination records with actual data
                                    $examinations = \App\Models\PreEmploymentExamination::where('pre_employment_record_id', $preEmployment->id)
                                        ->orderBy('updated_at', 'desc')
                                        ->get();
                                    
                                    $hasSubmittedData = false;
                                    $latestExamination = null;
                                    
                                    foreach($examinations as $exam) {
                                        $labData = $exam->lab_report;
                                        if ($labData && is_array($labData)) {
                                            foreach($labData as $key => $value) {
                                                if (!empty($value) && $value !== 'Not available' && !str_contains($key, '_others')) {
                                                    $hasSubmittedData = true;
                                                    $latestExamination = $exam;
                                                    break 2;
                                                }
                                            }
                                        }
                                    }
                                    
                                    // Check if medical checklist is completed (pathologist tasks: stool exam and urinalysis)
                                    $medicalChecklist = \App\Models\MedicalChecklist::where('pre_employment_record_id', $preEmployment->id)
                                        ->where(function($query) {
                                            $query->whereNotNull('stool_exam_done_by')
                                                  ->where('stool_exam_done_by', '!=', '')
                                                  ->orWhere(function($q) {
                                                      $q->whereNotNull('urinalysis_done_by')
                                                        ->where('urinalysis_done_by', '!=', '');
                                                  });
                                        })
                                        ->first();
                                    
                                    $isChecklistCompleted = $medicalChecklist !== null;
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                                <span class="text-purple-600 font-semibold text-sm">
                                                    <?php echo e(substr($preEmployment->first_name, 0, 1)); ?><?php echo e(substr($preEmployment->last_name, 0, 1)); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900"><?php echo e($preEmployment->first_name); ?> <?php echo e($preEmployment->last_name); ?></p>
                                                <p class="text-xs text-gray-500">Record ID: #<?php echo e($preEmployment->id); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($preEmployment->age); ?> years old</p>
                                            <p class="text-xs text-gray-500"><?php echo e(ucfirst($preEmployment->sex)); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($preEmployment->company_name); ?></p>
                                            <p class="text-xs text-gray-500">Laboratory screening</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php if($preEmployment->medicalTestCategory): ?>
                                                <span class="font-medium"><?php echo e(optional($preEmployment->medicalTestCategory)->name); ?></span>
                                                <?php if($preEmployment->medicalTest): ?>
                                                    <p class="text-xs text-gray-500"><?php echo e($preEmployment->medicalTest->name); ?></p>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-gray-500"><?php echo e($preEmployment->medical_exam_type ?? 'General Lab Exam'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($preEmployment->status === 'approved'): ?>
                                            <span class="px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>Approved
                                            </span>
                                        <?php elseif($preEmployment->status === 'declined'): ?>
                                            <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                                <i class="fas fa-times-circle mr-1"></i>Declined
                                            </span>
                                        <?php elseif($preEmployment->status === 'pending'): ?>
                                            <span class="px-3 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                                <i class="fas fa-question-circle mr-1"></i><?php echo e(ucfirst($preEmployment->status ?? 'Unknown')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($hasSubmittedData): ?>
                                            <span class="px-2 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full mr-2">
                                                <i class="fas fa-check-circle mr-1"></i>Lab Completed
                                            </span>
                                        <?php elseif(!$isChecklistCompleted): ?>
                                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full mr-2">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Checklist Required
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full mr-2">
                                                <i class="fas fa-clock mr-1"></i>Pending Lab
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <!-- View Details -->
                                            <a href="<?php echo e(route('pathologist.pre-employment.show', $preEmployment->id)); ?>" 
                                               class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Lab Results -->
                                            <?php if(!$isChecklistCompleted): ?>
                                                <button class="p-2 text-gray-400 cursor-not-allowed rounded-lg" 
                                                        title="Complete medical checklist first" 
                                                        disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('pathologist.pre-employment.edit', $preEmployment->id)); ?>" 
                                                   class="p-2 text-purple-600 hover:text-purple-900 hover:bg-purple-50 rounded-lg transition-colors" 
                                                   title="Lab Results">
                                                    <i class="fas fa-flask"></i>
                                                </a>
                                            <?php endif; ?>

                                            <!-- Medical Checklist -->
                                            <a href="<?php echo e(route('pathologist.medical-checklist')); ?>?pre_employment_record_id=<?php echo e($preEmployment->id); ?>&examination_type=pre_employment" 
                                               class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-lg transition-colors" 
                                               title="Medical Checklist">
                                                <i class="fas fa-clipboard-list"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-microscope text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Pre-Employment Records</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no pre-employment laboratory examination records to display. New records will appear here once created.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if($preEmployments->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <?php echo e($preEmployments->firstItem()); ?> to <?php echo e($preEmployments->lastItem()); ?> of <?php echo e($preEmployments->total()); ?> results
                    </div>
                    <div class="flex items-center space-x-2">
                        
                        <?php if($preEmployments->onFirstPage()): ?>
                            <span class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left mr-1"></i>Previous
                            </span>
                        <?php else: ?>
                            <a href="<?php echo e($preEmployments->appends(request()->query())->previousPageUrl()); ?>" 
                               class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-left mr-1"></i>Previous
                            </a>
                        <?php endif; ?>

                        
                        <?php $__currentLoopData = $preEmployments->appends(request()->query())->getUrlRange(1, $preEmployments->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $preEmployments->currentPage()): ?>
                                <span class="px-3 py-2 text-sm font-medium text-white bg-purple-600 border border-purple-600 rounded-lg">
                                    <?php echo e($page); ?>

                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>" 
                                   class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    <?php echo e($page); ?>

                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        
                        <?php if($preEmployments->hasMorePages()): ?>
                            <a href="<?php echo e($preEmployments->appends(request()->query())->nextPageUrl()); ?>" 
                               class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Next<i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        <?php else: ?>
                            <span class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                                Next<i class="fas fa-chevron-right ml-1"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth animations to content cards
        const contentCards = document.querySelectorAll('.content-card');
        contentCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in-up');
        });

        // Auto-hide alert messages after 5 seconds
        const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // Enhanced hover effects for table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(2px)';
                this.style.transition = 'transform 0.2s ease-out';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });

        // Enhanced button hover effects
        const actionButtons = document.querySelectorAll('a[class*="p-2"]');
        actionButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
                this.style.transition = 'transform 0.2s ease-out';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
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

    /* Enhanced table styling */
    tbody tr {
        transition: all 0.2s ease-out;
    }
    
    tbody tr:hover {
        background-color: rgba(124, 58, 237, 0.02);
        border-left: 3px solid #7c3aed;
    }

    /* Filter form enhancements */
    .content-card form select:focus,
    .content-card form input:focus {
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.pathologist', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/pathologist/pre-employment.blade.php ENDPATH**/ ?>