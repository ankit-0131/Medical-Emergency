@extends('layouts.admin')
@section('title', 'Emergency Detail')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex flex-col gap-2">
        <a href="{{ route('admin.emergencies') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 hover:text-white transition-colors w-max bg-slate-800/50 hover:bg-slate-700/50 px-3 py-1.5 rounded-lg border border-slate-700">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Emergencies
        </a>
        <h1 class="text-3xl font-poppins font-bold text-white tracking-tight flex items-center gap-3">
            Emergency #{{ $emergency->id }}
        </h1>
        <p class="text-slate-400">Submitted {{ $emergency->created_at->format('d M Y, h:i A') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- ══ LEFT: User & Emergency Info ══ -->
    <div class="lg:col-span-7 flex flex-col gap-6">
        <div class="glass-card p-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-6 flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4 text-secondary-blue"></i> Patient Information
            </h3>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <div class="text-xs text-slate-400 mb-1">Full Name</div>
                    <div class="font-bold text-white text-lg">{{ $emergency->user->name }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 mb-1">Phone</div>
                    <div class="font-bold text-white text-lg">
                        <a href="tel:{{ $emergency->user->phone }}" class="hover:text-primary transition-colors flex items-center gap-2">
                            {{ $emergency->user->phone ?? '—' }}
                        </a>
                    </div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 mb-1">Blood Group</div>
                    <div class="font-black text-2xl text-primary inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary/10 border border-primary/20">
                        {{ $emergency->user->blood_group ?? '—' }}
                    </div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 mb-1">Email</div>
                    <div class="text-slate-300">{{ $emergency->user->email }}</div>
                </div>
            </div>

            <div class="w-full h-px bg-slate-800 my-8"></div>

            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-6 flex items-center gap-2">
                <i data-lucide="contact" class="w-4 h-4 text-orange-400"></i> Emergency Contact
            </h3>
            
            <div class="grid grid-cols-2 gap-6 bg-slate-900/50 p-4 rounded-xl border border-slate-800">
                <div>
                    <div class="text-xs text-slate-400 mb-1">Contact Name</div>
                    <div class="font-bold text-slate-200">{{ $emergency->user->emergency_contact_name ?? '—' }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 mb-1">Contact Phone</div>
                    <div class="font-bold text-slate-200">
                        <a href="tel:{{ $emergency->user->emergency_contact_phone }}" class="hover:text-primary transition-colors">
                            {{ $emergency->user->emergency_contact_phone ?? '—' }}
                        </a>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="text-xs text-slate-400 mb-1">Relation</div>
                    <div class="inline-flex px-3 py-1 rounded-lg bg-slate-800 text-slate-300 text-sm font-semibold border border-slate-700">
                        {{ $emergency->user->relation ?? '—' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Details -->
        <div class="glass-card p-6">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-6 flex items-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4 text-success-green"></i> Emergency Details
            </h3>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <div class="text-xs text-slate-400 mb-2">Status</div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-bold
                        {{ $emergency->status == 'resolved' ? 'bg-success-green/20 text-success-green border border-success-green/20' : 
                          ($emergency->status == 'pending' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/20' : 
                          ($emergency->status == 'in_progress' ? 'bg-secondary-blue/20 text-blue-400 border border-secondary-blue/20' : 
                          ($emergency->status == 'completed' ? 'bg-success-green/20 text-success-green border border-success-green/20' : 
                          'bg-slate-700/50 text-slate-300 border border-slate-600'))) }}">
                        <span class="w-2 h-2 rounded-full {{ $emergency->status == 'resolved' || $emergency->status == 'completed' ? 'bg-success-green' : ($emergency->status == 'pending' ? 'bg-orange-400' : ($emergency->status == 'in_progress' ? 'bg-blue-400' : 'bg-slate-400')) }}"></span>
                        {{ ucfirst(str_replace('_', ' ', $emergency->status)) }}
                    </span>
                </div>
                <div>
                    <div class="text-xs text-slate-400 mb-2">Priority</div>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold 
                        {{ $emergency->priority == 'critical' ? 'bg-primary/20 text-primary border border-primary/20 animate-pulse' : 
                          ($emergency->priority == 'high' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/20' : 
                          ($emergency->priority == 'medium' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/20' : 
                          'bg-blue-500/20 text-blue-400 border border-blue-500/20')) }}">
                        {{ ucfirst($emergency->priority) }}
                    </span>
                </div>
                <div class="col-span-2">
                    <div class="text-xs text-slate-400 mb-2">Notes</div>
                    <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-4 text-slate-300 text-sm leading-relaxed min-h-[80px]">
                        {{ $emergency->notes ?? 'No additional notes provided.' }}
                    </div>
                </div>
                
                @if($emergency->accepted_at)
                    <div>
                        <div class="text-xs text-slate-400 mb-1 flex items-center gap-1"><i data-lucide="check-circle" class="w-3 h-3"></i> Accepted At</div>
                        <div class="text-sm text-slate-300 font-semibold">{{ $emergency->accepted_at->format('d M Y, h:i A') }}</div>
                    </div>
                @endif
                @if($emergency->completed_at)
                    <div>
                        <div class="text-xs text-slate-400 mb-1 flex items-center gap-1"><i data-lucide="check-circle-2" class="w-3 h-3"></i> Completed At</div>
                        <div class="text-sm text-slate-300 font-semibold">{{ $emergency->completed_at->format('d M Y, h:i A') }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ══ RIGHT: Location & Actions ══ -->
    <div class="lg:col-span-5 flex flex-col gap-6">
        <!-- Location -->
        <div class="glass-card p-6">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-6 flex items-center gap-2">
                <i data-lucide="map-pin" class="w-4 h-4 text-primary"></i> Location
            </h3>
            
            @if($emergency->latitude && $emergency->longitude)
                <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-4 mb-4 flex items-center gap-4">
                    <div class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center shrink-0">
                        <i data-lucide="compass" class="w-5 h-5 text-slate-400"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400 mb-0.5">Coordinates</div>
                        <div class="font-mono text-sm text-slate-200">
                            {{ $emergency->latitude }}, {{ $emergency->longitude }}
                        </div>
                    </div>
                </div>
                <a href="{{ $emergency->map_link }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-secondary-blue/20 text-blue-400 font-bold border border-secondary-blue/30 hover:bg-secondary-blue/30 transition-all shadow-lg hover:scale-[1.02]">
                    <i data-lucide="map" class="w-5 h-5"></i> Open in Google Maps
                </a>
            @elseif($emergency->address)
                <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-4 flex items-start gap-3">
                    <i data-lucide="map-pin" class="w-5 h-5 text-primary shrink-0 mt-0.5"></i>
                    <span class="text-sm text-slate-300 leading-relaxed">{{ $emergency->address }}</span>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-8 text-center bg-slate-900/50 rounded-xl border border-slate-800">
                    <i data-lucide="map-pin-off" class="w-8 h-8 text-slate-500 mb-2"></i>
                    <span class="text-sm text-slate-400">No location data available.</span>
                </div>
            @endif
        </div>

        <!-- Actions -->
        @if(!in_array($emergency->status, ['completed', 'rejected']))
            <div class="glass-card p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-6 flex items-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4 text-purple-400"></i> Update Status
                </h3>
                
                <div class="flex flex-col gap-3">
                    @if($emergency->status === 'pending')
                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-white bg-success-green hover:bg-green-600 transition-all shadow-[0_0_15px_rgba(34,197,94,0.3)] hover:scale-[1.02]">
                                <i data-lucide="check-circle" class="w-5 h-5"></i> Accept Emergency
                            </button>
                        </form>
                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this emergency request?');">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-white bg-primary hover:bg-red-600 transition-all shadow-[0_0_15px_rgba(255,59,48,0.3)] hover:scale-[1.02]">
                                <i data-lucide="x-circle" class="w-5 h-5"></i> Reject Emergency
                            </button>
                        </form>
                    @endif
                    
                    @if($emergency->status === 'accepted')
                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="in_progress">
                            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-white bg-purple-600 hover:bg-purple-500 transition-all shadow-[0_0_15px_rgba(147,51,234,0.3)] hover:scale-[1.02]">
                                <i data-lucide="arrow-right-circle" class="w-5 h-5"></i> Mark In Progress
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($emergency->status, ['accepted', 'in_progress']))
                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="complete">
                            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-white bg-secondary-blue hover:bg-blue-600 transition-all shadow-[0_0_15px_rgba(30,58,138,0.4)] hover:scale-[1.02]">
                                <i data-lucide="check-square" class="w-5 h-5"></i> Mark Completed
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @else
            <div class="glass-card p-8 text-center flex flex-col items-center justify-center">
                @if($emergency->status === 'completed')
                    <div class="w-20 h-20 bg-success-green/10 rounded-full flex items-center justify-center mb-4 border-2 border-success-green/20">
                        <i data-lucide="check-circle" class="w-10 h-10 text-success-green"></i>
                    </div>
                    <h3 class="text-xl font-black text-white mb-1">Emergency Completed</h3>
                    <p class="text-sm text-slate-400">This case has been successfully resolved.</p>
                @else
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mb-4 border-2 border-primary/20">
                        <i data-lucide="x-circle" class="w-10 h-10 text-primary"></i>
                    </div>
                    <h3 class="text-xl font-black text-white mb-1">Emergency Rejected</h3>
                    <p class="text-sm text-slate-400">This case was marked as invalid or cancelled.</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
