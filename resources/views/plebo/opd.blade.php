@extends('layouts.plebo')

@section('title', 'OPD Walk-in Examination')
@section('page-title', 'OPD Walk-in Examination')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300 text-center font-semibold">
        {{ session('error') }}
    </div>
@endif

<!-- Header Section -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
            <i class="fas fa-walking text-orange-600 text-xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-orange-600">OPD Walk-in Examination</h1>
            <p class="text-gray-600 mt-1">Manage medical checklist for OPD walk-in patients.</p>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
        <div class="text-2xl font-bold text-gray-800">{{ $opdPatients->total() }}</div>
        <div class="text-sm text-gray-600">Total Patients</div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-list text-blue-600"></i>
                <h2 class="text-xl font-semibold text-blue-800">OPD Walk-in Patients</h2>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Click to open medical checklist</span>
                <button class="bg-orange-100 text-orange-800 text-xs font-medium px-3 py-1 rounded-full flex items-center space-x-1">
                    <i class="fas fa-info-circle"></i>
                    <span>OPD Patients Only</span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-user mr-2"></i>Patient Information
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-phone mr-2"></i>Contact
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-calendar mr-2"></i>Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-tasks mr-2"></i>Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-cogs mr-2"></i>Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($opdPatients as $patient)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-orange-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $patient->age }} years • {{ $patient->sex }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $patient->email }}</div>
                            <div class="text-sm text-gray-500">{{ $patient->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $patient->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $hasExamination = $patient->opdExamination;
                                $hasMedicalChecklist = \App\Models\MedicalChecklist::where('opd_examination_id', optional($patient->opdExamination)->id)->exists();
                                
                                if ($hasExamination && $hasMedicalChecklist) {
                                    $statusClass = 'bg-green-100 text-green-800';
                                    $statusText = 'Completed';
                                    $statusIcon = 'fas fa-check-circle';
                                } elseif ($hasExamination || $hasMedicalChecklist) {
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    $statusText = 'In Progress';
                                    $statusIcon = 'fas fa-clock';
                                } else {
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    $statusText = 'Pending';
                                    $statusIcon = 'fas fa-hourglass-start';
                                }
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                <i class="{{ $statusIcon }} mr-1"></i>
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col space-y-2">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('plebo.medical-checklist.opd', $patient->id) }}" 
                                       class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                        <i class="fas fa-clipboard-list mr-1"></i>
                                        Checklist
                                    </a>
                                    
                                    <button onclick="generateBarcode({{ $patient->id }})" 
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        <i class="fas fa-barcode mr-1"></i>
                                        Barcode
                                    </button>
                                    
                                    @if($hasExamination && $hasMedicalChecklist)
                                        <form action="{{ route('plebo.opd.send-to-doctor', $patient->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200"
                                                    onclick="return confirm('Are you sure you want to send this patient to the doctor?')">
                                                <i class="fas fa-paper-plane mr-1"></i>
                                                Send
                                            </button>
                                        </form>
                                    @else
                                        <button disabled 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-gray-400 cursor-not-allowed">
                                            <i class="fas fa-paper-plane mr-1"></i>
                                            Send
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-user-friends text-gray-300 text-4xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No OPD patients found</h3>
                                <p class="text-gray-500">There are currently no OPD walk-in patients to display.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($opdPatients->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $opdPatients->links() }}
        </div>
    @endif
</div>


<script>

function generateBarcode(patientId) {
    try {
        console.log('Generating barcode for patient ID:', patientId);
        // Generate barcode for OPD patient
        const barcodeData = `OPD-${String(patientId).padStart(4, '0')}`;
        console.log('Barcode data:', barcodeData);
        
        // Show barcode modal
        showBarcodeModal(barcodeData);
    } catch (error) {
        console.error('Error in generateBarcode:', error);
        alert('Error generating barcode');
    }
}

function showBarcodeModal(barcodeData) {
    try {
        console.log('Showing barcode modal for:', barcodeData);
        
        // Remove existing modal if any
        const existingModal = document.getElementById('barcodeModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Create modal HTML
        const modalHTML = `
        <div id="barcodeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-0 border w-96 shadow-lg rounded-lg bg-white">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-barcode text-blue-600"></i>
                        <h3 class="text-lg font-medium text-gray-900">Generated Barcode</h3>
                    </div>
                    <button onclick="closeBarcodeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6">
                    <!-- Barcode Container -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center mb-4">
                        <div id="barcodeImage" class="mb-4">
                            <!-- Barcode will be generated here -->
                            <div class="barcode-lines mx-auto" style="width: 250px; height: 80px; background: repeating-linear-gradient(to right, black 0px, black 2px, white 2px, white 4px); position: relative;">
                                <div style="position: absolute; bottom: -25px; left: 50%; transform: translateX(-50%); font-family: monospace; font-size: 14px; font-weight: bold;">${barcodeData}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Patient Info -->
                    <div class="text-center mb-6">
                        <p class="text-sm text-gray-600 mb-2">Patient Number:</p>
                        <p class="text-xl font-bold text-gray-900">${barcodeData}</p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button onclick="printBarcode('${barcodeData}')" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <i class="fas fa-print"></i>
                            <span>Print</span>
                        </button>
                        <button onclick="downloadBarcode('${barcodeData}')" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <i class="fas fa-download"></i>
                            <span>Download</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        console.log('Modal added to DOM');
        
        // Generate actual barcode using JsBarcode if available, otherwise use CSS barcode
        setTimeout(() => {
            if (typeof JsBarcode !== 'undefined') {
                // Use JsBarcode library if available
                JsBarcode("#barcodeImage canvas", barcodeData, {
                    format: "CODE128",
                    width: 2,
                    height: 80,
                    displayValue: true
                });
            }
        }, 100);
        
    } catch (error) {
        console.error('Error in showBarcodeModal:', error);
        alert('Error displaying barcode modal');
    }
}

function closeBarcodeModal() {
    const modal = document.getElementById('barcodeModal');
    if (modal) {
        modal.remove();
    }
}

function printBarcode(barcodeData) {
    try {
        const printWindow = window.open('', '_blank', 'width=400,height=300');
        if (!printWindow) {
            alert('Please allow pop-ups to print the barcode');
            return;
        }
        
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Print Barcode - ${barcodeData}</title>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        text-align: center; 
                        padding: 20px; 
                        background: white;
                        margin: 0;
                    }
                    .barcode-container {
                        border: 2px solid #333;
                        padding: 20px;
                        margin: 20px auto;
                        width: fit-content;
                        background: white;
                    }
                    .barcode-lines {
                        width: 250px; 
                        height: 80px; 
                        background: repeating-linear-gradient(to right, black 0px, black 2px, white 2px, white 4px); 
                        margin: 0 auto;
                        position: relative;
                    }
                    .barcode-text {
                        margin-top: 10px;
                        font-family: monospace; 
                        font-size: 14px; 
                        font-weight: bold;
                    }
                    .patient-info {
                        margin: 10px 0;
                        font-size: 14px;
                    }
                    @media print {
                        body { margin: 0; }
                        .no-print { display: none; }
                    }
                </style>
            </head>
            <body>
                <div class="barcode-container">
                    <h3>RSS Health Services Corp</h3>
                    <div class="patient-info">OPD Walk-in Patient</div>
                    <div class="barcode-lines"></div>
                    <div class="barcode-text">${barcodeData}</div>
                    <div class="patient-info">Date: ${new Date().toLocaleDateString()}</div>
                </div>
                <script>
                    setTimeout(function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 1000);
                    }, 500);
                </script>
            </body>
            </html>
        `);
        
        setTimeout(() => {
            try {
                printWindow.document.close();
            } catch (e) {
                console.log('Document close error (this is normal):', e);
            }
        }, 100);
        
    } catch (error) {
        console.error('Print error:', error);
        alert('Error generating barcode for printing');
    }
}

function downloadBarcode(barcodeData) {
    try {
        // Create a canvas element for the barcode
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        // Set canvas size
        canvas.width = 300;
        canvas.height = 150;
        
        // Fill white background
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Draw barcode lines
        ctx.fillStyle = 'black';
        for (let i = 0; i < 125; i++) {
            if (i % 2 === 0) {
                ctx.fillRect(25 + i * 2, 30, 2, 60);
            }
        }
        
        // Draw text
        ctx.fillStyle = 'black';
        ctx.font = '14px monospace';
        ctx.textAlign = 'center';
        ctx.fillText(barcodeData, canvas.width / 2, 110);
        
        // Download the canvas as image
        const link = document.createElement('a');
        link.download = `barcode-${barcodeData}.png`;
        link.href = canvas.toDataURL('image/png');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
    } catch (error) {
        console.error('Download error:', error);
        alert('Error generating barcode for download');
    }
}

</script>
@endsection
