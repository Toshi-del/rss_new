<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Employee Account - RSS Citi Health Services</title>
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
        
        /* Account link container styling */
        .account-link-container {
            background: linear-gradient(135deg, #f0f7ff 0%, #e0f2fe 100%);
            border-radius: 12px;
            padding: 25px;
            border: 1px dashed #7dd3fc;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            text-align: center;
            margin-top: 30px;
            position: relative;
            overflow: hidden;
        }
        
        .account-link-container::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            background-color: rgba(56, 189, 248, 0.1);
            border-radius: 50%;
            z-index: 0;
        }
        
        .account-link {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            word-break: break-all;
            color: #0284c7;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;
        }
        
        /* Form input styling */
        .form-input-container {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .form-input-container:focus-within {
            transform: translateY(-2px);
        }
        
        /* Table styling */
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .modern-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 12px 15px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .modern-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: middle;
        }
        
        .modern-table tr:hover td {
            background-color: #f8fafc;
        }
        
        .modern-table tr:last-child td {
            border-bottom: none;
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
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Employee Account Creation</h1>
            <p class="text-gray-600">Generate account creation links for your employees</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-card overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white p-6">
                <h5 class="text-xl font-bold flex items-center">
                    <i class="bi bi-person-plus-fill mr-3"></i>Create Employee Account
                </h5>
                <p class="text-primary-100 mt-1">Generate a secure registration link for new employees</p>
            </div>
            <div class="p-6">
                <form id="employeeForm" class="space-y-6">
                    @csrf
                    <div class="mb-4">
                        <label for="linkExpiry" class="block font-medium text-gray-700 mb-2">Link Expiry</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-clock text-gray-400"></i>
                            </div>
                            <select class="block w-full pl-10 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 rounded-lg shadow-sm" id="linkExpiry" name="link_expiry" required>
                                <option value="24">24 Hours</option>
                                <option value="48">48 Hours</option>
                                <option value="72">72 Hours</option>
                                <option value="168">1 Week</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="bi bi-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <button type="submit" id="generateBtn" class="btn btn-primary">
                            <i class="bi bi-link-45deg"></i>Generate Account Link
                        </button>
                    </div>
                </form>
                
                <!-- Account Creation Link Display -->
                <div id="linkDisplay" class="account-link-container hidden">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-xl">
                            <i class="bi bi-link-45deg"></i>
                        </div>
                    </div>
                    <h6 class="text-lg font-semibold text-gray-800 mb-2">Account Creation Link</h6>
                    <p class="text-gray-600 text-sm mb-4">Share this link with your employee to create their account. The link will expire after the selected time period.</p>
                    <div class="account-link mb-4 p-4 bg-gray-50 rounded-lg break-all">
                        <span class="text-primary-600" id="registrationLink"></span>
                    </div>
                    <button class="btn btn-outline-primary" id="copyLink">
                        <i class="bi bi-clipboard"></i>Copy Link
                    </button>
                </div>

                <!-- Success/Error Messages -->
                <div id="successMessage" class="mt-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg hidden">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="bi bi-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700" id="successText"></p>
                        </div>
                    </div>
                </div>

                <div id="errorMessage" class="mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg hidden">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="bi bi-exclamation-triangle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700" id="errorText"></p>
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
            
            // Form submission
            $('#employeeForm').on('submit', function(e) {
                e.preventDefault();
                
                // Show loading state
                const generateBtn = $('#generateBtn');
                generateBtn.prop('disabled', true);
                generateBtn.html('<i class="bi bi-arrow-clockwise spin"></i>Generating...');
                
                // Hide any existing messages
                $('#successMessage, #errorMessage').addClass('hidden');
                
                fetch('{{ route("company.employees.generate-link") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        expiry_hours: $('#linkExpiry').val()
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.error || `HTTP error! status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    if (data.link) {
                        $('#registrationLink').text(data.link);
                        $('#linkDisplay').removeClass('hidden');
                        
                        // Show success message
                        $('#successText').text('Registration link generated successfully!');
                        $('#successMessage').removeClass('hidden');
                        
                        // Scroll to link display
                        $('#linkDisplay')[0].scrollIntoView({ behavior: 'smooth' });
                    } else {
                        throw new Error('No link received from server');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    $('#errorText').text('Failed to generate registration link. Please try again. Error: ' + error.message);
                    $('#errorMessage').removeClass('hidden');
                })
                .finally(() => {
                    // Reset button state
                    generateBtn.prop('disabled', false);
                    generateBtn.html('<i class="bi bi-link-45deg"></i>Generate Account Link');
                });
            });
            
            // Copy link functionality
            $('#copyLink').click(function() {
                const linkText = $('#registrationLink').text();
                navigator.clipboard.writeText(linkText).then(function() {
                    const btn = $(this);
                    const originalHtml = btn.html();
                    btn.html('<i class="bi bi-check-lg"></i>Copied!');
                    setTimeout(() => {
                        btn.html(originalHtml);
                    }, 2000);
                }.bind(this)).catch(function() {
                    alert('Failed to copy link. Please try again.');
                });
            });
            
            // Auto-hide messages after 5 seconds
            setTimeout(() => {
                $('#successMessage, #errorMessage').addClass('hidden');
            }, 5000);
        });
    </script>
</body>
</html> 