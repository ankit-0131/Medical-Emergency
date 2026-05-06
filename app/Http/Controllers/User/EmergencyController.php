<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Emergency;
use App\Mail\EmergencyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EmergencyController extends Controller
{
    /**
     * Handle SOS button click - Save emergency and send alerts.
     * Always returns JSON (never redirects) so the AJAX call works.
     */
    public function sos(Request $request)
    {
        $user = Auth::user();

        // ── DUPLICATE PREVENTION ──
        // Block if user triggered SOS in the last 60 seconds
        $recentEmergency = Emergency::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subSeconds(60))
            ->first();

        if ($recentEmergency) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait 60 seconds before sending another SOS.',
            ], 429);
        }

        // ── VALIDATE LOCATION DATA ──
        // Convert empty strings to null before validation so numeric rule doesn't fail
        $latitude  = $request->input('latitude')  !== '' ? $request->input('latitude')  : null;
        $longitude = $request->input('longitude') !== '' ? $request->input('longitude') : null;
        $address   = $request->input('address')   !== '' ? $request->input('address')   : null;

        // Validate only when values are present
        if ($latitude !== null && !is_numeric($latitude)) {
            return response()->json(['success' => false, 'message' => 'Invalid location data.'], 422);
        }
        if ($longitude !== null && !is_numeric($longitude)) {
            return response()->json(['success' => false, 'message' => 'Invalid location data.'], 422);
        }

        // ── CREATE EMERGENCY RECORD ──
        $emergency = Emergency::create([
            'user_id'   => $user->id,
            'latitude'  => $latitude,
            'longitude' => $longitude,
            'address'   => $address,
            'priority'  => 'high',    // Default priority is High
            'status'    => 'pending', // Initial status is Pending
        ]);

        // ── SEND EMAIL ALERTS ──
        // Try sending emails; if they fail, still save the emergency (don't block SOS)
        try {
            // Notify admin
            $adminEmail = env('ADMIN_EMAIL', 'admin@medicalapp.com');
            Mail::to($adminEmail)->send(new EmergencyMail($emergency, 'admin'));

            // Notify the user's own email (as proxy for emergency contacts alert)
            Mail::to($user->email)->send(new EmergencyMail($emergency, 'contact'));

        } catch (\Exception $e) {
            Log::error('Emergency email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success'      => true,
            'message'      => 'Emergency Sent Successfully!',
            'emergency_id' => $emergency->id,
            'map_link'     => $emergency->map_link,
        ]);
    }

    /**
     * Show the "Add Details" form after SOS is sent.
     */
    public function showDetails($id)
    {
        $emergency = Emergency::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.emergency_details', compact('emergency'));
    }

    /**
     * Update emergency with additional details and recalculate priority.
     */
    public function updateDetails(Request $request, $id)
    {
        $emergency = Emergency::where('user_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'type'  => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        // ── PRIORITY CALCULATION based on emergency type ──
        $priority = match ($request->type) {
            'accident', 'bleeding', 'unconscious' => 'critical',
            'heart_pain'                           => 'high',
            'fever'                                => 'medium',
            default                                => 'low',
        };

        $emergency->update([
            'notes'    => $request->notes ?? $request->type,
            'priority' => $priority,
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Emergency details updated. Priority set to: ' . strtoupper($priority));
    }

    /**
     * Show the emergency history table.
     */
    public function history()
    {
        $emergencies = Emergency::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.history', compact('emergencies'));
    }
}
