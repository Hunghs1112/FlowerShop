<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\VipLevel;
use App\Repositories\UserRepository;
use App\Services\AjaxFieldService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected UserRepository $users;
    protected AjaxFieldService $ajaxFieldService;

    public function __construct(
        UserRepository $users,
        AjaxFieldService $ajaxFieldService
    ) {
        $this->users = $users;
        $this->ajaxFieldService = $ajaxFieldService;
        
    }

    public function index(Request $request)
    {

        $filters = [
            'search' => $request->input('search'),
            'role' => $request->input('role'),
        ];

        $query = User::with('vipLevel');

        if ($filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone', 'like', '%' . $filters['search'] . '%');
            });
        }
        if ($filters['role']) {
            $query->where('role', $filters['role']);
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users', 'filters'));
    }

    public function create()
    {
        
        $vipLevels = VipLevel::active()->ordered()->get();
        return view('admin.users.create', compact('vipLevels'));
    }

    public function store(StoreUserRequest $request)
    {

        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $this->users->create($validated);

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

        // Define allowed fields (password excluded for security)
        $fieldConfig = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:admin,customer',
            'vip_level_id' => 'nullable|exists:vip_levels,id',
        ];

        return $this->ajaxFieldService->handleAjaxFieldUpdate(
            $user,
            $field,
            $value,
            $fieldConfig
        );
    }

    public function edit(User $user)
    {
        
        $vipLevels = VipLevel::active()->ordered()->get();
        return view('admin.users.edit', compact('user', 'vipLevels'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        $validated = $request->validated();

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
