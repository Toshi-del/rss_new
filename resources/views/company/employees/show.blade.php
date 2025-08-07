<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Details - RSS Citi Health Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f7ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    boxShadow: {
                        'card': '0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03)',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --sidebar-width: 280px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e4ecfb 100%);
            background-attachment: fixed;
            display: flex;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            margin-left: var(--sidebar-width);
            width: calc(100% - (var(--sidebar-width) + 30px));
            transition: margin-left 0.3s ease;
        }
        
        /* Sidebar styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #0c4a6e 0%, #0369a1 100%);
            color: white;
            z-index: 1000;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.25rem;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-brand i {
            font-size: 1.5rem;
        }
        
        .sidebar-menu {
            padding: 20px 0;
            list-style: none;
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
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            gap: 12px;
        }
        
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: #38bdf8;
        }
        
        .sidebar-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        /* User profile section */
        .user-profile {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            background-color: #38bdf8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .user-info {
            flex: 1;
        }
        
        .user-name {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .user-role {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }
        
        .logout-btn button {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.2s ease;
            padding: 5px;
        }
        
        .logout-btn button:hover {
            color: white;
        }
        
        /* Responsive adjustments for mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            body.sidebar-open .sidebar {
                transform: translateX(0);
            }
            
            .container {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            
            .mobile-toggle {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1001;
                background-color: #0284c7;
                color: white;
                border: none;
                border-radius: 8px;
                width: 45px;
                height: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                font-size: 1.2rem;
            }
        }
        
        /* Hide mobile toggle on desktop */
        .mobile-toggle {
            display: none;
        }
        
        /* Badge styling */
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        
        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        
        .badge-primary {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        
        /* Button styling */
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(to right, #0284c7, #0369a1);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(to right, #0369a1, #075985);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
        }
        
        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid #0284c7;
            color: #0284c7;
        }
        
        .btn-outline-primary:hover {
            background-color: #f0f7ff;
        }
        
        .btn-outline-danger {
            background-color: transparent;
            border: 1px solid #ef4444;
            color: #ef4444;
        }
        
        .btn-outline-danger:hover {
            background-color: #fee2e2;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <!-- Mobile sidebar toggle -->
    <button class="mobile-toggle d-md-none">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-building"></i>
            <span>Company Portal</span>
        </div>
        
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="{{ route('company.dashboard') }}" class="sidebar-link">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('company.appointments.index') }}" class="sidebar-link">
                    <i class="bi bi-person-plus"></i>
                    <span>Appointment</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('company.pre-employment.index') }}" class="sidebar-link">
                    <i class="bi bi-clipboard2-pulse"></i>
                    <span>Pre-Employment</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-file-earmark-medical"></i>
                    <span>Medical Reports</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('company.employees.index') }}" class="sidebar-link active">
                    <i class="bi bi-person-badge"></i>
                    <span>Employee Accounts</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
        
        <!-- User profile section -->
        <div class="user-profile">
            <div class="user-avatar">
                {{ substr(Auth::user()->fname, 0, 1) }}
            </div>
            <div class="user-info">
                <p class="user-name">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</p>
                <div class="user-role">Company Admin</div>
                <div>
                    <label class="text-sm text-gray-300 mb-1 block"><i class="bi bi-building me-2"></i>Company</label>
                    <p class="font-medium text-gray-100">{{ Auth::user()->company ?? 'Not specified' }}</p>
                </div>
            </div>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Employee Details</h1>
                    <p class="text-gray-600">View detailed information about this employee</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('company.employees.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i>Back to List
                    </a>
                    <form method="POST" action="{{ route('company.employees.destroy', $employee->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this employee?')">
                            <i class="bi bi-trash"></i>Delete Employee
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-card overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white p-6">
                <h5 class="text-xl font-bold flex items-center">
                    <i class="bi bi-person-fill mr-3"></i>Employee Information
                </h5>
                <p class="text-primary-100 mt-1">Complete details for {{ $employee->fname }} {{ $employee->lname }}</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h6 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h6>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Full Name</label>
                                <p class="text-gray-900 font-medium">{{ $employee->fname }} {{ $employee->mname }} {{ $employee->lname }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email Address</label>
                                <p class="text-gray-900">{{ $employee->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                                <p class="text-gray-900">{{ $employee->phone }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Date of Birth</label>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($employee->birthday)->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Age</label>
                                <p class="text-gray-900">{{ $employee->age }} years old</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h6 class="text-lg font-semibold text-gray-800 mb-4">Account Information</h6>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Employee Status</label>
                                <span class="badge {{ $employee->company === 'yes' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $employee->company === 'yes' ? 'Company Employee' : 'Not Company Employee' }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Account Role</label>
                                <span class="badge badge-primary">{{ ucfirst($employee->role) }}</span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Account Created</label>
                                <p class="text-gray-900">{{ $employee->created_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Last Updated</label>
                                <p class="text-gray-900">{{ $employee->updated_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Created By</label>
                                <p class="text-gray-900">{{ $employee->creator->fname }} {{ $employee->creator->lname }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mobile sidebar toggle functionality
            $('.mobile-toggle').click(function() {
                $('body').toggleClass('sidebar-open');
            });
        });
    </script>
</body>
</html> 