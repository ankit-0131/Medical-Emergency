@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-poppins font-bold text-white tracking-tight">Admin Dashboard</h1>
        <p class="text-slate-400 mt-1">System overview — {{ now()->format('D, d M Y') }}</p>
    </div>
</div>

<!-- ══ Statistics Cards ══ -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
    <div class="glass-card p-4 rounded-xl border-l-4 border-l-primary relative overflow-hidden group hover:bg-slate-800/50 transition-colors">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform"><i data-lucide="alert-triangle" class="w-24 h-24 text-primary"></i></div>
        <div class="flex items-center gap-3 mb-2 relative z-10">
            <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center text-primary">
                <i data-lucide="shield-alert" class="w-5 h-5"></i>
            </div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total<br>Emergencies</div>
        </div>
        <div class="text-3xl font-black text-white relative z-10">{{ $stats['total'] }}</div>
    </div>
    
    <div class="glass-card p-4 rounded-xl border-l-4 border-l-orange-500 relative overflow-hidden group hover:bg-slate-800/50 transition-colors">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform"><i data-lucide="clock" class="w-24 h-24 text-orange-500"></i></div>
        <div class="flex items-center gap-3 mb-2 relative z-10">
            <div class="w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center text-orange-500">
                <i data-lucide="hourglass" class="w-5 h-5"></i>
            </div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending<br>Cases</div>
        </div>
        <div class="text-3xl font-black text-white relative z-10">{{ $stats['pending'] }}</div>
    </div>
    
    <div class="glass-card p-4 rounded-xl border-l-4 border-l-secondary-blue relative overflow-hidden group hover:bg-slate-800/50 transition-colors">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform"><i data-lucide="activity" class="w-24 h-24 text-secondary-blue"></i></div>
        <div class="flex items-center gap-3 mb-2 relative z-10">
            <div class="w-10 h-10 rounded-lg bg-secondary-blue/20 flex items-center justify-center text-secondary-blue">
                <i data-lucide="activity" class="w-5 h-5"></i>
            </div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active<br>Cases</div>
        </div>
        <div class="text-3xl font-black text-white relative z-10">{{ $stats['active'] }}</div>
    </div>
    
    <div class="glass-card p-4 rounded-xl border-l-4 border-l-success-green relative overflow-hidden group hover:bg-slate-800/50 transition-colors">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform"><i data-lucide="check-circle" class="w-24 h-24 text-success-green"></i></div>
        <div class="flex items-center gap-3 mb-2 relative z-10">
            <div class="w-10 h-10 rounded-lg bg-success-green/20 flex items-center justify-center text-success-green">
                <i data-lucide="check" class="w-5 h-5"></i>
            </div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Completed<br>Cases</div>
        </div>
        <div class="text-3xl font-black text-white relative z-10">{{ $stats['completed'] }}</div>
    </div>
    
    <div class="glass-card p-4 rounded-xl border-l-4 border-l-purple-500 relative overflow-hidden group hover:bg-slate-800/50 transition-colors">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform"><i data-lucide="zap" class="w-24 h-24 text-purple-500"></i></div>
        <div class="flex items-center gap-3 mb-2 relative z-10">
            <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-500">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
            </div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">High<br>Priority</div>
        </div>
        <div class="text-3xl font-black text-white relative z-10">{{ $stats['high'] }}</div>
    </div>
</div>

<!-- ══ Recent Emergencies ══ -->
<div class="glass-card p-6 shadow-2xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i data-lucide="clock-history" class="w-5 h-5 text-secondary-blue"></i> Recent Emergencies
            </h2>
            <p class="text-sm text-slate-400 mt-1">Last 5 requests received</p>
        </div>
        <a href="{{ route('admin.emergencies') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800/50 border border-slate-700 text-sm font-semibold text-slate-300 hover:text-white hover:bg-slate-700 transition-colors">
            View All <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    @if($recentEmergencies->count() > 0)
        <div class="overflow-x-auto rounded-xl border border-slate-800/50">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="p-4">User</th>
                        <th class="p-4">Priority</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Time</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    @foreach($recentEmergencies as $emergency)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="p-4">
                                <div class="font-bold text-slate-200">{{ $emergency->user->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="phone" class="w-3 h-3"></i> {{ $emergency->user->phone }}
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold 
                                    {{ $emergency->priority == 'high' ? 'bg-primary/20 text-primary border border-primary/20' : 
                                      ($emergency->priority == 'medium' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/20' : 
                                      'bg-blue-500/20 text-blue-400 border border-blue-500/20') }}">
                                    {{ ucfirst($emergency->priority) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $emergency->status == 'resolved' ? 'bg-success-green/20 text-success-green border border-success-green/20' : 
                                      ($emergency->status == 'pending' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/20' : 
                                      'bg-slate-700/50 text-slate-300 border border-slate-600') }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $emergency->status == 'resolved' ? 'bg-success-green' : ($emergency->status == 'pending' ? 'bg-orange-400' : 'bg-slate-400') }}"></span>
                                    {{ ucfirst(str_replace('_', ' ', $emergency->status)) }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-400 text-sm">
                                <div class="flex items-center gap-1">
                                    <i data-lucide="clock" class="w-3 h-3"></i> {{ $emergency->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.emergencies.show', $emergency->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-secondary-blue/10 text-secondary-blue hover:bg-secondary-blue/20 hover:text-blue-400 border border-secondary-blue/20 transition-colors text-xs font-semibold">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-16 px-4 border border-slate-800 rounded-xl bg-slate-900/50">
            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-700">
                <i data-lucide="clipboard-x" class="w-8 h-8 text-slate-500"></i>
            </div>
            <p class="text-slate-400">No emergency requests yet.</p>
        </div>
    @endif
</div>
@endsection
