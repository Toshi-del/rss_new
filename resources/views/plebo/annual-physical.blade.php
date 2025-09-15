@extends('layouts.plebo')

@section('title', 'Annual Physical Examination')
@section('page-title', 'Annual Physical Examination')

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
        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <i class="fas fa-file-medical text-red-600 text-xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-red-600">Annual Physical Examination</h1>
            <p class="text-gray-600 mt-1">Manage medical checklist for annual physical examinations.</p>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
        <div class="text-2xl font-bold text-gray-800">{{ $patients->total() }}</div>
        <div class="text-sm text-gray-600">Total Patients</div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-list text-blue-600"></i>
                <h2 class="text-xl font-semibold text-blue-800">Annual Physical Examination Patients</h2>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Click to open medical checklist</span>
                <button class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full flex items-center space-x-1">
                    <i class="fas fa-info-circle"></i>
                    <span>Approved Patients Only</span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-user"></i>
                            <span>PATIENT INFORMATION</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-building"></i>
                            <span>COMPANY</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-info-circle"></i>
                            <span>STATUS</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar"></i>
                            <span>DATE</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-cog"></i>
                            <span>ACTIONS</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $patient->age }} years old • {{ $patient->sex }}</div>
                                    <div class="text-sm text-gray-500">{{ $patient->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $patient->company_name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $patient->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ ucfirst($patient->status ?? 'Pending') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $patient->created_at->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $patient->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <a href="{{ route('plebo.medical-checklist.annual-physical', $patient->id) }}" 
                                   class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors flex items-center" 
                                   title="Medical Checklist">
                                    <i class="fas fa-clipboard-list mr-1"></i>
                                    Checklist
                                </a>
                                <button onclick="generateBarcode('{{ $patient->id }}', '{{ $patient->first_name }} {{ $patient->last_name }}')" 
                                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors flex items-center" 
                                        title="Generate Barcode">
                                    <i class="fas fa-barcode mr-1"></i>
                                    Barcode
                                </button>
                                @php
                                    $hasMedicalChecklist = \App\Models\MedicalChecklist::where('patient_id', $patient->id)->exists();
                                @endphp
                                <form action="{{ route('plebo.annual-physical.send-to-doctor', $patient->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="{{ $hasMedicalChecklist ? 'bg-purple-600 hover:bg-purple-700' : 'bg-gray-400 cursor-not-allowed' }} text-white px-3 py-1 rounded transition-colors flex items-center" 
                                            title="{{ $hasMedicalChecklist ? 'Send to Doctor' : 'Complete medical checklist first' }}"
                                            {{ $hasMedicalChecklist ? '' : 'disabled' }}>
                                        <i class="fas fa-paper-plane mr-1"></i>
                                        Send
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-user-times text-gray-400 text-4xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No patients found</h3>
                                <p class="text-gray-500">No annual physical examination patients available at the moment.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Barcode Modal -->
<div id="barcodeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-barcode mr-2 text-blue-600"></i>Generated Barcode
                </h3>
                <button onclick="closeBarcodeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="text-center">
                <div id="barcodeContainer" class="mb-4 p-4 bg-white border-2 border-dashed border-gray-300 rounded-lg">
                    <p class="text-gray-500">Barcode will appear here</p>
                </div>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Patient Number:</p>
                    <p id="patientNumber" class="text-lg font-semibold text-gray-900"></p>
                </div>
                
                <div class="flex justify-center space-x-3">
                    <button onclick="printBarcode()" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                    <button onclick="downloadBarcode()" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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

function generateBarcode(patientId, patientName) {
    // Generate the patient number (same format as in PleboController)
    const patientNumber = 'PAT-' + String(patientId).padStart(4, '0');
    
    // Update the modal content
    document.getElementById('patientNumber').textContent = patientNumber;
    
    // Clear previous barcode
    document.getElementById('barcodeContainer').innerHTML = '';
    
    // Show modal first
    document.getElementById('barcodeModal').style.display = 'block';
    
    // Wait a bit for modal to be visible, then generate barcode
    setTimeout(() => {
        try {
            // Check if JsBarcode is loaded and not in fallback mode
            if (typeof JsBarcode === 'undefined' || JsBarcode.fallback) {
                console.log('Using fallback barcode generation');
                createFallbackBarcode(document.getElementById('barcodeContainer'), patientNumber);
                return;
            }
            
            // Create canvas element for barcode
            const canvas = document.createElement('canvas');
            canvas.id = 'barcodeCanvas';
            document.getElementById('barcodeContainer').appendChild(canvas);
            
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
                createFallbackBarcode(document.getElementById('barcodeContainer'), patientNumber);
            } catch (fallbackError) {
                console.error('Fallback also failed:', fallbackError);
                document.getElementById('barcodeContainer').innerHTML = `
                    <div class="text-center p-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-2xl mb-2"></i>
                        <p class="text-red-500 font-medium">Error generating barcode</p>
                        <p class="text-sm text-gray-500 mt-1">Please try again or contact support</p>
                    </div>
                `;
            }
        }
    }, 100);
}

function closeBarcodeModal() {
    document.getElementById('barcodeModal').style.display = 'none';
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
                <h2>Patient Barcode</h2>
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
            link.href = 'data:text/plain;charset=utf-8,' + encodeURIComponent(`Patient Barcode\nPatient Number: ${patientNumber}\nGenerated: ${new Date().toLocaleString()}\n\nThis is a text representation of the barcode.`);
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

// Close modal when clicking outside
document.getElementById('barcodeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBarcodeModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBarcodeModal();
    }
});

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Barcode functionality initialized for annual physical');
});
</script>
@endsection
