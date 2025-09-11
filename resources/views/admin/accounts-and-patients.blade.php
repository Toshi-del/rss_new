@extends('layouts.admin')

@section('title', 'Company Accounts & Patients')

@section('content')
<div class="container-fluid py-4">
    <div class="container">
        
        <!-- Header -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="bg-primary p-3 rounded-3 me-3">
                        <i class="fas fa-building text-white fs-4"></i>
                    </div>
                    <h2 class="h3 mb-0">Company Accounts</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group rounded-3 shadow-sm overflow-hidden">
                    <span class="input-group-text bg-white border-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-0" placeholder="Search companies...">
                </div>
            </div>
        </div>

        <!-- Company Grid -->
        <div class="row g-4">
            @foreach($companyData as $idx => $entry)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition">
                        <div class="card-body">
                            <!-- Header -->
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h3 class="h5 mb-0">{{ $entry['company']->company ?? $entry['company']->name ?? 'N/A' }}</h3>
                                    <span class="badge bg-primary">Company</span>
                                </div>
                                <p class="text-muted small mb-0">{{ $entry['company']->email }}</p>
                            </div>

                            <!-- Stats -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="bg-light rounded p-2 text-primary d-flex align-items-center">
                                        <i class="fas fa-users me-2"></i>
                                        <span class="small fw-medium">{{ count($entry['patients']) }} Patients</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded p-2 text-primary d-flex align-items-center">
                                        <i class="fas fa-briefcase-medical me-2"></i>
                                        <span class="small fw-medium">{{ count($entry['preEmployments']) }} Records</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action -->
                            <button data-bs-toggle="modal" data-bs-target="#companyModal-{{ $idx }}" 
                                    class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="companyModal-{{ $idx }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-building fs-4 me-2"></i>
                                    <div>
                                        <h5 class="modal-title mb-0">{{ $entry['company']->company ?? $entry['company']->name ?? 'N/A' }}</h5>
                                        <p class="text-muted small mb-0">{{ $entry['company']->email }}</p>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <!-- Delete Button -->
                                <form method="POST" 
                                      action="{{ route('admin.delete-company', $entry['company']->id) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this company account?');" 
                                      class="mb-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger d-inline-flex align-items-center gap-2 shadow-sm">
                                        <i class="fas fa-trash-alt"></i> Delete Account
                                    </button>
                                </form>

                                <!-- Tabs -->
                                <ul class="nav nav-tabs mb-4" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active d-flex align-items-center gap-2" id="patients-tab-{{ $idx }}" data-bs-toggle="tab" data-bs-target="#patients-{{ $idx }}" type="button" role="tab" aria-controls="patients-{{ $idx }}" aria-selected="true">
                                            <i class="fas fa-users"></i> Patients
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link d-flex align-items-center gap-2" id="records-tab-{{ $idx }}" data-bs-toggle="tab" data-bs-target="#records-{{ $idx }}" type="button" role="tab" aria-controls="records-{{ $idx }}" aria-selected="false">
                                            <i class="fas fa-briefcase-medical"></i> Pre-Employment Records
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!-- Patients Table -->
                                    <div class="tab-pane fade show active" id="patients-{{ $idx }}" role="tabpanel" aria-labelledby="patients-tab-{{ $idx }}">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-sm align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Full Name</th>
                                                        <th>Company</th>
                                                        <th>Age/Sex</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($entry['patients'] as $patient)
                                                        <tr>
                                                            <td>{{ $patient->getFullNameAttribute() }}</td>
                                                            <td>{{ $entry['company']->company?? $entry['company']->name ?? 'N/A' }}</td>
                                                            <td>{{ $patient->getAgeSexAttribute() }}</td>
                                                            <td>{{ $patient->email }}</td>
                                                            <td>{{ $patient->phone }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="5" class="text-center text-muted">No patients found.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Records Table -->
                                    <div class="tab-pane fade" id="records-{{ $idx }}" role="tabpanel" aria-labelledby="records-tab-{{ $idx }}">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-sm align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Full Name</th>
                                                        <th>Age/Sex</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($entry['preEmployments'] as $pre)
                                                        <tr>
                                                            <td>{{ $pre->full_name }}</td>
                                                            <td>{{ $pre->age }} / {{ $pre->sex }}</td>
                                                            <td>{{ $pre->email }}</td>
                                                            <td>{{ $pre->phone_number }}</td>
                                                            <td>
                                                                <span class="badge rounded-pill
                                                                    @if(strtolower($pre->status) === 'approved') bg-success
                                                                    @elseif(strtolower($pre->status) === 'pending') bg-warning
                                                                    @elseif(strtolower($pre->status) === 'declined') bg-danger
                                                                    @else bg-secondary @endif">
                                                                    {{ ucfirst($pre->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="5" class="text-center text-muted">No pre-employment records found.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
