<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Smart Medical Emergency Assistance & Alert Management System - Quick emergency response at one tap.">
    <title>@yield('title', 'Dashboard') | Medical Emergency</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<!-- ── Navbar ── -->
<nav class="navbar-custom">
    <div class="container d-flex align-items-center justify-content-between">
        <!-- Brand -->
        <a href="{{ route('user.dashboard') }}" class="navbar-brand-custom">
            <span class="brand-icon"><i class="bi bi-hospital-fill text-white"></i></span>
            <span>MedAlert</span>
        </a>

        <!-- Nav Links -->
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('user.dashboard') }}"
               class="nav-link-custom {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid me-1"></i> Dashboard
            </a>
            <a href="{{ route('user.history') }}"
               class="nav-link-custom {{ request()->routeIs('user.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-1"></i> History
            </a>
            <a href="{{ route('user.hospitals') }}"
               class="nav-link-custom {{ request()->routeIs('user.hospitals') ? 'active' : '' }}">
                <i class="bi bi-hospital me-1"></i> Hospitals
            </a>
            <a href="{{ route('user.profile') }}"
               class="nav-link-custom {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                <i class="bi bi-person me-1"></i> Profile
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-outline-custom">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- ── Main Content ── -->
<main class="container py-4">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert-custom alert-success auto-dismiss mb-3">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom alert-danger auto-dismiss mb-3">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom Scripts -->
<script src="{{ asset('js/custom.js') }}"></script>
@yield('scripts')
</body>
</html>
