@extends('layouts.app')
@section('title', 'Emergency History')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-poppins font-bold text-white tracking-tight">Emergency History</h1>
        <p class="text-slate-400 mt-1">All your past emergency requests</p>
    </div>
    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 border border-slate-700 text-slate-300 hover:text-white transition-all w-max">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Dashboard
    </a>
</div>

<div class="glass-card p-6 shadow-2xl">
    @if($emergencies->count() > 0)
        <div class="overflow-x-auto rounded-xl border border-slate-800/50">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="p-4">#</th>
                        <th class="p-4">Date & Time</th>
                        <th class="p-4">Priority</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Notes</th>
                        <th class="p-4">Location</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    @foreach($emergencies as $emergency)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="p-4 text-slate-500 font-medium">
                                #{{ $emergency->id }}
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-slate-300">{{ $emergency->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">
                                    {{ $emergency->created_at->format('h:i A') }}
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
                            <td class="p-4 text-slate-400 max-w-[200px] truncate">
                                {{ $emergency->notes ? Str::limit($emergency->notes, 40) : '—' }}
                            </td>
                            <td class="p-4">
                                @if($emergency->latitude)
                                    <a href="{{ $emergency->map_link }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-secondary-blue/10 text-secondary-blue hover:bg-secondary-blue/20 hover:text-blue-400 border border-secondary-blue/20 transition-colors text-xs font-semibold">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> Map
                                    </a>
                                @elseif($emergency->address)
                                    <span class="text-xs text-slate-400">
                                        {{ Str::limit($emergency->address, 30) }}
                                    </span>
                                @else
                                    <span class="text-slate-600">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($emergencies->hasPages())
            <div class="mt-6 flex justify-center custom-pagination">
                {{ $emergencies->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-16 px-4">
            <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-700">
                <i data-lucide="clipboard-x" class="w-10 h-10 text-slate-500"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">
                No Emergency History
            </h3>
            <p class="text-slate-400 mb-6">You haven't triggered any emergency alerts yet. Stay safe!</p>
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-primary text-white font-bold hover:bg-red-600 transition-all shadow-[0_0_15px_rgba(255,59,48,0.3)]">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Go to Dashboard
            </a>
        </div>
    @endif
</div>
@endsection
