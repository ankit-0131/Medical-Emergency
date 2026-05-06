<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard with SOS button and latest emergency status.
     */
    public function index()
    {
        $user = Auth::user();

        // Get latest emergency for status display
        $latestEmergency = $user->latestEmergency;

        // Get count of total emergencies by this user
        $totalEmergencies = $user->emergencies()->count();

        return view('user.dashboard', compact('user', 'latestEmergency', 'totalEmergencies'));
    }
}
