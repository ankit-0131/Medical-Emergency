<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emergency;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with statistics cards.
     */
    public function index()
    {
        // Aggregate statistics for dashboard cards
        $stats = [
            'total'     => Emergency::count(),
            'pending'   => Emergency::where('status', 'pending')->count(),
            'active'    => Emergency::whereIn('status', ['accepted', 'in_progress'])->count(),
            'completed' => Emergency::where('status', 'completed')->count(),
            'high'      => Emergency::whereIn('priority', ['high', 'critical'])->count(),
        ];

        // Get 5 most recent emergencies for the quick view table
        $recentEmergencies = Emergency::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentEmergencies'));
    }
}
