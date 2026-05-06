<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emergency;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show the reports page with chart data.
     */
    public function index()
    {
        // Last 7 days emergencies count per day
        $dailyData = Emergency::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Status breakdown
        $statusData = Emergency::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Priority breakdown
        $priorityData = Emergency::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->get();

        return view('admin.reports', compact('dailyData', 'statusData', 'priorityData'));
    }
}
