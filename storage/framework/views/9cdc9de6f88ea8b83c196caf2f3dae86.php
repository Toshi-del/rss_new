<?php $__env->startSection('title', 'OPD Walk-in ECG Patients'); ?>

<?php $__env->startSection('page-title', 'OPD Walk-in ECG Patients'); ?>
<?php $__env->startSection('page-description', 'Manage ECG examinations for outpatient department walk-in patients'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="mb-8 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 flex items-center space-x-3">
        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-white text-sm"></i>
        </div>
        <div>
            <p class="text-green-800 font-semibold"><?php echo e(session('success')); ?></p>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
<?php endif; ?>

<!-- Enhanced Search and Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8">
    <div class="flex items-center space-x-3 mb-6">
        <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-search text-white"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold text-gray-900">Search & Filter</h3>
            <p class="text-gray-600 text-sm">Find specific OPD walk-in patients quickly</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Search Patients</label>
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Search by patient name, email, phone..." 
                       class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">ECG Status</label>
            <select id="statusFilter" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                <option value="">All Status</option>
                <option value="completed">ECG Completed</option>
                <option value="pending">ECG Pending</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Registration Date</label>
            <select id="dateFilter" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 mb-4">
                <option value="">All Dates</option>
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
            </select>
            
            <button onclick="clearFilters()" class="w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors duration-200 flex items-center justify-center space-x-2">
                <i class="fas fa-times"></i>
                <span>Clear Filters</span>
            </button>
        </div>
    </div>
</div>

<!-- Enhanced OPD Walk-ins Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-amber-50">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-walking text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">OPD Walk-in ECG Patients</h2>
                    <p class="text-gray-600 text-sm mt-1">Outpatient department cardiac examinations and monitoring</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-orange-600" id="patientCount"><?php echo e($opdPatients->count()); ?></div>
                <div class="text-xs text-gray-500 uppercase tracking-wider">Total Patients</div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full" id="patientsTable">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Age</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Registration</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ECG Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $opdPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $opdExam = \App\Models\OpdExamination::where('user_id', $patient->id)->first();
                        $medicalChecklist = \App\Models\MedicalChecklist::where('user_id', $patient->id)
                            ->where('examination_type', 'opd')
                            ->whereNotNull('ecg_done_by')
                            ->first();
                        $canSendToDoctor = $medicalChecklist && !empty($medicalChecklist->ecg_done_by);
                        $ecgStatus = $medicalChecklist ? 'completed' : 'pending';
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200 patient-row" 
                        data-name="<?php echo e(strtolower($patient->fname . ' ' . $patient->lname)); ?>" 
                        data-email="<?php echo e(strtolower($patient->email)); ?>" 
                        data-phone="<?php echo e(strtolower($patient->phone)); ?>" 
                        data-status="<?php echo e($ecgStatus); ?>"
                        data-date="<?php echo e($patient->created_at->format('Y-m-d')); ?>">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        <?php echo e(strtoupper(substr($patient->fname, 0, 1) . substr($patient->lname, 0, 1))); ?>

                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($patient->fname); ?> <?php echo e($patient->lname); ?></p>
                                    <p class="text-xs text-gray-500">OPD Walk-in Patient</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($patient->age); ?></div>
                            <div class="text-xs text-gray-500">years old</div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($patient->email); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($patient->phone); ?></div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($patient->created_at->format('M d, Y')); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($patient->created_at->format('h:i A')); ?></div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap">
                            <?php if($medicalChecklist): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border bg-green-100 text-green-700 border-green-200">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    ECG Completed
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border bg-yellow-100 text-yellow-700 border-yellow-200">
                                    <i class="fas fa-clock mr-1"></i>
                                    ECG Pending
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-2">
                                <?php if($canSendToDoctor): ?>
                                    <form action="<?php echo e(route('ecgtech.opd.send-to-doctor', $patient->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200 group" title="Send to Doctor">
                                            <i class="fas fa-paper-plane mr-1 group-hover:translate-x-0.5 transition-transform"></i>
                                            Send
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button type="button" class="inline-flex items-center px-3 py-2 bg-gray-400 text-white text-xs font-semibold rounded-lg cursor-not-allowed" title="Complete ECG examination first" disabled>
                                        <i class="fas fa-paper-plane mr-1"></i>
                                        Send
                                    </button>
                                <?php endif; ?>
                                
                                <?php if($opdExam): ?>
                                    <a href="<?php echo e(route('ecgtech.opd.edit', $opdExam->id)); ?>" class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200 group" title="Edit ECG Results">
                                        <i class="fas fa-heartbeat mr-1 group-hover:scale-110 transition-transform"></i>
                                        Edit ECG
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('ecgtech.opd.create', ['user_id' => $patient->id])); ?>" class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200 group" title="Add ECG Results">
                                        <i class="fas fa-plus mr-1 group-hover:rotate-90 transition-transform"></i>
                                        Add ECG
                                    </a>
                                <?php endif; ?>
                                
                                <a href="<?php echo e(route('ecgtech.medical-checklist.opd', $patient->id)); ?>" class="inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200 group" title="Medical Checklist">
                                    <i class="fas fa-clipboard-list mr-1 group-hover:rotate-12 transition-transform"></i>
                                    Checklist
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr id="emptyState">
                        <td colspan="6" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-walking text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">No OPD walk-in patients found</p>
                                <p class="text-gray-400 text-sm">New walk-in patients will appear here</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Enhanced Pagination -->
    <?php if($opdPatients->hasPages()): ?>
        <div class="px-8 py-6 border-t border-gray-100 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Showing <?php echo e($opdPatients->firstItem()); ?> to <?php echo e($opdPatients->lastItem()); ?> of <?php echo e($opdPatients->total()); ?> results
                </div>
                <div class="pagination-wrapper">
                    <?php echo e($opdPatients->links()); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced search and filter functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const patientCount = document.getElementById('patientCount');
    
    // Add loading states and animations
    searchInput.addEventListener('input', debounce(filterTable, 300));
    statusFilter.addEventListener('change', filterTable);
    dateFilter.addEventListener('change', filterTable);
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilterValue = statusFilter.value;
        const dateFilterValue = dateFilter.value;
        const rows = document.querySelectorAll('.patient-row');
        const emptyState = document.getElementById('emptyState');
        let visibleCount = 0;
        
        // Add loading animation
        patientCount.style.opacity = '0.5';
        
        rows.forEach((row, index) => {
            const name = row.dataset.name;
            const email = row.dataset.email;
            const phone = row.dataset.phone;
            const status = row.dataset.status;
            const date = row.dataset.date;
            
            const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm);
            const matchesStatus = !statusFilterValue || status === statusFilterValue;
            const matchesDate = !dateFilterValue || checkDateRange(date, dateFilterValue);
            
            if (matchesSearch && matchesStatus && matchesDate) {
                row.style.display = '';
                row.style.animation = `fadeInUp 0.3s ease-out ${index * 0.05}s both`;
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update patient count with animation
        setTimeout(() => {
            patientCount.textContent = visibleCount;
            patientCount.style.opacity = '1';
        }, 150);
        
        // Show/hide empty state
        if (emptyState) {
            if (visibleCount === 0 && (searchTerm || statusFilterValue || dateFilterValue)) {
                emptyState.style.display = '';
                emptyState.innerHTML = `
                    <td colspan="6" class="px-8 py-12 text-center">
                        <div class="flex flex-col items-center space-y-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-search text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">No patients match your search</p>
                            <p class="text-gray-400 text-sm">Try adjusting your search terms or filters</p>
                            <button onclick="clearFilters()" class="mt-2 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                                Clear Filters
                            </button>
                        </div>
                    </td>
                `;
            } else if (visibleCount === 0) {
                emptyState.style.display = '';
            } else {
                emptyState.style.display = 'none';
            }
        }
    }
    
    function checkDateRange(dateString, range) {
        const date = new Date(dateString);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);
        
        switch(range) {
            case 'today': 
                return date.toDateString() === today.toDateString();
            case 'yesterday': 
                return date.toDateString() === yesterday.toDateString();
            case 'week': 
                const weekAgo = new Date(today);
                weekAgo.setDate(weekAgo.getDate() - 7);
                return date >= weekAgo && date <= today;
            case 'month': 
                const monthAgo = new Date(today);
                monthAgo.setMonth(monthAgo.getMonth() - 1);
                return date >= monthAgo && date <= today;
            default: 
                return true;
        }
    }
    
    function clearFilters() {
        searchInput.value = '';
        statusFilter.value = '';
        dateFilter.value = '';
        
        // Add clear animation
        searchInput.style.transform = 'scale(0.95)';
        statusFilter.style.transform = 'scale(0.95)';
        dateFilter.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            searchInput.style.transform = 'scale(1)';
            statusFilter.style.transform = 'scale(1)';
            dateFilter.style.transform = 'scale(1)';
        }, 150);
        
        filterTable();
    }
    
    // Debounce function for search input
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Add hover effects to action buttons
    const actionButtons = document.querySelectorAll('button, a');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
        
        // Escape to clear filters
        if (e.key === 'Escape') {
            clearFilters();
        }
    });
    
    // Add search input focus effects
    searchInput.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
        this.parentElement.style.boxShadow = '0 4px 12px rgba(234, 88, 12, 0.15)';
    });
    
    searchInput.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
        this.parentElement.style.boxShadow = 'none';
    });
    
    // Make clearFilters globally available
    window.clearFilters = clearFilters;
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .pagination-wrapper .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        space-x: 1rem;
    }
    
    .pagination-wrapper .pagination a,
    .pagination-wrapper .pagination span {
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        font-weight: 500;
    }
    
    .pagination-wrapper .pagination a:hover {
        background-color: #ea580c;
        color: white;
        transform: translateY(-1px);
    }
`;
document.head.appendChild(style);
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecgtech', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/ecgtech/opd.blade.php ENDPATH**/ ?>