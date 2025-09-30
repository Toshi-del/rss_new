<?php $__env->startSection('title', 'Annual Physical Examinations - RSS Citi Health Services'); ?>
<?php $__env->startSection('page-title', 'Annual Physical Examinations'); ?>
<?php $__env->startSection('page-description', 'Laboratory examinations for yearly health assessments'); ?>

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
                        Needs Review
                        <?php
                            $needsAttentionCount = \App\Models\Patient::where('status', 'approved')
                                ->whereHas('medicalChecklists', function($q) {
                                    $q->where('examination_type', 'annual-physical')
                                      ->whereNotNull('stool_exam_done_by')
                                      ->where('stool_exam_done_by', '!=', '')
                                      ->whereNotNull('urinalysis_done_by')
                                      ->where('urinalysis_done_by', '!=', '');
                                })
                                ->whereDoesntHave('annualPhysicalExamination', function($q) {
                                    $q->whereNotNull('lab_report')
                                      ->where('lab_report', '!=', '');
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
                            $completedCount = \App\Models\Patient::where('status', 'approved')
                                ->whereHas('medicalChecklists', function($q) {
                                    $q->where('examination_type', 'annual-physical')
                                      ->whereNotNull('stool_exam_done_by')
                                      ->where('stool_exam_done_by', '!=', '')
                                      ->whereNotNull('urinalysis_done_by')
                                      ->where('urinalysis_done_by', '!=', '');
                                })
                                ->whereHas('annualPhysicalExamination', function($q) {
                                    $q->whereNotNull('lab_report')
                                      ->where('lab_report', '!=', '');
                                })
                                ->count();
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?php echo e($currentTab === 'lab_completed' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                            <?php echo e($completedCount); ?>

                        </span>
                    </a>
                </div>
                
                <a href="<?php echo e(route('pathologist.annual-physical')); ?>" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-times mr-1"></i>Clear All Filters
                </a>
            </div>
        </div>

        <!-- Additional Filters -->
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('pathologist.annual-physical')); ?>" class="space-y-6">
                <!-- Preserve current tab -->
                <input type="hidden" name="lab_status" value="<?php echo e($currentTab); ?>">
                
                <!-- Preserve search query -->
                <?php if(request('search')): ?>
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <?php endif; ?>
                
                <!-- Filter Row: Gender only -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Gender Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm">
                            <option value="">All Genders</option>
                            <option value="male" <?php echo e(request('gender') === 'male' ? 'selected' : ''); ?>>Male</option>
                            <option value="female" <?php echo e(request('gender') === 'female' ? 'selected' : ''); ?>>Female</option>
                        </select>
                    </div>

                    <!-- Placeholder -->
                    <div></div>
                </div>

                <!-- Filter Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>Apply Filters
                        </button>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['gender' => null, 'search' => null])); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-undo mr-2"></i>Reset Filters
                        </a>
                    </div>
                    
                    <!-- Active Filters Display -->
                    <?php if(request()->hasAny(['gender', 'search'])): ?>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Active filters:</span>
                            <?php if(request('search')): ?>
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">
                                    Search: "<?php echo e(request('search')); ?>"
                                    <a href="<?php echo e(request()->fullUrlWithQuery(['search' => null])); ?>" class="ml-1 text-purple-600 hover:text-purple-800">×</a>
                                </span>
                            <?php endif; ?>
                            <?php if(request('gender')): ?>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                    Gender: <?php echo e(ucfirst(request('gender'))); ?>

                                    <a href="<?php echo e(request()->fullUrlWithQuery(['gender' => null])); ?>" class="ml-1 text-blue-600 hover:text-blue-800">×</a>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-calendar-check text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Annual Physical Laboratory Management</h3>
                        <p class="text-purple-100 text-sm">Laboratory assessments for yearly comprehensive health checkups</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Search Form -->
                    <form method="GET" action="<?php echo e(route('pathologist.annual-physical')); ?>" class="flex items-center space-x-3">
                        <!-- Preserve current filter -->
                        <?php if(request('lab_status')): ?>
                            <input type="hidden" name="lab_status" value="<?php echo e(request('lab_status')); ?>">
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



    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <?php
            $totalPatients = $patients->count();
            $completedCount = 0;
            $pendingCount = 0;
            $scheduledCount = $totalPatients;
            
            foreach($patients as $patient) {
                $annualPhysicalExam = \App\Models\AnnualPhysicalExamination::where('patient_id', $patient->id)->first();
                $medicalChecklist = \App\Models\MedicalChecklist::where('patient_id', $patient->id)
                    ->where('examination_type', 'annual-physical')
                    ->first();
                    
                if($annualPhysicalExam && $medicalChecklist) {
                    $completedCount++;
                } else {
                    $pendingCount++;
                }
            }
        ?>
        
        <div class="content-card rounded-xl p-6 border-l-4 border-indigo-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Patients</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($totalPatients); ?></p>
                    <p class="text-xs text-indigo-600 mt-1">Scheduled checkups</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-indigo-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl p-6 border-l-4 border-emerald-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Lab Completed</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($completedCount); ?></p>
                    <p class="text-xs text-emerald-600 mt-1">Lab tests done</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl p-6 border-l-4 border-amber-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending Lab</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($pendingCount); ?></p>
                    <p class="text-xs text-amber-600 mt-1">Awaiting lab work</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-amber-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="content-card rounded-xl p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Completion Rate</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($totalPatients > 0 ? round(($completedCount / $totalPatients) * 100) : 0); ?>%</p>
                    <p class="text-xs text-blue-600 mt-1">Lab progress</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Annual Physical Patients Table -->
    <div class="content-card rounded-xl shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-table text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Annual Physical Laboratory Patients</h3>
                        <p class="text-purple-100 text-sm">Laboratory examinations for yearly health assessment records</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-0">
            <?php if($patients->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Demographics</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact Info</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Appointment</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $annualPhysicalExam = \App\Models\AnnualPhysicalExamination::where('patient_id', $patient->id)->first();
                                    $medicalChecklist = \App\Models\MedicalChecklist::where('patient_id', $patient->id)
                                        ->where('examination_type', 'annual-physical')
                                        ->first();
                                    $isCompleted = $annualPhysicalExam && $medicalChecklist;
                                    $canSendToDoctor = $isCompleted;
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                                <span class="text-indigo-600 font-semibold text-sm">
                                                    <?php echo e(substr($patient->first_name, 0, 1)); ?><?php echo e(substr($patient->last_name, 0, 1)); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900"><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></p>
                                                <p class="text-xs text-gray-500">Patient ID: #<?php echo e($patient->id); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($patient->age); ?> years old</p>
                                            <p class="text-xs text-gray-500"><?php echo e(ucfirst($patient->sex)); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium"><?php echo e($patient->email); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($patient->phone ?? 'No phone'); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium">Appointment #<?php echo e($patient->appointment_id); ?></p>
                                            <p class="text-xs text-gray-500">Annual physical checkup</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($isCompleted): ?>
                                            <span class="px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>Lab Completed
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">
                                                <i class="fas fa-clock mr-1"></i>Pending Lab
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <!-- Lab Status Badge -->
                                            <?php if($annualPhysicalExam): ?>
                                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full mr-2">
                                                    <i class="fas fa-check-circle mr-1"></i>Lab Done
                                                </span>
                                            <?php else: ?>
                                                <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full mr-2">
                                                    <i class="fas fa-clock mr-1"></i>Pending Lab
                                                </span>
                                            <?php endif; ?>

                                            <!-- View Details -->
                                            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Lab Results -->
                                            <a href="<?php echo e(route('pathologist.annual-physical.edit', $patient->id)); ?>" 
                                               class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-lg transition-colors" 
                                               title="Lab Results">
                                                <i class="fas fa-flask"></i>
                                            </a>

                                            <!-- Medical Checklist -->
                                            <a href="<?php echo e(route('pathologist.medical-checklist')); ?>?patient_id=<?php echo e($patient->id); ?>&examination_type=annual_physical" 
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
                        <i class="fas fa-calendar-check text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Annual Physical Patients</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no patients scheduled for annual physical laboratory examinations. New appointments will appear here once scheduled.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if($patients->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <?php echo e($patients->firstItem()); ?> to <?php echo e($patients->lastItem()); ?> of <?php echo e($patients->total()); ?> results
                    </div>
                    <div class="flex items-center space-x-2">
                        
                        <?php if($patients->onFirstPage()): ?>
                            <span class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left mr-1"></i>Previous
                            </span>
                        <?php else: ?>
                            <a href="<?php echo e($patients->appends(request()->query())->previousPageUrl()); ?>" 
                               class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-left mr-1"></i>Previous
                            </a>
                        <?php endif; ?>

                        
                        <?php $__currentLoopData = $patients->appends(request()->query())->getUrlRange(1, $patients->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $patients->currentPage()): ?>
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

                        
                        <?php if($patients->hasMorePages()): ?>
                            <a href="<?php echo e($patients->appends(request()->query())->nextPageUrl()); ?>" 
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pathologist', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/pathologist/annual-physical.blade.php ENDPATH**/ ?>