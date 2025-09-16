<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - RSS Citi Health Services')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1e40af;
            --secondary-color: #64748b;
            --light-bg: #f8fafc;
            --dark-bg: #1e293b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #0ea5e9;
            --sidebar-width: 220px;
            --transition-speed: 0.3s;
            --border-radius: 0.5rem;
        }
        
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-color);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }
    
        .sidebar-brand {
            padding: 20px;
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    
        .sidebar-brand i {
            margin-right: 10px;
            font-size: 1.4rem;
        }
    
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
        }
    
        .sidebar-item {
            margin-bottom: 5px;
        }
    
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
    
        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
    
        .sidebar-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
    
        /* User profile section */
        .user-profile {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }
        
        .user-info {
            flex: 1;
        }
        
        .user-name {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .user-role {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        .logout-btn {
            margin-left: 10px;
        }
        
        .logout-btn .btn {
            background: none;
            border: none;
            color: white;
            padding: 5px;
        }
        
        .logout-btn .btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
    
        /* Main content styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px 30px;
            transition: all 0.3s;
            width: calc(100% - var(--sidebar-width));
        }
        
        .page-header {
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }
        
        .search-container {
            position: relative;
            width: 300px;
        }
        
        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            background-color: white;
            font-size: 0.9rem;
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        
        /* Card styles */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 24px;
            background-color: white;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-weight: 600;
            color: var(--primary-dark);
            margin: 0;
            font-size: 1.2rem;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Stats card */
        .stats-card {
            padding: 20px;
            border-radius: 12px;
            background-color: white;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
            color: white;
        }
        
        .stats-icon.primary {
            background-color: #0d6efd;
        }
        
        .stats-icon.success {
            background-color: #10b981;
        }
        
        .stats-icon.warning {
            background-color: #f59e0b;
        }
        
        .stats-icon.info {
            background-color: #0ea5e9;
        }
        
        .stats-info {
            flex: 1;
        }
        
        .stats-label {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 5px;
        }
        
        .stats-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            display: flex;
            align-items: center;
        }
        
        .stats-trend {
            font-size: 0.8rem;
            margin-left: 8px;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .stats-trend.up {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        
        .stats-trend.down {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        
        /* Table styles */
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            font-weight: 600;
            color: #64748b;
            border-bottom: 2px solid #f1f5f9;
            padding: 12px 15px;
        }
        
        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Mobile sidebar toggle */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }
        
        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .search-container {
                width: 200px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Mobile sidebar toggle -->
    <button class="mobile-toggle d-md-none">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-activity"></i>
            <span>RSS Citi Health</span>
        </div>
        
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.patients') }}" class="sidebar-link {{ request()->routeIs('admin.patients*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Patients</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.appointments') }}" class="sidebar-link {{ request()->routeIs('admin.appointments*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.pre-employment') }}" class="sidebar-link {{ request()->routeIs('admin.pre-employment*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-medical"></i>
                    <span>Pre-Employment</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.tests') }}" class="sidebar-link {{ request()->routeIs('admin.tests*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-pulse"></i>
                    <span>Tests</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('medical-test-categories.index') }}" class="sidebar-link {{ request()->routeIs('medical-test-categories*') ? 'active' : '' }}">
                    <i class="bi bi-list-ul"></i>
                    <span>Medical Test Categories</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.messages') }}" class="sidebar-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots"></i>
                    <span>Messages</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.report') }}" class="sidebar-link {{ request()->routeIs('admin.report*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.accounts-and-patients') }}" class="sidebar-link {{ request()->routeIs('admin.accounts-and-patients') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Company Accounts & Patients</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.opd', ['filter' => request('filter','pending')]) }}" class="sidebar-link {{ request()->routeIs('admin.opd*') ? 'active' : '' }}">
                    <i class="bi bi-hospital"></i>
                    <span>OPD Entries</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.medical-staff') }}" class="sidebar-link {{ request()->routeIs('admin.medical-staff*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Medical Staff</span>
                </a>
            </li>
            
        </ul>
        
        <!-- User profile section -->
        <div class="user-profile">
            <div class="user-avatar">
                {{ substr(Auth::user()->fname ?? 'A', 0, 1) }}
            </div>
            <div class="user-info">
                <p class="user-name">{{ Auth::user()->fname ?? 'Admin' }} {{ Auth::user()->lname ?? 'User' }}</p>
                <div class="user-role">Administrator</div>
            </div>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-white p-0">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            <div class="search-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search...">
            </div>
        </div>
        
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.mobile-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickInsideToggle = toggleBtn.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickInsideToggle && window.innerWidth < 768) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html> 