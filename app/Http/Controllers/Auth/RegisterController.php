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

        return redirect(localized_route('login'))
            ->with('status', __('customer.registration_disabled'));
    }
}
