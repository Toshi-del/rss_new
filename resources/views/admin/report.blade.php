@extends('layouts.admin')

@section('title', 'Admin Report')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Pre-Employment Examinations</h2>
    <div class="table-responsive mb-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($preEmploymentExams as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name ?? 'N/A' }}</td>
                        <td>{{ $exam->company_name ?? ($exam->user->company ?? 'N/A') }}</td>
                        <td>{{ $exam->user_id ?? 'N/A' }}</td>
                        <td>{{ $exam->status ?? 'N/A' }}</td>
                        <td>{{ $exam->date ? $exam->date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No pre-employment examinations found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h2 class="mb-4">Annual Physical Examinations</h2>
    <div class="table-responsive mb-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($annualPhysicalExams as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name ?? 'N/A' }}</td>
                        <td>{{ $exam->user_id ?? 'N/A' }}</td>
                        <td>{{ $exam->status ?? 'N/A' }}</td>
                        <td>{{ $exam->date ? $exam->date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No annual physical examinations found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

   
            </tbody>
        </table>
    </div>
</div>
@endsection
