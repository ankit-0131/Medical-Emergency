<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Fast Medical Help When Every Second Matters. Medical Emergency platform.">
    <title>{{ config('app.name', 'MediAlert') }} | Emergency Response</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Vite (Tailwind CSS) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            primary: '#ef4444', // Red
                            background: '#111827', // Very dark slate
                            surface: '#1f2937', // Dark slate
                            muted: '#9ca3af',
                        }
                    }
                }
            }
        </script>
    @endif

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            background-color: #111827;
            color: #f8fafc;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        [x-cloak] { display: none !important; }

        /* Navbar styling */
        .nav-link {
            color: #d1d5db;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-link:hover {
            color: #ffffff;
        }

        /* Floating SOS Button */
        .floating-sos {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background-color: #ef4444;
            color: white;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.5);
            z-index: 50;
            transition: transform 0.2s;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
        @media (max-width: 640px) {
            .floating-sos {
                right: auto;
                left: 1.5rem;
                bottom: 1.5rem;
                width: 3.5rem;
                height: 3.5rem;
            }
        }
        .floating-sos:hover {
            transform: scale(1.05);
            color: white;
        }
        .floating-sos-text {
            font-size: 0.6rem;
            font-weight: 700;
            margin-top: 2px;
        }
        .text-glow { text-shadow: 0 0 10px rgba(255, 59, 48, 0.5); }
    </style>
</head>
<body x-data="{ mobileMenuOpen: false }">

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
               class="flex items-center gap-2 text-sm font-semibold transition-colors text-slate-400 hover:text-white">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </a>
            <a href="{{ route('user.history') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors text-slate-400 hover:text-white">
                <i data-lucide="clock" class="w-4 h-4"></i> History
            </a>
            <a href="{{ route('user.hospitals') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors text-slate-400 hover:text-white">
                <i data-lucide="hospital" class="w-4 h-4"></i> Hospitals
            </a>
            <a href="#about"
               class="flex items-center gap-2 text-sm font-semibold transition-colors text-slate-400 hover:text-white">
                <i data-lucide="info" class="w-4 h-4"></i> About
            </a>
            <a href="{{ route('user.profile') }}"
               class="flex items-center gap-2 text-sm font-semibold transition-colors text-slate-400 hover:text-white">
                <i data-lucide="user" class="w-4 h-4"></i> Profile
            </a>

            <!-- Auth/Logout -->
            @if (Route::has('login'))
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-5 py-2 text-sm font-bold text-red-500 bg-[#1e293b] border border-red-500/50 rounded-lg hover:bg-red-500 hover:text-white transition-all duration-300">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                        </button>
                    </form>
                @else
                    <div class="flex items-center gap-6 ml-4">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-red-500 px-6 py-2.5 rounded-lg hover:bg-red-600 transition-colors shadow-lg shadow-red-500/30">Join Free</a>
                        @endif
                    </div>
                @endauth
            @endif
        </div>

        <!-- Mobile Menu Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-300 hover:text-white">
            <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
            <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" x-cloak></i>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden fixed top-24 left-4 right-4 bg-[#1e293b] border border-slate-700/50 p-4 rounded-xl flex flex-col gap-4 z-[60] shadow-2xl">
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 text-slate-300">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
        </a>
        <a href="{{ route('user.history') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 text-slate-300">
            <i data-lucide="clock" class="w-5 h-5"></i> History
        </a>
        <a href="{{ route('user.hospitals') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 text-slate-300">
            <i data-lucide="hospital" class="w-5 h-5"></i> Hospitals
        </a>
        <a href="#about" @click="mobileMenuOpen = false" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 text-slate-300">
            <i data-lucide="info" class="w-5 h-5"></i> About
        </a>
        <a href="{{ route('user.profile') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 text-slate-300">
            <i data-lucide="user" class="w-5 h-5"></i> Profile
        </a>
        @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-bold text-white bg-red-500 rounded-lg hover:bg-red-600 transition-all">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="w-full text-center py-3 text-sm font-bold text-white border border-slate-700 rounded-lg">Login</a>
            <a href="{{ route('register') }}" class="w-full text-center py-3 text-sm font-bold text-white bg-red-500 rounded-lg">Join Free</a>
        @endauth
    </div>

    <!-- Main Hero Section -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 pt-16 lg:pt-24 pb-24 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
        
        <!-- Left Content -->
        <div class="flex flex-col items-start gap-6">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-500/10 border border-red-500/20">
                <div class="w-1.5 h-1.5 rounded-full bg-red-500"></div>
                <span class="text-[0.65rem] font-bold text-red-500 uppercase tracking-wider">Emergency Response Network</span>
            </div>

            <!-- Heading -->
            <h1 class="text-[3.5rem] lg:text-[4rem] font-bold leading-[1.1] text-white tracking-tight">
                Fast Medical Help <br>
                When Every <br>
                <span class="text-[#ef4444]">Second Matters.</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg text-slate-400 max-w-lg leading-relaxed mt-2">
                Instantly connect with the nearest hospitals, ambulances, and life-saving resources. Your emergency deserves an immediate response.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mt-4 w-full sm:w-auto">
                <button {{ auth()->check() ? 'id=sos-button-secondary' : 'onclick=window.location.href=\''.route('login').'\'' }} class="flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-bold text-white bg-[#ef4444] rounded-lg hover:bg-red-600 transition-colors">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    Request Emergency Help
                </button>
                <a href="{{ route('user.hospitals') }}" class="flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-bold text-white bg-transparent border border-slate-700 rounded-lg hover:bg-slate-800 transition-colors">
                    Find Nearby Hospital
                </a>
            </div>

        </div>

        <!-- Right: Giant SOS Button -->
        <div class="relative w-full flex flex-col items-center justify-center mt-12 lg:mt-0 min-h-[400px]">
            <!-- Alert container (JS inserts messages here) -->
            <div id="sos-alerts" class="w-full max-w-md mx-auto absolute top-0 z-20"></div>

            <!-- Hidden URL for JS -->
            @auth
                <input type="hidden" id="sos-url" value="{{ route('user.sos') }}">
            @endauth

            <div class="relative z-10 flex flex-col items-center group">
                <div class="relative flex items-center justify-center w-64 h-64 mb-8">
                    <!-- Ripple animations -->
                    <div class="absolute inset-0 bg-[#ef4444]/20 rounded-full animate-ping" style="animation-duration: 2s;"></div>
                    <div class="absolute inset-4 bg-[#ef4444]/30 rounded-full animate-ping" style="animation-duration: 2s; animation-delay: 0.5s;"></div>
                    
                    <!-- Main Button -->
                    <button {{ auth()->check() ? 'id=sos-button' : 'onclick=window.location.href=\''.route('login').'\'' }} class="relative w-48 h-48 rounded-full bg-gradient-to-br from-[#ef4444] to-red-800 shadow-[0_0_50px_rgba(239,68,68,0.5)] border-4 border-white/10 flex flex-col items-center justify-center transform transition-transform duration-300 hover:scale-105 active:scale-95 cursor-pointer" title="Press to send emergency SOS">
                        <i data-lucide="shield-alert" class="w-16 h-16 text-white mb-2"></i>
                        <span class="text-white font-black text-3xl tracking-widest text-glow">SOS</span>
                    </button>
                </div>
                
                <h3 class="text-2xl font-bold text-white mb-2">Emergency Response</h3>
                <p class="text-slate-400 text-center max-w-sm">
                    Tap the button to trigger an emergency alert. Your live location will be captured automatically.
                </p>
                <p id="sos-status-msg" class="text-orange-400 font-semibold mt-4 h-6 text-sm"></p>
            </div>
        </div>
    </main>

    <!-- ── Why MedAlert Section ── -->
    <section id="about" class="py-24 bg-[#0f172a]/30 border-y border-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">The MedAlert Difference</h2>
                <p class="text-slate-400 max-w-2xl mx-auto">
                    We aren't just an app; we are a specialized emergency infrastructure designed to close the gap between critical incidents and medical professionals.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Stat 1 -->
                <div class="glass-card p-8 text-center border-slate-800">
                    <div class="text-4xl font-black text-red-500 mb-2">50+</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Partner Hospitals</div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Direct integration with top-tier medical facilities in your region.
                    </p>
                </div>
                <!-- Stat 2 -->
                <div class="glass-card p-8 text-center border-slate-800">
                    <div class="text-4xl font-black text-blue-500 mb-2">120+</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Active Responders</div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        A network of verified ambulance services and emergency teams.
                    </p>
                </div>
                <!-- Stat 3 -->
                <div class="glass-card p-8 text-center border-slate-800">
                    <div class="text-4xl font-black text-green-500 mb-2">8 min</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Avg. Response Time</div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Optimized routing and instant alerts ensure help arrives faster.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center bg-[#1e293b]/30 p-8 rounded-3xl border border-slate-800">
                <div class="flex flex-col gap-6">
                    <h3 class="text-2xl font-bold text-white">Our Commitment to Privacy</h3>
                    <p class="text-slate-400 leading-relaxed">
                        In an emergency, data is vital—but privacy is paramount. MedAlert uses bank-grade encryption to ensure your medical history and location data are only shared with authorized emergency responders during an active SOS event.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-500"></i> No third-party data selling
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-500"></i> Local storage for health records
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-500"></i> One-tap account deletion
                        </li>
                    </ul>
                </div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-slate-700 bg-slate-900/50 p-4">
                    <img src="{{ asset('images/privacy-illustration.png') }}" alt="MedAlert Privacy Illustration" class="w-full h-auto rounded-xl">
                    <div class="absolute inset-0 bg-red-500/5 mix-blend-overlay pointer-events-none"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Footer Section ── -->
    <footer class="bg-[#0b0f19] border-t border-slate-800/80 pt-16 pb-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                
                <!-- Left: Branding & Bio -->
                <div class="flex flex-col gap-6">
                    <a href="/" class="flex items-center gap-3 text-white transition-colors group">
                        <div class="bg-red-500 p-2 rounded-lg shadow-lg shadow-red-500/30">
                            <i data-lucide="activity" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-white">MedAlert</span>
                    </a>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Providing an intelligent, fast-response medical emergency ecosystem. Saving lives through high-fidelity resource management.
                    </p>
                </div>

                <!-- Column 2: Platform Grid -->
                <div class="flex flex-col gap-5">
                    <h4 class="text-xs font-bold text-red-500 uppercase tracking-widest">Platform Grid</h4>
                    <ul class="flex flex-col gap-3">
                        <li>
                            <a href="{{ route('user.dashboard') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Emergency Dispatch</a>
                        </li>
                        <li>
                            <a href="{{ route('user.hospitals') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Hospital Uplink</a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-slate-400 hover:text-white transition-colors">Active Node Grid</a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Legal Protocols -->
                <div class="flex flex-col gap-5">
                    <h4 class="text-xs font-bold text-red-500 uppercase tracking-widest">Legal Protocols</h4>
                    <ul class="flex flex-col gap-3">
                        <li>
                            <a href="#" class="text-sm text-slate-400 hover:text-white transition-colors">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-slate-400 hover:text-white transition-colors">Terms of Utility</a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-slate-400 hover:text-white transition-colors">HIPAA Compliance</a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-slate-400 hover:text-white transition-colors">Developer Hub</a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Hotline Card -->
                <div class="glass-card p-6 border-red-500/20 shadow-lg shadow-red-500/5 relative overflow-hidden bg-gradient-to-br from-red-950/10 via-slate-900/40 to-slate-900/80 rounded-2xl">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-red-500/5 rounded-full blur-2xl"></div>
                    <h4 class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-2">Hotline Protocol</h4>
                    <div class="text-2xl font-black text-white tracking-tight mb-2">911 or 108</div>
                    <p class="text-[10px] text-slate-500 leading-relaxed uppercase tracking-wider mb-4">
                        Direct satellite bypass enabled. 24/7 Command Center Monitoring.
                    </p>
                    <a href="mailto:sos@medalert.com" class="inline-flex items-center gap-2 text-xs font-bold text-red-400 hover:text-red-300 transition-colors">
                        <i data-lucide="mail" class="w-4 h-4"></i> sos@medalert.com
                    </a>
                </div>

            </div>

            <!-- Bottom Divider -->
            <div class="border-t border-slate-800/60 pt-8 mt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500 tracking-wider">
                    &copy; 2026 MEDALERT GLOBAL SYSTEMS. ALL RIGHTS RESERVED.
                </p>
                <div class="flex items-center gap-6 text-xs text-slate-500 tracking-widest uppercase">
                    <span>Encrypted Data Secure</span>
                    <span class="text-slate-800">|</span>
                    <span>Mission Critical Readiness</span>
                </div>
            </div>

        </div>
    </footer>

    <!-- Floating SOS Action Button (Bottom Right) -->
    <button {{ auth()->check() ? 'id=sos-button-floating' : 'onclick=window.location.href=\''.route('login').'\'' }} class="floating-sos group">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:animate-pulse text-white">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
        </svg>
        <span class="floating-sos-text text-white">SOS</span>
    </button>

    @auth
    <!-- ══ SOS Success Overlay Modal ══ -->
    <div id="sos-success-overlay" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#111827]/80 backdrop-blur-sm" style="display:none;">
        <div class="bg-[#1e293b] border border-red-500/30 shadow-[0_0_30px_rgba(239,68,68,0.2)] p-8 rounded-xl max-w-sm w-full text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-orange-400"></div>
            
            <div class="w-20 h-20 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                <div class="absolute inset-0 border-4 border-red-500 rounded-full animate-ping opacity-50"></div>
                <i data-lucide="check-circle" class="w-10 h-10 text-red-500"></i>
            </div>
            
            <h2 class="text-2xl font-black text-white mb-2">Emergency Sent!</h2>
            <p class="text-sm text-slate-400 mb-8">
                Your SOS has been sent successfully. Help is on the way.
                <br>Emergency contacts and admin have been notified.
            </p>
            
            <div class="flex flex-col gap-3">
                <a id="add-details-link" data-base="{{ url('/user/emergency') }}" href="#" class="w-full flex items-center justify-center gap-2 py-3 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-red-500 hover:bg-red-600 transition-all shadow-lg" style="display:none;">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Add More Details
                </a>
                
                <a id="map-link" href="#" target="_blank" class="w-full flex items-center justify-center gap-2 py-3 px-4 border border-slate-700 rounded-xl text-sm font-bold text-white bg-slate-800 hover:bg-slate-700 transition-all" style="display:none;">
                    <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i> View My Location
                </a>
                
                <button onclick="SosHandler.closeModal()" class="w-full py-3 px-4 text-sm font-bold text-slate-400 hover:text-white transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Include Geolocation script to make the SOS button work -->
    <script src="{{ asset('js/geolocation.js') }}"></script>
    <script>
        // Make sure the secondary SOS buttons also trigger the SOS logic
        document.addEventListener('DOMContentLoaded', () => {
            const secondaryBtn = document.getElementById('sos-button-secondary');
            const floatingBtn = document.getElementById('sos-button-floating');
            const mainBtn = document.getElementById('sos-button');
            
            if (secondaryBtn && mainBtn) {
                secondaryBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    mainBtn.click();
                });
            }
            if (floatingBtn && mainBtn) {
                floatingBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    mainBtn.click();
                });
            }
        });
    </script>
    @endauth

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
