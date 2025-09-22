@extends('layouts.ecgtech')

@section('title', 'OPD Walk-in Patients')

@section('page-title', 'OPD Walk-in Patients')

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- OPD Walk-ins Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">OPD Walk-in Patients - ECG Examination</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PATIENT NAME</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AGE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EMAIL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PHONE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">REGISTRATION DATE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ECG STATUS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($opdPatients as $patient)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $patient->fname }} {{ $patient->lname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->age }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    $opdExam = \App\Models\OpdExamination::where('user_id', $patient->id)->first();
                                    $medicalChecklist = \App\Models\MedicalChecklist::where('user_id', $patient->id)
                                        ->where('examination_type', 'opd')
                                        ->whereNotNull('ecg_done_by')
                                        ->first();
                                @endphp
                                @if($medicalChecklist)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ECG Completed
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        ECG Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    $canSendToDoctor = $medicalChecklist && !empty($medicalChecklist->ecg_done_by);
                                @endphp
                                @if($canSendToDoctor)
                                    <form action="{{ route('ecgtech.opd.send-to-doctor', $patient->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-ecgtech-600 text-white px-3 py-1 rounded hover:bg-ecgtech-700 transition-colors mr-2" title="Send to Doctor">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed mr-2" title="Complete ECG examination first" disabled>
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                @endif
                                
                                @if($opdExam)
                                    <a href="{{ route('ecgtech.opd.edit', $opdExam->id) }}" class="bg-ecgtech-600 text-white px-3 py-1 rounded hover:bg-ecgtech-700 transition-colors mr-2" title="Edit ECG Results">
                                        <i class="fas fa-heartbeat"></i>
                                    </a>
                                @else
                                    <a href="{{ route('ecgtech.opd.create', ['user_id' => $patient->id]) }}" class="bg-ecgtech-600 text-white px-3 py-1 rounded hover:bg-ecgtech-700 transition-colors mr-2" title="Add ECG Results">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endif
                                
                                <a href="{{ route('ecgtech.medical-checklist.opd', $patient->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors mr-2" title="Medical Checklist">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                No OPD walk-in patients found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($opdPatients->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $opdPatients->links() }}
            </div>
        @endif
    </div>
@endsection
