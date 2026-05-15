@extends('layouts.app')
@section('title', 'Nearby Hospitals')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-poppins font-bold text-white tracking-tight flex items-center gap-3">
            <div class="p-2 bg-primary/20 rounded-xl">
                <i data-lucide="hospital" class="w-6 h-6 text-primary"></i>
            </div>
            Nearby Hospitals
        </h1>
        <p class="text-slate-400 mt-2">Emergency hospitals and medical centres near your current location</p>
    </div>
</div>

<div class="glass-card shadow-2xl relative overflow-hidden">
    <!-- Decorative Glow -->
    <div class="absolute -top-20 -right-20 w-40 h-40 bg-secondary-blue/20 rounded-full blur-3xl mix-blend-screen"></div>

    <div id="location-status" class="py-24 px-6 text-center flex flex-col items-center justify-center relative z-10">
        <div class="relative w-20 h-20 mb-6">
            <div class="absolute inset-0 border-4 border-secondary-blue/30 rounded-full border-t-secondary-blue animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <i data-lucide="map-pin" class="w-8 h-8 text-secondary-blue animate-pulse"></i>
            </div>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Acquiring Live Location...</h3>
        <p class="text-slate-400 max-w-md">Please allow location access when prompted by your browser to find the nearest emergency medical facilities.</p>
    </div>

    <div id="map-container" style="display:none;" class="relative z-10">
        <div class="w-full h-[600px] bg-slate-900">
            <iframe
                id="google-maps-iframe"
                class="w-full h-full"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div class="p-6 bg-slate-900/80 border-t border-slate-800 flex justify-center">
            <a id="external-map-link" href="#" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-secondary-blue text-white font-bold hover:bg-blue-600 transition-all shadow-[0_0_15px_rgba(30,58,138,0.4)] hover:scale-105">
                <i data-lucide="external-link" class="w-5 h-5"></i> Open in Google Maps App
            </a>
        </div>
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
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-primary/20">
                <i data-lucide="map-pin-off" class="w-10 h-10 text-primary"></i>
            </div>
            <h3 class="text-xl font-bold text-primary mb-2">Location Mandatory</h3>
            <p class="text-slate-400 max-w-md mx-auto mb-6">${message}</p>
            <button onclick="location.reload()" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-800 text-white font-bold hover:bg-slate-700 transition-all border border-slate-700">
                <i data-lucide="refresh-cw" class="w-5 h-5"></i> Try Again
            </button>
        `;
        // re-initialize lucide icons for dynamically added content
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
});
</script>
@endsection
