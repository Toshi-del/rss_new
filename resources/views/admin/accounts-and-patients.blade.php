@extends('layouts.admin')

@section('title', 'Company Accounts & Patients')

@section('content')
<div class="container mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-6">All Company Accounts and Their Patients</h2>
    @foreach($companiesWithPatients as $company)
        <div class="mb-8 p-4 bg-white rounded shadow">
            <h3 class="text-xl font-semibold mb-2">{{ $company->full_name }} ({{ $company->email }})</h3>
            <p class="mb-2 text-gray-600">Company: {{ $company->company ?? 'N/A' }}</p>
            <h4 class="font-semibold mb-2">Patients:</h4>
            @if($company->patients->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 mb-2">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">Full Name</th>
                                <th class="px-4 py-2 border">Age/Sex</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($company->patients as $patient)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $patient->full_name }}</td>
                                    <td class="px-4 py-2 border">{{ $patient->age_sex }}</td>
                                    <td class="px-4 py-2 border">{{ $patient->email }}</td>
                                    <td class="px-4 py-2 border">{{ $patient->phone }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No patients found for this company.</p>
            @endif
        </div>
    @endforeach
</div>
@endsection
