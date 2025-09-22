@extends('layouts.opd')

@section('opd-content')
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
  <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex items-center justify-between">
    <div class="flex items-center">
      <a href="{{ route('opd.dashboard') }}" class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50 transition mr-3">
        <i class="fa-solid fa-arrow-left mr-2"></i> Back
      </a>
      <h2 class="m-0 flex items-center text-base font-semibold text-gray-900">
        <i class="fa-solid fa-inbox text-blue-600 mr-2"></i>
        Incoming Tests
      </h2>
    </div>
    <a href="{{ route('opd.medical-test-categories') }}" class="inline-flex items-center px-3 py-2 rounded-lg border border-blue-600 text-blue-700 text-sm hover:bg-blue-50 transition">
      <i class="fa-solid fa-plus mr-2"></i> Add More
    </a>
  </div>
  <div class="p-4 sm:p-6">
    @if(empty($incoming))
      <div class="text-center text-gray-500 py-10">No incoming tests yet.</div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-gray-200 text-left text-gray-600">
              <th class="py-3 px-2">Name</th>
              <th class="py-3 px-2">Medical Test</th>
              <th class="py-3 px-2">Date</th>
              <th class="py-3 px-2">Time</th>
              <th class="py-3 px-2">Customer</th>
              <th class="py-3 px-2">Email</th>
              <th class="py-3 px-2 text-right">Price</th>
              <th class="py-3 px-2 text-right">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach($incoming as $test)
              <tr class="hover:bg-gray-50">
                <td class="py-3 px-2">{{ $test['name'] }}</td>
                <td class="py-3 px-2">{{ $test['name'] }}</td>
                <td class="py-3 px-2">{{ $test['appointment_date'] ?? '—' }}</td>
                <td class="py-3 px-2">{{ $test['appointment_time'] ?? '—' }}</td>
                <td class="py-3 px-2">{{ $test['customer_name'] ?? '—' }}</td>
                <td class="py-3 px-2">{{ $test['customer_email'] ?? '—' }}</td>
                <td class="py-3 px-2 text-right">₱{{ number_format($test['price'], 2) }}</td>
                <td class="py-3 px-2 text-right">
                  <form method="POST" action="{{ route('opd.incoming-tests.remove', $test['id']) }}" class="inline">
                    @csrf
                    <button class="inline-flex items-center px-2.5 py-1.5 rounded-md border border-red-600 text-red-700 hover:bg-red-50">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="border-t border-gray-200">
              <th colspan="6" class="py-3 px-2 text-right text-gray-700">Total</th>
              <th class="py-3 px-2 text-right font-semibold">₱{{ number_format($total, 2) }}</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection

