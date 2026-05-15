<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Smart Medical Emergency Assistance & Alert Management System - Quick emergency response at one tap.">
    <title>@yield('title', 'Dashboard') | Medical Emergency</title>

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
            <span class="font-bold text-2xl tracking-tight text-white">MedAlert</span>
        </a>

        <!-- Desktop Nav Links -->
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('user.dashboard') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors {{ request()->routeIs('user.dashboard') ? 'text-red-500' : 'text-slate-400 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </a>
            <a href="{{ route('user.history') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors {{ request()->routeIs('user.history') ? 'text-red-500' : 'text-slate-400 hover:text-white' }}">
                <i data-lucide="clock" class="w-4 h-4"></i> History
            </a>
            <a href="{{ route('user.hospitals') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors {{ request()->routeIs('user.hospitals') ? 'text-red-500' : 'text-slate-400 hover:text-white' }}">
                <i data-lucide="hospital" class="w-4 h-4"></i> Hospitals
            </a>
            <a href="{{ route('user.profile') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors {{ request()->routeIs('user.profile') ? 'text-red-500' : 'text-slate-400 hover:text-white' }}">
                <i data-lucide="user" class="w-4 h-4"></i> Profile
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
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-300 hover:text-white">
            <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
            <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" x-cloak></i>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden fixed top-24 left-4 right-4 bg-[#1e293b] border border-slate-700/50 p-4 rounded-xl flex flex-col gap-4 z-[60] shadow-2xl">
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('user.dashboard') ? 'text-primary bg-primary/10' : 'text-slate-300' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
        </a>
        <a href="{{ route('user.history') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('user.history') ? 'text-primary bg-primary/10' : 'text-slate-300' }}">
            <i data-lucide="clock" class="w-5 h-5"></i> History
        </a>
        <a href="{{ route('user.hospitals') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('user.hospitals') ? 'text-primary bg-primary/10' : 'text-slate-300' }}">
            <i data-lucide="hospital" class="w-5 h-5"></i> Hospitals
        </a>
        <a href="{{ route('user.profile') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('user.profile') ? 'text-primary bg-primary/10' : 'text-slate-300' }}">
            <i data-lucide="user" class="w-5 h-5"></i> Profile
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 mt-2 text-sm font-bold text-white bg-primary rounded-lg hover:bg-red-600 transition-all">
                <i data-lucide="log-out" class="w-4 h-4"></i> Logout
            </button>
        </form>
    </div>

    <!-- ── Main Content ── -->
    <main class="flex-grow container mx-auto px-4 lg:px-8 pt-8 pb-12 w-full max-w-7xl">
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
    </main>

    <!-- Floating SOS Button -->
    <a href="{{ route('user.dashboard') }}?sos=true" class="fixed bottom-8 right-8 sm:right-8 left-8 sm:left-auto z-50 group flex flex-col items-center">
        <div class="absolute inset-0 bg-primary rounded-full blur-xl opacity-50 group-hover:opacity-80 transition-opacity animate-pulse"></div>
        <button class="relative flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white shadow-2xl border-2 border-white/20 transform group-hover:scale-110 transition-transform duration-300">
            <i data-lucide="phone-call" class="w-7 h-7"></i>
        </button>
        <span class="mt-2 text-xs font-bold text-primary text-glow opacity-0 group-hover:opacity-100 transition-opacity duration-300">EMERGENCY SOS</span>
    </a>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>
