@extends('layouts.admin')
@section('title', 'Emergency Detail')

@section('content')
<div class="page-header">
    <a href="{{ route('admin.emergencies') }}" class="btn-outline-custom mb-3">
        <i class="bi bi-arrow-left"></i> Back to Emergencies
    </a>
    <h1 class="page-title">Emergency #{{ $emergency->id }}</h1>
    <p class="page-subtitle">Submitted {{ $emergency->created_at->format('d M Y, h:i A') }}</p>
</div>

<div class="row g-4">
    <!-- ══ LEFT: User & Emergency Info ══ -->
    <div class="col-lg-7">
        <div class="card-custom mb-3">
            <div style="font-size:0.72rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:16px;">
                Patient Information
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Full Name</div>
                    <div style="font-weight:700;">{{ $emergency->user->name }}</div>
                </div>
                <div class="col-6">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Phone</div>
                    <div style="font-weight:700;">
                        <a href="tel:{{ $emergency->user->phone }}" style="color:inherit; text-decoration:none;">
                            {{ $emergency->user->phone ?? '—' }}
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Blood Group</div>
                    <div style="font-weight:800; font-size:1.2rem; color:#f87171;">
                        {{ $emergency->user->blood_group ?? '—' }}
                    </div>
                </div>
                <div class="col-6">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Email</div>
                    <div style="font-size:0.88rem;">{{ $emergency->user->email }}</div>
                </div>
            </div>

            <hr class="divider">

            <div style="font-size:0.72rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:14px;">
                Emergency Contact
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Contact Name</div>
                    <div style="font-weight:600;">{{ $emergency->user->emergency_contact_name ?? '—' }}</div>
                </div>
                <div class="col-6">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Contact Phone</div>
                    <div style="font-weight:600;">
                        <a href="tel:{{ $emergency->user->emergency_contact_phone }}" style="color:inherit;text-decoration:none;">
                            {{ $emergency->user->emergency_contact_phone ?? '—' }}
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Relation</div>
                    <div>{{ $emergency->user->relation ?? '—' }}</div>
                </div>
            </div>
        </div>

        <!-- Emergency Details -->
        <div class="card-custom">
            <div style="font-size:0.72rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:16px;">
                Emergency Details
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Status</div>
                    <span class="status-badge badge-{{ $emergency->status }}">
                        {{ ucfirst(str_replace('_', ' ', $emergency->status)) }}
                    </span>
                </div>
                <div class="col-6">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Priority</div>
                    <span class="status-badge badge-{{ $emergency->priority }}">
                        {{ ucfirst($emergency->priority) }}
                    </span>
                </div>
                <div class="col-12">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Notes</div>
                    <div style="background:rgba(255,255,255,0.04); border-radius:8px; padding:12px; font-size:0.88rem; min-height:50px;">
                        {{ $emergency->notes ?? 'No additional notes provided.' }}
                    </div>
                </div>
                @if($emergency->accepted_at)
                    <div class="col-6">
                        <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Accepted At</div>
                        <div style="font-size:0.88rem;">{{ $emergency->accepted_at->format('d M Y, h:i A') }}</div>
                    </div>
                @endif
                @if($emergency->completed_at)
                    <div class="col-6">
                        <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:3px;">Completed At</div>
                        <div style="font-size:0.88rem;">{{ $emergency->completed_at->format('d M Y, h:i A') }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ══ RIGHT: Location & Actions ══ -->
    <div class="col-lg-5 d-flex flex-column gap-3">
        <!-- Location -->
        <div class="card-custom">
            <div style="font-size:0.72rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:14px;">
                <i class="bi bi-geo-alt-fill text-danger"></i> Location
            </div>
            @if($emergency->latitude && $emergency->longitude)
                <div class="mb-2">
                    <div style="font-size:0.78rem; color:var(--text-muted);">Coordinates</div>
                    <div style="font-family:monospace; font-size:0.88rem;">
                        {{ $emergency->latitude }}, {{ $emergency->longitude }}
                    </div>
                </div>
                <a href="{{ $emergency->map_link }}" target="_blank" class="map-btn w-100 justify-content-center">
                    <i class="bi bi-google"></i> Open in Google Maps
                </a>
            @elseif($emergency->address)
                <div style="font-size:0.88rem; color:var(--text-muted);">
                    <i class="bi bi-geo-alt-fill me-1" style="color:#f87171;"></i>
                    {{ $emergency->address }}
                </div>
            @else
                <div style="color:var(--text-muted); font-size:0.85rem;">No location data available.</div>
            @endif
        </div>

        <!-- Actions -->
        @if(!in_array($emergency->status, ['completed', 'rejected']))
            <div class="card-custom">
                <div style="font-size:0.72rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:14px;">
                    Update Status
                </div>
                <div class="d-flex flex-column gap-2">
                    @if($emergency->status === 'pending')
                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="background:#22c55e;">
                                <i class="bi bi-check-circle"></i> Accept Emergency
                            </button>
                        </form>
                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="background:#dc2626;"
                                    data-confirm="Reject this emergency request?">
                                <i class="bi bi-x-circle"></i> Reject Emergency
                            </button>
                        </form>
                    @endif
                    @if($emergency->status === 'accepted')
                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="in_progress">
                            <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="background:#8b5cf6;">
                                <i class="bi bi-arrow-right-circle"></i> Mark In Progress
                            </button>
                        </form>
                    @endif
                    @if(in_array($emergency->status, ['accepted', 'in_progress']))
                        <form action="{{ route('admin.emergencies.status', $emergency->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="complete">
                            <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="background:#3b82f6;">
                                <i class="bi bi-check2-all"></i> Mark Completed
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @else
            <div class="card-custom text-center" style="padding:30px;">
                @if($emergency->status === 'completed')
                    <div style="margin-bottom:8px;"><i class="bi bi-check-circle-fill text-success" style="font-size:3rem;"></i></div>
                    <p style="color:#4ade80; font-weight:600;">Emergency Completed</p>
                @else
                    <div style="margin-bottom:8px;"><i class="bi bi-x-circle-fill text-danger" style="font-size:3rem;"></i></div>
                    <p style="color:#f87171; font-weight:600;">Emergency Rejected</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
