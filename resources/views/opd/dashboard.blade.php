@extends('layouts.opd')

@section('opd-content')
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('opd.dashboard') }}">OPD</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
  </ol>
  </nav>

<div class="card border-0 shadow-sm mb-4 tile-modern hero-modern">
  <div class="card-body d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
      <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center me-3" style="width:56px;height:56px;">
        <i class="fa-solid fa-user"></i>
      </div>
      <div>
        <h5 class="mb-1">Welcome, {{ Auth::user()->fname ?? 'OPD' }}!</h5>
        <div class="text-muted small">Walk‑in patient portal</div>
      </div>
    </div>
    <div>
      <a href="{{ route('opd.medical-test-categories') }}" class="btn btn-sm btn-primary">
        <i class="fa-solid fa-compass me-1"></i> Start browsing
      </a>
    </div>
  </div>
</div>

<div class="row g-3 align-items-stretch">
  <div class="col-md-6 d-flex">
    <div class="card border-0 shadow-sm h-100 card-tile tile-modern tile-primary">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <div class="text-muted small">Browse</div>
          <h6 class="mb-1">Medical Test Categories</h6>
          <div class="text-muted small mb-2">Explore tests available for walk‑in patients</div>
          <a href="{{ route('opd.medical-test-categories') }}" class="stretched-link text-decoration-none"></a>
          <a href="{{ route('opd.medical-test-categories') }}" class="btn btn-sm btn-primary position-relative">
            <i class="fa-solid fa-list me-1"></i> View Categories
          </a>
        </div>
        <div class="text-primary opacity-75">
          <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center tile-icon" style="width:48px;height:48px;">
            <i class="fa-solid fa-folder-tree"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-6 d-flex">
    <div class="card border-0 shadow-sm h-100 card-tile tile-modern tile-info">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <div class="text-muted small">Queue</div>
          <h6 class="mb-1">Incoming Tests</h6>
          <div class="text-muted small mb-2">Review and manage tests you added</div>
          <a href="{{ route('opd.incoming-tests') }}" class="stretched-link text-decoration-none"></a>
          <a href="{{ route('opd.incoming-tests') }}" class="btn btn-sm btn-outline-primary">
            <i class="fa-solid fa-inbox me-1"></i>
            View Incoming
            <span class="badge bg-primary-subtle text-primary ms-2">{{ is_countable($incoming ?? []) ? count($incoming ?? []) : 0 }}</span>
          </a>
        </div>
        <div class="text-primary opacity-75 text-end">
          <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center ms-auto mb-1 tile-icon" style="width:48px;height:48px;">
            <i class="fa-solid fa-inbox"></i>
          </div>
          <div class="small text-muted">Estimated Total</div>
          <div class="fw-semibold">₱{{ number_format($total ?? 0, 2) }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mt-1">
  <div class="col-md-6 d-flex">
    <div class="card border-0 shadow-sm h-100 card-tile tile-modern tile-neutral">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <div class="text-muted small">Preview</div>
          <h6 class="mb-1">Result Template</h6>
          <div class="text-muted small mb-2">UI-only sample of result card</div>
          <a href="{{ route('opd.result') }}" class="stretched-link text-decoration-none"></a>
          <a href="{{ route('opd.result') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-file-lines me-1"></i> Open Preview
          </a>
        </div>
        <div class="text-primary opacity-75">
          <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center tile-icon" style="width:48px;height:48px;">
            <i class="fa-solid fa-file-medical"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .card-tile { transition: box-shadow .2s ease, transform .15s ease; min-height: 112px; }
  .card-tile .card-body { padding: .9rem 1rem; }
  .card-tile:hover { box-shadow: 0 .5rem 1.25rem rgba(31,45,61,.08); transform: translateY(-2px); }
  .card-tile:active { transform: translateY(0); }
  .card-tile .btn { transition: all .15s ease; }
  .tile-icon { transition: background-color .2s ease, transform .2s ease; width:40px !important; height:40px !important; }
  .card-tile h6 { margin-bottom: .25rem !important; }
  .card-tile .small { line-height: 1.2; }
  .card-tile:hover .tile-icon { background-color: rgba(13,110,253,.15) !important; transform: scale(1.05); }
</style>
<style>
  /* Modern aesthetic */
  .tile-modern { position: relative; border: 1px solid rgba(33,37,41,.06); border-radius: .75rem; background: rgba(255,255,255,.92); backdrop-filter: saturate(160%) blur(6px); }
  .tile-modern::before { content: ""; position: absolute; left: 0; top: 0; right: 0; height: 3px; background: linear-gradient(90deg, #0d6efd, #6f42c1); }
  .tile-primary::before { background: linear-gradient(90deg, #0d6efd, #66b2ff); }
  .tile-info::before { background: linear-gradient(90deg, #20c997, #0d6efd); }
  .tile-neutral::before { background: linear-gradient(90deg, #6c757d, #adb5bd); }
  .tile-primary .tile-icon { background-color: rgba(13,110,253,.12) !important; color: #0d6efd; }
  .tile-info .tile-icon { background-color: rgba(32,201,151,.12) !important; color: #20c997; }
  .tile-neutral .tile-icon { background-color: rgba(108,117,125,.12) !important; color: #6c757d; }
  .tile-modern .btn { border-radius: .5rem; }
  .tile-modern:hover { box-shadow: 0 .75rem 1.75rem rgba(16,24,40,.08); }
  .hero-modern { background: linear-gradient(180deg, rgba(13,110,253,.06), rgba(255,255,255,1)); border: 1px solid rgba(13,110,253,.08); }
</style>
@endsection





  
