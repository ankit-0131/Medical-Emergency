@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title"><i class="bi bi-person-vcard me-2"></i>My Profile</h1>
    <p class="page-subtitle">Manage your personal information and emergency contacts</p>
</div>

@if(session('success'))
    <div class="alert-custom alert-success auto-dismiss mb-4 shadow-sm" style="animation: slideInDown 0.4s ease-out;">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('user.profile.update') }}" method="POST" id="profile-form">
    @csrf

    <div class="row g-4">
        {{-- ══ LEFT COLUMN: PROFILE SUMMARY & SECURITY ══ --}}
        <div class="col-lg-4">
            <!-- Profile Info Card -->
            <div class="card-custom text-center mb-4 position-relative overflow-hidden" style="padding: 40px 20px;">
                <div style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: rgba(220,38,38,0.1); border-radius: 50%; filter: blur(30px); pointer-events: none;"></div>
                
                <div style="width:110px;height:110px;background:radial-gradient(circle, rgba(220,38,38,0.15), rgba(153,27,27,0.05));border:2px solid rgba(220,38,38,0.3);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:3.5rem;margin: 0 auto 20px;box-shadow: 0 0 25px rgba(220,38,38,0.15); transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="bi bi-person-fill text-danger"></i>
                </div>
                
                <h3 style="font-weight: 800; font-size: 1.5rem; margin-bottom: 4px; color: var(--white);">{{ $user->name }}</h3>
                <p style="color:var(--text-muted); font-size:0.95rem; margin-bottom: 16px;"><i class="bi bi-envelope-fill me-2"></i>{{ $user->email }}</p>
                
                <div class="d-inline-flex align-items-center justify-content-center px-3 py-2 rounded-pill" style="background: rgba(220,38,38,0.1); border: 1px solid rgba(220,38,38,0.2);">
                    <i class="bi bi-droplet-fill text-danger me-2"></i>
                    <span style="font-weight: 700; color: #fca5a5; font-size: 0.9rem;">Blood Group: {{ strtoupper($user->blood_group ?? 'N/A') }}</span>
                </div>
            </div>

            <!-- Password Card -->
            <div class="card-custom mb-4">
                <h5 style="font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:12px; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-shield-lock-fill text-secondary"></i> Security
                </h5>
                <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:20px;">Leave blank if you don't want to change your password.</p>
                
                <div class="mb-3">
                    <label for="password" class="form-label-custom"><i class="bi bi-key me-1"></i>New Password</label>
                    <input type="password" id="password" name="password" class="form-control-custom" placeholder="Enter new password">
                </div>
                <div>
                    <label for="password_confirmation" class="form-label-custom"><i class="bi bi-key-fill me-1"></i>Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control-custom" placeholder="Repeat password">
                </div>
            </div>
        </div>

        {{-- ══ RIGHT COLUMN: CONTACTS & EMERGENCY ══ --}}
        <div class="col-lg-8">
            <!-- Personal Contact Details -->
            <div class="card-custom mb-4 position-relative overflow-hidden">
                <div style="position: absolute; right: -30px; bottom: -30px; font-size: 8rem; color: rgba(255,255,255,0.02); pointer-events: none;">
                    <i class="bi bi-telephone-fill"></i>
                </div>
                
                <h5 style="font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-person-lines-fill text-info"></i> Personal Details
                </h5>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="phone" class="form-label-custom">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: rgba(255,255,255,0.05); border: 1px solid var(--dark-border); border-right: none; color: var(--text-muted);"><i class="bi bi-telephone"></i></span>
                            <input type="text" id="phone" name="phone"
                                   class="form-control-custom @error('phone') border-danger @enderror"
                                   style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="9876543210" required>
                        </div>
                        @error('phone')
                            <div class="text-danger mt-1" style="font-size:0.82rem;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="blood_group" class="form-label-custom">Blood Group</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: rgba(255,255,255,0.05); border: 1px solid var(--dark-border); border-right: none; color: var(--text-muted);"><i class="bi bi-droplet"></i></span>
                            <select id="blood_group" name="blood_group" class="form-control-custom" style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;" required>
                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                    <option value="{{ $bg }}" {{ old('blood_group', $user->blood_group) == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emergency Contacts -->
            <div class="card-custom mb-4">
                <h5 style="font-size:0.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:24px; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-heart-pulse-fill text-danger"></i> Emergency Contacts
                </h5>

                {{-- Contact 1 --}}
                <div class="p-3 mb-4 rounded" style="background: rgba(220,38,38,0.03); border: 1px solid rgba(220,38,38,0.15); position: relative;">
                    <span class="badge bg-danger position-absolute" style="top: -10px; left: 16px; font-size: 0.75rem; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(220,38,38,0.3);"><i class="bi bi-star-fill me-1"></i> PRIMARY CONTACT</span>
                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <label for="emergency_contact_name" class="form-label-custom">Full Name</label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                                   class="form-control-custom @error('emergency_contact_name') border-danger @enderror"
                                   value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}"
                                   placeholder="Name" required>
                            @error('emergency_contact_name')
                                <div class="text-danger mt-1" style="font-size:0.82rem;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="emergency_contact_phone" class="form-label-custom">Phone Number</label>
                            <input type="text" id="emergency_contact_phone" name="emergency_contact_phone"
                                   class="form-control-custom @error('emergency_contact_phone') border-danger @enderror"
                                   value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}"
                                   placeholder="Phone" required>
                            @error('emergency_contact_phone')
                                <div class="text-danger mt-1" style="font-size:0.82rem;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="relation" class="form-label-custom">Relation</label>
                            <select id="relation" name="relation" class="form-control-custom" required>
                                @foreach(['Father','Mother','Spouse','Sibling','Guardian','Other'] as $r)
                                    <option value="{{ $r }}" {{ old('relation', $user->relation) == $r ? 'selected' : '' }}>{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Contact 2 --}}
                <div class="p-3 mb-4 rounded" style="background: rgba(59,130,246,0.03); border: 1px solid rgba(59,130,246,0.15); position: relative;">
                    <span class="badge bg-primary position-absolute" style="top: -10px; left: 16px; font-size: 0.75rem; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(59,130,246,0.3);"><i class="bi bi-shield-plus me-1"></i> SECONDARY FAMILY (OPTIONAL)</span>
                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <label for="emergency_contact2_name" class="form-label-custom">Full Name</label>
                            <input type="text" id="emergency_contact2_name" name="emergency_contact2_name"
                                   class="form-control-custom @error('emergency_contact2_name') border-danger @enderror"
                                   value="{{ old('emergency_contact2_name', $user->emergency_contact2_name) }}"
                                   placeholder="Name">
                            @error('emergency_contact2_name')
                                <div class="text-danger mt-1" style="font-size:0.82rem;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="emergency_contact2_phone" class="form-label-custom">Phone Number</label>
                            <input type="text" id="emergency_contact2_phone" name="emergency_contact2_phone"
                                   class="form-control-custom @error('emergency_contact2_phone') border-danger @enderror"
                                   value="{{ old('emergency_contact2_phone', $user->emergency_contact2_phone) }}"
                                   placeholder="Phone">
                            @error('emergency_contact2_phone')
                                <div class="text-danger mt-1" style="font-size:0.82rem;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="emergency_contact2_relation" class="form-label-custom">Relation</label>
                            <select id="emergency_contact2_relation" name="emergency_contact2_relation" class="form-control-custom">
                                <option value="">— Select —</option>
                                @foreach(['Father','Mother','Spouse','Sibling','Guardian','Other'] as $r)
                                    <option value="{{ $r }}" {{ old('emergency_contact2_relation', $user->emergency_contact2_relation) == $r ? 'selected' : '' }}>{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Contact 3 --}}
                <div class="p-3 rounded" style="background: rgba(34,197,94,0.03); border: 1px solid rgba(34,197,94,0.15); position: relative;">
                    <span class="badge bg-success position-absolute" style="top: -10px; left: 16px; font-size: 0.75rem; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(34,197,94,0.3);"><i class="bi bi-people-fill me-1"></i> FRIEND / OTHER (OPTIONAL)</span>
                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <label for="emergency_contact3_name" class="form-label-custom">Full Name</label>
                            <input type="text" id="emergency_contact3_name" name="emergency_contact3_name"
                                   class="form-control-custom @error('emergency_contact3_name') border-danger @enderror"
                                   value="{{ old('emergency_contact3_name', $user->emergency_contact3_name) }}"
                                   placeholder="Name">
                            @error('emergency_contact3_name')
                                <div class="text-danger mt-1" style="font-size:0.82rem;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="emergency_contact3_phone" class="form-label-custom">Phone Number</label>
                            <input type="text" id="emergency_contact3_phone" name="emergency_contact3_phone"
                                   class="form-control-custom @error('emergency_contact3_phone') border-danger @enderror"
                                   value="{{ old('emergency_contact3_phone', $user->emergency_contact3_phone) }}"
                                   placeholder="Phone">
                            @error('emergency_contact3_phone')
                                <div class="text-danger mt-1" style="font-size:0.82rem;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="emergency_contact3_relation" class="form-label-custom">Relation</label>
                            <select id="emergency_contact3_relation" name="emergency_contact3_relation" class="form-control-custom">
                                <option value="">— Select —</option>
                                @foreach(['Friend','Colleague','Neighbour','Other'] as $r)
                                    <option value="{{ $r }}" {{ old('emergency_contact3_relation', $user->emergency_contact3_relation) == $r ? 'selected' : '' }}>{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Save Action -->
            <div class="text-end">
                <button type="submit" class="btn-primary-custom" style="padding: 14px 40px; font-size: 1rem; border-radius: 50px; box-shadow: 0 4px 15px rgba(220,38,38,0.3);">
                    <i class="bi bi-save me-2"></i> Save All Changes
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<style>
    /* Small animation for success alert */
    @keyframes slideInDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    /* Make input group texts look better */
    .input-group-text {
        border-color: var(--dark-border);
        background-color: rgba(255,255,255,0.03);
        color: var(--text-muted);
    }
    
    /* Enhance form controls when focused in group */
    .form-control-custom:focus + .input-group-text,
    .input-group:focus-within .input-group-text {
        border-color: var(--red-primary);
        color: var(--red-primary);
    }
</style>
<script>
/**
 * Client-side duplicate phone check before form submit.
 */
(function () {
    const form = document.getElementById('profile-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        const own   = document.getElementById('phone')?.value.trim();
        const c1    = document.getElementById('emergency_contact_phone')?.value.trim();
        const c2    = document.getElementById('emergency_contact2_phone')?.value.trim();
        const c3    = document.getElementById('emergency_contact3_phone')?.value.trim();

        const issues = [];

        if (c1 && c1 === own)  issues.push('Contact 1 matches your phone number.');
        if (c2) {
            if (c2 === own)    issues.push('Contact 2 matches your phone number.');
            if (c2 === c1)     issues.push('Contact 2 matches Contact 1.');
        }
        if (c3) {
            if (c3 === own)    issues.push('Contact 3 matches your phone number.');
            if (c3 === c1)     issues.push('Contact 3 matches Contact 1.');
            if (c2 && c3 === c2) issues.push('Contact 3 matches Contact 2.');
        }

        if (issues.length > 0) {
            e.preventDefault();
            let banner = document.getElementById('phone-dupe-banner');
            if (!banner) {
                banner = document.createElement('div');
                banner.id = 'phone-dupe-banner';
                banner.className = 'alert-custom alert-danger mb-4 shadow-sm';
                form.insertBefore(banner, form.firstChild);
            }
            banner.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i><div><strong>Duplicate numbers detected:</strong><ul style="margin:4px 0 0 16px; font-size: 0.9rem;">'
                + issues.map(i => `<li>${i}</li>`).join('')
                + '</ul></div>';
            banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
</script>
@endsection
