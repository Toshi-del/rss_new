<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="bg-blue-900 text-white text-center py-3 rounded-t-lg mb-8">
            <h2 class="text-xl font-bold tracking-wide">MEDICAL CHECKLIST</h2>
        </div>

        <form action="{{ isset($medicalChecklist) && $medicalChecklist->id ? route('radtech.medical-checklist.update', $medicalChecklist->id) : route('radtech.medical-checklist.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @if(isset($medicalChecklist) && $medicalChecklist->id)
                @method('PATCH')
            @endif
            <input type="hidden" name="examination_type" value="{{ $examinationType }}">
            @if(isset($preEmploymentRecord))
                <input type="hidden" name="pre_employment_record_id" value="{{ $preEmploymentRecord->id }}">
            @endif
            @if(isset($patient))
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $medicalChecklist->name ?? (isset($preEmploymentRecord) ? ($preEmploymentRecord->first_name . ' ' . $preEmploymentRecord->last_name) : (isset($patient) ? ($patient->first_name . ' ' . $patient->last_name) : '')) ) }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Date</label>
                    @php
                        $currentDate = old('date', ($medicalChecklist->date ?? now()->format('Y-m-d')));
                    @endphp
                    <a class="text-blue-600 hover:underline cursor-default">{{ \Carbon\Carbon::parse($currentDate)->format('Y-m-d') }}</a>
                    <input type="hidden" name="date" value="{{ $currentDate }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Age</label>
                    <input type="number" name="age" value="{{ old('age', $medicalChecklist->age ?? (isset($preEmploymentRecord) ? $preEmploymentRecord->age : (isset($patient) ? $patient->age : '')) ) }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Number</label>
                    @php($displayNumber = old('number', $medicalChecklist->number ?? ($number ?? '')))
                    @if($displayNumber)
                        <a class="text-blue-600 hover:underline cursor-pointer" tabindex="-1">{{ $displayNumber }}</a>
                    @else
                        <span class="text-sm text-gray-500">N/A</span>
                    @endif
                    <input type="hidden" name="number" value="{{ $displayNumber }}" />
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="text-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Done By</h3>
                </div>

                <div class="space-y-4">
                    @foreach([
                        'chest_xray' => 'Chest X-Ray',
                        'stool_exam' => 'Stool Exam',
                        'urinalysis' => 'Urinalysis',
                        'drug_test' => 'Drug Test',
                        'blood_extraction' => 'Blood Extraction',
                        'ecg' => 'ElectroCardioGram (ECG)',
                        'physical_exam' => 'Physical Exam',
                    ] as $field => $examName)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-700 mr-4">{{ $loop->iteration }}.</span>
                                <span class="text-sm text-gray-700">{{ $examName }}</span>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-700">Completed by:</span>
                                @if($field === 'chest_xray')
                                    <input type="text" name="chest_xray_done_by" 
                                           value="{{ old('chest_xray_done_by', $medicalChecklist->chest_xray_done_by ?? '') }}" 
                                           placeholder="Initials/Signature" 
                                           class="form-input w-32 rounded border-gray-300 text-sm">
                                @else
                                    <span class="text-sm text-gray-500">{{ $medicalChecklist->{$field . '_done_by'} ?? 'Not completed' }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Optional</label>
                    <input type="text" name="optional_exam" value="{{ old('optional_exam', $medicalChecklist->optional_exam ?? 'Audiometry/Ishihara') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Nurse's Signature</label>
                    <input type="text" name="nurse_signature" value="{{ old('nurse_signature', $medicalChecklist->nurse_signature ?? '') }}" class="form-input w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">X-Ray Image</label>
                    <input type="file" name="xray_image" accept="image/*" class="text-sm">
                    @if(isset($medicalChecklist) && $medicalChecklist->xray_image_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $medicalChecklist->xray_image_path) }}" alt="X-Ray Image" class="w-full max-h-72 object-contain rounded border bg-white">
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg shadow hover:bg-blue-700 transition-colors font-semibold tracking-wide">
                    {{ isset($medicalChecklist) && $medicalChecklist->id ? 'Update' : 'Submit' }}
                </button>
            </div>
        </form>
    </div>
</div>
