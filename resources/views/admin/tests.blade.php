@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mt-4 mb-4">Certificate of Medical Examination Results</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Pre-Employment Examinations</div>
                <div class="card-body">
                    @if($preEmploymentResults->count())
                        @foreach($preEmploymentResults as $result)
                            <div class="border p-3 mb-3">
                                <strong>Name:</strong> {{ $result->name ?? 'N/A' }}<br>
                                <strong>Date:</strong> {{ $result->date ?? 'N/A' }}<br>
                                <strong>Company:</strong> {{ $result->company_name ?? 'N/A' }}<br>
                                <strong>Status:</strong> {{ $result->status ?? 'N/A' }}<br>
                                <!-- Add more fields as needed -->
                            </div>
                        @endforeach
                    @else
                        <p>No pre-employment examination results found.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">Annual Physical Examinations</div>
                <div class="card-body">
                    @if($annualPhysicalResults->count())
                        @foreach($annualPhysicalResults as $result)
                            <div class="border p-3 mb-3">
                                <strong>Name:</strong> {{ $result->name ?? 'N/A' }}<br>
                                <strong>Date:</strong> {{ $result->date ?? 'N/A' }}<br>
                                <strong>Status:</strong> {{ $result->status ?? 'N/A' }}<br>
                                <!-- Add more fields as needed -->
                            </div>
                        @endforeach
                    @else
                        <p>No annual physical examination results found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
