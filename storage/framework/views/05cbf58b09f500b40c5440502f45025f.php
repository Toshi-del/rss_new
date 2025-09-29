<?php $__env->startSection('title', 'Pre-Employment ECG Records'); ?>

<?php $__env->startSection('page-title', 'Pre-Employment ECG Records'); ?>
<?php $__env->startSection('page-description', 'Manage ECG examinations and cardiac assessments for employment screening'); ?>

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
        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-search text-white"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold text-gray-900">Search & Filter</h3>
            <p class="text-gray-600 text-sm">Find specific pre-employment records quickly</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Search Records</label>
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Search by patient name, company name..." 
                       class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Filter by Status</label>
                <select id="statusFilter" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                    <option value="">All Status</option>
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="declined">Declined</option>
                </select>
            </div>
            
            <button onclick="clearFilters()" class="w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors duration-200 flex items-center justify-center space-x-2">
                <i class="fas fa-times"></i>
                <span>Clear Filters</span>
            </button>
        </div>
    </div>
</div>

<!-- Enhanced Records Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-briefcase text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Pre-Employment ECG Records</h2>
                    <p class="text-gray-600 text-sm mt-1">Comprehensive cardiac assessments for employment screening</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-blue-600" id="recordCount"><?php echo e($preEmployments->count()); ?></div>
                <div class="text-xs text-gray-500 uppercase tracking-wider">Total Records</div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full" id="recordsTable">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Age</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Gender</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $preEmployments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preEmployment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200 record-row" data-name="<?php echo e(strtolower($preEmployment->first_name . ' ' . $preEmployment->last_name)); ?>" data-company="<?php echo e(strtolower($preEmployment->company_name)); ?>" data-status="<?php echo e($preEmployment->status); ?>">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        <?php echo e(strtoupper(substr($preEmployment->first_name, 0, 1) . substr($preEmployment->last_name, 0, 1))); ?>

                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($preEmployment->first_name); ?> <?php echo e($preEmployment->last_name); ?></p>
                                    <p class="text-xs text-gray-500">Pre-Employment Candidate</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium"><?php echo e($preEmployment->age); ?></td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 font-medium"><?php echo e($preEmployment->sex); ?></td>
                        <td class="px-6 py-6 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($preEmployment->company_name); ?></div>
                            <div class="text-xs text-gray-500">Hiring Company</div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap">
                            <?php
                                $statusConfig = match($preEmployment->status) {
                                    'approved' => ['class' => 'bg-green-100 text-green-700 border-green-200', 'icon' => 'fas fa-check-circle'],
                                    'declined' => ['class' => 'bg-red-100 text-red-700 border-red-200', 'icon' => 'fas fa-times-circle'],
                                    'pending' => ['class' => 'bg-yellow-100 text-yellow-700 border-yellow-200', 'icon' => 'fas fa-clock'],
                                    default => ['class' => 'bg-gray-100 text-gray-700 border-gray-200', 'icon' => 'fas fa-question-circle']
                                };
                            ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border <?php echo e($statusConfig['class']); ?>">
                                <i class="<?php echo e($statusConfig['icon']); ?> mr-1"></i>
                                <?php echo e(ucfirst($preEmployment->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-2">
                                <form action="<?php echo e(route('ecgtech.pre-employment.send-to-doctor', $preEmployment->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200 group" title="Send to Doctor">
                                        <i class="fas fa-paper-plane mr-1 group-hover:translate-x-0.5 transition-transform"></i>
                                        Send
                                    </button>
                                </form>
                                <a href="<?php echo e(route('ecgtech.medical-checklist-page.pre-employment', $preEmployment->id)); ?>" class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200 group" title="ECG Checklist">
                                    <i class="fas fa-heartbeat mr-1 group-hover:scale-110 transition-transform"></i>
                                    ECG
                                </a>
                                <a href="<?php echo e(route('ecgtech.pre-employment.edit', $preEmployment->id)); ?>" class="inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold rounded-lg transition-colors duration-200 group" title="Edit ECG Data">
                                    <i class="fas fa-edit mr-1 group-hover:rotate-12 transition-transform"></i>
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr id="emptyState">
                        <td colspan="6" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-briefcase text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">No pre-employment records found</p>
                                <p class="text-gray-400 text-sm">New employment screening records will appear here</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Enhanced Pagination -->
    <?php if($preEmployments->hasPages()): ?>
        <div class="px-8 py-6 border-t border-gray-100 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Showing <?php echo e($preEmployments->firstItem()); ?> to <?php echo e($preEmployments->lastItem()); ?> of <?php echo e($preEmployments->total()); ?> results
                </div>
                <div class="pagination-wrapper">
                    <?php echo e($preEmployments->links()); ?>

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
    const recordCount = document.getElementById('recordCount');
    
    // Add loading states and animations
    searchInput.addEventListener('input', debounce(filterTable, 300));
    statusFilter.addEventListener('change', filterTable);
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const rows = document.querySelectorAll('.record-row');
        const emptyState = document.getElementById('emptyState');
        let visibleCount = 0;
        
        // Add loading animation
        recordCount.style.opacity = '0.5';
        
        rows.forEach((row, index) => {
            const name = row.dataset.name;
            const company = row.dataset.company;
            const status = row.dataset.status;
            
            const matchesSearch = name.includes(searchTerm) || company.includes(searchTerm);
            const matchesStatus = !statusFilter || status === statusFilter;
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                row.style.animation = `fadeInUp 0.3s ease-out ${index * 0.05}s both`;
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update record count with animation
        setTimeout(() => {
            recordCount.textContent = visibleCount;
            recordCount.style.opacity = '1';
        }, 150);
        
        // Show/hide empty state
        if (emptyState) {
            if (visibleCount === 0 && (searchTerm || statusFilter)) {
                emptyState.style.display = '';
                emptyState.innerHTML = `
                    <td colspan="6" class="px-8 py-12 text-center">
                        <div class="flex flex-col items-center space-y-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-search text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">No records match your search</p>
                            <p class="text-gray-400 text-sm">Try adjusting your search terms or filters</p>
                            <button onclick="clearFilters()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
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
    
    function clearFilters() {
        searchInput.value = '';
        statusFilter.value = '';
        
        // Add clear animation
        searchInput.style.transform = 'scale(0.95)';
        statusFilter.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            searchInput.style.transform = 'scale(1)';
            statusFilter.style.transform = 'scale(1)';
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
        this.parentElement.style.boxShadow = '0 4px 12px rgba(34, 197, 94, 0.15)';
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
        background-color: #3b82f6;
        color: white;
        transform: translateY(-1px);
    }
`;
document.head.appendChild(style);
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecgtech', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rss_new\resources\views/ecgtech/pre-employment.blade.php ENDPATH**/ ?>