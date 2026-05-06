<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emergency Status Update</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; }
        .wrapper { max-width: 540px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.1); }
        .header { padding: 32px 40px; text-align: center; }
        .header-pending    { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .header-accepted   { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .header-in_progress{ background: linear-gradient(135deg, #8b5cf6, #6d28d9); }
        .header-completed  { background: linear-gradient(135deg, #22c55e, #15803d); }
        .header-rejected   { background: linear-gradient(135deg, #ef4444, #b91c1c); }
        .header h1 { color: #fff; font-size: 1.3rem; font-weight: 800; margin: 8px 0 4px; }
        .header p  { color: rgba(255,255,255,0.85); font-size: 0.85rem; margin: 0; }
        .header-icon { font-size: 2.5rem; }
        .body { padding: 32px 40px; }
        .status-box { background: #f8fafc; border-radius: 10px; padding: 20px; text-align: center; margin-bottom: 24px; }
        .status-label { font-size: 0.72rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 6px; }
        .status-value { font-size: 1.5rem; font-weight: 900; }
        .status-pending    { color: #f59e0b; }
        .status-accepted   { color: #3b82f6; }
        .status-in_progress{ color: #8b5cf6; }
        .status-completed  { color: #22c55e; }
        .status-rejected   { color: #ef4444; }
        .footer { background: #f8fafc; padding: 20px 40px; text-align: center; font-size: 0.78rem; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Dynamic header based on status -->
    <div class="header header-{{ $emergency->status }}">
        <div class="header-icon">
            @switch($emergency->status)
                @case('completed') ✅ @break
                @case('accepted')  ✔️ @break
                @case('in_progress') 🔄 @break
                @case('rejected') ❌ @break
                @default ⏳
            @endswitch
        </div>
        <h1>Emergency Status Updated</h1>
        <p>Your emergency request has been {{ str_replace('_', ' ', $emergency->status) }}</p>
    </div>

    <div class="body">
        <p style="font-size:0.9rem; color:#334155; margin-bottom:20px;">
            Dear <strong>{{ $emergency->user->name }}</strong>, your emergency request
            <strong>#{{ $emergency->id }}</strong> status has been updated.
        </p>

        <div class="status-box">
            <div class="status-label">Current Status</div>
            <div class="status-value status-{{ $emergency->status }}">
                {{ strtoupper(str_replace('_', ' ', $emergency->status)) }}
            </div>
        </div>

        @if($emergency->status === 'completed')
            <p style="font-size:0.9rem; color:#334155; background:#f0fdf4; border-radius:8px; padding:14px; border-left:4px solid #22c55e;">
                ✅ Your emergency has been handled successfully. We hope you are safe.
                Please contact us if you need further assistance.
            </p>
        @elseif($emergency->status === 'rejected')
            <p style="font-size:0.9rem; color:#334155; background:#fef2f2; border-radius:8px; padding:14px; border-left:4px solid #ef4444;">
                ⚠️ Your request was not actioned. Please call emergency services directly
                at <strong>112</strong> if you are still in danger.
            </p>
        @elseif($emergency->status === 'accepted')
            <p style="font-size:0.9rem; color:#334155; background:#eff6ff; border-radius:8px; padding:14px; border-left:4px solid #3b82f6;">
                👨‍⚕️ Help is on the way! Medical staff have been dispatched to your location.
            </p>
        @elseif($emergency->status === 'in_progress')
            <p style="font-size:0.9rem; color:#334155; background:#f5f3ff; border-radius:8px; padding:14px; border-left:4px solid #8b5cf6;">
                🚑 Emergency response is actively in progress. Stay calm.
            </p>
        @endif

        <div style="margin-top:20px; font-size:0.82rem; color:#94a3b8;">
            Emergency ID: #{{ $emergency->id }} &nbsp;|&nbsp;
            Updated at: {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>

    <div class="footer">
        <p style="margin:0;">Medical Emergency Assistance System</p>
        <p style="margin:4px 0 0;">This is an automated notification. Do not reply to this email.</p>
    </div>
</div>
</body>
</html>
