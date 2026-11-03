<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\B2cInquiry;
use Illuminate\Http\Request;

class B2bInquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = B2cInquiry::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(fn ($q) => $q
                ->where('business_name', 'like', "%{$search}%")
                ->orWhere('contact_name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('contact_email', 'like', "%{$search}%"));
        }

        return view('admin.b2b-inquiries.index', [
            'inquiries' => $query->paginate(25)->withQueryString(),
        ]);
    }

    public function show(B2cInquiry $b2bInquiry)
    {
        return view('admin.b2b-inquiries.show', compact('b2bInquiry'));
    }

    public function updateStatus(Request $request, B2cInquiry $b2bInquiry)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,completed'],
        ]);

        $b2bInquiry->update($validated);

        return back()->with('success', 'Đã cập nhật trạng thái đơn B2B.');
    }
}
