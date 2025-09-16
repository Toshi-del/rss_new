@extends('layouts.nurse')

@section('title', 'Annual Physical Examination')
@section('page-title', 'Annual Physical Examination')
@section('page-description', 'Manage annual physical examinations and medical assessments')

@section('content')
<div class="space-y-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-emerald-600"></i>
            </div>
            <div>
                <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-emerald-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Annual Physical Examination</h3>
                        <p class="text-emerald-100 text-sm">Manage annual physical examinations and patient assessments</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Request Equipment Button -->
                    <button type="button" 
                            class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg text-sm font-medium transition-all duration-150 border border-white/20 backdrop-blur-sm"
                            onclick="openRequestEquipmentModal()">
                        <i class="fas fa-box mr-2"></i>
                        Request Equipment
                    </button>
                    <!-- Filter Dropdown -->
                    <div class="relative">
                        <select class="glass-morphism px-4 py-2 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 border border-white/20">
                            <option value="all" class="text-gray-900">All Status</option>
                            <option value="completed" class="text-gray-900">Completed</option>
                            <option value="pending" class="text-gray-900">Pending</option>
                        </select>
                    </div>
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-white/60 text-sm"></i>
                        </div>
                        <input type="text" id="searchInput" onkeyup="searchPatients()"
                               class="glass-morphism pl-12 pr-4 py-2 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 w-72 text-sm border border-white/20" 
                               placeholder="Search by name, email, or phone...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Annual Physical Patients Table -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full" id="annualPhysicalTable">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">ID</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Patient Name</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Age/Sex</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Contact Info</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Appointment</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="text-left py-5 px-6 text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-emerald-50 transition-all duration-200 border-l-4 border-transparent hover:border-emerald-400 patient-card">
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-bold text-gray-700">
                                        {{ $patient->id }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center shadow-md">
                                        <span class="text-white font-bold text-sm">
                                            {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                        </div>
                                        <div class="text-xs text-gray-500">Patient ID: #{{ $patient->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="space-y-1">
                                    <div class="bg-blue-50 px-2 py-1 rounded text-xs font-medium text-blue-700">
                                        {{ $patient->age }} years
                                    </div>
                                    <div class="bg-purple-50 px-2 py-1 rounded text-xs font-medium text-purple-700">
                                        {{ ucfirst($patient->sex) }}
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="space-y-1">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-envelope text-gray-400 text-xs"></i>
                                        <span class="text-sm text-gray-700">{{ $patient->email }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-phone text-gray-400 text-xs"></i>
                                        <span class="text-sm text-gray-700">{{ $patient->phone }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                <div class="bg-blue-50 px-3 py-2 rounded-lg border border-blue-200">
                                    <div class="text-sm font-medium text-blue-800">
                                        Appointment #{{ $patient->appointment_id }}
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 border-r border-gray-100">
                                @php
                                    $annualPhysicalExam = \App\Models\AnnualPhysicalExamination::where('patient_id', $patient->id)->first();
                                    $medicalChecklist = \App\Models\MedicalChecklist::where('patient_id', $patient->id)->where('examination_type', 'annual-physical')->first();
                                    $isCompleted = $annualPhysicalExam && $medicalChecklist;
                                @endphp
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border
                                    @if($isCompleted) bg-green-100 text-green-800 border-green-200
                                    @else bg-yellow-100 text-yellow-800 border-yellow-200 @endif">
                                    <i class="fas fa-circle text-xs mr-1.5"></i>
                                    {{ $isCompleted ? 'Completed' : 'Pending' }}
                                </span>
                            </td>
                            <td class="py-5 px-6">
                                @php
                                    $canSendToDoctor = $annualPhysicalExam && $medicalChecklist;
                                @endphp
                                <div class="flex items-center space-x-2">
                                    @if($canSendToDoctor)
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-medium transition-all duration-150 border border-blue-200"
                                            onclick="openSendToDoctorModal({{ $patient->id }}, '{{ $patient->first_name }} {{ $patient->last_name }}')">
                                        <i class="fas fa-paper-plane mr-1"></i>
                                        Send
                                    </button>
                                    @endif

                                    @if($annualPhysicalExam)
                                    <a href="{{ route('nurse.annual-physical.edit', $annualPhysicalExam->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg text-xs font-medium transition-all duration-150 border border-emerald-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    @else
                                    <a href="{{ route('nurse.annual-physical.create', ['patient_id' => $patient->id]) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg text-xs font-medium transition-all duration-150 border border-green-200">
                                        <i class="fas fa-plus mr-1"></i>
                                        Create
                                    </a>
                                    @endif

                                    <a href="{{ route('nurse.medical-checklist.annual-physical', $patient->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg text-xs font-medium transition-all duration-150 border border-purple-200">
                                        <i class="fas fa-clipboard-list mr-1"></i>
                                        Checklist
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-heartbeat text-gray-400 text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Annual Physical Patients</h3>
                                        <p class="text-sm text-gray-500">No annual physical examination patients found in the system.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Send to Doctor Modal -->
<div id="sendToDoctorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
        <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-paper-plane text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Send to Doctor</h3>
                </div>
                <button onclick="closeModal('sendToDoctorModal')" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4 mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-md text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Confirm Action</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Are you sure you want to send <span id="sendToDoctor-patient-name" class="font-semibold"></span>'s annual physical examination to the doctor for review?
                    </p>
                </div>
            </div>
            <form id="sendToDoctorForm" method="POST">
                @csrf
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal('sendToDoctorModal')" 
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send to Doctor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Request Equipment Modal -->
<div id="requestEquipmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300 max-h-[90vh] overflow-hidden">
        <div class="bg-emerald-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Request Equipment</h3>
                </div>
                <button onclick="closeModal('requestEquipmentModal')" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
            <form id="requestEquipmentForm" action="{{ route('nurse.equipment-request.store') }}" method="POST">
                @csrf
                <input type="hidden" name="requested_by" value="{{ auth()->id() }}">
                <input type="hidden" name="department" value="nurse">
                <input type="hidden" name="purpose" value="annual-physical">
                
                <!-- Request Details -->
                <div class="mb-6">
                    <div class="flex items-start space-x-4 mb-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clipboard-list text-emerald-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Equipment Request Details</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Select the equipment you need for annual physical examinations. All requests will be reviewed by the admin team.
                            </p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level</label>
                            <select name="priority" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Select Priority</option>
                                <option value="low">Low - Can wait</option>
                                <option value="medium">Medium - Needed soon</option>
                                <option value="high">High - Urgent</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Expected Date Needed</label>
                            <input type="date" name="date_needed" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Request Notes</label>
                        <textarea name="notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                  placeholder="Additional notes or special requirements..."></textarea>
                    </div>
                </div>

                <!-- Equipment Selection -->
                <div class="mb-6">
                    <h5 class="text-md font-semibold text-gray-900 mb-4">Select Equipment</h5>
                    <div class="space-y-3 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        <div id="equipmentList">
                            <!-- Equipment items will be loaded here -->
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin text-gray-400 text-xl mb-2"></i>
                                <p class="text-gray-500">Loading equipment...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal('requestEquipmentModal')" 
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-150 border border-gray-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all duration-150 shadow-md">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal functions
function openSendToDoctorModal(patientId, patientName) {
    document.getElementById('sendToDoctor-patient-name').textContent = patientName;
    document.getElementById('sendToDoctorForm').action = `/nurse/annual-physical/send-to-doctor/${patientId}`;
    document.getElementById('sendToDoctorModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openRequestEquipmentModal() {
    document.getElementById('requestEquipmentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    loadEquipment();
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Search function
function searchPatients() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('annualPhysicalTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < cells.length - 1; j++) {
            const cellText = cells[j].textContent || cells[j].innerText;
            if (cellText.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        row.style.display = found ? '' : 'none';
    }
}

// Load equipment from inventory
async function loadEquipment() {
    try {
        const response = await fetch('/nurse/equipment-request/inventory');
        const data = await response.json();
        
        const equipmentList = document.getElementById('equipmentList');
        
        if (data.success && data.inventory.length > 0) {
            equipmentList.innerHTML = '';
            
            // Group equipment by category
            const categories = {};
            data.inventory.forEach(item => {
                if (!categories[item.category]) {
                    categories[item.category] = [];
                }
                categories[item.category].push(item);
            });
            
            // Render equipment by category
            Object.keys(categories).forEach(category => {
                const categoryDiv = document.createElement('div');
                categoryDiv.className = 'mb-4';
                
                const categoryTitle = document.createElement('h6');
                categoryTitle.className = 'text-sm font-semibold text-gray-700 mb-2 capitalize';
                categoryTitle.textContent = category.replace('_', ' ').replace('-', ' ');
                categoryDiv.appendChild(categoryTitle);
                
                const itemsDiv = document.createElement('div');
                itemsDiv.className = 'space-y-2 ml-4';
                
                categories[category].forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50';
                    
                    const stockStatus = item.current_quantity <= 0 ? 'out-of-stock' : 
                                      item.current_quantity <= item.minimum_quantity ? 'low-stock' : 'in-stock';
                    const stockColor = stockStatus === 'out-of-stock' ? 'text-red-600' : 
                                      stockStatus === 'low-stock' ? 'text-yellow-600' : 'text-green-600';
                    
                    itemDiv.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="equipment_items[]" value="${item.id}" 
                                   class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                   onchange="toggleQuantityInput(this, ${item.id})"
                                   ${item.current_quantity <= 0 ? 'disabled' : ''}>
                            <div>
                                <div class="font-medium text-gray-900">${item.name}</div>
                                <div class="text-sm text-gray-500">${item.description || 'No description'}</div>
                                <div class="text-xs ${stockColor}">
                                    Stock: ${item.current_quantity} ${item.unit_name} 
                                    ${stockStatus === 'low-stock' ? '(Low Stock)' : stockStatus === 'out-of-stock' ? '(Out of Stock)' : ''}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="quantity-input-${item.id} hidden">
                                <label class="text-xs text-gray-600 block">Qty:</label>
                                <input type="number" name="quantities[${item.id}]" min="1" max="${item.current_quantity}" 
                                       class="w-16 px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-emerald-500"
                                       placeholder="1">
                            </div>
                            <span class="text-xs text-gray-500">${item.unit_name}</span>
                        </div>
                    `;
                    
                    itemsDiv.appendChild(itemDiv);
                });
                
                categoryDiv.appendChild(itemsDiv);
                equipmentList.appendChild(categoryDiv);
            });
        } else {
            equipmentList.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-box-open text-gray-400 text-3xl mb-2"></i>
                    <p class="text-gray-500">No equipment available in inventory</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading equipment:', error);
        document.getElementById('equipmentList').innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-exclamation-triangle text-red-400 text-3xl mb-2"></i>
                <p class="text-red-500">Error loading equipment. Please try again.</p>
            </div>
        `;
    }
}

// Toggle quantity input visibility
function toggleQuantityInput(checkbox, itemId) {
    const quantityDiv = document.querySelector(`.quantity-input-${itemId}`);
    const quantityInput = quantityDiv.querySelector('input');
    
    if (checkbox.checked) {
        quantityDiv.classList.remove('hidden');
        quantityInput.required = true;
        quantityInput.value = '1'; // Default quantity
    } else {
        quantityDiv.classList.add('hidden');
        quantityInput.required = false;
        quantityInput.value = '';
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['sendToDoctorModal', 'requestEquipmentModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            closeModal(modalId);
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = ['sendToDoctorModal', 'requestEquipmentModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (!modal.classList.contains('hidden')) {
                closeModal(modalId);
            }
        });
    }
});
</script>
@endsection
