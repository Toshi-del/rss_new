@extends('layouts.company')

@section('title', 'Annual Appointment Management')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Annual Appointment Management</h1>
            <p class="text-sm text-gray-600">Schedule appointments and manage applicant data.</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <!-- Calendar Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button id="prevMonth" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors">
                            &lt;
                        </button>
                        <button id="nextMonth" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors">
                            &gt;
                        </button>
                        <button id="todayBtn" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition-colors">
                            today
                        </button>
                    </div>
                    
                    <h2 class="text-lg font-semibold text-gray-900" id="currentMonth">
                        {{ now()->format('F Y') }}
                    </h2>
                    
                    <div class="flex items-center space-x-2">
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm">month</button>
                        <button class="border border-blue-600 text-blue-600 px-3 py-1 rounded text-sm hover:bg-blue-50">week</button>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="p-6">
                <!-- Days of Week Header -->
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-center text-sm font-medium text-gray-500 py-2">Sun</div>
                    <div class="text-center text-sm font-medium text-gray-500 py-2">Mon</div>
                    <div class="text-center text-sm font-medium text-gray-500 py-2">Tue</div>
                    <div class="text-center text-sm font-medium text-gray-500 py-2">Wed</div>
                    <div class="text-center text-sm font-medium text-gray-500 py-2">Thu</div>
                    <div class="text-center text-sm font-medium text-gray-500 py-2">Fri</div>
                    <div class="text-center text-sm font-medium text-gray-500 py-2">Sat</div>
                </div>

                <!-- Calendar Days -->
                <div class="grid grid-cols-7 gap-1" id="calendarGrid">
                    <!-- Calendar days will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Appointments List -->
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Upcoming Appointments</h3>
                    <a href="{{ route('company.appointments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        New Appointment
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patients</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $appointment->formatted_date }}</div>
                                <div class="text-sm text-gray-500">{{ $appointment->formatted_time_slot }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ optional($appointment->medicalTestCategory)->name }}
                                    @if($appointment->medicalTest)
                                        - {{ $appointment->medicalTest->name }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $appointment->patients ? $appointment->patients->count() : 0 }} patients</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Scheduled
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('company.appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                <a href="{{ route('company.appointments.edit', $appointment) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('company.appointments.destroy', $appointment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No appointments scheduled. <a href="{{ route('company.appointments.create') }}" class="text-blue-600 hover:text-blue-900">Create your first appointment</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarGrid = document.getElementById('calendarGrid');
    const currentMonthElement = document.getElementById('currentMonth');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const todayBtn = document.getElementById('todayBtn');
    
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    function generateCalendar(month, year) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());
        
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                           'July', 'August', 'September', 'October', 'November', 'December'];
        
        currentMonthElement.textContent = `${monthNames[month]} ${year}`;
        
        calendarGrid.innerHTML = '';
        
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);
            
            const dayElement = document.createElement('div');
            dayElement.className = 'border border-gray-200 min-h-[80px] p-2 relative cursor-pointer hover:bg-gray-50 transition-colors';
            
            const dayNumber = date.getDate();
            const isCurrentMonth = date.getMonth() === month;
            const isToday = date.toDateString() === new Date().toDateString();
            const isPast = date < new Date().setHours(0, 0, 0, 0);
            
            dayElement.innerHTML = `
                <div class="text-sm ${isCurrentMonth ? 'text-gray-900' : 'text-gray-400'} ${isToday ? 'bg-blue-100 rounded' : ''}">
                    ${dayNumber}
                </div>
            `;
            
            if (isToday) {
                dayElement.classList.add('bg-blue-50');
            }
            
            if (isPast) {
                dayElement.classList.add('opacity-50');
                dayElement.style.cursor = 'not-allowed';
            } else {
                // Add click event for future dates
                dayElement.addEventListener('click', function() {
                    // Format date in local timezone to avoid timezone offset issues
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const selectedDate = `${year}-${month}-${day}`;
                    window.location.href = `{{ route('company.appointments.create') }}?date=${selectedDate}`;
                });
            }
            
            calendarGrid.appendChild(dayElement);
        }
    }
    
    // Navigation event listeners
    prevMonthBtn.addEventListener('click', function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentMonth, currentYear);
    });
    
    nextMonthBtn.addEventListener('click', function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentMonth, currentYear);
    });
    
    todayBtn.addEventListener('click', function() {
        currentDate = new Date();
        currentMonth = currentDate.getMonth();
        currentYear = currentDate.getFullYear();
        generateCalendar(currentMonth, currentYear);
    });
    
    generateCalendar(currentMonth, currentYear);
});
</script>
@endpush
@endsection