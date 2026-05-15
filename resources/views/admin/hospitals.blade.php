@extends('layouts.admin')
@section('title', 'Hospital Management')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-poppins font-bold text-white tracking-tight flex items-center gap-3">
            <div class="p-2 bg-secondary-blue/20 rounded-xl">
                <i data-lucide="building-2" class="w-6 h-6 text-secondary-blue"></i>
            </div>
            Hospital Management
        </h1>
        <p class="text-slate-400 mt-2">Add, edit or remove hospitals from the directory</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- ══ LEFT: Add / Edit Form ══ -->
    <div class="lg:col-span-4">
        <div class="glass-card p-6 sticky top-6">
            <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                @if(isset($hospital))
                    <i data-lucide="edit" class="w-5 h-5 text-primary"></i> Edit Hospital
                @else
                    <i data-lucide="plus-circle" class="w-5 h-5 text-success-green"></i> Add New Hospital
                @endif
            </h2>

            @if(isset($hospital))
                <form action="{{ route('admin.hospitals.update', $hospital->id) }}" method="POST">
                    @csrf @method('PUT')
            @else
                <form action="{{ route('admin.hospitals.store') }}" method="POST">
                    @csrf
            @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Hospital Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="hospital" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input type="text" name="name" class="block w-full pl-10 pr-3 py-3 border {{ $errors->has('name') ? 'border-primary' : 'border-slate-700' }} rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                   value="{{ old('name', $hospital->name ?? '') }}" placeholder="City General Hospital" required>
                        </div>
                        @error('name')
                            <div class="text-primary text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Address</label>
                        <div class="relative">
                            <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                <i data-lucide="map-pin" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <textarea name="address" rows="3" class="block w-full pl-10 pr-3 py-3 border {{ $errors->has('address') ? 'border-primary' : 'border-slate-700' }} rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none"
                                      placeholder="Full hospital address" required>{{ old('address', $hospital->address ?? '') }}</textarea>
                        </div>
                        @error('address')
                            <div class="text-primary text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Phone Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="phone" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input type="text" name="phone" class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                   value="{{ old('phone', $hospital->phone ?? '') }}" placeholder="011-12345678" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Google Maps Link <span class="text-slate-500 font-normal">(Optional)</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="map" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input type="url" name="map_link" class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                   value="{{ old('map_link', $hospital->map_link ?? '') }}" placeholder="https://maps.google.com/?q=...">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit" class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-white bg-primary hover:bg-red-600 transition-all shadow-[0_0_15px_rgba(255,59,48,0.3)]">
                            <i data-lucide="save" class="w-4 h-4"></i> {{ isset($hospital) ? 'Update' : 'Add Hospital' }}
                        </button>
                        @if(isset($hospital))
                            <a href="{{ route('admin.hospitals') }}" class="flex items-center justify-center w-12 h-12 rounded-xl border border-slate-700 text-slate-400 hover:text-white hover:bg-slate-800 transition-all" title="Cancel">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ══ RIGHT: Hospitals Table ══ -->
    <div class="lg:col-span-8">
        <div class="glass-card shadow-2xl relative overflow-hidden">
            @if($hospitals->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-900/80 border-b border-slate-800 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                <th class="p-4">Hospital</th>
                                <th class="p-4">Phone</th>
                                <th class="p-4">Map</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/50 text-sm">
                            @foreach($hospitals as $h)
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="p-4">
                                        <div class="font-bold text-white flex items-center gap-2">
                                            <i data-lucide="building" class="w-4 h-4 text-slate-500"></i> {{ $h->name }}
                                        </div>
                                        <div class="text-xs text-slate-400 mt-1 line-clamp-1">{{ Str::limit($h->address, 50) }}</div>
                                    </td>
                                    <td class="p-4 text-slate-300 font-medium">
                                        <a href="tel:{{ $h->phone }}" class="hover:text-primary transition-colors flex items-center gap-1.5">
                                            <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-500"></i> {{ $h->phone }}
                                        </a>
                                    </td>
                                    <td class="p-4">
                                        @if($h->map_link)
                                            <a href="{{ $h->map_link }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-secondary-blue/10 text-secondary-blue hover:bg-secondary-blue/20 hover:text-blue-400 border border-secondary-blue/20 transition-colors text-xs font-semibold">
                                                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> Map
                                            </a>
                                        @else
                                            <span class="text-slate-600 font-medium">—</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.hospitals.edit', $h->id) }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 transition-colors">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.hospitals.destroy', $h->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this hospital?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 transition-colors">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
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
                    <div class="p-4 border-t border-slate-800/50 flex justify-center custom-pagination">
                        {{ $hospitals->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16 px-4">
                    <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-700">
                        <i data-lucide="building-2" class="w-10 h-10 text-slate-500"></i>
                    </div>
                    <p class="text-slate-400">No hospitals added yet. Use the form to add one.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
