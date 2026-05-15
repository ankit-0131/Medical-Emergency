<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register | MedAlert Emergency System</title>

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
<body class="bg-slate-950 text-slate-200 font-sans antialiased min-h-screen relative flex items-center justify-center p-4 py-12" style="background-image: radial-gradient(circle at top left, #1E3A8A 0%, transparent 50%), radial-gradient(circle at bottom right, #0F172A 0%, transparent 50%); background-attachment: fixed;">
    
    <!-- Back Button -->
    <a href="/" class="absolute top-6 left-6 text-slate-400 hover:text-white flex items-center gap-2 transition-colors">
        <i data-lucide="arrow-left" class="w-5 h-5"></i> Back to Home
    </a>

    <div class="w-full max-w-2xl mt-8">
        <div class="glass-card p-6 md:p-10 shadow-2xl relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
            
            <!-- Logo -->
            <div class="flex flex-col items-center mb-8 relative z-10">
                <div class="bg-primary/20 p-3 rounded-xl mb-4 border border-primary/30 shadow-[0_0_15px_rgba(255,59,48,0.3)]">
                    <i data-lucide="activity" class="w-8 h-8 text-primary"></i>
                </div>
                <h1 class="text-2xl font-poppins font-bold text-white tracking-tight">Create Account</h1>
                <p class="text-sm text-slate-400 mt-1">Register to access emergency services</p>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-primary/10 border border-primary/30 text-primary relative z-10">
                    <div class="flex items-center gap-2 font-bold mb-2">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                        Please fix the following errors:
                    </div>
                    <ul class="list-disc pl-8 space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('register.post') }}" method="POST" class="relative z-10">
                @csrf
                
                <div class="space-y-6">
                    <!-- Personal Info Section -->
                    <div>
                        <h3 class="text-xs font-bold text-secondary-blue uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4"></i> Personal Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Full Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="user" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="John Doe">
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="mail" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="john@example.com">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-slate-300 mb-2">Phone Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="phone" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                                        class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="9876543210">
                                </div>
                            </div>

                            <!-- Blood Group -->
                            <div>
                                <label for="blood_group" class="block text-sm font-medium text-slate-300 mb-2">Blood Group</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="droplet" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <select id="blood_group" name="blood_group" required
                                        class="block w-full pl-10 pr-10 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none">
                                        <option value="" disabled selected class="text-slate-500">Select blood group</option>
                                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                            <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }} class="bg-slate-900 text-white">{{ $bg }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i data-lucide="chevron-down" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="lock" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <input type="password" id="password" name="password" required
                                        class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="Min 8 chars">
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Confirm Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="shield-check" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                        class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="Repeat password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full h-px bg-slate-800"></div>

                    <!-- Emergency Contact Section -->
                    <div>
                        <h3 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i data-lucide="heart-pulse" class="w-4 h-4"></i> Emergency Contact Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Contact Name -->
                            <div>
                                <label for="emergency_contact_name" class="block text-sm font-medium text-slate-300 mb-2">Contact Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="users" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" required
                                        class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="Jane Doe">
                                </div>
                            </div>

                            <!-- Contact Phone -->
                            <div>
                                <label for="emergency_contact_phone" class="block text-sm font-medium text-slate-300 mb-2">Contact Phone</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="phone-call" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" required
                                        class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="9876543211">
                                </div>
                            </div>

                            <!-- Relation -->
                            <div class="md:col-span-2">
                                <label for="relation" class="block text-sm font-medium text-slate-300 mb-2">Relation</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="network" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <select id="relation" name="relation" required
                                        class="block w-full pl-10 pr-10 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none">
                                        <option value="" disabled selected class="text-slate-500">Select relation</option>
                                        @foreach(['Father','Mother','Spouse','Sibling','Friend','Guardian','Other'] as $r)
                                            <option value="{{ $r }}" {{ old('relation') == $r ? 'selected' : '' }} class="bg-slate-900 text-white">{{ $r }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i data-lucide="chevron-down" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-4 px-4 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-primary hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:ring-offset-slate-900 transition-all hover:scale-[1.02] shadow-[0_0_15px_rgba(255,59,48,0.3)] mt-8">
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                        Create Account
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-800 text-center relative z-10">
                <p class="text-sm text-slate-400">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-semibold text-white hover:text-primary transition-colors">Login here</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
