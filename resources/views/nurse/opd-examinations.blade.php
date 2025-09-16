@extends('layouts.nurse')

@section('title', 'OPD Examinations')
@section('page-title', 'OPD Examinations')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-7xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="bg-green-900 text-white text-center py-3 rounded-t-lg">
            <h2 class="text-xl font-bold tracking-wide">OPD EXAMINATIONS</h2>
        </div>
        
        <div class="p-6">
            @if($opdTests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left text-xs font-semibold uppercase">Customer Name</th>
                                <th class="border border-gray-300 px-4 py-2 text-left text-xs font-semibold uppercase">Email</th>
                                <th class="border border-gray-300 px-4 py-2 text-left text-xs font-semibold uppercase">Medical Test</th>
                                <th class="border border-gray-300 px-4 py-2 text-left text-xs font-semibold uppercase">Date</th>
                                <th class="border border-gray-300 px-4 py-2 text-left text-xs font-semibold uppercase">Status</th>
                                <th class="border border-gray-300 px-4 py-2 text-center text-xs font-semibold uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($opdTests as $opdTest)
                                @php
                                    $examination = \App\Models\OpdExamination::where('opd_test_id', $opdTest->id)->first();
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2">{{ $opdTest->customer_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $opdTest->customer_email }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $opdTest->medical_test }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $opdTest->appointment_date ? \Carbon\Carbon::parse($opdTest->appointment_date)->format('M j, Y') : 'N/A' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if($examination)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($examination->status === 'Pending') bg-yellow-100 text-yellow-800
                                                @elseif($examination->status === 'Sent to Doctor') bg-blue-100 text-blue-800
                                                @elseif($examination->status === 'Completed') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $examination->status }}
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                No Examination
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <div class="flex justify-center space-x-2">
                                            @if(!$examination)
                                                <a href="{{ route('nurse.opd-examinations.create', ['opd_test_id' => $opdTest->id]) }}" 
                                                   class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition-colors">
                                                    Create Exam
                                                </a>
                                            @else
                                                <a href="{{ route('nurse.opd-examinations.edit', $examination->id) }}" 
                                                   class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 transition-colors">
                                                    Edit
                                                </a>
                                                @if($examination->status === 'Pending')
                                                    <form method="POST" action="{{ route('nurse.opd-examinations.send-to-doctor', $opdTest->id) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="bg-purple-600 text-white px-3 py-1 rounded text-xs hover:bg-purple-700 transition-colors"
                                                                onclick="return confirm('Send this examination to doctor?')">
                                                            Send to Doctor
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                            <a href="{{ route('nurse.opd-medical-checklist', $opdTest->id) }}" 
                                               class="bg-gray-600 text-white px-3 py-1 rounded text-xs hover:bg-gray-700 transition-colors">
                                                Checklist
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6">
                    {{ $opdTests->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-500 text-lg mb-4">No OPD tests found</div>
                    <p class="text-gray-400">OPD tests will appear here once they are approved by admin.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
