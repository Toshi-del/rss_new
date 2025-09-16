<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPD - RSS Citi Health Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .navbar .nav-link{
            display:flex; align-items:center; gap:.35rem;
        }
        .navbar .nav-link .nav-icon{ opacity:.7; }
        .navbar .nav-link:hover .nav-icon{ opacity:1; }
        .navbar .nav-link.active{
            color:#0d6efd; font-weight:600; position:relative;
        }
        .navbar .nav-link.active::after{
            content:""; position:absolute; left:.65rem; right:.65rem; bottom:.35rem;
            height:2px; background:#0d6efd; border-radius:2px;
        }
        .brand-pill{ font-weight:600; padding:.25rem .5rem; border-radius:.5rem; background:rgba(13,110,253,.08); color:#0d6efd; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('opd.dashboard') }}">
                <i class="fa-solid fa-hospital-user me-2 text-primary"></i>
                <span class="brand-pill">OPD</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#opdNavbar" aria-controls="opdNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="opdNavbar">
               
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item d-flex align-items-center me-2 text-muted small">
                        <i class="fa-regular fa-user me-1"></i>{{ Auth::user()->lname ?? '' }}, {{ Auth::user()->fname ?? '' }}
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('opd-content')
    </main>

    <footer class="border-top bg-white py-3">
        <div class="container d-flex justify-content-between align-items-center text-muted small">
            <div>&copy; {{ date('Y') }} RSS Citi Health Services</div>
            <div class="d-none d-sm-flex align-items-center gap-3">
                <span><i class="fa-solid fa-shield-halved me-1"></i>Secure</span>
                <span><i class="fa-solid fa-circle-info me-1"></i>Help</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

