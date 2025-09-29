<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Doctor Dashboard'); ?> - RCC Health Services</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php echo $__env->yieldContent('styles'); ?>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .nav-item-active {
            background: #1f2937;
            color: white;
            border-radius: 12px;
        }
        
        .nav-item {
            transition: all 0.2s ease;
            border-radius: 12px;
            margin: 2px 0;
        }
        
        .nav-item:hover {
            background: #f3f4f6;
        }
        
        .nav-item-active:hover {
            background: #1f2937;
        }
        
        .notification-badge {
            background: #10b981;
        }
        
        .sidebar-border {
            border-right: 1px solid #e5e7eb;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Clean Minimal Sidebar -->
        <div class="w-80 bg-white sidebar-border flex flex-col">
            <!-- Header Section -->
            <div class="p-8 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center">
                        <i class="fas fa-hospital text-white text-lg"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">RCC</h1>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 px-6 py-8">
                <div class="space-y-1">
                    <a href="<?php echo e(route('doctor.dashboard')); ?>" class="nav-item flex items-center px-4 py-3 text-gray-700 <?php echo e(request()->routeIs('doctor.dashboard') ? 'nav-item-active text-white' : ''); ?>">
                        <i class="fas fa-th-large mr-3 text-lg"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="<?php echo e(route('doctor.annual-physical')); ?>" class="nav-item flex items-center px-4 py-3 text-gray-700 <?php echo e(request()->routeIs('doctor.annual-physical*') ? 'nav-item-active text-white' : ''); ?>">
                        <i class="fas fa-file-medical mr-3 text-lg"></i>
                        <span class="font-medium">Annual Physical</span>
                    </a>
                    
                    <a href="<?php echo e(route('doctor.pre-employment')); ?>" class="nav-item flex items-center px-4 py-3 text-gray-700 <?php echo e(request()->routeIs('doctor.pre-employment*') ? 'nav-item-active text-white' : ''); ?>">
                        <i class="fas fa-briefcase mr-3 text-lg"></i>
                        <span class="font-medium">Pre-Employment</span>
                    </a>
                    
                    <a href="<?php echo e(route('doctor.messages')); ?>" class="nav-item flex items-center px-4 py-3 text-gray-700 <?php echo e(request()->routeIs('doctor.messages*') ? 'nav-item-active text-white' : ''); ?>">
                        <i class="fas fa-comments mr-3 text-lg"></i>
                        <span class="font-medium">Messages</span>
                        <span class="ml-auto notification-badge text-white text-xs px-2 py-1 rounded-full font-medium">2</span>
                    </a>
                </div>
            </nav>
            
            <!-- Profile Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">
                            <?php echo e(strtoupper(substr(Auth::user()->fname, 0, 1) . substr(Auth::user()->lname, 0, 1))); ?>

                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-900 font-semibold text-sm truncate">Dr. <?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?></p>
                        <p class="text-gray-500 text-xs truncate"><?php echo e(Auth::user()->email); ?></p>
                    </div>
                    <button id="profileButton" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-cog text-gray-500 text-sm"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Simple Header -->
            <header class="bg-white border-b border-gray-100">
                <div class="px-8 py-6">
                    <h1 class="text-2xl font-semibold text-gray-900"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                    <p class="text-gray-600 text-sm mt-1"><?php echo $__env->yieldContent('page-description', 'Welcome to your medical dashboard'); ?></p>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-8">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Clean Profile Modal -->
    <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-0 w-96 shadow-xl rounded-xl bg-white overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-100 bg-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Profile</h3>
                    <button id="closeModal" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-times text-gray-500"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Profile Info -->
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white font-semibold text-lg">
                            <?php echo e(strtoupper(substr(Auth::user()->fname, 0, 1) . substr(Auth::user()->lname, 0, 1))); ?>

                        </span>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900">Dr. <?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?></h4>
                        <p class="text-gray-600 text-sm"><?php echo e(Auth::user()->email); ?></p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-2">
                            <i class="fas fa-user-md mr-1"></i>
                            Medical Doctor
                        </span>
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="space-y-2">
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-user-edit text-gray-500 mr-3"></i>
                        <span class="font-medium">Edit Profile</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-cog text-gray-500 mr-3"></i>
                        <span class="font-medium">Settings</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-question-circle text-gray-500 mr-3"></i>
                        <span class="font-medium">Help & Support</span>
                    </a>
                    
                    <div class="border-t border-gray-100 pt-2 mt-4">
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="block">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                <i class="fas fa-sign-out-alt text-red-500 mr-3"></i>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->yieldContent('scripts'); ?>
    
    <script>
        // Profile Modal Functionality
        const profileButton = document.getElementById('profileButton');
        const profileModal = document.getElementById('profileModal');
        const closeModal = document.getElementById('closeModal');

        // Open modal
        profileButton.addEventListener('click', function() {
            profileModal.classList.remove('hidden');
        });

        // Close modal
        closeModal.addEventListener('click', function() {
            profileModal.classList.add('hidden');
        });

        // Close modal when clicking outside
        profileModal.addEventListener('click', function(e) {
            if (e.target === profileModal) {
                profileModal.classList.add('hidden');
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !profileModal.classList.contains('hidden')) {
                profileModal.classList.add('hidden');
            }
        });
    </script>
</body>
</html> <?php /**PATH C:\xampp\htdocs\rss_new-1\resources\views/layouts/doctor.blade.php ENDPATH**/ ?>