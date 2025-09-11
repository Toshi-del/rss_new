@extends('layouts.plebo')

@section('title', 'Pre-Employment Records')

@section('page-title', 'Pre-Employment Records')

@section('content')
<div class="min-h-screen bg-gray-50" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-white border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif; color: #800000;">
                                <i class="fas fa-user-md mr-3"></i>Pre-Employment Records
                            </h1>
                            <p class="text-sm text-gray-600">Manage medical checklist for pre-employment examinations</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <div class="text-2xl font-bold text-blue-600">{{ $preEmployments->total() }}</div>
                                <div class="text-sm text-gray-500">Total Records</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Total Records</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $preEmployments->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Approved</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $preEmployments->where('status', 'approved')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Pending</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ $preEmployments->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Declined</h3>
                        <p class="text-2xl font-bold text-red-600">{{ $preEmployments->where('status', 'declined')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Records Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-list mr-2 text-blue-600"></i>Pre-Employment Records
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Click to open medical checklist or generate barcode</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            Approved Records Only
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-user mr-1"></i>Patient Information
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-building mr-1"></i>Company
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-info-circle mr-1"></i>Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-1"></i>Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-1"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($preEmployments as $preEmployment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $preEmployment->first_name }} {{ $preEmployment->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $preEmployment->age }} years old • {{ ucfirst($preEmployment->sex) }}
                                        </div>
                                        @if($preEmployment->email)
                                        <div class="text-xs text-blue-600">
                                            <i class="fas fa-envelope mr-1"></i>{{ $preEmployment->email }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $preEmployment->company_name }}</div>
                                @if($preEmployment->phone_number)
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-phone mr-1"></i>{{ $preEmployment->phone_number }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusConfig = match($preEmployment->status) {
                                        'approved' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'check-circle'],
                                        'declined' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'times-circle'],
                                        'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'clock'],
                                        default => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'question-circle']
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusConfig['class'] }}">
                                    <i class="fas fa-{{ $statusConfig['icon'] }} mr-1"></i>
                                    {{ ucfirst($preEmployment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                    {{ $preEmployment->created_at->format('M d, Y') }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $preEmployment->created_at->format('h:i A') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <!-- Medical Checklist Button -->
                                    <a href="{{ route('plebo.medical-checklist.pre-employment', $preEmployment->id) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                                       title="Medical Checklist">
                                        <i class="fas fa-clipboard-list mr-1"></i>
                                        Checklist
                                    </a>
                                    
                                    <!-- Generate Barcode Button -->
                                    <button type="button" 
                                            data-record-id="{{ $preEmployment->id }}"
                                            class="generate-barcode-btn inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                                            title="Generate Barcode">
                                        <i class="fas fa-barcode mr-1"></i>
                                        Barcode
                                    </button>
                                    
                                    <!-- Send to Doctor Button -->
                                    <form action="{{ route('plebo.pre-employment.send-to-doctor', $preEmployment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                                                title="Send to Doctor"
                                                onclick="return confirm('Are you sure you want to send this record to the doctor?')">
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
                                    <i class="fas fa-user-md text-4xl text-gray-400 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No pre-employment records found</h3>
                                    <p class="text-gray-500">There are no approved pre-employment records to display.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($preEmployments->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $preEmployments->links() }}
            </div>
            @endif
        </div>
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
                    <p class="text-sm text-gray-600 mb-2">Record Number:</p>
                    <p id="recordNumber" class="text-lg font-semibold text-gray-900"></p>
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
function generateBarcode(recordId) {
    // Generate the record number (same format as in PleboController)
    const recordNumber = 'EMP-' + String(recordId).padStart(4, '0');
    
    // Update the modal content
    document.getElementById('recordNumber').textContent = recordNumber;
    
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
                createFallbackBarcode(document.getElementById('barcodeContainer'), recordNumber);
                return;
            }
            
            // Create canvas element for barcode
            const canvas = document.createElement('canvas');
            canvas.id = 'barcodeCanvas';
            document.getElementById('barcodeContainer').appendChild(canvas);
            
            // Generate barcode using JsBarcode
            JsBarcode(canvas, recordNumber, {
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
            
            console.log('Barcode generated successfully for:', recordNumber);
        } catch (error) {
            console.error('Error generating barcode:', error);
            // Try fallback method
            try {
                createFallbackBarcode(document.getElementById('barcodeContainer'), recordNumber);
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
    const recordNumber = document.getElementById('recordNumber').textContent;
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
        barcodeContent = `<img src="${barcodeDataURL}" alt="Barcode for ${recordNumber}" class="barcode-image">`;
    } else {
        // Use fallback content
        barcodeContent = barcodeContainer.innerHTML;
    }
    
    printWindow.document.write(`
        <html>
            <head>
                <title>Barcode - ${recordNumber}</title>
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
                    .record-number { 
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
                <h2>Medical Record Barcode</h2>
                <div class="record-number">${recordNumber}</div>
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
    const recordNumber = document.getElementById('recordNumber').textContent;
    const barcodeContainer = document.getElementById('barcodeContainer');
    
    if (!canvas && !barcodeContainer.innerHTML.includes('fallback')) {
        alert('No barcode to download. Please generate a barcode first.');
        return;
    }
    
    try {
        if (canvas) {
            // Download as PNG image
            const link = document.createElement('a');
            link.download = `barcode-${recordNumber}.png`;
            link.href = canvas.toDataURL('image/png');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            console.log('Barcode downloaded successfully:', recordNumber);
        } else {
            // For fallback, create a simple text file
            const link = document.createElement('a');
            link.download = `barcode-${recordNumber}.txt`;
            link.href = 'data:text/plain;charset=utf-8,' + encodeURIComponent(`Medical Record Barcode\nRecord Number: ${recordNumber}\nGenerated: ${new Date().toLocaleString()}\n\nThis is a text representation of the barcode.`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            console.log('Fallback barcode info downloaded:', recordNumber);
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
    // Add click event listeners to all barcode buttons
    document.querySelectorAll('.generate-barcode-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const recordId = this.getAttribute('data-record-id');
            if (recordId) {
                generateBarcode(parseInt(recordId));
            }
        });
    });
    
    console.log('Barcode functionality initialized');
});
</script>
@endsection