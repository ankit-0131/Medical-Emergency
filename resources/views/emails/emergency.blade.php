<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Alert</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; }
        .wrapper { max-width: 580px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #dc2626, #991b1b); padding: 32px 40px; text-align: center; }
        .header-icon { font-size: 3rem; margin-bottom: 8px; }
        .header h1 { color: #fff; font-size: 1.4rem; font-weight: 800; margin: 0; }
        .header p { color: rgba(255,255,255,0.8); font-size: 0.88rem; margin: 4px 0 0; }
        .body { padding: 32px 40px; }
        .section-title { font-size: 0.72rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 12px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .info-item { background: #f8fafc; border-radius: 8px; padding: 12px; }
        .info-label { font-size: 0.72rem; color: #94a3b8; font-weight: 600; }
        .info-value { font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-top: 2px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .badge-high     { background: #fef3c7; color: #92400e; }
        .badge-critical { background: #fee2e2; color: #991b1b; }
        .badge-medium   { background: #dbeafe; color: #1e40af; }
        .badge-low      { background: #f1f5f9; color: #475569; }
        .map-btn { display: inline-block; margin-top: 8px; padding: 10px 24px; background: #dc2626; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.88rem; }
        .footer { background: #f8fafc; padding: 20px 40px; text-align: center; font-size: 0.78rem; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        hr { border: none; border-top: 1px solid #e2e8f0; margin: 24px 0; }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Header -->
    <div class="header">
        <div class="header-icon">🚨</div>
        <h1>MEDICAL EMERGENCY ALERT</h1>
        <p>{{ $recipient === 'admin' ? 'A new emergency request has been received' : 'Your contact needs emergency help' }}</p>
    </div>

    <!-- Body -->
    <div class="body">
        <p style="font-size:0.95rem; color:#334155; margin-bottom:24px;">
            @if($recipient === 'admin')
                A new emergency request has been submitted by <strong>{{ $emergency->user->name }}</strong>.
                Please review and take action immediately.
            @else
                <strong>{{ $emergency->user->name }}</strong> has triggered an emergency SOS.
                Please check on them immediately or contact emergency services.
            @endif
        </p>

        <!-- Patient Info -->
        <div class="section-title">Patient Information</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Full Name</div>
                <div class="info-value">{{ $emergency->user->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $emergency->user->phone ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Blood Group</div>
                <div class="info-value" style="color:#dc2626;">{{ $emergency->user->blood_group ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Priority</div>
                <div class="info-value">
                    <span class="badge badge-{{ $emergency->priority }}">{{ ucfirst($emergency->priority) }}</span>
                </div>
            </div>
        </div>

        <hr>

        <!-- Emergency Contact -->
        <div class="section-title">Emergency Contact</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Contact Name</div>
                <div class="info-value">{{ $emergency->user->emergency_contact_name ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Contact Phone</div>
                <div class="info-value">{{ $emergency->user->emergency_contact_phone ?? '—' }}</div>
            </div>
        </div>

        <hr>

        <!-- Location -->
        <div class="section-title">Location</div>
        @if($emergency->latitude && $emergency->longitude)
            <p style="font-size:0.88rem; color:#64748b; margin-bottom:8px;">
                Coordinates: {{ $emergency->latitude }}, {{ $emergency->longitude }}
            </p>
            <a href="{{ $emergency->map_link }}" class="map-btn" target="_blank">
                📍 View Location on Google Maps
            </a>
        @elseif($emergency->address)
            <p style="font-size:0.88rem; color:#334155;">{{ $emergency->address }}</p>
        @else
            <p style="font-size:0.88rem; color:#94a3b8;">Location not available.</p>
        @endif

        @if($emergency->notes)
            <hr>
            <div class="section-title">Notes</div>
            <p style="font-size:0.88rem; color:#334155; background:#f8fafc; padding:12px; border-radius:8px; margin:0;">
                {{ $emergency->notes }}
            </p>
        @endif

        <hr>
        <p style="font-size:0.82rem; color:#94a3b8; margin:0;">
            This alert was triggered at <strong>{{ $emergency->created_at->format('d M Y, h:i A') }}</strong>.
            Emergency ID: #{{ $emergency->id }}
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p style="margin:0;">Medical Emergency Assistance System</p>
        <p style="margin:4px 0 0;">This is an automated alert. Do not reply to this email.</p>
    </div>
</div>
</body>
</html>
