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

        $query = Inquiry::with('user')
            ->where('type', 'contact');

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
            'all' => Inquiry::where('type', 'contact')->count(),
            'new' => Inquiry::where('type', 'contact')->where('status', 'new')->count(),
            'contacted' => Inquiry::where('type', 'contact')->where('status', 'contacted')->count(),
            'completed' => Inquiry::where('type', 'contact')->where('status', 'completed')->count(),
            'cancelled' => Inquiry::where('type', 'contact')->where('status', 'cancelled')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'statusCounts', 'filters'));
    }

    public function show(Inquiry $inquiry)
    {

        $inquiry->load('user');

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

    public function autoSave(Request $request, Inquiry $inquiry)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        if ($field === 'status') {
            $validated = $request->validate([
                'field' => 'required',
                'value' => 'required|in:new,contacted,completed,cancelled',
            ]);
            $inquiry->update(['status' => $validated['value']]);
            return response()->json(['success' => true, 'message' => 'Đã cập nhật trạng thái']);
        }

        return response()->json(['success' => false, 'message' => 'Trường không hợp lệ'], 422);
    }
}
