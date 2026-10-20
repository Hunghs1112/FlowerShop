<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (auth()->user()?->isAdmin()) {
            return redirect()->route('admin.users.create');
        }

        return redirect()->route('login')
            ->with('status', 'Tài khoản mới do cửa hàng tạo. Vui lòng liên hệ quản trị viên để được cấp tài khoản.');
    }
}
