@extends('layouts.admin')
@section('title', 'Emergency Management')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-poppins font-bold text-white tracking-tight flex items-center gap-3">
            <div class="p-2 bg-primary/20 rounded-xl">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-primary"></i>
            </div>
            Emergency Management
        </h1>
        <p class="text-slate-400 mt-2">Manage all incoming emergency requests</p>
    </div>
</div>

<!-- ══ Filters ══ -->
<div class="glass-card p-6 mb-6">
    <form action="{{ route('admin.emergencies') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Filter by Status</label>
            <div class="relative">
                <select name="status" class="block w-48 pl-4 pr-10 py-2.5 border border-slate-700 rounded-xl bg-slate-900/50 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none" onchange="this.form.submit()">
                    <option value="" class="text-slate-500">All Statuses</option>
                    @foreach(['pending','accepted','in_progress','completed','rejected'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }} class="bg-slate-900 text-white">
                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Filter by Priority</label>
            <div class="relative">
                <select name="priority" class="block w-48 pl-4 pr-10 py-2.5 border border-slate-700 rounded-xl bg-slate-900/50 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none" onchange="this.form.submit()">
                    <option value="" class="text-slate-500">All Priorities</option>
                    @foreach(['critical','high','medium','low'] as $p)
                        <option value="{{ $p }}" {{ request('priority') == $p ? 'selected' : '' }} class="bg-slate-900 text-white">
                            {{ ucfirst($p) }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500"></i>
                </div>
            </div>
        </div>

        @if(request()->hasAny(['status', 'priority']))
            <a href="{{ route('admin.emergencies') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-700 text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i> Clear Filters
            </a>
        @endif
    </form>
</div>

<!-- ══ Emergencies Table ══ -->
<div class="glass-card shadow-2xl relative overflow-hidden">
    @if($emergencies->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="p-4">#</th>
                        <th class="p-4">User</th>
                        <th class="p-4">Blood Group</th>
                        <th class="p-4">Priority</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Time</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    @foreach($emergencies as $emergency)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="p-4 text-slate-500 font-medium">#{{ $emergency->id }}</td>
                            <td class="p-4">
                                <div class="font-bold text-white">{{ $emergency->user->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="phone" class="w-3 h-3"></i> {{ $emergency->user->phone }}
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 border border-primary/20 text-primary font-bold text-xs">
                                    {{ $emergency->user->blood_group ?? '—' }}
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold 
                                    {{ $emergency->priority == 'critical' ? 'bg-primary/20 text-primary border border-primary/20 animate-pulse' : 
                                      ($emergency->priority == 'high' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/20' : 
                                      ($emergency->priority == 'medium' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/20' : 
                                      'bg-blue-500/20 text-blue-400 border border-blue-500/20')) }}">
                                    {{ ucfirst($emergency->priority) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $emergency->status == 'resolved' ? 'bg-success-green/20 text-success-green border border-success-green/20' : 
                                      ($emergency->status == 'pending' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/20' : 
                                      ($emergency->status == 'in_progress' ? 'bg-secondary-blue/20 text-blue-400 border border-secondary-blue/20' : 
                                      ($emergency->status == 'completed' ? 'bg-success-green/20 text-success-green border border-success-green/20' : 
                                      'bg-slate-700/50 text-slate-300 border border-slate-600'))) }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $emergency->status == 'resolved' || $emergency->status == 'completed' ? 'bg-success-green' : ($emergency->status == 'pending' ? 'bg-orange-400' : ($emergency->status == 'in_progress' ? 'bg-blue-400' : 'bg-slate-400')) }}"></span>
                                    {{ ucfirst(str_replace('_', ' ', $emergency->status)) }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-400">
                                <div class="flex items-center gap-1.5 text-xs">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ $emergency->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    <!-- View -->
                                    <a href="{{ route('admin.emergencies.show', $emergency->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 border border-slate-700 transition-colors text-xs font-semibold">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> View
                                    </a>

                                    @if($emergency->status === 'pending')
                                        <!-- Accept -->
                                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="accept">
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-success-green/10 text-success-green hover:bg-success-green/20 border border-success-green/20 transition-colors text-xs font-semibold">
                                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Accept
                                            </button>
                                        </form>
                                        <!-- Reject -->
                                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this emergency?');">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 border border-primary/20 transition-colors text-xs font-semibold">
                                                <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Reject
                                            </button>
                                        </form>
                                    @endif

                                    @if($emergency->status === 'accepted')
                                        <!-- In Progress -->
                                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="in_progress">
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-500/10 text-purple-400 hover:bg-purple-500/20 border border-purple-500/20 transition-colors text-xs font-semibold">
                                                <i data-lucide="arrow-right-circle" class="w-3.5 h-3.5"></i> In Progress
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($emergency->status, ['accepted', 'in_progress']))
                                        <!-- Complete -->
                                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="complete">
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 border border-blue-500/20 transition-colors text-xs font-semibold">
                                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Complete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($emergencies->hasPages())
            <div class="p-4 border-t border-slate-800/50 flex justify-center custom-pagination">
                {{ $emergencies->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-16 px-4">
            <div class="w-20 h-20 bg-success-green/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-success-green/20">
                <i data-lucide="check-circle" class="w-10 h-10 text-success-green"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">No emergencies found</h3>
            <p class="text-slate-400">
                @if(request()->hasAny(['status','priority']))
                    Try changing your filters.
                @else
                    No emergency requests have been submitted yet.
                @endif
            </p>
        </div>
    @endif
</div>
@endsection
