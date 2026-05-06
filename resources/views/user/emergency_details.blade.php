@extends('layouts.app')
@section('title', 'Add Emergency Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="page-header">
            <a href="{{ route('user.dashboard') }}" class="btn-outline-custom mb-3">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
            <h1 class="page-title">Add Emergency Details</h1>
            <p class="page-subtitle">Help responders prioritize by telling them what happened.</p>
        </div>

        <div class="card-custom">
            <form action="{{ route('user.emergency.details.store', $emergency->id) }}" method="POST">
                @csrf

                <!-- Emergency Type Selector -->
                <div class="mb-4">
                    <label class="form-label-custom mb-3">What is the emergency?</label>
                    <div class="type-selector">
                        @php
                        $types = [
                            ['value' => 'accident',    'icon' => '<i class="bi bi-car-front-fill text-primary"></i>', 'label' => 'Accident'],
                            ['value' => 'heart_pain',  'icon' => '<i class="bi bi-heart-pulse-fill text-danger"></i>', 'label' => 'Heart Pain'],
                            ['value' => 'bleeding',    'icon' => '<i class="bi bi-droplet-fill text-danger"></i>', 'label' => 'Bleeding'],
                            ['value' => 'injury',      'icon' => '<i class="bi bi-bandaid-fill text-warning"></i>', 'label' => 'Injury'],
                            ['value' => 'fever',       'icon' => '<i class="bi bi-thermometer-high text-danger"></i>', 'label' => 'Fever'],
                            ['value' => 'other',       'icon' => '<i class="bi bi-question-circle-fill text-info"></i>', 'label' => 'Other'],
                        ];
                        @endphp

                        @foreach($types as $type)
                            <div class="type-option">
                                <input type="radio" name="type"
                                       id="type_{{ $type['value'] }}"
                                       value="{{ $type['value'] }}"
                                       {{ old('type') == $type['value'] ? 'checked' : '' }}>
                                <label for="type_{{ $type['value'] }}">
                                    <span class="type-icon">{!! $type['icon'] !!}</span>
                                    {{ $type['label'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('type')
                        <div style="color:#f87171; font-size:0.82rem; margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Priority Info -->
                <div class="alert-custom alert-info mb-4" style="font-size:0.82rem;">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        <strong>Priority will be set automatically:</strong><br>
                        Accident / Bleeding → Critical &nbsp;|&nbsp;
                        Heart Pain → High &nbsp;|&nbsp;
                        Fever → Medium &nbsp;|&nbsp;
                        Other → Low
                    </div>
                </div>

                <!-- Additional Notes -->
                <div class="mb-4">
                    <label for="notes" class="form-label-custom">Additional Notes (Optional)</label>
                    <textarea id="notes" name="notes"
                              class="form-control-custom"
                              rows="3"
                              placeholder="Describe what happened in more detail...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="padding:13px;">
                    <i class="bi bi-send-check"></i> Update Emergency Details
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
