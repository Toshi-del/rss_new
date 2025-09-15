@extends('layouts.opd')

@section('opd-content')
<div class="card border-0 shadow-sm mb-3">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <a href="{{ route('opd.dashboard') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Back
      </a>
      <h5 class="mb-0"><i class="fa-solid fa-folder-tree me-2 text-primary"></i>Medical Test Categories</h5>
    </div>
  </div>
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-sm-6">
        <div class="input-group input-group-sm">
          <span class="input-group-text"><i class="fa-solid fa-search"></i></span>
          <input id="categoryFilter" type="text" class="form-control" placeholder="Filter categories and tests...">
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
        <div class="mb-4 category-card" data-cat-name="{{ strtolower($category->name) }}" data-cat-desc="{{ strtolower($category->description ?? '') }}">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
              <h6 class="mb-0">{{ $category->name }}</h6>
              @if($category->description)
                <small class="text-muted">{{ $category->description }}</small>
              @endif
            </div>
            @php $uniqueTests = $category->medicalTests->unique(function($t){ return strtolower($t->name ?? ''); }); @endphp
            <span class="badge text-bg-primary">{{ $uniqueTests->count() }} tests</span>
          </div>

          @if($uniqueTests->count() > 0)
          <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
            @foreach($uniqueTests as $test)
              <div class="col">
                <div class="border rounded p-3 h-100 d-flex flex-column test-item" data-test-name="{{ strtolower($test->name) }}" data-test-desc="{{ strtolower($test->description ?? '') }}">
                  <div class="d-flex align-items-start justify-content-between">
                    <div class="d-flex align-items-center">
                      <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;">
                        <i class="{{ opd_icon_for_test($test->name) }}"></i>
                      </div>
                      <div>
                        <div class="fw-semibold small">{{ $test->name }}</div>
                        @if($test->description)
                          <div class="text-muted small">{{ Str::limit($test->description, 80) }}</div>
                        @endif
                      </div>
                    </div>
                    @if(!is_null($test->price))
                      <span class="small fw-semibold text-primary">₱{{ number_format($test->price, 2) }}</span>
                    @endif
                  </div>
                  <div class="mt-auto pt-2 text-end">
                    <form method="POST" action="{{ route('opd.incoming-tests.add', $test->id) }}">
                      @csrf
                      <button class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-plus me-1"></i>Add to Incoming
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          @else
            <div class="text-muted small">No tests in this category.</div>
          @endif
          <hr class="mt-3">
        </div>
      @empty
        <div class="text-center text-muted py-5">No categories found.</div>
      @endforelse
    </div>

    @if(method_exists($categories, 'total'))
    <div class="d-flex justify-content-between align-items-center mt-3">
      <small class="text-muted">
        Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
      </small>
      <div>
        {{ $categories->onEachSide(1)->links('pagination::bootstrap-5') }}
      </div>
    </div>
    @endif
  </div>
</div>

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
  })();
</script>
@endsection






