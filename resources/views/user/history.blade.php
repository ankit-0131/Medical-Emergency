@extends('layouts.app')
@section('title', 'Emergency History')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start">
    <div>
        <h1 class="page-title">Emergency History</h1>
        <p class="page-subtitle">All your past emergency requests</p>
    </div>
    <a href="{{ route('user.dashboard') }}" class="btn-outline-custom">
        <i class="bi bi-arrow-left"></i> Dashboard
    </a>
</div>

<div class="card-custom">
    @if($emergencies->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date & Time</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emergencies as $emergency)
                        <tr>
                            <td style="color: var(--text-muted); font-size:0.82rem;">
                                #{{ $emergency->id }}
                            </td>
                            <td>
                                <div style="font-weight:600;">{{ $emergency->created_at->format('d M Y') }}</div>
                                <div style="font-size:0.78rem; color:var(--text-muted);">
                                    {{ $emergency->created_at->format('h:i A') }}
                                </div>
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
                            <td style="max-width:180px; color:var(--text-muted); font-size:0.85rem;">
                                {{ $emergency->notes ? Str::limit($emergency->notes, 40) : '—' }}
                            </td>
                            <td>
                                @if($emergency->latitude)
                                    <a href="{{ $emergency->map_link }}" target="_blank" class="map-btn">
                                        <i class="bi bi-geo-alt-fill"></i> Map
                                    </a>
                                @elseif($emergency->address)
                                    <span style="font-size:0.82rem; color:var(--text-muted);">
                                        {{ Str::limit($emergency->address, 30) }}
                                    </span>
                                @else
                                    <span style="color:var(--text-muted);">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($emergencies->hasPages())
            <div class="mt-4 d-flex justify-content-center" style="color: var(--text-muted);">
                {{ $emergencies->links() }}
            </div>
        @endif
    @else
        <div style="text-align:center; padding:60px 20px; color:var(--text-muted);">
            <div style="margin-bottom:12px;"><i class="bi bi-clipboard-x text-muted" style="font-size:3rem;"></i></div>
            <h3 style="font-size:1.1rem; font-weight:600; color:var(--text-primary); margin-bottom:8px;">
                No Emergency History
            </h3>
            <p style="font-size:0.88rem;">You haven't triggered any emergency alerts yet.</p>
            <a href="{{ route('user.dashboard') }}" class="btn-primary-custom mt-3">
                <i class="bi bi-grid"></i> Go to Dashboard
            </a>
        </div>
    @endif
</div>
@endsection
