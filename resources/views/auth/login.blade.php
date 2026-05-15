<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | MedAlert Emergency System</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Vite (Tailwind CSS) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            poppins: ['Poppins', 'sans-serif'],
                        },
                        colors: {
                            primary: '#FF3B30',
                            'dark-navy': '#0F172A',
                            'secondary-blue': '#1E3A8A',
                            'soft-gray': '#CBD5E1',
                            'success-green': '#22C55E',
                        }
                    }
                }
            }
        </script>
        <style>
            .glass-card {
                background: rgba(15, 23, 42, 0.6);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 1rem;
            }
        </style>
    @endif
</head>
<body class="bg-slate-950 text-slate-200 font-sans antialiased min-h-screen relative flex items-center justify-center p-4" style="background-image: radial-gradient(circle at top left, #1E3A8A 0%, transparent 50%), radial-gradient(circle at bottom right, #0F172A 0%, transparent 50%); background-attachment: fixed;">
    
    <!-- Back Button -->
    <a href="/" class="absolute top-6 left-6 text-slate-400 hover:text-white flex items-center gap-2 transition-colors">
        <i data-lucide="arrow-left" class="w-5 h-5"></i> Back to Home
    </a>

    <div class="w-full max-w-md">
        <div class="glass-card p-8 shadow-2xl relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
            
            <!-- Logo -->
            <div class="flex flex-col items-center mb-8 relative z-10">
                <div class="bg-primary/20 p-3 rounded-xl mb-4 border border-primary/30 shadow-[0_0_15px_rgba(255,59,48,0.3)]">
                    <i data-lucide="activity" class="w-8 h-8 text-primary"></i>
                </div>
                <h1 class="text-2xl font-poppins font-bold text-white tracking-tight">Welcome Back</h1>
                <p class="text-sm text-slate-400 mt-1">Sign in to your MedAlert account</p>
            </div>

            <!-- Flash Messages -->
            @if($errors->any())
                <div class="mb-6 px-4 py-3 rounded-xl bg-primary/10 border border-primary/30 text-primary flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                    <p class="text-sm font-medium">{{ $errors->first() }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 px-4 py-3 rounded-xl bg-success-green/10 border border-success-green/30 text-success-green flex items-start gap-3">
                    <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0 mt-0.5"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-5 relative z-10">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-5 h-5 text-slate-500"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                            placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-slate-500"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="rounded bg-slate-900 border-slate-700 text-primary focus:ring-primary/50 focus:ring-offset-slate-950">
                        <span class="text-sm text-slate-400 group-hover:text-slate-300 transition-colors">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:ring-offset-slate-900 transition-all hover:scale-[1.02] shadow-[0_0_15px_rgba(255,59,48,0.3)]">
                    Sign In
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-800 text-center relative z-10">
                <p class="text-sm text-slate-400">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-white hover:text-primary transition-colors">Register here</a>
                </p>
            </div>

            <!-- Demo Credentials -->
            <div class="mt-6 p-4 rounded-xl bg-secondary-blue/10 border border-secondary-blue/30 relative z-10">
                <div class="flex items-center gap-2 text-secondary-blue font-semibold text-xs uppercase tracking-wider mb-2">
                    <i data-lucide="key" class="w-4 h-4"></i> Demo Credentials
                </div>
                <div class="text-sm text-slate-300 flex flex-col gap-1">
                    <div><span class="text-slate-500">Admin:</span> admin@medicalapp.com / admin@123</div>
                    <div><span class="text-slate-500">User:</span> user@medicalapp.com / user@123</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
