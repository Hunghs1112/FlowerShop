<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('vipLevel');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $vipLevels = \App\Models\VipLevel::active()->ordered()->get();
        return view('admin.users.create', compact('vipLevels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:admin,customer',
            'vip_level_id' => 'nullable|exists:vip_levels,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Tạo người dùng thành công');
    }

    // ============================================================
    // AJAX: Update single field
    // ============================================================
    public function updateField(Request $request, User $user)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        // Validate field name to prevent mass assignment
        // NOTE: Password is NOT allowed for auto-save for security
        $allowedFields = [
            'name', 'email', 'phone', 'address', 'role', 'vip_level_id'
        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Trường không hợp lệ'
            ], 422);
        }

        // Validate specific fields
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:admin,customer',
            'vip_level_id' => 'nullable|exists:vip_levels,id',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make([$field => $value], [
            $field => $rules[$field] ?? 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first($field),
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $user->update([$field => $value]);

        return response()->json([
            'success' => true,
            'message' => 'Đã lưu ' . $field,
            'data' => [
                $field => $user->$field
            ]
        ]);
    }

    public function edit(User $user)
    {
        $vipLevels = \App\Models\VipLevel::active()->ordered()->get();
        return view('admin.users.edit', compact('user', 'vipLevels'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:admin,customer',
            'vip_level_id' => 'nullable|exists:vip_levels,id',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Cập nhật người dùng thành công');
    }

    /**
     * Update VIP level for a user (AJAX endpoint)
     */
    public function updateVipLevel(Request $request, User $user)
    {
        $validated = $request->validate([
            'vip_level_id' => 'nullable|exists:vip_levels,id',
        ]);

        $user->update(['vip_level_id' => $validated['vip_level_id']]);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật VIP level',
        ]);
    }
}
