@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-poppins font-bold text-white tracking-tight flex items-center gap-3">
            <div class="p-2 bg-secondary-blue/20 rounded-xl">
                <i data-lucide="user-circle" class="w-6 h-6 text-secondary-blue"></i>
            </div>
            My Profile
        </h1>
        <p class="text-slate-400 mt-2">Manage your personal information and emergency contacts</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 px-4 py-3 rounded-xl bg-success-green/10 border border-success-green/30 text-success-green flex items-start gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
        <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0 mt-0.5"></i>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

<form action="{{ route('user.profile.update') }}" method="POST" id="profile-form">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- ══ LEFT COLUMN: PROFILE SUMMARY & SECURITY ══ --}}
        <div class="lg:col-span-4 flex flex-col gap-8">
            <!-- Profile Info Card -->
            <div class="glass-card p-8 text-center relative overflow-hidden">
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-primary/20 rounded-full blur-3xl mix-blend-screen pointer-events-none"></div>
                
                <div class="w-28 h-28 mx-auto mb-4 bg-gradient-to-br from-primary/20 to-red-900/20 border-2 border-primary/30 rounded-full flex items-center justify-center shadow-[0_0_25px_rgba(255,59,48,0.15)] group hover:scale-105 transition-transform duration-300">
                    <i data-lucide="user" class="w-12 h-12 text-primary group-hover:animate-pulse"></i>
                </div>
                
                <h3 class="font-bold text-2xl text-white mb-1">{{ $user->name }}</h3>
                <p class="text-slate-400 text-sm mb-6 flex items-center justify-center gap-2">
                    <i data-lucide="mail" class="w-4 h-4"></i> {{ $user->email }}
                </p>
                
                <div class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-full bg-primary/10 border border-primary/20 text-red-400 font-bold text-sm">
                    <i data-lucide="droplet" class="w-4 h-4"></i>
                    Blood Group: {{ strtoupper($user->blood_group ?? 'N/A') }}
                </div>
            </div>

            <!-- Password Card -->
            <div class="glass-card p-6">
                <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-secondary-blue"></i> Security
                </h5>
                <p class="text-xs text-slate-400 mb-6">Leave blank if you don't want to change your password.</p>
                
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="key" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input type="password" id="password" name="password"
                                class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="Enter new password">
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="key-square" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="Repeat password">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ RIGHT COLUMN: CONTACTS & EMERGENCY ══ --}}
        <div class="lg:col-span-8 flex flex-col gap-8">
            <!-- Personal Contact Details -->
            <div class="glass-card p-6 relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 opacity-5 text-white pointer-events-none">
                    <i data-lucide="phone-call" class="w-48 h-48"></i>
                </div>
                
                <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-6 flex items-center gap-2">
                    <i data-lucide="contact" class="w-4 h-4 text-info text-blue-400"></i> Personal Details
                </h5>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-300 mb-2">Phone Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="phone" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required
                                class="block w-full pl-10 pr-3 py-3 border {{ $errors->has('phone') ? 'border-primary' : 'border-slate-700' }} rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="9876543210">
                        </div>
                        @error('phone')
                            <div class="text-primary text-xs mt-1 font-medium flex items-center gap-1"><i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="blood_group" class="block text-sm font-medium text-slate-300 mb-2">Blood Group</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="droplet" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <select id="blood_group" name="blood_group" required
                                class="block w-full pl-10 pr-10 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none">
                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                    <option value="{{ $bg }}" {{ old('blood_group', $user->blood_group) == $bg ? 'selected' : '' }} class="bg-slate-900">{{ $bg }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i data-lucide="chevron-down" class="w-5 h-5 text-slate-500"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emergency Contacts -->
            <div class="glass-card p-6">
                <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-8 flex items-center gap-2">
                    <i data-lucide="heart-pulse" class="w-4 h-4 text-primary"></i> Emergency Contacts
                </h5>

                {{-- Contact 1 --}}
                <div class="relative p-6 mb-8 rounded-xl bg-primary/5 border border-primary/20">
                    <span class="absolute -top-3 left-6 px-3 py-1 bg-primary text-white text-[10px] font-bold tracking-widest uppercase rounded-full shadow-[0_4px_10px_rgba(255,59,48,0.3)] flex items-center gap-1">
                        <i data-lucide="star" class="w-3 h-3"></i> Primary Contact
                    </span>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                        <div>
                            <label for="emergency_contact_name" class="block text-xs font-medium text-slate-400 mb-1">Full Name</label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                                class="w-full px-3 py-2 bg-slate-900/50 border {{ $errors->has('emergency_contact_name') ? 'border-primary' : 'border-slate-700' }} rounded-lg text-white focus:ring-2 focus:ring-primary focus:outline-none transition-all"
                                value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" placeholder="Name" required>
                            @error('emergency_contact_name')
                                <div class="text-primary text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="emergency_contact_phone" class="block text-xs font-medium text-slate-400 mb-1">Phone Number</label>
                            <input type="text" id="emergency_contact_phone" name="emergency_contact_phone"
                                class="w-full px-3 py-2 bg-slate-900/50 border {{ $errors->has('emergency_contact_phone') ? 'border-primary' : 'border-slate-700' }} rounded-lg text-white focus:ring-2 focus:ring-primary focus:outline-none transition-all"
                                value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}" placeholder="Phone" required>
                            @error('emergency_contact_phone')
                                <div class="text-primary text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="relation" class="block text-xs font-medium text-slate-400 mb-1">Relation</label>
                            <select id="relation" name="relation" class="w-full px-3 py-2 bg-slate-900/50 border border-slate-700 rounded-lg text-white focus:ring-2 focus:ring-primary focus:outline-none transition-all" required>
                                @foreach(['Father','Mother','Spouse','Sibling','Guardian','Other'] as $r)
                                    <option value="{{ $r }}" {{ old('relation', $user->relation) == $r ? 'selected' : '' }} class="bg-slate-900">{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Contact 2 --}}
                <div class="relative p-6 mb-8 rounded-xl bg-secondary-blue/5 border border-secondary-blue/20">
                    <span class="absolute -top-3 left-6 px-3 py-1 bg-secondary-blue text-white text-[10px] font-bold tracking-widest uppercase rounded-full shadow-[0_4px_10px_rgba(30,58,138,0.3)] flex items-center gap-1">
                        <i data-lucide="shield-plus" class="w-3 h-3"></i> Secondary Family (Optional)
                    </span>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                        <div>
                            <label for="emergency_contact2_name" class="block text-xs font-medium text-slate-400 mb-1">Full Name</label>
                            <input type="text" id="emergency_contact2_name" name="emergency_contact2_name"
                                class="w-full px-3 py-2 bg-slate-900/50 border {{ $errors->has('emergency_contact2_name') ? 'border-primary' : 'border-slate-700' }} rounded-lg text-white focus:ring-2 focus:ring-secondary-blue focus:outline-none transition-all"
                                value="{{ old('emergency_contact2_name', $user->emergency_contact2_name) }}" placeholder="Name">
                            @error('emergency_contact2_name')
                                <div class="text-primary text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="emergency_contact2_phone" class="block text-xs font-medium text-slate-400 mb-1">Phone Number</label>
                            <input type="text" id="emergency_contact2_phone" name="emergency_contact2_phone"
                                class="w-full px-3 py-2 bg-slate-900/50 border {{ $errors->has('emergency_contact2_phone') ? 'border-primary' : 'border-slate-700' }} rounded-lg text-white focus:ring-2 focus:ring-secondary-blue focus:outline-none transition-all"
                                value="{{ old('emergency_contact2_phone', $user->emergency_contact2_phone) }}" placeholder="Phone">
                            @error('emergency_contact2_phone')
                                <div class="text-primary text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="emergency_contact2_relation" class="block text-xs font-medium text-slate-400 mb-1">Relation</label>
                            <select id="emergency_contact2_relation" name="emergency_contact2_relation" class="w-full px-3 py-2 bg-slate-900/50 border border-slate-700 rounded-lg text-white focus:ring-2 focus:ring-secondary-blue focus:outline-none transition-all">
                                <option value="" class="text-slate-500">— Select —</option>
                                @foreach(['Father','Mother','Spouse','Sibling','Guardian','Other'] as $r)
                                    <option value="{{ $r }}" {{ old('emergency_contact2_relation', $user->emergency_contact2_relation) == $r ? 'selected' : '' }} class="bg-slate-900">{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Contact 3 --}}
                <div class="relative p-6 rounded-xl bg-success-green/5 border border-success-green/20">
                    <span class="absolute -top-3 left-6 px-3 py-1 bg-success-green text-white text-[10px] font-bold tracking-widest uppercase rounded-full shadow-[0_4px_10px_rgba(34,197,94,0.3)] flex items-center gap-1">
                        <i data-lucide="users" class="w-3 h-3"></i> Friend / Other (Optional)
                    </span>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                        <div>
                            <label for="emergency_contact3_name" class="block text-xs font-medium text-slate-400 mb-1">Full Name</label>
                            <input type="text" id="emergency_contact3_name" name="emergency_contact3_name"
                                class="w-full px-3 py-2 bg-slate-900/50 border {{ $errors->has('emergency_contact3_name') ? 'border-primary' : 'border-slate-700' }} rounded-lg text-white focus:ring-2 focus:ring-success-green focus:outline-none transition-all"
                                value="{{ old('emergency_contact3_name', $user->emergency_contact3_name) }}" placeholder="Name">
                            @error('emergency_contact3_name')
                                <div class="text-primary text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="emergency_contact3_phone" class="block text-xs font-medium text-slate-400 mb-1">Phone Number</label>
                            <input type="text" id="emergency_contact3_phone" name="emergency_contact3_phone"
                                class="w-full px-3 py-2 bg-slate-900/50 border {{ $errors->has('emergency_contact3_phone') ? 'border-primary' : 'border-slate-700' }} rounded-lg text-white focus:ring-2 focus:ring-success-green focus:outline-none transition-all"
                                value="{{ old('emergency_contact3_phone', $user->emergency_contact3_phone) }}" placeholder="Phone">
                            @error('emergency_contact3_phone')
                                <div class="text-primary text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="emergency_contact3_relation" class="block text-xs font-medium text-slate-400 mb-1">Relation</label>
                            <select id="emergency_contact3_relation" name="emergency_contact3_relation" class="w-full px-3 py-2 bg-slate-900/50 border border-slate-700 rounded-lg text-white focus:ring-2 focus:ring-success-green focus:outline-none transition-all">
                                <option value="" class="text-slate-500">— Select —</option>
                                @foreach(['Friend','Colleague','Neighbour','Other'] as $r)
                                    <option value="{{ $r }}" {{ old('emergency_contact3_relation', $user->emergency_contact3_relation) == $r ? 'selected' : '' }} class="bg-slate-900">{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Save Action -->
            <div class="flex justify-end">
                <button type="submit" class="flex items-center gap-2 px-8 py-3 rounded-full bg-primary text-white font-bold hover:bg-red-600 transition-all shadow-[0_4px_15px_rgba(255,59,48,0.3)] hover:scale-105">
                    <i data-lucide="save" class="w-5 h-5"></i> Save All Changes
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
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
                banner.className = 'mb-6 px-4 py-3 rounded-xl bg-primary/10 border border-primary/30 text-primary flex items-start gap-3 shadow-sm';
                form.insertBefore(banner, form.firstChild);
            }
            banner.innerHTML = '<i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5"></i><div><strong class="block mb-1">Duplicate numbers detected:</strong><ul class="list-disc pl-5 space-y-1 text-sm">'
                + issues.map(i => `<li>${i}</li>`).join('')
                + '</ul></div>';
            
            if (window.lucide) {
                window.lucide.createIcons();
            }
            banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
</script>
@endsection
