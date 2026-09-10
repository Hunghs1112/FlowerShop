<div class="form-container">
    <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Thông Tin Người Dùng</h2>
            </div>
            <div class="admin-card-body">
                <div class="form-group">
                    <label class="form-label required">Họ Tên</label>
                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" 
                           class="form-input @error('name') error @enderror" required>
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" 
                               class="form-input @error('email') error @enderror" required>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Điện Thoại</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" 
                               class="form-input @error('phone') error @enderror">
                        @error('phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if(!isset($user))
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Mật Khẩu</label>
                        <input type="password" name="password" 
                               class="form-input @error('password') error @enderror" required>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Xác Nhận Mật Khẩu</label>
                        <input type="password" name="password_confirmation" 
                               class="form-input" required>
                    </div>
                </div>
                @else
                <div class="form-group">
                    <label class="form-label">Mật Khẩu Mới</label>
                    <input type="password" name="password" 
                           class="form-input @error('password') error @enderror">
                    <small class="form-help">Để trống nếu muốn giữ mật khẩu hiện tại</small>
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Địa Chỉ</label>
                    <textarea name="address" rows="3" 
                              class="form-input @error('address') error @enderror">{{ old('address', $user->address ?? '') }}</textarea>
                    @error('address')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Vai Trò Người Dùng</label>
                    <select name="role" class="form-input @error('role') error @enderror" required>
                        <option value="customer" {{ old('role', $user->role ?? 'customer') === 'customer' ? 'selected' : '' }}>Khách hàng</option>
                        <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                    </select>
                    @error('role')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">
                {{ isset($user) ? 'Cập Nhật' : 'Tạo Người Dùng' }}
            </button>
        </div>
</div>

