<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Pathologist Dashboard'); ?> - RSS Health Services Corp</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php echo $__env->yieldContent('styles'); ?>
    <style>
        :root {
            --primary-teal: #0d9488;
            --primary-teal-dark: #0f766e;
            --primary-teal-light: #5eead4;
            --sidebar-bg: rgba(255, 255, 255, 0.98);
            --sidebar-border: rgba(15, 118, 110, 0.1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        
        .content-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        
        .content-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Allow gradient backgrounds to override white background */
        .bg-gradient-to-r.content-card,
        .bg-gradient-to-l.content-card,
        .bg-gradient-to-t.content-card,
        .bg-gradient-to-b.content-card {
            background: inherit !important;
        }
        
        /* Specific welcome section styling */
        .welcome-gradient {
            background: linear-gradient(to right, #0d9488, #0f766e) !important;
        }
        
        .sidebar-glass {
            background: var(--sidebar-bg);
            backdrop-filter: blur(20px);
            border-right: 2px solid rgba(13, 148, 136, 0.2);
            box-shadow: 2px 0 10px rgba(13, 148, 136, 0.1);
        }
        
        .nav-item {
            transition: all 0.3s ease;
            border-radius: 1rem;
            margin: 0.25rem 0.75rem;
        }
        
        .nav-item:hover {
            background-color: rgba(13, 148, 136, 0.1);
        }
        
        .nav-item.active {
            background-color: rgba(13, 148, 136, 0.15);
            color: var(--primary-teal-dark);
            font-weight: 600;
            border-left: 3px solid var(--primary-teal);
        }
        
        .notification-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .header-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(15, 118, 110, 0.2);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .search-focus:focus {
            ring-color: var(--primary-teal);
            border-color: var(--primary-teal);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-teal);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-teal-dark);
        }
    </style>
</head>
<body class="bg-slate-50 font-poppins">
    <div class="flex h-screen">
        <!-- Modern Sidebar -->
        <div class="w-64 sidebar-glass flex-shrink-0 shadow-xl relative">
            <!-- Brand Header -->
            <div class="p-6 border-b border-teal-100">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-microscope text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Pathologist</h1>
                        <p class="text-teal-600 text-sm font-medium">Laboratory Portal</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="mt-6 px-3">
                <div class="space-y-1">
                    <!-- Main Menu -->
                    <div class="px-3 mb-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Main Menu</h3>
                    </div>
                    
                    <a href="<?php echo e(route('pathologist.dashboard')); ?>" 
                       class="nav-item flex items-center px-4 py-3 text-gray-700 <?php echo e(request()->routeIs('pathologist.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-th-large mr-3 text-lg"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </div>
                
                <!-- Laboratory Services -->
                <div class="mt-8 px-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Laboratory Services</h3>
                    <div class="space-y-1">
                        <a href="<?php echo e(route('pathologist.annual-physical')); ?>" 
                           class="nav-item flex items-center px-4 py-3 text-gray-700 <?php echo e(request()->routeIs('pathologist.annual-physical*') ? 'active' : ''); ?>">
                            <i class="fas fa-file-medical mr-3 text-lg"></i>
                            <span class="font-medium">Annual Physical</span>
                        </a>
                        
                        <a href="<?php echo e(route('pathologist.pre-employment')); ?>" 
                           class="nav-item flex items-center px-4 py-3 text-gray-700 <?php echo e(request()->routeIs('pathologist.pre-employment*') ? 'active' : ''); ?>">
                            <i class="fas fa-briefcase mr-3 text-lg"></i>
                            <span class="font-medium">Pre-Employment</span>
                        </a>
                        
                        <a href="<?php echo e(route('pathologist.opd')); ?>" 
                           class="nav-item flex items-center px-4 py-3 text-gray-700 <?php echo e(request()->routeIs('pathologist.opd*') ? 'active' : ''); ?>">
                            <i class="fas fa-walking mr-3 text-lg"></i>
                            <span class="font-medium">OPD Walk-ins</span>
                        </a>
                    </div>
                </div>
                
                <!-- Communication -->
                <div class="mt-8 px-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Communication</h3>
                    <div class="space-y-1">
                        <a href="<?php echo e(route('pathologist.messages')); ?>" 
                           class="nav-item flex items-center px-4 py-3 text-gray-700 <?php echo e(request()->routeIs('pathologist.messages*') ? 'active' : ''); ?>">
                            <i class="fas fa-comments mr-3 text-lg"></i>
                            <span class="font-medium">Messages</span>
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1 notification-pulse">3</span>
                        </a>
                    </div>
                </div>
            </nav>
            
            <!-- Laboratory Stats -->
            <div class="mt-8 mx-6 mb-6">
                <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl p-4 border border-teal-200">
                    <div class="flex items-center space-x-2 mb-3">
                        <i class="fas fa-chart-bar text-teal-600"></i>
                        <h3 class="text-sm font-semibold text-teal-800">Lab Overview</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-teal-700">Pending Tests</span>
                            <span class="text-sm font-bold text-teal-800 bg-teal-200 px-2 py-1 rounded-lg">12</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-teal-700">Completed Today</span>
                            <span class="text-sm font-bold text-teal-800 bg-teal-200 px-2 py-1 rounded-lg">8</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-teal-700">In Progress</span>
                            <span class="text-sm font-bold text-teal-800 bg-teal-200 px-2 py-1 rounded-lg">5</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Section -->
            <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-teal-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">
                            <?php echo e(substr(Auth::user()->fname, 0, 1)); ?><?php echo e(substr(Auth::user()->lname, 0, 1)); ?>

                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">Dr. <?php echo e(Auth::user()->fname); ?></p>
                        <p class="text-xs text-teal-600">Pathologist</p>
                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Modern Header -->
            <header class="header-glass shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-2xl font-bold text-gray-800"><?php echo $__env->yieldContent('page-title', 'Laboratory Overview'); ?></h1>
                        <div class="relative">
                            <input type="text" placeholder="Search lab results, patients..." 
                                   class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 w-80 bg-white/80 backdrop-blur-sm search-focus transition-all duration-200">
                            <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Quick Actions -->
                        <button class="p-2.5 text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-xl transition-colors duration-200" title="Lab Reports">
                            <i class="fas fa-chart-line text-lg"></i>
                        </button>
                        
                        <button class="p-2.5 text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-xl transition-colors duration-200" title="Lab Settings">
                            <i class="fas fa-cog text-lg"></i>
                        </button>
                        
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-2.5 text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-xl transition-colors duration-200">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center notification-pulse">3</span>
                            </button>
                        </div>
                        
                        <!-- User Profile -->
                        <div class="flex items-center space-x-3 pl-4 border-l border-gray-200">
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">Dr. <?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?></p>
                                <p class="text-sm text-teal-600">Medical Pathologist</p>
                            </div>
                            <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-white font-semibold text-sm">
                                    <?php echo e(substr(Auth::user()->fname, 0, 1)); ?><?php echo e(substr(Auth::user()->lname, 0, 1)); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <?php echo $__env->yieldContent('scripts'); ?>
    <script>
        // Enhanced pathologist layout functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality with enhanced UX
            const searchInput = document.querySelector('input[placeholder*="Search"]');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const searchTerm = this.value.trim();
                        if (searchTerm) {
                            console.log('Laboratory search for:', searchTerm);
                            // Implement laboratory-specific search functionality
                        }
                    }
                });

                // Add search focus effects
                searchInput.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-teal-500');
                });

                searchInput.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-teal-500');
                });
            }

            // Enhanced navigation interactions (removed problematic transforms)
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.style.backgroundColor = 'rgba(13, 148, 136, 0.1)';
                    }
                });

                item.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.backgroundColor = '';
                    }
                });
            });

            // Quick action button interactions (removed scale transforms)
            document.querySelectorAll('button[title]').forEach(button => {
                button.addEventListener('click', function() {
                    // Add visual feedback without transforms
                    this.style.opacity = '0.8';
                    setTimeout(() => {
                        this.style.opacity = '1';
                    }, 150);
                });
            });

            // Auto-hide success/error messages with enhanced animation
            setTimeout(function() {
                const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 500);
                });
            }, 5000);

            // Notification pulse animation (removed scale transforms)
            const notifications = document.querySelectorAll('.notification-pulse');
            notifications.forEach(notification => {
                setInterval(() => {
                    notification.style.opacity = '0.7';
                    setTimeout(() => {
                        notification.style.opacity = '1';
                    }, 200);
                }, 3000);
            });

            console.log('Pathologist layout initialized with enhanced interactions');
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/layouts/pathologist.blade.php ENDPATH**/ ?>