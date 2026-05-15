@extends('layouts.app')
@section('title', 'Add Emergency Details')

@section('content')
<div class="max-w-2xl mx-auto mt-4">
    <div class="mb-6 flex flex-col gap-4">
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 border border-slate-700 text-slate-300 hover:text-white transition-all w-max">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Dashboard
        </a>
        <div>
            <h1 class="text-3xl font-poppins font-bold text-white tracking-tight flex items-center gap-3">
                <i data-lucide="file-plus-2" class="w-8 h-8 text-primary"></i>
                Add Emergency Details
            </h1>
            <p class="text-slate-400 mt-2">Help responders prioritize by telling them what happened.</p>
        </div>
    </div>

    <div class="glass-card p-6 md:p-8 shadow-2xl relative overflow-hidden">
        <form action="{{ route('user.emergency.details.store', $emergency->id) }}" method="POST" class="relative z-10">
            @csrf

            <!-- Emergency Type Selector -->
            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">What is the emergency?</label>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @php
                    $types = [
                        ['value' => 'accident',    'icon' => 'car-front', 'color' => 'text-primary', 'label' => 'Accident'],
                        ['value' => 'heart_pain',  'icon' => 'heart-pulse', 'color' => 'text-red-500', 'label' => 'Heart Pain'],
                        ['value' => 'bleeding',    'icon' => 'droplets', 'color' => 'text-red-600', 'label' => 'Bleeding'],
                        ['value' => 'injury',      'icon' => 'bandaid', 'color' => 'text-orange-500', 'label' => 'Injury'],
                        ['value' => 'fever',       'icon' => 'thermometer-sun', 'color' => 'text-orange-600', 'label' => 'Fever'],
                        ['value' => 'other',       'icon' => 'help-circle', 'color' => 'text-secondary-blue', 'label' => 'Other'],
                    ];
                    @endphp

                    @foreach($types as $type)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="{{ $type['value'] }}" class="peer sr-only" {{ old('type') == $type['value'] ? 'checked' : '' }}>
                            <div class="flex flex-col items-center gap-3 p-4 rounded-xl bg-slate-900/50 border border-slate-800 transition-all peer-checked:bg-primary/10 peer-checked:border-primary peer-checked:shadow-[0_0_15px_rgba(255,59,48,0.2)] hover:bg-slate-800">
                                <i data-lucide="{{ $type['icon'] }}" class="w-8 h-8 {{ $type['color'] }} peer-checked:animate-bounce"></i>
                                <span class="text-sm font-semibold text-slate-300 peer-checked:text-white">{{ $type['label'] }}</span>
                            </div>
                            <div class="absolute inset-0 border-2 border-transparent rounded-xl peer-focus:border-primary/50 pointer-events-none"></div>
                        </label>
                    @endforeach
                </div>
                @error('type')
                    <div class="text-primary text-sm mt-3 font-medium flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Priority Info -->
            <div class="mb-8 p-4 rounded-xl bg-secondary-blue/10 border border-secondary-blue/30 text-slate-300 flex items-start gap-3">
                <i data-lucide="info" class="w-5 h-5 text-secondary-blue shrink-0 mt-0.5"></i>
                <div class="text-sm leading-relaxed">
                    <strong class="text-white block mb-1">Priority will be set automatically:</strong>
                    Accident / Bleeding &rarr; <span class="text-primary font-bold">Critical</span> &nbsp;|&nbsp;
                    Heart Pain &rarr; <span class="text-orange-500 font-bold">High</span> &nbsp;|&nbsp;
                    Fever &rarr; <span class="text-orange-400 font-bold">Medium</span> &nbsp;|&nbsp;
                    Other &rarr; <span class="text-slate-400 font-bold">Low</span>
                </div>
            </div>

            <!-- Additional Notes -->
            <div class="mb-8">
                <label for="notes" class="block text-sm font-bold text-slate-300 uppercase tracking-wider mb-2">Additional Notes (Optional)</label>
                <div class="relative">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i data-lucide="file-text" class="w-5 h-5 text-slate-500"></i>
                    </div>
                    <textarea id="notes" name="notes" rows="4"
                        class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl bg-slate-900/50 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none"
                        placeholder="Describe what happened in more detail...">{{ old('notes') }}</textarea>
                </div>
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-2 py-4 px-4 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-primary hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:ring-offset-slate-900 transition-all hover:scale-[1.02] shadow-[0_0_15px_rgba(255,59,48,0.3)]">
                <i data-lucide="send" class="w-5 h-5"></i>
                Update Emergency Details
            </button>
        </form>
    </div>
</div>
@endsection
