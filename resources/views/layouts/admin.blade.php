<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Admin Panel - Medical Emergency System">
    <title>@yield('title', 'Admin') | MedAlert Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#111827] text-[#f8fafc] font-sans antialiased min-h-screen flex flex-col relative" x-data="{ mobileMenuOpen: false }">

    <!-- ── Navbar ── -->
    <nav class="sticky top-0 z-50 bg-[#0f172a]/80 backdrop-blur-md border border-slate-700/50 mx-4 mt-4 mb-6 px-6 py-3 rounded-xl flex items-center justify-between shadow-2xl">
        <!-- Brand -->
        <a href="/" class="flex items-center gap-3 text-white transition-colors group">
            <div class="bg-red-500 p-2 rounded-lg shadow-lg shadow-red-500/30">
                <i data-lucide="activity" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <span class="font-bold text-2xl tracking-tight text-white">MedAlert</span>
                <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold -mt-1">Admin Panel</span>
            </div>
        </a>

        <!-- Desktop Nav Links -->
        <div class="hidden lg:flex items-center gap-8">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-red-500' : 'text-slate-400 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </a>
            <a href="{{ route('admin.emergencies') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors {{ request()->routeIs('admin.emergencies*') ? 'text-red-500' : 'text-slate-400 hover:text-white' }}">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i> Emergencies
            </a>
            <a href="{{ route('admin.hospitals') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors {{ request()->routeIs('admin.hospitals*') ? 'text-red-500' : 'text-slate-400 hover:text-white' }}">
                <i data-lucide="hospital" class="w-4 h-4"></i> Hospitals
            </a>
            <a href="{{ route('admin.reports') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors {{ request()->routeIs('admin.reports') ? 'text-red-500' : 'text-slate-400 hover:text-white' }}">
                <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Reports
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-5 py-2 text-sm font-bold text-red-500 bg-[#1e293b] border border-red-500/50 rounded-lg hover:bg-red-500 hover:text-white transition-all duration-300">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                </button>
            </form>
        </div>

        <!-- Mobile Menu Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-slate-300 hover:text-white">
            <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
            <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" x-cloak></i>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition x-cloak class="lg:hidden fixed top-24 left-4 right-4 bg-[#1e293b] border border-slate-700/50 p-4 rounded-xl flex flex-col gap-4 z-[60] shadow-2xl">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'text-primary bg-primary/10' : 'text-slate-300' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
        </a>
        <a href="{{ route('admin.emergencies') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.emergencies*') ? 'text-primary bg-primary/10' : 'text-slate-300' }}">
            <i data-lucide="alert-triangle" class="w-5 h-5"></i> Emergencies
        </a>
        <a href="{{ route('admin.hospitals') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.hospitals*') ? 'text-primary bg-primary/10' : 'text-slate-300' }}">
            <i data-lucide="hospital" class="w-5 h-5"></i> Hospitals
        </a>
        <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.reports') ? 'text-primary bg-primary/10' : 'text-slate-300' }}">
            <i data-lucide="bar-chart-3" class="w-5 h-5"></i> Reports
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 mt-2 text-sm font-bold text-white bg-red-500 rounded-lg hover:bg-red-600 transition-all">
                <i data-lucide="log-out" class="w-4 h-4"></i> Logout
            </button>
        </form>
    </div>

    <!-- ── Main Content ── -->
    <main class="flex-grow min-w-0 bg-slate-950/50 pt-12">

        <div class="p-4 lg:p-8 w-full max-w-7xl mx-auto flex-1">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 px-4 py-3 rounded-xl bg-success-green/10 border border-success-green/30 text-success-green flex items-center gap-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 px-4 py-3 rounded-xl bg-primary/10 border border-primary/30 text-primary flex items-center gap-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Chart.js (for reports) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>
