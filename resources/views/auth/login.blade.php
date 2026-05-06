<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Medical Emergency System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="auth-page">
    <div class="auth-card">
        <!-- Logo -->
        <div class="auth-logo">
            <div class="auth-logo-icon"><i class="bi bi-hospital-fill"></i></div>
            <div class="text-center">
                <h1 class="auth-title">MedAlert</h1>
                <p class="auth-sub">Smart Medical Emergency System</p>
            </div>
        </div>

        <!-- Flash Errors -->
        @if($errors->any())
            <div class="alert-custom alert-danger mb-4 shadow-sm">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div style="font-size: 0.9rem;">{{ $errors->first() }}</div>
            </div>
        @endif

        @if(session('success'))
            <div class="alert-custom alert-success mb-4 shadow-sm">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div style="font-size: 0.9rem;">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label-custom">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="email" name="email"
                           class="form-control-custom"
                           style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                           value="{{ old('email') }}"
                           placeholder="you@example.com"
                           required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label-custom">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" name="password"
                           class="form-control-custom"
                           style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <label class="d-flex align-items-center gap-2" style="font-size:0.85rem; color: var(--text-muted); cursor:pointer;">
                    <input type="checkbox" name="remember" class="form-check-input m-0" style="background-color: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="padding:14px; font-size: 1.05rem;">
                Sign In <i class="bi bi-arrow-right-short fs-4 ms-1"></i>
            </button>
        </form>

        <hr class="divider">

        <p style="text-align:center; font-size:0.9rem; color: var(--text-muted);">
            Don't have an account?
            <a href="{{ route('register') }}" style="color: var(--brand-red); font-weight:700; text-decoration:none; margin-left: 4px; transition: color 0.2s;">
                Register here
            </a>
        </p>

        <!-- Demo Credentials -->
        <div style="margin-top: 32px; padding: 16px; background: rgba(59,130,246,0.05); border: 1px solid rgba(59,130,246,0.2); border-radius: var(--radius-sm);">
            <p style="font-size: 0.75rem; font-weight: 700; color: #60a5fa; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 6px;">
                <i class="bi bi-key-fill text-info"></i> Demo Credentials
            </p>
            <p style="font-size: 0.85rem; color: var(--text-secondary); margin:0;">
                <strong style="color:var(--text-primary)">Admin:</strong> admin@medicalapp.com / admin@123
            </p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
