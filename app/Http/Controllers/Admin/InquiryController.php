<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {

        $filters = [
            'status' => $request->input('status'),
            'search' => $request->input('search'),
        ];

        $query = Inquiry::with(['user', 'products']);

        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }

        if ($filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        $inquiries = $query->latest()->get();

        $statusCounts = [
            'all' => Inquiry::count(),
            'new' => Inquiry::where('status', 'new')->count(),
            'contacted' => Inquiry::where('status', 'contacted')->count(),
            'completed' => Inquiry::where('status', 'completed')->count(),
            'cancelled' => Inquiry::where('status', 'cancelled')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'statusCounts', 'filters'));
    }

    public function show(Inquiry $inquiry)
    {

        $inquiry->load(['user', 'products.productImages', 'products.category']);

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {

        $validated = $request->validate([
            'status' => 'required|in:new,contacted,completed,cancelled',
            'admin_notes' => 'nullable|string',
        ]);

        $inquiry->update($validated);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    }
}
