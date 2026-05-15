@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 relative z-10">
    <!-- ══ LEFT: SOS Section & Info ══ -->
    <div class="lg:col-span-7 flex flex-col gap-6">
        <div class="glass-card p-8 text-center relative overflow-hidden flex flex-col items-center justify-center min-h-[450px]">
            <!-- Decorative Glows -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl mix-blend-screen"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl mix-blend-screen"></div>

            <!-- Alert container (JS inserts messages here) -->
            <div id="sos-alerts" class="w-full max-w-md mx-auto absolute top-6 z-20"></div>

            <!-- Hidden URL for JS -->
            <input type="hidden" id="sos-url" value="{{ route('user.sos') }}">

            <!-- SOS Button -->
            <div class="relative z-10 flex flex-col items-center group">
                <div class="relative flex items-center justify-center w-64 h-64 mb-8">
                    <!-- Ripple animations -->
                    <div class="absolute inset-0 bg-primary/20 rounded-full animate-ping" style="animation-duration: 2s;"></div>
                    <div class="absolute inset-4 bg-primary/30 rounded-full animate-ping" style="animation-duration: 2s; animation-delay: 0.5s;"></div>
                    
                    <!-- Main Button -->
                    <button id="sos-button" class="relative w-48 h-48 rounded-full bg-gradient-to-br from-primary to-red-700 shadow-[0_0_50px_rgba(255,59,48,0.5)] border-4 border-white/10 flex flex-col items-center justify-center transform transition-transform duration-300 hover:scale-105 active:scale-95" title="Press to send emergency SOS">
                        <i data-lucide="shield-alert" class="w-16 h-16 text-white mb-2"></i>
                        <span class="text-white font-black text-3xl tracking-widest text-glow">SOS</span>
                    </button>
                </div>
                
                <h3 class="text-2xl font-bold text-white mb-2">Emergency Response</h3>
                <p class="text-slate-400 max-w-sm">
                    Tap the button to trigger an emergency alert. Your live location will be captured automatically.
                </p>
                <p id="sos-status-msg" class="text-orange-400 font-semibold mt-4 h-6 text-sm"></p>
            </div>
        </div>

        <!-- NEW: Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nearby Facilities -->
            <div class="glass-card p-6 flex flex-col">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="hospital" class="w-4 h-4 text-blue-400"></i> Nearby Facilities
                </h3>
                <div class="space-y-3 flex-1">
                    @forelse($nearbyHospitals as $hospital)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900/50 border border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                                    <i data-lucide="building-2" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-white truncate max-w-[120px]">{{ $hospital->name }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $hospital->address }}</div>
                                </div>
                            </div>
                            <a href="{{ route('user.hospitals') }}" class="text-slate-500 hover:text-white transition-colors">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 text-center py-4">No facilities found nearby.</p>
                    @endforelse
                </div>
                <a href="{{ route('user.hospitals') }}" class="mt-4 text-xs font-bold text-blue-400 hover:text-blue-300 flex items-center gap-1">
                    View all facilities <i data-lucide="arrow-right" class="w-3 h-3"></i>
                </a>
            </div>

            <!-- Emergency Contacts -->
            <div class="glass-card p-6 flex flex-col">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="users" class="w-4 h-4 text-primary"></i> Emergency Contacts
                </h3>
                <div class="space-y-3 flex-1">
                    @if($user->emergency_contact_name)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900/50 border border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                    {{ substr($user->relation ?? 'P', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-white">{{ $user->emergency_contact_name }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $user->relation }} • {{ $user->emergency_contact_phone }}</div>
                                </div>
                            </div>
                            <a href="tel:{{ $user->emergency_contact_phone }}" class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-500">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </a>
                        </div>
                    @endif

                    @if($user->emergency_contact2_name)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900/50 border border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500 font-bold text-xs">
                                    {{ substr($user->emergency_contact2_relation ?? 'S', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-white">{{ $user->emergency_contact2_name }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $user->emergency_contact2_relation }} • {{ $user->emergency_contact2_phone }}</div>
                                </div>
                            </div>
                            <a href="tel:{{ $user->emergency_contact2_phone }}" class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-500">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </a>
                        </div>
                    @endif

                    @if(!$user->emergency_contact_name && !$user->emergency_contact2_name)
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-slate-500 mb-3">
                                <i data-lucide="user-plus" class="w-6 h-6"></i>
                            </div>
                            <p class="text-xs text-slate-500 max-w-[150px]">No emergency contacts saved yet.</p>
                        </div>
                    @endif
                </div>
                <a href="{{ route('user.profile') }}" class="mt-4 text-xs font-bold text-primary hover:text-red-400 flex items-center gap-1">
                    Manage Contacts <i data-lucide="settings" class="w-3 h-3"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- ══ RIGHT: Info Panel ══ -->
    <div class="lg:col-span-5 flex flex-col gap-6">

        <!-- User Info Card -->
        <div class="glass-card p-6">
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-800">
                <div class="w-14 h-14 bg-secondary-blue/20 rounded-full flex items-center justify-center border border-secondary-blue/30 text-secondary-blue">
                    <i data-lucide="user" class="w-7 h-7"></i>
                </div>
                <div>
                    <div class="font-bold text-lg text-white">{{ auth()->user()->name }}</div>
                    <div class="text-sm text-slate-400">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-800">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-2">
                        <i data-lucide="droplet" class="w-4 h-4 text-primary"></i> Blood Group
                    </div>
                    <div class="font-bold text-xl text-primary mt-1">
                        {{ auth()->user()->blood_group ?? 'Not set' }}
                    </div>
                </div>
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-800">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 text-success-green"></i> Phone
                    </div>
                    <div class="font-bold text-lg text-white mt-1">
                        {{ auth()->user()->phone ?? 'Not set' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Last Emergency Status -->
        <div class="glass-card p-6">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="activity" class="w-4 h-4 text-secondary-blue"></i> Last Emergency Status
            </h3>
            
            @if($latestEmergency)
                <div class="bg-slate-900/50 rounded-xl p-5 border border-slate-800 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-2 h-full {{ $latestEmergency->status == 'resolved' ? 'bg-success-green' : 'bg-primary' }}"></div>
                    
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold
                            {{ $latestEmergency->status == 'resolved' ? 'bg-success-green/20 text-success-green' : 'bg-orange-500/20 text-orange-400' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $latestEmergency->status == 'resolved' ? 'bg-success-green' : 'bg-orange-400' }}"></span>
                            {{ ucfirst(str_replace('_', ' ', $latestEmergency->status)) }}
                        </span>
                        
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-primary/20 text-primary">
                            {{ ucfirst($latestEmergency->priority) }} Priority
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-2 text-sm text-slate-400 mb-4">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        {{ $latestEmergency->created_at->diffForHumans() }}
                    </div>
                    
                    @if($latestEmergency->latitude)
                        <a href="{{ $latestEmergency->map_link }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-secondary-blue hover:text-blue-400 transition-colors bg-secondary-blue/10 px-4 py-2 rounded-lg w-full justify-center">
                            <i data-lucide="map-pin" class="w-4 h-4"></i> View Location on Map
                        </a>
                    @endif
                </div>
            @else
                <div class="text-center py-8 bg-slate-900/50 rounded-xl border border-slate-800">
                    <div class="w-12 h-12 bg-success-green/10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-success-green"></i>
                    </div>
                    <p class="text-sm text-slate-400">No emergency requests yet. You're safe!</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="glass-card p-6">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="zap" class="w-4 h-4 text-orange-400"></i> Quick Actions
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('user.hospitals') }}" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-slate-900/50 border border-slate-800 hover:bg-slate-800 transition-all group text-center">
                    <div class="p-2 bg-blue-500/10 rounded-lg text-blue-400">
                        <i data-lucide="hospital" class="w-5 h-5"></i>
                    </div>
                    <span class="text-[10px] font-bold text-slate-300">Hospitals</span>
                </a>
                <a href="{{ route('user.history') }}" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-slate-900/50 border border-slate-800 hover:bg-slate-800 transition-all group text-center">
                    <div class="p-2 bg-purple-500/10 rounded-lg text-purple-400">
                        <i data-lucide="history" class="w-5 h-5"></i>
                    </div>
                    <span class="text-[10px] font-bold text-slate-300">History</span>
                </a>
            </div>
        </div>

        <!-- Live System Activity -->
        <div class="glass-card p-6">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="activity" class="w-4 h-4 text-green-500"></i> Live Network Status
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-[11px] text-slate-300 font-medium">Global Emergency Line</span>
                    </div>
                    <span class="text-[10px] font-bold text-green-500 uppercase">Online</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-400"></i>
                        <span class="text-[11px] text-slate-300 font-medium">GPS Signal</span>
                    </div>
                    <span class="text-[10px] font-bold text-blue-400 uppercase">Strong</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-purple-400"></i>
                        <span class="text-[11px] text-slate-300 font-medium">Encryption</span>
                    </div>
                    <span class="text-[10px] font-bold text-purple-400 uppercase">Active</span>
                </div>
                <div class="pt-2 border-t border-slate-800/50 mt-2">
                    <div class="text-[9px] text-slate-500 italic flex items-center gap-1">
                        <i data-lucide="info" class="w-3 h-3"></i> Encrypted end-to-peer connection active.
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- ══ SOS Success Overlay Modal ══ -->
<div id="sos-success-overlay" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" style="display:none;">
    <div class="glass-card border-primary/30 shadow-[0_0_30px_rgba(255,59,48,0.2)] p-8 max-w-sm w-full text-center relative overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-orange-400"></div>
        
        <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6 relative">
            <div class="absolute inset-0 border-4 border-primary rounded-full animate-ping opacity-50"></div>
            <i data-lucide="check-circle" class="w-10 h-10 text-primary"></i>
        </div>
        
        <h2 class="text-2xl font-black text-white mb-2">Emergency Sent!</h2>
        <p class="text-sm text-slate-400 mb-8">
            Your SOS has been sent successfully. Help is on the way.
            <br>Emergency contacts and admin have been notified.
        </p>
        
        <div class="flex flex-col gap-3">
            <a id="add-details-link" data-base="{{ url('/user/emergency') }}" href="#" class="w-full flex items-center justify-center gap-2 py-3 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-primary hover:bg-red-600 transition-all shadow-lg" style="display:none;">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Add More Details
            </a>
            
            <a id="map-link" href="#" target="_blank" class="w-full flex items-center justify-center gap-2 py-3 px-4 border border-slate-700 rounded-xl text-sm font-bold text-white bg-slate-800 hover:bg-slate-700 transition-all" style="display:none;">
                <i data-lucide="map-pin" class="w-4 h-4 text-secondary-blue"></i> View My Location
            </a>
            
            <button onclick="SosHandler.closeModal()" class="w-full py-3 px-4 text-sm font-bold text-slate-400 hover:text-white transition-colors">
                Close
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/geolocation.js') }}"></script>
@endsection
