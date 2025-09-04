@extends('layouts.admin')

@section('title', 'Tests - RSS Citi Health Services')
@section('page-title', 'Tests')

@section('content')
<div class="container mt-4">
    <h2>Pre-Employment Examinations</h2>
    <div class="table-responsive mb-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($preEmploymentResults as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name }}</td>
                        <td>{{ $exam->company_name }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->status }}</td>
                        <td>
                            <a href="{{ route('admin.view-pre-employment-examination', $exam->id) }}" class="btn btn-primary btn-sm">View & Send to Company</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2>Annual Physical Examinations</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($annualPhysicalResults as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->status }}</td>
                        <td>
                            <a href="{{ route('admin.view-annual-physical-examination', $exam->id) }}" class="btn btn-primary btn-sm">View & Send to Company</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
