@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Admin Dashboard</h1>
    <p class="page-subtitle">System overview — {{ now()->format('D, d M Y') }}</p>
</div>

<!-- ══ Statistics Cards ══ -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg">
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-shield-fill-exclamation text-white"></i></div>
            <div>
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Emergencies</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="stat-card">
            <div class="stat-icon yellow"><i class="bi bi-hourglass-split text-white"></i></div>
            <div>
                <div class="stat-number">{{ $stats['pending'] }}</div>
                <div class="stat-label">Pending Cases</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-activity text-white"></i></div>
            <div>
                <div class="stat-number">{{ $stats['active'] }}</div>
                <div class="stat-label">Active Cases</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-check-lg text-white"></i></div>
            <div>
                <div class="stat-number">{{ $stats['completed'] }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-exclamation-triangle-fill text-white"></i></div>
            <div>
                <div class="stat-number">{{ $stats['high'] }}</div>
                <div class="stat-label">High Priority</div>
            </div>
        </div>
    </div>
</div>

<!-- ══ Recent Emergencies ══ -->
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 style="font-size:1rem; font-weight:700; margin:0;">Recent Emergencies</h2>
            <p style="font-size:0.82rem; color:var(--text-muted); margin:0;">Last 5 requests received</p>
        </div>
        <a href="{{ route('admin.emergencies') }}" class="btn-outline-custom">
            View All <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    @if($recentEmergencies->count() > 0)
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentEmergencies as $emergency)
                        <tr>
                            <td>
                                <div style="font-weight:600;">{{ $emergency->user->name }}</div>
                                <div style="font-size:0.78rem; color:var(--text-muted);">{{ $emergency->user->phone }}</div>
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
                                <a href="{{ route('admin.emergencies.show', $emergency->id) }}"
                                   class="btn-outline-custom">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align:center; padding:40px 0; color:var(--text-muted);">
            <div style="margin-bottom:8px;"><i class="bi bi-clipboard-x text-muted" style="font-size:2.5rem;"></i></div>
            <p style="font-size:0.9rem;">No emergency requests yet.</p>
        </div>
    @endif
</div>
@endsection
