@if($examinationType === 'pre-employment')
    <!-- Pre-Employment Medical Checklist -->
    <div class="space-y-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="font-semibold text-blue-800 mb-2">Patient Information</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium">Name:</span> 
                    {{ $preEmploymentRecord->first_name }} {{ $preEmploymentRecord->last_name }}
                </div>
                <div>
                    <span class="font-medium">Age:</span> 
                    {{ $preEmploymentRecord->age }}
                </div>
                <div>
                    <span class="font-medium">Sex:</span> 
                    {{ $preEmploymentRecord->sex }}
                </div>
                <div>
                    <span class="font-medium">Company:</span> 
                    {{ $preEmploymentRecord->company_name }}
                </div>
            </div>
        </div>
@else
    <!-- Annual Physical Medical Checklist -->
    <div class="space-y-6">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <h4 class="font-semibold text-green-800 mb-2">Patient Information</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium">Name:</span> 
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </div>
                <div>
                    <span class="font-medium">Age:</span> 
                    {{ $patient->age }}
                </div>
                <div>
                    <span class="font-medium">Sex:</span> 
                    {{ $patient->sex }}
                </div>
                <div>
                    <span class="font-medium">Email:</span> 
                    {{ $patient->email }}
                </div>
            </div>
        </div>
@endif

<!-- Medical Checklist Form -->
<div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
    <h4 class="font-semibold text-gray-800 mb-4">X-Ray Information</h4>
    
    @if($medicalChecklist)
        <form action="{{ route('radtech.medical-checklist.update', $medicalChecklist->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">X-Ray Done By (Initials)</label>
                    <input type="text" name="xray_done_by" value="{{ old('xray_done_by', $medicalChecklist->xray_done_by) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Enter your initials" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">X-Ray Date</label>
                    <input type="date" name="xray_date" value="{{ old('xray_date', $medicalChecklist->xray_date) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">X-Ray Notes</label>
                <textarea name="xray_notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                          placeholder="Any additional notes about the X-ray">{{ old('xray_notes', $medicalChecklist->xray_notes) }}</textarea>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeMedicalChecklistModal()" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update X-Ray Info
                </button>
            </div>
        </form>
    @else
        <div class="text-center py-8">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-clipboard-list text-6xl"></i>
            </div>
            <h5 class="text-lg font-medium text-gray-900 mb-2">No Medical Checklist Found</h5>
            <p class="text-gray-500">A medical checklist needs to be created by a nurse first before you can add X-ray information.</p>
        </div>
        
        <div class="flex justify-center pt-4">
            <button onclick="closeMedicalChecklistModal()" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Close
            </button>
        </div>
    @endif
</div>

@if($medicalChecklist)
    <!-- Current Checklist Information (Read-only) -->
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h4 class="font-semibold text-gray-800 mb-4">Current Checklist Status</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-600">Blood Test Done By:</span>
                <span class="ml-2">{{ $medicalChecklist->blood_test_done_by ?: 'Not completed' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Blood Extraction Done By:</span>
                <span class="ml-2">{{ $medicalChecklist->blood_extraction_done_by ?: 'Not completed' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">ECG Done By:</span>
                <span class="ml-2">{{ $medicalChecklist->ecg_done_by ?: 'Not completed' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Physical Exam Done By:</span>
                <span class="ml-2">{{ $medicalChecklist->physical_exam_done_by ?: 'Not completed' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">X-Ray Done By:</span>
                <span class="ml-2 font-semibold {{ $medicalChecklist->xray_done_by ? 'text-green-600' : 'text-gray-500' }}">
                    {{ $medicalChecklist->xray_done_by ?: 'Not completed' }}
                </span>
            </div>
            <div>
                <span class="font-medium text-gray-600">X-Ray Date:</span>
                <span class="ml-2 {{ $medicalChecklist->xray_date ? 'text-green-600' : 'text-gray-500' }}">
                    {{ $medicalChecklist->xray_date ?: 'Not completed' }}
                </span>
            </div>
        </div>
        
        @if($medicalChecklist->xray_notes)
            <div class="mt-4">
                <span class="font-medium text-gray-600">X-Ray Notes:</span>
                <p class="mt-1 text-gray-700 bg-gray-50 p-3 rounded">{{ $medicalChecklist->xray_notes }}</p>
            </div>
        @endif
    </div>
@endif
