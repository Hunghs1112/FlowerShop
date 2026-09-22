<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => ['required', Rule::in(['admin', 'customer'])],
            'vip_level_id' => 'nullable|exists:vip_levels,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên người dùng là bắt buộc',
            'name.max' => 'Tên người dùng không được vượt quá 255 ký tự',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'role.required' => 'Vui lòng chọn vai trò',
            'role.in' => 'Vai trò không hợp lệ',
            'vip_level_id.exists' => 'Cấp VIP không tồn tại',
        ];
    }
}
