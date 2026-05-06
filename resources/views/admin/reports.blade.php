@extends('layouts.admin')
@section('title', 'Reports')

@section('content')
<div class="page-header">
    <h1 class="page-title">Reports & Analytics</h1>
    <p class="page-subtitle">Emergency statistics for the past 7 days</p>
</div>

<div class="row g-4">
    <!-- Daily Emergencies Chart -->
    <div class="col-lg-8">
        <div class="card-custom">
            <h2 style="font-size:1rem; font-weight:700; margin-bottom:20px;">
                <i class="bi bi-graph-up text-primary"></i> Emergencies Per Day (Last 7 Days)
            </h2>
            <canvas id="dailyChart" height="100"></canvas>
        </div>
    </div>

    <!-- Status Breakdown Chart -->
    <div class="col-lg-4">
        <div class="card-custom">
            <h2 style="font-size:1rem; font-weight:700; margin-bottom:20px;">
                <i class="bi bi-pie-chart-fill text-success"></i> Status Breakdown
            </h2>
            <canvas id="statusChart" height="200"></canvas>
        </div>
    </div>

    <!-- Priority Breakdown Chart -->
    <div class="col-lg-6">
        <div class="card-custom">
            <h2 style="font-size:1rem; font-weight:700; margin-bottom:20px;">
                <i class="bi bi-bar-chart-fill text-danger"></i> Priority Distribution
            </h2>
            <canvas id="priorityChart" height="120"></canvas>
        </div>
    </div>

    <!-- Summary Numbers -->
    <div class="col-lg-6">
        <div class="card-custom">
            <h2 style="font-size:1rem; font-weight:700; margin-bottom:20px;">
                <i class="bi bi-card-list text-info"></i> Status Summary
            </h2>
            @foreach($statusData as $s)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="status-badge badge-{{ $s->status }}">
                        {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                    </span>
                    <span style="font-size:1.4rem; font-weight:800;">{{ $s->count }}</span>
                </div>
            @endforeach
            @if($statusData->isEmpty())
                <div style="color:var(--text-muted); text-align:center; padding:20px 0;">No data yet</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Chart.js default dark theme config
Chart.defaults.color = '#94a3b8';
Chart.defaults.borderColor = '#334155';

// ── Daily Chart ──
const dailyCtx = document.getElementById('dailyChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($dailyData->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
        datasets: [{
            label: 'Emergencies',
            data: {!! json_encode($dailyData->pluck('count')) !!},
            backgroundColor: 'rgba(220, 38, 38, 0.6)',
            borderColor: '#dc2626',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1, color: '#94a3b8' },
                grid: { color: '#1e293b' }
            },
            x: {
                ticks: { color: '#94a3b8' },
                grid: { display: false }
            }
        }
    }
});

// ── Status Donut Chart ──
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($statusData->pluck('status')->map(fn($s) => ucfirst(str_replace('_', ' ', $s)))) !!},
        datasets: [{
            data: {!! json_encode($statusData->pluck('count')) !!},
            backgroundColor: ['#f59e0b','#3b82f6','#8b5cf6','#22c55e','#ef4444'],
            borderWidth: 2,
            borderColor: '#1e293b',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { padding: 12, boxWidth: 14 } }
        },
        cutout: '65%',
    }
});

// ── Priority Bar Chart ──
const priorityCtx = document.getElementById('priorityChart').getContext('2d');
new Chart(priorityCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($priorityData->pluck('priority')->map(fn($p) => ucfirst($p))) !!},
        datasets: [{
            label: 'Count',
            data: {!! json_encode($priorityData->pluck('count')) !!},
            backgroundColor: ['#ef4444','#f59e0b','#3b82f6','#94a3b8'],
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1, color: '#94a3b8' }, grid: { color: '#1e293b' } },
            x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
        }
    }
});
</script>
@endsection
