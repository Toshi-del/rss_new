<?php $__env->startSection('title', 'Pre-Employment Medical Examinations - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Pre-Employment Examinations'); ?>
<?php $__env->startSection('page-description', 'Manage employment medical examinations and health assessments'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-emerald-800 font-medium"><?php echo e(session('success')); ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium"><?php echo e(session('error')); ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-user-md text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Pre-Employment Medical Management</h3>
                        <p class="text-emerald-100 text-sm">Employment health assessments and medical clearances</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Search Form -->
                    <form method="GET" action="<?php echo e(route('nurse.pre-employment')); ?>" class="flex items-center space-x-3">
                        <!-- Preserve current filter -->
                        <?php if(request('exam_status')): ?>
                            <input type="hidden" name="exam_status" value="<?php echo e(request('exam_status')); ?>">
                        <?php endif; ?>
                        <?php if(request('company')): ?>
                            <input type="hidden" name="company" value="<?php echo e(request('company')); ?>">
                        <?php endif; ?>
                        <?php if(request('gender')): ?>
                            <input type="hidden" name="gender" value="<?php echo e(request('gender')); ?>">
                        <?php endif; ?>
                        <?php if(request('date_range')): ?>
                            <input type="hidden" name="date_range" value="<?php echo e(request('date_range')); ?>">
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
                                   placeholder="Search by name, email, company...">
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

    <!-- Exam Status Tabs -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <?php
            $currentTab = request('exam_status', 'needs_attention');
        ?>
        
        <!-- Tab Navigation -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex space-x-1">
                    <a href="<?php echo e(request()->fullUrlWithQuery(['exam_status' => 'needs_attention'])); ?>" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 <?php echo e($currentTab === 'needs_attention' ? 'bg-emerald-600 text-white' : 'text-gray-600 hover:text-emerald-600 hover:bg-emerald-50'); ?>">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Needs Attention
                        <?php
                            $needsAttentionCount = \App\Models\PreEmploymentRecord::where('status', 'approved')
                                ->whereDoesntHave('preEmploymentExamination')
                                ->count();
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?php echo e($currentTab === 'needs_attention' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                            <?php echo e($needsAttentionCount); ?>

                        </span>
                    </a>
                    
                    <a href="<?php echo e(request()->fullUrlWithQuery(['exam_status' => 'exam_completed'])); ?>" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 <?php echo e($currentTab === 'exam_completed' ? 'bg-emerald-600 text-white' : 'text-gray-600 hover:text-emerald-600 hover:bg-emerald-50'); ?>">
                        <i class="fas fa-check-circle mr-2"></i>
                        Completed
                        <?php
                            $completedCount = \App\Models\PreEmploymentRecord::where('status', 'approved')
                                ->whereHas('preEmploymentExamination')
                                ->count();
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?php echo e($currentTab === 'exam_completed' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                            <?php echo e($completedCount); ?>

                        </span>
                    </a>
                </div>
                
                <a href="<?php echo e(route('nurse.pre-employment')); ?>" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-times mr-1"></i>Clear All Filters
                </a>
            </div>
        </div>

        <!-- Additional Filters -->
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('nurse.pre-employment')); ?>" class="space-y-6">
                <!-- Preserve current tab -->
                <input type="hidden" name="exam_status" value="<?php echo e($currentTab); ?>">
                
                <!-- Preserve search query -->
                <?php if(request('search')): ?>
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <?php endif; ?>
                
                <!-- Filter Row: Company, Gender, Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Company Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                        <select name="company" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Companies</option>
                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($company); ?>" <?php echo e(request('company') === $company ? 'selected' : ''); ?>>
                                    <?php echo e($company); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Gender Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Genders</option>
                            <option value="male" <?php echo e(request('gender') === 'male' ? 'selected' : ''); ?>>Male</option>
                            <option value="female" <?php echo e(request('gender') === 'female' ? 'selected' : ''); ?>>Female</option>
                        </select>
                    </div>

                    <!-- Date Range Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                        <select name="date_range" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Dates</option>
                            <option value="today" <?php echo e(request('date_range') === 'today' ? 'selected' : ''); ?>>Today</option>
                            <option value="week" <?php echo e(request('date_range') === 'week' ? 'selected' : ''); ?>>This Week</option>
                            <option value="month" <?php echo e(request('date_range') === 'month' ? 'selected' : ''); ?>>This Month</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>Apply Filters
                        </button>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['company' => null, 'gender' => null, 'date_range' => null, 'search' => null])); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-undo mr-2"></i>Reset Filters
                        </a>
                    </div>
                    
                    <!-- Active Filters Display -->
                    <?php if(request()->hasAny(['company', 'gender', 'date_range', 'search'])): ?>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Active filters:</span>
                            <?php if(request('search')): ?>
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs">
                                    Search: "<?php echo e(request('search')); ?>"
                                    <a href="<?php echo e(request()->fullUrlWithQuery(['search' => null])); ?>" class="ml-1 text-emerald-600 hover:text-emerald-800">×</a>
                                </span>
                            <?php endif; ?>
                            <?php if(request('company')): ?>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                    Company: <?php echo e(request('company')); ?>

                                    <a href="<?php echo e(request()->fullUrlWithQuery(['company' => null])); ?>" class="ml-1 text-blue-600 hover:text-blue-800">×</a>
                                </span>
                            <?php endif; ?>
                            <?php if(request('gender')): ?>
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">
                                    Gender: <?php echo e(ucfirst(request('gender'))); ?>

                                    <a href="<?php echo e(request()->fullUrlWithQuery(['gender' => null])); ?>" class="ml-1 text-purple-600 hover:text-purple-800">×</a>
                                </span>
                            <?php endif; ?>
                            <?php if(request('date_range')): ?>
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs">
                                    Date: <?php echo e(ucfirst(request('date_range'))); ?>

                                    <a href="<?php echo e(request()->fullUrlWithQuery(['date_range' => null])); ?>" class="ml-1 text-indigo-600 hover:text-indigo-800">×</a>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <?php
            $totalRecords = $preEmployments->count();
            $approvedCount = $preEmployments->where('status', 'approved')->count();
            $pendingCount = $preEmployments->where('status', 'pending')->count();
            $declinedCount = $preEmployments->where('status', 'declined')->count();
        ?>
        
        <div class="content-card rounded-xl p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Records</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($totalRecords); ?></p>
                    <p class="text-xs text-blue-600 mt-1">All examinations</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl p-6 border-l-4 border-emerald-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Approved</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($approvedCount); ?></p>
                    <p class="text-xs text-emerald-600 mt-1">Medical clearance</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl p-6 border-l-4 border-amber-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($pendingCount); ?></p>
                    <p class="text-xs text-amber-600 mt-1">Under review</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-amber-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl p-6 border-l-4 border-red-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Declined</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($declinedCount); ?></p>
                    <p class="text-xs text-red-600 mt-1">Medical issues</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pre-Employment Records Table -->
    <div class="content-card rounded-xl shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-table text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Pre-Employment Records</h3>
                        <p class="text-emerald-100 text-sm">Medical examination records and status tracking</p>
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
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php $__currentLoopData = $preEmployments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preEmployment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-blue-600 font-semibold text-sm">
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
                                            <p class="text-xs text-gray-500">Employment screening</p>
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
                                                <span class="text-gray-500"><?php echo e($preEmployment->medical_exam_type ?? 'General Medical Exam'); ?></span>
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
                                        <?php
                                            $medicalChecklist = \App\Models\MedicalChecklist::where('pre_employment_record_id', $preEmployment->id)
                                                ->where('examination_type', 'pre-employment')
                                                ->first();
                                            $canSendToDoctor = $preEmployment->preEmploymentExamination && $medicalChecklist && !empty($medicalChecklist->physical_exam_done_by);
                                            $hasExamination = !is_null($preEmployment->preEmploymentExamination);
                                        ?>
                                        
                                        <div class="flex items-center space-x-2">
                                            <!-- Examination Status Badge -->
                                            <?php if($hasExamination): ?>
                                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full mr-2">
                                                    <i class="fas fa-check-circle mr-1"></i>Exam Completed
                                                </span>
                                            <?php else: ?>
                                                <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full mr-2">
                                                    <i class="fas fa-clock mr-1"></i>Pending Exam
                                                </span>
                                            <?php endif; ?>

                                            <!-- Examination Action Buttons -->
                                            <?php if($hasExamination): ?>
                                                <a href="<?php echo e(route('nurse.pre-employment.edit', $preEmployment->preEmploymentExamination->id)); ?>" 
                                                   class="p-2 text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 rounded-lg transition-colors" 
                                                   title="Edit Examination">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php else: ?>
                                                <?php if($medicalChecklist && !empty($medicalChecklist->physical_exam_done_by)): ?>
                                                    <a href="<?php echo e(route('nurse.pre-employment.create', ['record_id' => $preEmployment->id])); ?>" 
                                                       class="p-2 text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 rounded-lg transition-colors" 
                                                       title="Create Examination">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <button class="p-2 text-gray-400 cursor-not-allowed rounded-lg" 
                                                            title="Complete medical checklist first" 
                                                            disabled>
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <!-- Medical Checklist -->
                                            <a href="<?php echo e(route('nurse.medical-checklist.pre-employment', $preEmployment->id)); ?>" 
                                               class="p-2 text-purple-600 hover:text-purple-900 hover:bg-purple-50 rounded-lg transition-colors" 
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
                        <i class="fas fa-user-md text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Pre-Employment Records</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no pre-employment medical examination records to display. New records will appear here once created.</p>
                    <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-plus mr-2"></i>Create New Record
                    </button>
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
                                <span class="px-3 py-2 text-sm font-medium text-white bg-emerald-600 border border-emerald-600 rounded-lg">
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
        const alerts = document.querySelectorAll('[class*="bg-emerald-50"], [class*="bg-red-50"]');
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
        background-color: rgba(16, 185, 129, 0.02);
        border-left: 3px solid #10b981;
    }

    /* Filter form enhancements */
    .content-card form select:focus,
    .content-card form input:focus {
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.nurse', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/nurse/pre-employment.blade.php ENDPATH**/ ?>