@extends('layouts.admin')
@section('title', 'Hospital Management')

@section('content')
<div class="page-header">
    <h1 class="page-title">Hospital Management</h1>
    <p class="page-subtitle">Add, edit or remove hospitals from the directory</p>
</div>

<div class="row g-4">
    <!-- ══ LEFT: Add / Edit Form ══ -->
    <div class="col-lg-4">
        <div class="card-custom">
            <h2 style="font-size:1rem; font-weight:700; margin-bottom:16px;">
                {!! isset($hospital) ? '<i class="bi bi-pencil-square"></i> Edit Hospital' : '<i class="bi bi-plus-circle"></i> Add New Hospital' !!}
            </h2>

            @if(isset($hospital))
                <form action="{{ route('admin.hospitals.update', $hospital->id) }}" method="POST">
                    @csrf @method('PUT')
            @else
                <form action="{{ route('admin.hospitals.store') }}" method="POST">
                    @csrf
            @endif

                <div class="mb-3">
                    <label class="form-label-custom">Hospital Name</label>
                    <input type="text" name="name" class="form-control-custom"
                           value="{{ old('name', $hospital->name ?? '') }}"
                           placeholder="City General Hospital" required>
                    @error('name')
                        <div style="color:#f87171; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label-custom">Address</label>
                    <textarea name="address" class="form-control-custom" rows="2"
                              placeholder="Full hospital address" required>{{ old('address', $hospital->address ?? '') }}</textarea>
                    @error('address')
                        <div style="color:#f87171; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label-custom">Phone Number</label>
                    <input type="text" name="phone" class="form-control-custom"
                           value="{{ old('phone', $hospital->phone ?? '') }}"
                           placeholder="011-12345678" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-custom">Google Maps Link (Optional)</label>
                    <input type="url" name="map_link" class="form-control-custom"
                           value="{{ old('map_link', $hospital->map_link ?? '') }}"
                           placeholder="https://maps.google.com/?q=...">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-primary-custom flex-fill justify-content-center">
                        <i class="bi bi-save"></i> {{ isset($hospital) ? 'Update' : 'Add Hospital' }}
                    </button>
                    @if(isset($hospital))
                        <a href="{{ route('admin.hospitals') }}" class="btn-outline-custom">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- ══ RIGHT: Hospitals Table ══ -->
    <div class="col-lg-8">
        <div class="card-custom">
            @if($hospitals->count() > 0)
                <div style="overflow-x:auto;">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Hospital</th>
                                <th>Phone</th>
                                <th>Map</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hospitals as $h)
                                <tr>
                                    <td>
                                        <div style="font-weight:600;">{{ $h->name }}</div>
                                        <div style="font-size:0.78rem; color:var(--text-muted);">{{ Str::limit($h->address, 50) }}</div>
                                    </td>
                                    <td style="font-size:0.85rem;">{{ $h->phone }}</td>
                                    <td>
                                        @if($h->map_link)
                                            <a href="{{ $h->map_link }}" target="_blank" class="map-btn">
                                                <i class="bi bi-geo-alt-fill"></i> Map
                                            </a>
                                        @else
                                            <span style="color:var(--text-muted); font-size:0.82rem;">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.hospitals.edit', $h->id) }}"
                                               class="btn-outline-custom" style="padding:5px 10px; font-size:0.78rem;">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.hospitals.destroy', $h->id) }}" method="POST" class="delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.25);color:#f87171;padding:5px 10px;border-radius:6px;font-size:0.78rem;cursor:pointer;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($hospitals->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $hospitals->links() }}
                    </div>
                @endif
            @else
                <div style="text-align:center; padding:40px; color:var(--text-muted);">
                    <div style="margin-bottom:8px;"><i class="bi bi-hospital text-muted" style="font-size:2.5rem;"></i></div>
                    <p style="font-size:0.9rem;">No hospitals added yet. Use the form to add one.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
