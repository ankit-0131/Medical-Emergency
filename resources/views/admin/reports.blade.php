@extends('layouts.admin')
@section('title', 'Reports')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-poppins font-bold text-white tracking-tight flex items-center gap-3">
            <div class="p-2 bg-purple-500/20 rounded-xl">
                <i data-lucide="bar-chart-3" class="w-6 h-6 text-purple-500"></i>
            </div>
            Reports & Analytics
        </h1>
        <p class="text-slate-400 mt-2">Emergency statistics for the past 7 days</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
    <!-- Daily Emergencies Chart -->
    <div class="xl:col-span-8">
        <div class="glass-card p-6 h-full">
            <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <i data-lucide="trending-up" class="w-5 h-5 text-primary"></i> Emergencies Per Day (Last 7 Days)
            </h2>
            <div class="w-full h-[300px]">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Status Breakdown Chart -->
    <div class="xl:col-span-4">
        <div class="glass-card p-6 h-full flex flex-col">
            <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <i data-lucide="pie-chart" class="w-5 h-5 text-success-green"></i> Status Breakdown
            </h2>
            <div class="flex-1 flex items-center justify-center min-h-[250px]">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Priority Breakdown Chart -->
    <div class="xl:col-span-6">
        <div class="glass-card p-6">
            <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <i data-lucide="bar-chart" class="w-5 h-5 text-orange-500"></i> Priority Distribution
            </h2>
            <div class="w-full h-[250px]">
                <canvas id="priorityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Summary Numbers -->
    <div class="xl:col-span-6">
        <div class="glass-card p-6 h-full">
            <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <i data-lucide="list-checks" class="w-5 h-5 text-secondary-blue"></i> Status Summary
            </h2>
            
            <div class="flex flex-col gap-4">
                @foreach($statusData as $s)
                    <div class="flex items-center justify-between p-4 rounded-xl bg-slate-900/50 border border-slate-800 hover:bg-slate-800 transition-colors">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-bold
                            {{ $s->status == 'resolved' ? 'bg-success-green/20 text-success-green' : 
                              ($s->status == 'pending' ? 'bg-orange-500/20 text-orange-400' : 
                              ($s->status == 'in_progress' ? 'bg-secondary-blue/20 text-blue-400' : 
                              ($s->status == 'completed' ? 'bg-success-green/20 text-success-green' : 
                              'bg-slate-700/50 text-slate-300'))) }}">
                            <span class="w-2 h-2 rounded-full {{ $s->status == 'resolved' || $s->status == 'completed' ? 'bg-success-green' : ($s->status == 'pending' ? 'bg-orange-400' : ($s->status == 'in_progress' ? 'bg-blue-400' : 'bg-slate-400')) }}"></span>
                            {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                        </span>
                        <span class="text-3xl font-black text-white">{{ $s->count }}</span>
                    </div>
                @endforeach
                @if($statusData->isEmpty())
                    <div class="text-slate-500 text-center py-8">No data available for the past 7 days</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js default dark theme config
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.borderColor = 'rgba(51, 65, 85, 0.5)';
    Chart.defaults.font.family = "'Inter', sans-serif";

    // ── Daily Chart ──
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($dailyData->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
            datasets: [{
                label: 'Emergencies',
                data: {!! json_encode($dailyData->pluck('count')) !!},
                backgroundColor: 'rgba(255, 59, 48, 0.2)',
                borderColor: '#FF3B30',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(255, 59, 48, 0.4)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#cbd5e1',
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, padding: 10 },
                    grid: { color: 'rgba(51, 65, 85, 0.5)', drawBorder: false }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { padding: 10 }
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
                backgroundColor: ['#f97316', '#3b82f6', '#a855f7', '#22c55e', '#ef4444', '#64748b'],
                borderWidth: 2,
                borderColor: '#0f172a',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'bottom', 
                    labels: { padding: 20, boxWidth: 12, usePointStyle: true, font: { size: 12 } } 
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            cutout: '70%',
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
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)', // critical
                    'rgba(249, 115, 22, 0.8)', // high
                    'rgba(234, 179, 8, 0.8)', // medium
                    'rgba(59, 130, 246, 0.8)'  // low
                ],
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { stepSize: 1, padding: 10 }, 
                    grid: { color: 'rgba(51, 65, 85, 0.5)', drawBorder: false } 
                },
                x: { 
                    grid: { display: false, drawBorder: false },
                    ticks: { padding: 10 }
                }
            }
        }
    });
});
</script>
@endsection
