@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- ══ LEFT: SOS Section ══ -->
    <div class="col-lg-7">
        <div class="card-custom text-center" style="padding: 48px 24px;">

            <!-- Alert container (JS inserts messages here) -->
            <div id="sos-alerts"></div>

            <!-- Hidden URL for JS -->
            <input type="hidden" id="sos-url" value="{{ route('user.sos') }}">

            <!-- SOS Button -->
            <div class="sos-wrapper">
                <div class="sos-ring">
                    <button id="sos-button" class="sos-btn" title="Press to send emergency SOS">
                        <span class="sos-icon"><i class="bi bi-shield-fill-exclamation text-white"></i></span>
                        <span class="sos-label">PRESS</span>
                    </button>
                </div>
                <p class="sos-hint" style="margin-top:60px">
                    Tap the button to trigger emergency alert.<br>
                    Your location will be captured automatically.
                </p>
                <p id="sos-status-msg" style="color: #fbbf24; font-size:0.95rem; font-weight:600; min-height:24px; letter-spacing:0.2px;"></p>
            </div>

            <!-- Manual Address Form (removed, location is mandatory) -->
        </div>
    </div>

    <!-- ══ RIGHT: Info Panel ══ -->
    <div class="col-lg-5 d-flex flex-column gap-3 mt-3 mt-lg-0">

        <!-- User Info Card -->
        <div class="card-custom">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;background:rgba(220,38,38,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">
                    <i class="bi bi-person-fill text-danger"></i>
                </div>
                <div>
                    <div style="font-weight:700; font-size:1rem;">{{ auth()->user()->name }}</div>
                    <div style="font-size:0.8rem; color:var(--text-muted);">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-6">
                    <div style="background:rgba(255,255,255,0.04); border-radius:8px; padding:10px 12px;">
                        <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Blood Group</div>
                        <div style="font-weight:700; font-size:1rem; color:#f87171; margin-top:2px;">
                            {{ auth()->user()->blood_group ?? 'Not set' }}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:rgba(255,255,255,0.04); border-radius:8px; padding:10px 12px;">
                        <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Phone</div>
                        <div style="font-weight:600; font-size:0.9rem; margin-top:2px;">
                            {{ auth()->user()->phone ?? 'Not set' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Last Emergency Status -->
        <div class="card-custom">
            <div style="font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:12px;">
                Last Emergency Status
            </div>
            @if($latestEmergency)
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="status-badge badge-{{ $latestEmergency->status }}">
                        {{ ucfirst(str_replace('_', ' ', $latestEmergency->status)) }}
                    </span>
                    <span class="status-badge badge-{{ $latestEmergency->priority }}">
                        {{ ucfirst($latestEmergency->priority) }} Priority
                    </span>
                </div>
                <div style="font-size:0.82rem; color:var(--text-muted);">
                    <i class="bi bi-clock me-1"></i>
                    {{ $latestEmergency->created_at->diffForHumans() }}
                </div>
                @if($latestEmergency->latitude)
                    <a href="{{ $latestEmergency->map_link }}" target="_blank" class="map-btn mt-2">
                        <i class="bi bi-geo-alt-fill"></i> View Location
                    </a>
                @endif
            @else
                <div style="text-align:center; padding:20px 0; color:var(--text-muted);">
                    <div style="font-size:2rem; margin-bottom:8px;"><i class="bi bi-check-circle text-success"></i></div>
                    <div style="font-size:0.88rem;">No emergency requests yet</div>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="card-custom">
            <div style="font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:12px;">
                Quick Actions
            </div>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('user.hospitals') }}" class="btn-outline-custom">
                    <i class="bi bi-hospital"></i> Nearby Hospitals
                </a>
                <a href="{{ route('user.history') }}" class="btn-outline-custom">
                    <i class="bi bi-clock-history"></i> Emergency History
                    @if($totalEmergencies > 0)
                        <span style="background:var(--red-primary); color:white; border-radius:10px; padding:1px 7px; font-size:0.72rem; margin-left:auto;">
                            {{ $totalEmergencies }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('user.profile') }}" class="btn-outline-custom">
                    <i class="bi bi-person-gear"></i> Update Profile
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ══ SOS Success Overlay Modal ══ -->
<div id="sos-success-overlay" class="sos-overlay" style="display:none;">
    <div class="sos-modal">
        <div class="sos-success-icon"><i class="bi bi-check-lg"></i></div>
        <h2 style="font-size:1.4rem; font-weight:800; margin-bottom:8px;">Emergency Sent!</h2>
        <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:24px;">
            Your SOS has been sent successfully. Help is on the way.<br>
            Emergency contacts and admin have been notified.
        </p>
        <div class="d-flex flex-column gap-2">
            <a id="add-details-link"
               data-base="{{ url('/user/emergency') }}"
               href="#"
               class="btn-primary-custom justify-content-center"
               style="display:none;">
                <i class="bi bi-plus-circle"></i> Add More Details
            </a>
            <a id="map-link" href="#" target="_blank"
               class="map-btn justify-content-center"
               style="display:none;">
                <i class="bi bi-geo-alt-fill"></i> View My Location
            </a>
            <button onclick="SosHandler.closeModal()" class="btn-outline-custom justify-content-center">
                <i class="bi bi-x"></i> Close
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/geolocation.js') }}"></script>
@endsection
