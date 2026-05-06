@extends('layouts.admin')
@section('title', 'Emergency Management')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start">
    <div>
        <h1 class="page-title">Emergency Management</h1>
        <p class="page-subtitle">Manage all incoming emergency requests</p>
    </div>
</div>

<!-- ══ Filters ══ -->
<div class="card-custom mb-4">
    <form action="{{ route('admin.emergencies') }}" method="GET" class="d-flex gap-3 flex-wrap">
        <div>
            <label class="form-label-custom">Filter by Status</label>
            <select name="status" class="form-control-custom" style="width:180px;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['pending','accepted','in_progress','completed','rejected'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label-custom">Filter by Priority</label>
            <select name="priority" class="form-control-custom" style="width:180px;" onchange="this.form.submit()">
                <option value="">All Priorities</option>
                @foreach(['critical','high','medium','low'] as $p)
                    <option value="{{ $p }}" {{ request('priority') == $p ? 'selected' : '' }}>
                        {{ ucfirst($p) }}
                    </option>
                @endforeach
            </select>
        </div>
        @if(request()->hasAny(['status', 'priority']))
            <div style="align-self:flex-end;">
                <a href="{{ route('admin.emergencies') }}" class="btn-outline-custom">
                    <i class="bi bi-x"></i> Clear
                </a>
            </div>
        @endif
    </form>
</div>

<!-- ══ Emergencies Table ══ -->
<div class="card-custom">
    @if($emergencies->count() > 0)
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Blood Group</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emergencies as $emergency)
                        <tr>
                            <td style="color:var(--text-muted); font-size:0.82rem;">#{{ $emergency->id }}</td>
                            <td>
                                <div style="font-weight:600;">{{ $emergency->user->name }}</div>
                                <div style="font-size:0.78rem; color:var(--text-muted);">{{ $emergency->user->phone }}</div>
                            </td>
                            <td>
                                <span style="font-weight:700; color:#f87171;">
                                    {{ $emergency->user->blood_group ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge badge-{{ $emergency->priority }}">
                                    {{ ucfirst($emergency->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge badge-{{ $emergency->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $emergency->status)) }}
                                </span>
                            </td>
                            <td style="color:var(--text-muted); font-size:0.82rem;">
                                {{ $emergency->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <!-- View -->
                                    <a href="{{ route('admin.emergencies.show', $emergency->id) }}"
                                       class="btn-outline-custom" style="padding:5px 10px; font-size:0.78rem;">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if($emergency->status === 'pending')
                                        <!-- Accept -->
                                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="accept">
                                            <button type="submit" style="background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.3);color:#4ade80;padding:5px 10px;border-radius:6px;font-size:0.78rem;cursor:pointer;">
                                                <i class="bi bi-check-circle"></i> Accept
                                            </button>
                                        </form>
                                        <!-- Reject -->
                                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#f87171;padding:5px 10px;border-radius:6px;font-size:0.78rem;cursor:pointer;"
                                                    data-confirm="Reject this emergency?">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </button>
                                        </form>
                                    @endif

                                    @if($emergency->status === 'accepted')
                                        <!-- In Progress -->
                                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="in_progress">
                                            <button type="submit" style="background:rgba(139,92,246,0.15);border:1px solid rgba(139,92,246,0.3);color:#a78bfa;padding:5px 10px;border-radius:6px;font-size:0.78rem;cursor:pointer;">
                                                <i class="bi bi-arrow-right-circle"></i> In Progress
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($emergency->status, ['accepted', 'in_progress']))
                                        <!-- Complete -->
                                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="complete">
                                            <button type="submit" style="background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.3);color:#60a5fa;padding:5px 10px;border-radius:6px;font-size:0.78rem;cursor:pointer;">
                                                <i class="bi bi-check-circle-fill"></i> Complete
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
            <div class="mt-4 d-flex justify-content-center">
                {{ $emergencies->links() }}
            </div>
        @endif
    @else
        <div style="text-align:center; padding:60px 20px; color:var(--text-muted);">
            <div style="margin-bottom:12px;"><i class="bi bi-check-circle text-muted" style="font-size:3rem;"></i></div>
            <h3 style="font-size:1.1rem; color:var(--text-primary);">No emergencies found</h3>
            <p style="font-size:0.88rem;">
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
