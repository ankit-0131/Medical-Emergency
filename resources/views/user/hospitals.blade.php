@extends('layouts.app')
@section('title', 'Nearby Hospitals')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-hospital text-danger me-2"></i> Nearby Hospitals</h1>
    <p class="page-subtitle">Emergency hospitals and medical centres near you</p>
</div>

@if(true)
    <div class="card-custom text-center" id="location-status" style="padding: 60px;">
        <div class="spinner mb-3"></div>
        <h3 style="font-size:1.2rem; color:var(--text-primary);">Acquiring Live Location...</h3>
        <p style="color:var(--text-muted); font-size:0.95rem;">Please allow location access when prompted by your browser.</p>
    </div>

    <div id="map-container" style="display:none;">
        <div class="card-custom p-0 overflow-hidden" style="border-radius: var(--border-radius); border: 1px solid var(--dark-border);">
            <iframe
                id="google-maps-iframe"
                width="100%"
                height="500"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div class="mt-3 text-center">
            <a id="external-map-link" href="#" target="_blank" class="btn-primary-custom">
                <i class="bi bi-google"></i> Open in Google Maps App
            </a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusDiv = document.getElementById('location-status');
        const mapContainer = document.getElementById('map-container');
        const mapIframe = document.getElementById('google-maps-iframe');
        const externalLink = document.getElementById('external-map-link');

        if (!navigator.geolocation) {
            showError("Geolocation is not supported by your browser. It is mandatory for this feature.");
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Generate map URLs
                const embedUrl = `https://maps.google.com/maps?q=hospitals&ll=${lat},${lng}&z=14&output=embed`;
                const externalUrl = `https://www.google.com/maps/search/hospitals/@${lat},${lng},14z`;

                // Update UI
                statusDiv.style.display = 'none';
                mapContainer.style.display = 'block';

                mapIframe.src = embedUrl;
                externalLink.href = externalUrl;
            },
            function(error) {
                let msg = "Location access denied. Accessing your live location is mandatory to show nearby hospitals.";
                if (error.code === error.POSITION_UNAVAILABLE) msg = "Location information is unavailable.";
                if (error.code === error.TIMEOUT) msg = "The request to get user location timed out.";
                showError(msg);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );

        function showError(message) {
            statusDiv.innerHTML = `
                <div style="margin-bottom:12px;"><i class="bi bi-geo-alt-fill text-danger" style="font-size:3rem;"></i></div>
                <h3 style="font-size:1.2rem; color:#f87171; margin-bottom:8px;">Location Mandatory</h3>
                <p style="color:var(--text-muted); font-size:0.95rem;">${message}</p>
                <button onclick="location.reload()" class="btn-outline-custom mt-3">
                    <i class="bi bi-arrow-clockwise"></i> Try Again
                </button>
            `;
        }
    });
    </script>
@endif
@endsection
