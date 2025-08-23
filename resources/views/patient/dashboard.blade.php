<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - RSS Citi Health Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    },
                    animation: {
                        'fadeIn': 'fadeIn 0.5s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 },
                        }
                    },
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }
        
        .timeline-dot {
            position: absolute;
            left: -9px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #4f46e5;
            border: 3px solid white;
        }
        
        .nav-hover-effect {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #4f46e5;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-white to-gray-50 shadow-sm py-4">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <a href="#" class="text-xl font-semibold text-primary-600 tracking-wide">
                    <i class="bi bi-activity me-2"></i>RSS Citi Health Services
                </a>
                <button id="mobileMenuButton" class="md:hidden text-gray-500 hover:text-primary-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <div id="navbarMenu" class="hidden md:flex items-center space-x-1">
                    <a href="#" class="nav-link px-3 py-2 rounded-md text-gray-700 font-medium hover:text-primary-600 relative">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        <span class="nav-hover-effect"></span>
                    </a>
                    <a href="{{ route('patient.profile') }}" class="nav-link px-3 py-2 rounded-md text-gray-700 font-medium hover:text-primary-600 relative">
                        <i class="bi bi-person-circle me-1"></i> Profile
                        <span class="nav-hover-effect"></span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="nav-link px-3 py-2 rounded-md text-gray-700 font-medium hover:text-primary-600 relative">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                            <span class="nav-hover-effect"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-6">
        @if(session('success'))
            <div id="successAlert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md relative animate-[fadeIn_0.5s_ease-in-out]" role="alert">
                <div class="flex items-center">
                    <i class="bi bi-check-circle-fill mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="absolute top-0 right-0 mt-4 mr-4" onclick="document.getElementById('successAlert').remove()">
                    <svg class="h-4 w-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
        
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row items-start md:items-center mb-6">
                <div class="w-20 h-20 bg-primary-50 rounded-full flex items-center justify-center text-primary-600 text-3xl mr-6 mb-4 md:mb-0">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-primary-800 mb-1">Welcome, {{ Auth::user()->lname }}, {{ Auth::user()->fname }} {{ Auth::user()->mname }}</h4>
                    <p class="text-gray-600">
                        <span class="bg-primary-600 text-white text-xs px-2 py-1 rounded-md">{{ ucfirst(Auth::user()->role) }}</span>
                    </p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="text-sm text-gray-500 mb-1 block"><i class="bi bi-envelope me-2"></i>Email</label>
                    <p class="font-medium text-gray-800">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-1 block"><i class="bi bi-telephone me-2"></i>Phone</label>
                    <p class="font-medium text-gray-800">{{ Auth::user()->phone }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-1 block"><i class="bi bi-building me-2"></i>Company</label>
                    <p class="font-medium text-gray-800">{{ Auth::user()->company ?? 'Not specified' }}</p>
                </div>
            </div>
        </div>
        
        <div class="mb-12">
            <div class="flex flex-wrap border-b-0">
                <button class="px-6 py-3 font-medium text-gray-700 bg-gray-100 rounded-t-lg focus:outline-none active-tab" id="tests-tab" onclick="openTab('tests')">
                    <i class="bi bi-clipboard2-pulse me-2"></i>Tests
                </button>
                <button class="px-6 py-3 font-medium text-gray-500 bg-gray-100 rounded-t-lg focus:outline-none ml-1" id="results-tab" onclick="openTab('results')">
                    <i class="bi bi-file-earmark-check me-2"></i>Results
                </button>
            </div>
            
            <div class="bg-white rounded-b-xl shadow-sm p-6">
                <!-- Tests Tab -->
                <div id="tests" class="tab-content">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <h5 class="text-lg font-semibold text-gray-800 mb-4 md:mb-0">Appointments & Pre-Employment Records</h5>
                        <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md text-sm transition duration-300 transform hover:-translate-y-1">
                            <i class="bi bi-plus-circle me-2"></i>Request New Test
                        </button>
                    </div>
                    
                    <!-- Appointments List -->
                    <div class="mb-8">
                        <h6 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="bi bi-calendar-check me-2"></i>Appointments
                        </h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Time</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Type</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Created</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse(Auth::user()->patientAppointments()->orderBy('created_at', 'desc')->get() as $appointment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 text-sm">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                        <td class="py-3 px-4 text-sm">{{ $appointment->time_slot }}</td>
                                        <td class="py-3 px-4 text-sm">{{ $appointment->appointment_type ?? 'General Checkup' }}</td>
                                        <td class="py-3 px-4">
                                            @if($appointment->status == 'approved')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                                            @elseif($appointment->status == 'pending')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Declined</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">{{ $appointment->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-gray-500">No appointments found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pre-Employment Records List -->
                    <div class="mb-8">
                        <h6 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="bi bi-file-earmark-medical me-2"></i>Pre-Employment Records
                        </h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Age/Sex</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Exam Type</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Company</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Created</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse(Auth::user()->preEmploymentRecords()->orderBy('created_at', 'desc')->get() as $record)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 text-sm font-medium">{{ $record->full_name }}</td>
                                        <td class="py-3 px-4 text-sm">{{ $record->age }} / {{ $record->sex }}</td>
                                        <td class="py-3 px-4 text-sm">{{ $record->medical_exam_type }}</td>
                                        <td class="py-3 px-4 text-sm">{{ $record->company_name ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">
                                            @if($record->status == 'completed')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                            @elseif($record->status == 'pending')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($record->status == 'in_progress')
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ ucfirst($record->status ?? 'Unknown') }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">{{ $record->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-gray-500">No pre-employment records found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Results Tab -->
                <div id="results" class="tab-content hidden">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <h5 class="text-lg font-semibold text-gray-800 mb-4 md:mb-0">Examination Results</h5>
                        <div class="relative w-full md:w-64">
                            <input type="text" id="searchResults" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Search results...">
                            <button class="absolute right-0 top-0 h-full px-3 text-gray-500 hover:text-primary-600">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Pre-Employment Examination Results -->
                    <div class="mb-8">
                        <h6 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="bi bi-file-earmark-medical me-2"></i>Pre-Employment Examination Results
                        </h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Physical Findings</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Lab Findings</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">ECG</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse(Auth::user()->preEmploymentExaminations()->orderBy('created_at', 'desc')->get() as $exam)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 text-sm">{{ $exam->date ? $exam->date->format('M d, Y') : 'N/A' }}</td>
                                        <td class="py-3 px-4">
                                            @if($exam->status == 'completed')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                            @elseif($exam->status == 'pending')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($exam->status == 'in_progress')
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ ucfirst($exam->status ?? 'Unknown') }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            @if($exam->physical_findings && count($exam->physical_findings) > 0)
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Available</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Not Available</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            @if($exam->lab_findings && count($exam->lab_findings) > 0)
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Available</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Not Available</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            @if($exam->ecg)
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Available</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Not Available</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            <button class="text-primary-600 hover:text-primary-800 font-medium" onclick="viewExamDetails('pre-employment', {{ $exam->id }})">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-gray-500">No pre-employment examination results found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Annual Physical Examination Results -->
                    <div class="mb-8">
                        <h6 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="bi bi-heart-pulse me-2"></i>Annual Physical Examination Results
                        </h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Physical Findings</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Lab Findings</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">ECG</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse(Auth::user()->annualPhysicalExaminations()->orderBy('created_at', 'desc')->get() as $exam)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 text-sm">{{ $exam->date ? $exam->date->format('M d, Y') : 'N/A' }}</td>
                                        <td class="py-3 px-4">
                                            @if($exam->status == 'completed')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                            @elseif($exam->status == 'pending')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($exam->status == 'in_progress')
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ ucfirst($exam->status ?? 'Unknown') }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            @if($exam->physical_findings && count($exam->physical_findings) > 0)
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Available</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Not Available</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            @if($exam->lab_findings && count($exam->lab_findings) > 0)
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Available</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Not Available</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            @if($exam->ecg)
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Available</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Not Available</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            <button class="text-primary-600 hover:text-primary-800 font-medium" onclick="viewExamDetails('annual-physical', {{ $exam->id }})">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-gray-500">No annual physical examination results found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white py-6 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600 text-sm">&copy; 2023 RSS Citi Health Services. All rights reserved.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors duration-300">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors duration-300">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors duration-300">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors duration-300">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for tab functionality -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const menu = document.getElementById('navbarMenu');
            menu.classList.toggle('hidden');
        });
        
        // Tab functionality
        function openTab(tabName) {
            // Hide all tab content
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show the selected tab content
            document.getElementById(tabName).classList.remove('hidden');
            
            // Update active tab styling
            const tabs = document.querySelectorAll('[id$="-tab"]');
            tabs.forEach(tab => {
                tab.classList.remove('text-primary-600', 'bg-white');
                tab.classList.add('text-gray-500', 'bg-gray-100');
            });
            
            document.getElementById(tabName + '-tab').classList.remove('text-gray-500', 'bg-gray-100');
            document.getElementById(tabName + '-tab').classList.add('text-primary-600', 'bg-white');
        }
        
        // Hover effect for nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.querySelector('.nav-hover-effect').style.width = '80%';
            });
            
            link.addEventListener('mouseleave', function() {
                this.querySelector('.nav-hover-effect').style.width = '0';
            });
        });
        
        // Auto-hide success alert after 5 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.add('opacity-0');
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }

        // Search functionality for results
        document.getElementById('searchResults').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#results tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // View exam details function
        function viewExamDetails(type, examId) {
            // You can implement a modal or redirect to a detailed view page
            alert(`Viewing ${type} examination details for ID: ${examId}`);
            // For now, just show an alert. You can implement a modal or redirect later
            // Example: window.open(`/patient/exam-details/${type}/${examId}`, '_blank');
        }
    </script>
</body>
</html> 