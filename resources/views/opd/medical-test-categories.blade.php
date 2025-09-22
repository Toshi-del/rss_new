@extends('layouts.opd')

@section('opd-content')
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4">
  <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex items-center justify-between">
    <div class="flex items-center">
      <a href="{{ route('opd.dashboard') }}" class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50 transition mr-3">
        <i class="fa-solid fa-arrow-left mr-2"></i> Back
      </a>
      <h2 class="m-0 flex items-center text-base font-semibold text-gray-900">
        <i class="fa-solid fa-folder-tree text-blue-600 mr-2"></i>
        Medical Test Categories
      </h2>
    </div>
  </div>
  <div class="p-4 sm:p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
      <div>
        <label class="sr-only" for="categoryFilter">Filter</label>
        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
          <span class="px-3 text-gray-500"><i class="fa-solid fa-search"></i></span>
          <input id="categoryFilter" type="text" class="w-full px-3 py-2 text-sm outline-none" placeholder="Filter categories and tests...">
        </div>
      </div>
      <div>
        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
          <span class="px-3 text-gray-500"><i class="fa-solid fa-calendar-day"></i></span>
          <input type="date" id="opdAppointmentDate" class="w-full px-3 py-2 text-sm outline-none" placeholder="Date">
        </div>
      </div>
      <div>
        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
          <span class="px-3 text-gray-500"><i class="fa-solid fa-clock"></i></span>
          <input type="time" id="opdAppointmentTime" class="w-full px-3 py-2 text-sm outline-none" placeholder="Time">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
            <span class="px-3 text-gray-500"><i class="fa-solid fa-user"></i></span>
            <input type="text" id="opdCustomerName" class="w-full px-3 py-2 text-sm outline-none" placeholder="Full name">
          </div>
        </div>
        <div>
          <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
            <span class="px-3 text-gray-500"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" id="opdCustomerEmail" class="w-full px-3 py-2 text-sm outline-none" placeholder="Email">
          </div>
        </div>
      </div>
    </div>

    @php
        function opd_icon_for_test($name) {
            $n = strtolower($name);
            if (str_contains($n, 'xray') || str_contains($n, 'x-ray')) return 'fa-solid fa-x-ray';
            if (str_contains($n, 'ecg') || str_contains($n, 'electro')) return 'fa-solid fa-heart-pulse';
            if (str_contains($n, 'blood') || str_contains($n, 'cbc')) return 'fa-solid fa-droplet';
            if (str_contains($n, 'urine')) return 'fa-solid fa-flask';
            if (str_contains($n, 'stool') || str_contains($n, 'fecal')) return 'fa-solid fa-clipboard-check';
            if (str_contains($n, 'vision') || str_contains($n, 'eye')) return 'fa-regular fa-eye';
            if (str_contains($n, 'drug')) return 'fa-solid fa-capsules';
            if (str_contains($n, 'preg') || str_contains($n, 'hcg')) return 'fa-solid fa-person-pregnant';
            if (str_contains($n, 'audio') || str_contains($n, 'hearing')) return 'fa-solid fa-ear-listen';
            if (str_contains($n, 'spirom') || str_contains($n, 'pulmo')) return 'fa-solid fa-wind';
            return 'fa-solid fa-vial-circle-check';
        }
      @endphp
    @php
        $categoryItems = method_exists($categories, 'getCollection')
            ? $categories->getCollection()->unique(function($c){ return strtolower($c->name ?? ''); })->values()
            : collect($categories)->unique(function($c){ return strtolower($c->name ?? ''); })->values();
    @endphp
    <div id="categoryList">
      @forelse($categoryItems as $category)
        <div class="mb-6 category-card" data-cat-name="{{ strtolower($category->name) }}" data-cat-desc="{{ strtolower($category->description ?? '') }}">
          <div class="flex items-center justify-between mb-2">
            <div>
              <h3 class="text-sm font-semibold text-gray-900">{{ $category->name }}</h3>
              @if($category->description)
                <p class="text-xs text-gray-500">{{ $category->description }}</p>
              @endif
            </div>
            @php $uniqueTests = $category->medicalTests->unique(function($t){ return strtolower($t->name ?? ''); }); @endphp
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $uniqueTests->count() }} tests</span>
          </div>

          @if($uniqueTests->count() > 0)
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($uniqueTests as $test)
              <div>
                <div class="border border-gray-200 rounded-lg p-3 h-full flex flex-col test-item" data-test-name="{{ strtolower($test->name) }}" data-test-desc="{{ strtolower($test->description ?? '') }}">
                  <div class="flex items-start justify-between">
                    <div class="flex items-center">
                      <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mr-2">
                        <i class="{{ opd_icon_for_test($test->name) }}"></i>
                      </div>
                      <div>
                        <div class="font-semibold text-sm text-gray-900">{{ $test->name }}</div>
                        @if($test->description)
                          <div class="text-xs text-gray-500">{{ Str::limit($test->description, 80) }}</div>
                        @endif
                      </div>
                    </div>
                    @if(!is_null($test->price))
                      <span class="text-xs font-semibold text-blue-700">₱{{ number_format($test->price, 2) }}</span>
                    @endif
                  </div>
                  <div class="mt-2 pt-2 text-right">
                    <form method="POST" action="{{ route('opd.incoming-tests.add', $test->id) }}" class="opd-add-form inline">
                      @csrf
                      <input type="hidden" name="appointment_date" value="">
                      <input type="hidden" name="appointment_time" value="">
                      <input type="hidden" name="customer_name" value="">
                      <input type="hidden" name="customer_email" value="">
                      <button class="inline-flex items-center px-3 py-1.5 rounded-lg border border-blue-600 text-blue-700 text-sm hover:bg-blue-50">
                        <i class="fa-solid fa-plus mr-2"></i>Add to Incoming
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          @else
            <div class="text-xs text-gray-500">No tests in this category.</div>
          @endif
          <div class="mt-3 border-t"></div>
        </div>
      @empty
        <div class="text-center text-gray-500 py-10">No categories found.</div>
      @endforelse
    </div>
    @if(method_exists($categories, 'total'))
    <div class="flex items-center justify-between mt-4">
      <small class="text-gray-500">
        Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
      </small>
      <div class="text-sm">
        {{ $categories->onEachSide(1)->links() }}
      </div>
    </div>
    @endif
  </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
  (function(){
    const input = document.getElementById('categoryFilter');
    if(!input) return;
    const cards = Array.from(document.querySelectorAll('.category-card'));
    input.addEventListener('input', function(){
      const q = this.value.toLowerCase();
      cards.forEach(card => {
        const name = card.getAttribute('data-cat-name') || '';
        const desc = card.getAttribute('data-cat-desc') || '';
        let match = name.includes(q) || desc.includes(q);
        if (!match) {
          const tests = Array.from(card.querySelectorAll('.test-item'));
          match = tests.some(t => {
            const tn = t.getAttribute('data-test-name') || '';
            const td = t.getAttribute('data-test-desc') || '';
            return tn.includes(q) || td.includes(q);
          });
        }
        card.style.display = match ? '' : 'none';
      });
    });

    // Init calendar pickers
    if (window.flatpickr) {
      flatpickr('#opdAppointmentDate', {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'M j, Y',
        allowInput: true
      });
      flatpickr('#opdAppointmentTime', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'h:i K',
        time_24hr: false,
        minuteIncrement: 5,
        allowInput: true
      });
    }

    // Sync appointment details into each form before submit
    function syncHiddenFields(form){
      const date = document.getElementById('opdAppointmentDate')?.value || '';
      const time = document.getElementById('opdAppointmentTime')?.value || '';
      const name = document.getElementById('opdCustomerName')?.value || '';
      const email = document.getElementById('opdCustomerEmail')?.value || '';
      form.querySelector('input[name="appointment_date"]').value = date;
      form.querySelector('input[name="appointment_time"]').value = time;
      form.querySelector('input[name="customer_name"]').value = name;
      form.querySelector('input[name="customer_email"]').value = email;
    }

    document.querySelectorAll('form.opd-add-form').forEach(f => {
      f.addEventListener('submit', function(){ syncHiddenFields(this); });
    });
  })();
</script>
@endsection






