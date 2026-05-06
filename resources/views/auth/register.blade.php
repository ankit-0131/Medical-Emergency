<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Medical Emergency System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="auth-page" style="padding: 40px 24px;">
    <div class="auth-card" style="max-width: 600px;">
        <!-- Logo -->
        <div class="auth-logo">
            <div class="auth-logo-icon"><i class="bi bi-hospital-fill"></i></div>
            <div class="text-center">
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-sub">Register to access emergency services</p>
            </div>
        </div>

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert-custom alert-danger mb-4 shadow-sm">
                <div>
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2" style="padding-left:16px;">
                        @foreach($errors->all() as $error)
                            <li style="font-size:0.9rem;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Register Form -->
        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <!-- Personal Info Section -->
            <p style="font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:16px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-person-badge text-info"></i> Personal Information
            </p>

            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label for="name" class="form-label-custom">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="name" name="name"
                               class="form-control-custom"
                               style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                               value="{{ old('name') }}"
                               placeholder="John Doe" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label-custom">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email"
                               class="form-control-custom"
                               style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                               value="{{ old('email') }}"
                               placeholder="john@example.com" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label-custom">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" id="phone" name="phone"
                               class="form-control-custom"
                               style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                               value="{{ old('phone') }}"
                               placeholder="9876543210" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="blood_group" class="form-label-custom">Blood Group</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-droplet"></i></span>
                        <select id="blood_group" name="blood_group" class="form-control-custom" style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;" required>
                            <option value="" disabled selected>Select blood group</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>
                                    {{ $bg }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label-custom">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password"
                               class="form-control-custom"
                               style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                               placeholder="Min 8 chars" required>
                    </div>
                </div>
                <div class="col-12">
                    <label for="password_confirmation" class="form-label-custom">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control-custom"
                               style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                               placeholder="Repeat password" required>
                    </div>
                </div>
            </div>

            <hr class="divider">

            <!-- Emergency Contact Section -->
            <p style="font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:16px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-heart-pulse text-danger"></i> Emergency Contact Information
            </p>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="emergency_contact_name" class="form-label-custom">Contact Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                               class="form-control-custom"
                               style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                               value="{{ old('emergency_contact_name') }}"
                               placeholder="Jane Doe" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="emergency_contact_phone" class="form-label-custom">Contact Phone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone-inbound"></i></span>
                        <input type="text" id="emergency_contact_phone" name="emergency_contact_phone"
                               class="form-control-custom"
                               style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                               value="{{ old('emergency_contact_phone') }}"
                               placeholder="9876543211" required>
                    </div>
                </div>
                <div class="col-12">
                    <label for="relation" class="form-label-custom">Relation</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-people"></i></span>
                        <select id="relation" name="relation" class="form-control-custom" style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;" required>
                            <option value="" disabled selected>Select relation</option>
                            @foreach(['Father','Mother','Spouse','Sibling','Friend','Guardian','Other'] as $r)
                                <option value="{{ $r }}" {{ old('relation') == $r ? 'selected' : '' }}>{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="padding:14px; font-size: 1.05rem;">
                <i class="bi bi-person-plus fs-5"></i> Create Account
            </button>
        </form>

        <hr class="divider">
        <p style="text-align:center; font-size:0.9rem; color: var(--text-muted);">
            Already have an account?
            <a href="{{ route('login') }}" style="color: var(--brand-red); font-weight:700; text-decoration:none; margin-left: 4px; transition: color 0.2s;">Login here</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
