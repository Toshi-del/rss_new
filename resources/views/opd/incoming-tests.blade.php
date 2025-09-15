@extends('layouts.opd')

@section('opd-content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <a href="{{ route('opd.dashboard') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Back
      </a>
      <h5 class="mb-0"><i class="fa-solid fa-inbox me-2 text-primary"></i>Incoming Tests</h5>
    </div>
    <a href="{{ route('opd.medical-test-categories') }}" class="btn btn-sm btn-outline-primary">
      <i class="fa-solid fa-plus me-1"></i> Add More
    </a>
  </div>
  <div class="card-body">
    @if(empty($incoming))
      <div class="text-center text-muted py-5">No incoming tests yet.</div>
    @else
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Name</th>
              <th>Category</th>
              <th class="text-end">Price</th>
              <th class="text-end">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($incoming as $test)
              <tr>
                <td>{{ $test['name'] }}</td>
                <td>{{ $test['category'] }}</td>
                <td class="text-end">₱{{ number_format($test['price'], 2) }}</td>
                <td class="text-end">
                  <form method="POST" action="{{ route('opd.incoming-tests.remove', $test['id']) }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2" class="text-end">Total</th>
              <th class="text-end">₱{{ number_format($total, 2) }}</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection

