<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PopupController extends Controller
{
    public function index(Request $request)
    {
        $query = Popup::query();

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $popups = $query->sorted()->paginate(15)->withQueryString();

        return view('admin.popups.index', compact('popups'));
    }

    public function create()
    {
        return view('admin.popups.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_key' => 'required|string|max:50|unique:popups,id_key',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'id_key.unique' => 'Mã popup đã tồn tại. Vui lòng sử dụng mã khác.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['_token', '_method']);

        // Handle bullets array
        if (isset($data['bullets']) && is_array($data['bullets'])) {
            $data['bullets'] = array_filter($data['bullets'], fn($b) => !empty(trim($b)));
        } else {
            $data['bullets'] = null;
        }

        // Handle checkbox
        $data['is_active'] = $request->has('is_active');

        // Handle dates
        if ($request->has('countdown') && $request->countdown) {
            $data['countdown'] = $request->countdown . ':00';
        } else {
            $data['countdown'] = null;
        }

        $data['sort_order'] = $request->sort_order ?? 0;

        Popup::create($data);

        return redirect()->route('admin.popups.index')
            ->with('success', 'Popup đã được tạo thành công.');
    }

    public function edit(Popup $popup)
    {
        return view('admin.popups.edit', compact('popup'));
    }

    public function update(Request $request, Popup $popup)
    {
        $validator = Validator::make($request->all(), [
            'id_key' => 'required|string|max:50|unique:popups,id_key,' . $popup->id,
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'id_key.unique' => 'Mã popup đã tồn tại. Vui lòng sử dụng mã khác.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['_token', '_method']);

        // Handle bullets array
        if (isset($data['bullets']) && is_array($data['bullets'])) {
            $data['bullets'] = array_filter($data['bullets'], fn($b) => !empty(trim($b)));
        } else {
            $data['bullets'] = null;
        }

        // Handle checkbox
        $data['is_active'] = $request->has('is_active');

        // Handle dates
        if ($request->has('countdown') && $request->countdown) {
            $data['countdown'] = $request->countdown . ':00';
        } else {
            $data['countdown'] = null;
        }

        $data['sort_order'] = $request->sort_order ?? 0;

        $popup->update($data);

        return redirect()->back()
            ->with('success', 'Popup đã được cập nhật.');
    }

    public function destroy(Popup $popup)
    {
        $popup->delete();

        return redirect()->route('admin.popups.index')
            ->with('success', 'Popup đã được xóa.');
    }

    public function toggleActive(Popup $popup)
    {
        $popup->update(['is_active' => !$popup->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $popup->is_active
        ]);
    }

    public function updateSortOrder(Request $request, Popup $popup)
    {
        $request->validate([
            'sort_order' => 'required|integer|min:0'
        ]);

        $popup->update(['sort_order' => $request->sort_order]);

        return response()->json(['success' => true]);
    }
}
