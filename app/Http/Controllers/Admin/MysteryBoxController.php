<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MysteryBoxRequest;
use Illuminate\Http\Request;

class MysteryBoxController extends Controller
{
    /**
     * Display a listing of mystery box requests
     */
    public function index(Request $request)
    {
        $query = MysteryBoxRequest::with('user')->latest();

        // Filter by status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Search by customer name, phone, or request ID
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('request_id', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $mysteryBoxRequests = $query->get();

        // Status counts for filter tabs
        $statusCounts = [
            'all' => MysteryBoxRequest::count(),
            'new' => MysteryBoxRequest::where('status', 'new')->count(),
            'reviewing' => MysteryBoxRequest::where('status', 'reviewing')->count(),
            'confirmed' => MysteryBoxRequest::where('status', 'confirmed')->count(),
            'completed' => MysteryBoxRequest::where('status', 'completed')->count(),
            'cancelled' => MysteryBoxRequest::where('status', 'cancelled')->count(),
        ];

        return view('admin.mystery-boxes.index', compact('mysteryBoxRequests', 'statusCounts'));
    }

    /**
     * Display the specified mystery box request
     */
    public function show(MysteryBoxRequest $mysteryBox)
    {
        $mysteryBox->load('user');
        
        return view('admin.mystery-boxes.show', compact('mysteryBox'));
    }

    /**
     * Update the status of mystery box request
     */
    public function updateStatus(Request $request, MysteryBoxRequest $mysteryBox)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,reviewing,confirmed,completed,cancelled',
        ]);

        $mysteryBox->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    }
}
