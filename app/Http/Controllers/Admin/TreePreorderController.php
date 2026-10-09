<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class TreePreorderController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'status' => $request->input('status'),
            'search' => $request->input('search'),
        ];

        $query = Inquiry::with('user')
            ->where('type', 'tree_preorder');

        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }

        if ($filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone', 'like', '%' . $filters['search'] . '%');
            });
        }

        $preorders = $query->latest()->get();

        $statusCounts = [
            'all' => Inquiry::where('type', 'tree_preorder')->count(),
            'new' => Inquiry::where('type', 'tree_preorder')->where('status', 'new')->count(),
            'contacted' => Inquiry::where('type', 'tree_preorder')->where('status', 'contacted')->count(),
            'completed' => Inquiry::where('type', 'tree_preorder')->where('status', 'completed')->count(),
            'cancelled' => Inquiry::where('type', 'tree_preorder')->where('status', 'cancelled')->count(),
        ];

        return view('admin.tree-preorders.index', compact('preorders', 'statusCounts', 'filters'));
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load('user');

        return view('admin.tree-preorders.show', compact('inquiry'));
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
