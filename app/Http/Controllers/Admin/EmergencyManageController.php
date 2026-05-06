<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emergency;
use App\Mail\StatusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EmergencyManageController extends Controller
{
    /**
     * Show all emergencies with filters.
     */
    public function index(Request $request)
    {
        $query = Emergency::with('user')->latest();

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority if provided
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $emergencies = $query->paginate(15);

        return view('admin.emergencies', compact('emergencies'));
    }

    /**
     * Show detail view of a single emergency.
     */
    public function show($id)
    {
        $emergency = Emergency::with('user')->findOrFail($id);
        return view('admin.emergency_detail', compact('emergency'));
    }

    /**
     * Update the status of an emergency request.
     * Valid actions: accept, reject, in_progress, complete
     */
    public function updateStatus(Request $request, $id)
    {
        $emergency = Emergency::findOrFail($id);

        $request->validate([
            'action' => 'required|in:accept,reject,in_progress,complete',
        ]);

        // Map action to status
        $statusMap = [
            'accept'      => 'accepted',
            'reject'      => 'rejected',
            'in_progress' => 'in_progress',
            'complete'    => 'completed',
        ];

        $newStatus = $statusMap[$request->action];
        $now = Carbon::now();

        $updateData = ['status' => $newStatus];

        // Set timestamps based on action
        if ($request->action === 'accept') {
            $updateData['accepted_at'] = $now;
        }
        if ($request->action === 'complete') {
            $updateData['completed_at'] = $now;
        }

        $emergency->update($updateData);

        // Notify user via email about status change
        try {
            Mail::to($emergency->user->email)
                ->send(new StatusMail($emergency));
        } catch (\Exception $e) {
            Log::error('Status email failed: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Emergency status updated to: ' . strtoupper($newStatus));
    }
}
