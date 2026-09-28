<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px;">
    
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    Thông Tin Người Dùng
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Họ Tên <span style="color: var(--admin-error);">*</span></label>
                        <input type="text" name="name" value="<?php echo e(old('name', $user->name ?? '')); ?>" 
                               class="auto-save-input"
                               data-entity="users"
                               data-id="<?php echo e($user->id ?? ''); ?>"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; transition: all 0.2s;" 
                               required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Email <span style="color: var(--admin-error);">*</span></label>
                            <input type="email" name="email" value="<?php echo e(old('email', $user->email ?? '')); ?>" 
                                   class="auto-save-input"
                                   data-entity="users"
                                   data-id="<?php echo e($user->id ?? ''); ?>"
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;" 
                                   required>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Điện Thoại</label>
                            <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone ?? '')); ?>" 
                                   class="auto-save-input"
                                   data-entity="users"
                                   data-id="<?php echo e($user->id ?? ''); ?>"
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Địa Chỉ</label>
                        <textarea name="address" rows="3" 
                                  class="auto-save-input"
                                  data-entity="users"
                                  data-id="<?php echo e($user->id ?? ''); ?>"
                                  style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;"><?php echo e(old('address', $user->address ?? '')); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    Mật Khẩu
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <?php if(!isset($user)): ?>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mật Khẩu <span style="color: var(--admin-error);">*</span></label>
                            <input type="password" name="password" 
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;" 
                                   required>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Xác Nhận Mật Khẩu <span style="color: var(--admin-error);">*</span></label>
                            <input type="password" name="password_confirmation" 
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;" 
                                   required>
                        </div>
                    <?php else: ?>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mật Khẩu Mới</label>
                            <input type="password" name="password" 
                                   placeholder="Để trống nếu giữ nguyên"
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;">
                            <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Để trống nếu muốn giữ mật khẩu hiện tại</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    Vai Trò
                </h2>
            </div>
            <div class="admin-card-body">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Vai Trò Người Dùng <span style="color: var(--admin-error);">*</span></label>
                    <select name="role" 
                            class="auto-save-select"
                            data-entity="users"
                            data-id="<?php echo e($user->id ?? ''); ?>"
                            style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; background: white;" 
                            required>
                        <option value="customer" <?php echo e(old('role', $user->role ?? 'customer') === 'customer' ? 'selected' : ''); ?>>👤 Khách hàng</option>
                        <option value="admin" <?php echo e(old('role', $user->role ?? '') === 'admin' ? 'selected' : ''); ?>>🔐 Quản trị viên</option>
                    </select>
                </div>
            </div>
        </div>

        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    VIP Level
                </h2>
            </div>
            <div class="admin-card-body">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Cấp độ VIP</label>
                    <select name="vip_level_id" 
                            class="auto-save-select"
                            data-entity="users"
                            data-id="<?php echo e($user->id ?? ''); ?>"
                            style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; background: white;">
                        <option value="">Không có VIP</option>
                        <?php if(isset($vipLevels)): ?>
                            <?php $__currentLoopData = $vipLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vipLevel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($vipLevel->id); ?>" <?php echo e(old('vip_level_id', $user->vip_level_id ?? '') == $vipLevel->id ? 'selected' : ''); ?>>
                                    <?php echo e($vipLevel->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                    <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Chọn cấp độ VIP cho người dùng này</small>
                </div>
            </div>
        </div>

        <?php if(!isset($isEdit) || !$isEdit): ?>
        
        <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px; font-size: 15px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <?php echo e(isset($user) ? 'Cập Nhật' : 'Tạo Người Dùng'); ?>

        </button>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /root/FlowerShop/resources/views/admin/users/form.blade.php ENDPATH**/ ?>