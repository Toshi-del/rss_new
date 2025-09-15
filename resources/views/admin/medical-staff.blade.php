@extends('layouts.admin')

@section('title', 'Medical Staff Management - RSS Citi Health Services')
@section('page-title', 'Medical Staff Management')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Staff Directory</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createStaffModal">
                <i class="fas fa-user-plus mr-1"></i> Add Staff
            </button>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.medical-staff') }}" class="form-inline mb-3">
                <div class="form-group mr-2 mb-2">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name or email">
                </div>
                <div class="form-group mr-2 mb-2">
                    <select name="role" class="form-control">
                        <option value="">All roles</option>
                        @php
                            $roles = [
                                'doctor' => 'Doctor',
                                'nurse' => 'Nurse (Medtech)',
                                'plebo' => 'Plebo',
                                'pathologist' => 'Pathologist',
                                'ecgtech' => 'ECG Tech',
                                'radtech' => 'Radtech',
                                'radiologist' => 'Radiologist',
                            ];
                        @endphp
                        @foreach($roles as $key => $label)
                            <option value="{{ $key }}" {{ request('role') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn btn-outline-secondary mb-2">Filter</button>
                @if(request()->hasAny(['search','role','status']))
                    <a href="{{ route('admin.medical-staff') }}" class="btn btn-link mb-2">Reset</a>
                @endif
            </form>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff ?? [] as $user)
                            <tr>
                                <td>{{ $user->fname }} {{ $user->lname }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-capitalize">{{ $user->role }}</td>
                                
                                <td class="text-right">
                                    <button 
                                        class="btn btn-sm btn-outline-primary mr-1"
                                        title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                        data-id="{{ $user->id }}"
                                        data-fname="{{ $user->fname }}"
                                        data-lname="{{ $user->lname }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}"
                                        
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.medical-staff.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this staff?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No staff found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($staff))
                <div class="mt-2">
                    {{ method_exists($staff, 'links') ? $staff->appends(request()->query())->links() : '' }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Staff Modal -->
<div class="modal fade" id="createStaffModal" tabindex="-1" role="dialog" aria-labelledby="createStaffLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createStaffLabel">Add Medical Staff</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.medical-staff.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>First Name</label>
                    <input type="text" name="fname" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Last Name</label>
                    <input type="text" name="lname" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        @foreach($roles as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>
            
            <div class="form-group">
                <label>Temporary Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStaffLabel">Edit Medical Staff</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editStaffForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>First Name</label>
                    <input type="text" name="fname" id="edit-fname" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Last Name</label>
                    <input type="text" name="lname" id="edit-lname" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="edit-email" class="form-control" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Role</label>
                    <select name="role" id="edit-role" class="form-control" required>
                        @foreach($roles as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>
            
            <div class="form-group">
                <label>Reset Password (optional)</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#editStaffModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');
        const fname = button.data('fname');
        const lname = button.data('lname');
        const email = button.data('email');
        const role = button.data('role');
        

        const modal = $(this);
        modal.find('#edit-id').val(id);
        modal.find('#edit-fname').val(fname);
        modal.find('#edit-lname').val(lname);
        modal.find('#edit-email').val(email);
        modal.find('#edit-role').val(role);
        
        

        const form = document.getElementById('editStaffForm');
        form.action = '{{ url('admin/medical-staff') }}/' + id;
    });

    // Clear form when modal hides
    $('#editStaffModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('editStaffForm');
        if (form) {
            form.reset();
            form.action = '';
        }
        const idField = document.getElementById('edit-id');
        if (idField) idField.value = '';
    });

    // Prevent double submit
    const editForm = document.getElementById('editStaffForm');
    if (editForm) {
        editForm.addEventListener('submit', function () {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';
            }
        });
    }
});
</script>
@endsection


