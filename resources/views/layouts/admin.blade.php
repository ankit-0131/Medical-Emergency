<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Admin Panel - Medical Emergency System">
    <title>@yield('title', 'Admin') | MedAlert Admin</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<!-- ── Sidebar ── -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon"><i class="bi bi-hospital-fill"></i></div>
        <div>
            <div style="font-size:0.85rem; line-height:1.2">MedAlert</div>
            <div style="font-size:0.7rem; color: var(--text-muted); font-weight:400">Admin Panel</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section">Main</div>
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section">Management</div>
        <a href="{{ route('admin.emergencies') }}"
           class="sidebar-link {{ request()->routeIs('admin.emergencies*') ? 'active' : '' }}">
            <i class="bi bi-exclamation-triangle"></i> Emergencies
        </a>
        <a href="{{ route('admin.hospitals') }}"
           class="sidebar-link {{ request()->routeIs('admin.hospitals*') ? 'active' : '' }}">
            <i class="bi bi-hospital"></i> Hospitals
        </a>
        <a href="{{ route('admin.reports') }}"
           class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i> Reports
        </a>
    </nav>

    <!-- Logout at bottom -->
    <div style="margin-top: auto; padding-top: 16px; border-top: 1px solid var(--dark-border);">
        <div style="font-size:0.8rem; color: var(--text-muted); padding: 0 8px 8px;">
            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-link w-100" style="background:none;border:none;cursor:pointer;color:var(--text-muted);">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</aside>

<!-- ── Main Content ── -->
<main class="main-content">
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
<!-- Chart.js (for reports) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<!-- Custom Scripts -->
<script src="{{ asset('js/custom.js') }}"></script>
@yield('scripts')
</body>
</html>
