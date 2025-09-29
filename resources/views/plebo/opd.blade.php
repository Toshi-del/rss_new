@extends('layouts.plebo')

@section('title', 'OPD Blood Collection')
@section('page-title', 'OPD Walk-in Records')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 flex items-center space-x-3">
    <div class="flex-shrink-0">
        <i class="fas fa-check-circle text-green-600 text-xl"></i>
    </div>
    <div>
        <p class="text-green-800 font-medium">{{ session('success') }}</p>
    </div>
    <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 flex items-center space-x-3">
    <div class="flex-shrink-0">
        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
    </div>
    <div>
        <p class="text-red-800 font-medium">{{ session('error') }}</p>
    </div>
    <button onclick="this.parentElement.remove()" class="ml-auto text-red-600 hover:text-red-800">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Patients -->
    <div class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border-l-4 border-blue-500">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-walking text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $opdPatients->total() }}</h3>
                <p class="text-sm text-gray-600">Total Patients</p>
            </div>
        </div>
        <p class="text-gray-600 text-sm mt-4">OPD walk-in examinations</p>
    </div>

    <!-- Completed Patients -->
    <div class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border-l-4 border-green-500">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div>
                @php
                    $completedCount = $opdPatients->filter(function($patient) {
                        $hasExamination = $patient->opdExamination;
                        $hasMedicalChecklist = \App\Models\MedicalChecklist::where('opd_examination_id', optional($patient->opdExamination)->id)->exists();
                        return $hasExamination && $hasMedicalChecklist;
                    })->count();
                @endphp
                <h3 class="text-2xl font-bold text-gray-900">{{ $completedCount }}</h3>
                <p class="text-sm text-gray-600">Completed</p>
            </div>
        </div>
        <p class="text-gray-600 text-sm mt-4">Blood collection completed</p>
    </div>

    <!-- Pending Patients -->
    <div class="content-card rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border-l-4 border-yellow-500">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div>
                @php
                    $pendingCount = $opdPatients->filter(function($patient) {
                        $hasExamination = $patient->opdExamination;
                        $hasMedicalChecklist = \App\Models\MedicalChecklist::where('opd_examination_id', optional($patient->opdExamination)->id)->exists();
                        return !($hasExamination && $hasMedicalChecklist);
                    })->count();
                @endphp
                <h3 class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</h3>
                <p class="text-sm text-gray-600">Pending</p>
            </div>
        </div>
        <p class="text-gray-600 text-sm mt-4">Awaiting blood collection</p>
    </div>
</div>

<!-- OPD Walk-in Patients Table -->
<div class="content-card rounded-2xl mb-8 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-walking text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">OPD Walk-in Blood Collection</h2>
                    <p class="text-blue-100 text-sm">Manage blood collection for outpatient department visits</p>
                </div>
            </div>
            <div class="bg-white/20 px-3 py-1 rounded-full">
                <span class="text-white font-semibold">{{ $opdPatients->count() }} Patients</span>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50/80">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($opdPatients as $patient)
                    <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">
                                        {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $patient->age }} years • {{ ucfirst($patient->sex) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                <p class="text-gray-900 font-medium">{{ $patient->email }}</p>
                                <p class="text-gray-500">
                                    <i class="fas fa-phone mr-1"></i>{{ $patient->phone }}
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <p class="font-medium">{{ $patient->created_at->format('M d, Y') }}</p>
                                <p class="text-gray-500">{{ $patient->created_at->format('h:i A') }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $hasExamination = $patient->opdExamination;
                                $hasMedicalChecklist = \App\Models\MedicalChecklist::where('opd_examination_id', optional($patient->opdExamination)->id)->exists();
                                
                                if ($hasExamination && $hasMedicalChecklist) {
                                    $statusConfig = ['class' => 'bg-green-100 text-green-800 border-green-200', 'icon' => 'fa-check-circle', 'text' => 'Completed'];
                                } elseif ($hasExamination || $hasMedicalChecklist) {
                                    $statusConfig = ['class' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'icon' => 'fa-clock', 'text' => 'In Progress'];
                                } else {
                                    $statusConfig = ['class' => 'bg-gray-100 text-gray-800 border-gray-200', 'icon' => 'fa-hourglass-start', 'text' => 'Pending'];
                                }
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusConfig['class'] }}">
                                <i class="fas {{ $statusConfig['icon'] }} mr-1"></i>
                                {{ $statusConfig['text'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <!-- Blood Collection Checklist -->
                                <a href="{{ route('plebo.medical-checklist.opd', $patient->id) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200"
                                   title="Blood Collection Checklist">
                                    <i class="fas fa-vial mr-2"></i>
                                    Checklist
                                </a>
                                
                                <!-- Generate Barcode -->
                                <button onclick="generateBarcode({{ $patient->id }})" 
                                        class="inline-flex items-center px-3 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition-colors duration-200"
                                        title="Generate Patient Barcode">
                                    <i class="fas fa-barcode mr-2"></i>
                                    Barcode
                                </button>
                                
                                <!-- Send to Doctor -->
                                @if($hasExamination && $hasMedicalChecklist)
                                    <form action="{{ route('plebo.opd.send-to-doctor', $patient->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg transition-colors duration-200"
                                                title="Send to Doctor for Review"
                                                onclick="return confirm('Send this record to the doctor for review?')">
                                            <i class="fas fa-paper-plane mr-2"></i>
                                            Send
                                        </button>
                                    </form>
                                @else
                                    <button disabled 
                                            class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-400 cursor-not-allowed rounded-lg"
                                            title="Complete blood collection first">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Send
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-walking text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">No OPD patients found</p>
                                <p class="text-gray-400 text-sm">OPD walk-in patients will appear here when available</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($opdPatients->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $opdPatients->links() }}
        </div>
    @endif
</div>

<!-- Enhanced Barcode Modal -->
<div id="barcodeModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm overflow-y-auto h-full w-full z-50" style="display: none;">
    <div class="relative top-20 mx-auto p-0 border-0 w-96 max-w-md shadow-2xl rounded-2xl bg-white overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-barcode text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Patient Barcode</h3>
                        <p class="text-blue-100 text-sm">OPD walk-in record identifier</p>
                    </div>
                </div>
                <button onclick="closeBarcodeModal()" class="text-blue-200 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-xl transition-all duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Content -->
        <div class="p-6">
            <div class="text-center">
                <!-- Barcode Display Area -->
                <div id="barcodeContainer" class="mb-6 p-6 bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl">
                    <div class="flex items-center justify-center py-8">
                        <div class="text-center space-y-3">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                            <p class="text-gray-500 text-sm">Generating barcode...</p>
                        </div>
                    </div>
                </div>
                
                <!-- Patient Information -->
                <div class="mb-6 p-4 bg-blue-50 rounded-xl">
                    <p class="text-sm text-blue-700 font-medium mb-1">Patient Number</p>
                    <p id="patientNumber" class="text-xl font-bold text-blue-900"></p>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-center space-x-3">
                    <button onclick="printBarcode()" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors duration-200 font-medium">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                    <button onclick="downloadBarcode()" 
                            class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors duration-200 font-medium">
                        <i class="fas fa-download mr-2"></i>
                        Download
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JsBarcode Library -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js" 
        onerror="loadBarcodeFallback()"></script>

<script>
// Fallback barcode generation using a simple text-based approach
function loadBarcodeFallback() {
    console.warn('JsBarcode CDN failed to load, using fallback method');
    window.JsBarcode = {
        fallback: true
    };
}

// Simple barcode-like visualization fallback
function createFallbackBarcode(container, text) {
    container.innerHTML = `
        <div class="text-center p-4">
            <div class="inline-block bg-white border-2 border-black p-4">
                <div class="text-xs font-mono tracking-widest mb-2">${text}</div>
                <div class="flex justify-center space-x-1">
                    ${text.split('').map(char => 
                        `<div class="w-1 h-8 bg-black inline-block"></div>`
                    ).join('')}
                </div>
                <div class="text-xs font-mono tracking-widest mt-2">${text}</div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Simple barcode representation</p>
        </div>
    `;
}

function generateBarcode(patientId) {
    const modal = document.getElementById('barcodeModal');
    const barcodeContainer = document.getElementById('barcodeContainer');
    const patientNumberElement = document.getElementById('patientNumber');
    
    // Generate the patient number (same format as in PleboController)
    const patientNumber = 'OPD-' + String(patientId).padStart(4, '0');
    
    // Update the modal content
    patientNumberElement.textContent = patientNumber;
    
    // Show loading state
    barcodeContainer.innerHTML = `
        <div class="flex items-center justify-center py-8">
            <div class="text-center space-y-3">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                <p class="text-gray-500 text-sm">Generating barcode...</p>
            </div>
        </div>
    `;
    
    // Show modal with animation
    modal.style.display = 'block';
    document.body.classList.add('overflow-hidden');
    
    // Add entrance animation
    setTimeout(() => {
        modal.querySelector('.relative').style.transform = 'scale(1)';
        modal.querySelector('.relative').style.opacity = '1';
    }, 10);
    
    // Wait a bit for modal to be visible, then generate barcode
    setTimeout(() => {
        try {
            // Check if JsBarcode is loaded and not in fallback mode
            if (typeof JsBarcode === 'undefined' || JsBarcode.fallback) {
                console.log('Using fallback barcode generation');
                createFallbackBarcode(barcodeContainer, patientNumber);
                return;
            }
            
            // Create canvas element for barcode
            const canvas = document.createElement('canvas');
            canvas.id = 'barcodeCanvas';
            barcodeContainer.innerHTML = '';
            barcodeContainer.appendChild(canvas);
            
            // Generate barcode using JsBarcode
            JsBarcode(canvas, patientNumber, {
                format: "CODE128",
                width: 2,
                height: 100,
                displayValue: true,
                fontSize: 16,
                margin: 10,
                background: "#ffffff",
                lineColor: "#000000",
                textAlign: "center",
                textPosition: "bottom",
                textMargin: 2
            });
            
            console.log('Barcode generated successfully for:', patientNumber);
        } catch (error) {
            console.error('Error generating barcode:', error);
            // Try fallback method
            try {
                createFallbackBarcode(barcodeContainer, patientNumber);
            } catch (fallbackError) {
                console.error('Fallback also failed:', fallbackError);
                barcodeContainer.innerHTML = `
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                        </div>
                        <p class="text-red-600 font-medium mb-2">Error generating barcode</p>
                        <p class="text-gray-500 text-sm">Please try again or contact support</p>
                    </div>
                `;
            }
        }
    }, 300);
}

function closeBarcodeModal() {
    const modal = document.getElementById('barcodeModal');
    
    // Add exit animation
    modal.querySelector('.relative').style.transform = 'scale(0.95)';
    modal.querySelector('.relative').style.opacity = '0.8';
    
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.classList.remove('overflow-hidden');
    }, 200);
}

function printBarcode() {
    const canvas = document.querySelector('#barcodeCanvas');
    const patientNumber = document.getElementById('patientNumber').textContent;
    const barcodeContainer = document.getElementById('barcodeContainer');
    
    if (!canvas && !barcodeContainer.innerHTML.includes('fallback')) {
        alert('No barcode to print. Please generate a barcode first.');
        return;
    }
    
    const printWindow = window.open('', '_blank');
    let barcodeContent;
    
    if (canvas) {
        // Use canvas data for real barcode
        const barcodeDataURL = canvas.toDataURL('image/png');
        barcodeContent = `<img src="${barcodeDataURL}" alt="Barcode for ${patientNumber}" class="barcode-image">`;
    } else {
        // Use fallback content
        barcodeContent = barcodeContainer.innerHTML;
    }
    
    printWindow.document.write(`
        <html>
            <head>
                <title>Barcode - ${patientNumber}</title>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        text-align: center; 
                        padding: 20px;
                        margin: 0;
                    }
                    .barcode-container { 
                        margin: 20px 0; 
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    .patient-number { 
                        font-size: 18px; 
                        font-weight: bold; 
                        margin: 10px 0; 
                    }
                    .barcode-image {
                        max-width: 100%;
                        height: auto;
                    }
                    @media print {
                        body { margin: 0; padding: 10px; }
                        .barcode-container { page-break-inside: avoid; }
                    }
                </style>
            </head>
            <body>
                <h2>OPD Patient Barcode</h2>
                <div class="patient-number">${patientNumber}</div>
                <div class="barcode-container">
                    ${barcodeContent}
                </div>
                <p>Generated on: ${new Date().toLocaleString()}</p>
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

function downloadBarcode() {
    const canvas = document.querySelector('#barcodeCanvas');
    const patientNumber = document.getElementById('patientNumber').textContent;
    const barcodeContainer = document.getElementById('barcodeContainer');
    
    if (!canvas && !barcodeContainer.innerHTML.includes('fallback')) {
        alert('No barcode to download. Please generate a barcode first.');
        return;
    }
    
    try {
        if (canvas) {
            // Download as PNG image
            const link = document.createElement('a');
            link.download = `barcode-${patientNumber}.png`;
            link.href = canvas.toDataURL('image/png');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            console.log('Barcode downloaded successfully:', patientNumber);
        } else {
            // For fallback, create a simple text file
            const link = document.createElement('a');
            link.download = `barcode-${patientNumber}.txt`;
            link.href = 'data:text/plain;charset=utf-8,' + encodeURIComponent(`OPD Patient Barcode\nPatient Number: ${patientNumber}\nGenerated: ${new Date().toLocaleString()}\n\nThis is a text representation of the barcode.`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            console.log('Fallback barcode info downloaded:', patientNumber);
        }
    } catch (error) {
        console.error('Error downloading barcode:', error);
        alert('Error downloading barcode. Please try again.');
    }
}

// Initialize modal animations and event listeners
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('barcodeModal');
    const modalContent = modal.querySelector('.relative');
    
    // Set initial animation state
    modalContent.style.transition = 'all 0.3s ease';
    modalContent.style.transform = 'scale(0.95)';
    modalContent.style.opacity = '0.8';
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeBarcodeModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display !== 'none') {
            closeBarcodeModal();
        }
    });
    
    console.log('OPD page functionality initialized');
});

</script>
@endsection
