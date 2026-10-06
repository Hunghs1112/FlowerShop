<?php $__env->startSection('page-title', 'Chi Tiết Mystery Box Request'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Chi Tiết Yêu Cầu <?php echo e($mysteryBox->request_id); ?></h1>
        <p class="admin-page-subtitle">Xem và cập nhật thông tin yêu cầu hộp hoa bí ẩn</p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.mystery-boxes.index')); ?>" class="btn btn-outline">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay lại danh sách
        </a>
    </div>
</div>

<div class="admin-grid" style="grid-template-columns: 2fr 1fr;">
    
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Thông Tin Yêu Cầu</h2>
            <span class="badge <?php echo e($mysteryBox->status_badge_class); ?>">
                <?php echo e($mysteryBox->status_label); ?>

            </span>
        </div>
        <div class="admin-card-body">
            
            <div class="detail-section">
                <h3 class="detail-section-title">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Thông Tin Khách Hàng
                </h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Họ và tên</span>
                        <span class="detail-value"><?php echo e($mysteryBox->name); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Số điện thoại</span>
                        <span class="detail-value text-mono"><?php echo e($mysteryBox->phone); ?></span>
                    </div>
                    <?php if($mysteryBox->email): ?>
                    <div class="detail-item">
                        <span class="detail-label">Email</span>
                        <span class="detail-value"><?php echo e($mysteryBox->email); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if($mysteryBox->user): ?>
                    <div class="detail-item">
                        <span class="detail-label">Tài khoản</span>
                        <span class="detail-value">
                            <a href="<?php echo e(route('admin.users.edit', $mysteryBox->user)); ?>" class="text-link">
                                <?php echo e($mysteryBox->user->email); ?>

                            </a>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="detail-section">
                <h3 class="detail-section-title">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Thông Tin Mystery Box
                </h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Phong cách</span>
                        <span class="detail-value">
                            <span class="badge badge-primary"><?php echo e($mysteryBox->style); ?></span>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Ngân sách</span>
                        <span class="detail-value">
                            <span class="badge badge-success"><?php echo e($mysteryBox->budget_range); ?></span>
                        </span>
                    </div>
                    <div class="detail-item full-width">
                        <span class="detail-label">Bảng màu</span>
                        <span class="detail-value">
                            <?php $__currentLoopData = $mysteryBox->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge badge-secondary"><?php echo e($color); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>
                    </div>
                    <div class="detail-item full-width">
                        <span class="detail-label">Sở thích</span>
                        <span class="detail-value">
                            <?php $__currentLoopData = $mysteryBox->preferences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge badge-info"><?php echo e($pref); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>
                    </div>
                    <div class="detail-item full-width">
                        <span class="detail-label">Mức độ bất ngờ</span>
                        <span class="detail-value"><?php echo e($mysteryBox->surprise_level); ?></span>
                    </div>
                    <?php if($mysteryBox->note): ?>
                    <div class="detail-item full-width">
                        <span class="detail-label">Ghi chú từ khách hàng</span>
                        <div class="note-box"><?php echo e($mysteryBox->note); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="detail-section">
                <h3 class="detail-section-title">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Thời Gian
                </h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Ngày tạo</span>
                        <span class="detail-value text-mono"><?php echo e($mysteryBox->created_at->format('d/m/Y H:i:s')); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Cập nhật lần cuối</span>
                        <span class="detail-value text-mono"><?php echo e($mysteryBox->updated_at->format('d/m/Y H:i:s')); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div>
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Trạng Thái</h2>
            </div>
            <div class="admin-card-body">
                <form action="<?php echo e(route('admin.mystery-boxes.updateStatus', $mysteryBox)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    
                    <div class="form-group">
                        <label class="form-label">Cập nhật trạng thái</label>
                        <select name="status" class="form-input" required>
                            <option value="new" <?php echo e($mysteryBox->status == 'new' ? 'selected' : ''); ?>>Mới</option>
                            <option value="reviewing" <?php echo e($mysteryBox->status == 'reviewing' ? 'selected' : ''); ?>>Đang xem xét</option>
                            <option value="confirmed" <?php echo e($mysteryBox->status == 'confirmed' ? 'selected' : ''); ?>>Đã xác nhận</option>
                            <option value="completed" <?php echo e($mysteryBox->status == 'completed' ? 'selected' : ''); ?>>Hoàn thành</option>
                            <option value="cancelled" <?php echo e($mysteryBox->status == 'cancelled' ? 'selected' : ''); ?>>Đã hủy</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Cập nhật
                    </button>
                </form>

                <div class="status-info" style="margin-top: 24px; padding: 16px; background: rgba(63, 90, 69, 0.05); border-radius: 8px; font-size: 0.875rem;">
                    <p style="margin: 0 0 8px; font-weight: 600;">Quy trình xử lý:</p>
                    <ul style="margin: 0; padding-left: 20px; line-height: 1.8;">
                        <li><strong>Mới:</strong> Yêu cầu vừa được tạo</li>
                        <li><strong>Đang xem xét:</strong> Đang kiểm tra hoa sẵn có</li>
                        <li><strong>Đã xác nhận:</strong> Đã xác nhận với khách</li>
                        <li><strong>Hoàn thành:</strong> Đã giao hàng</li>
                        <li><strong>Đã hủy:</strong> Khách hủy hoặc không thực hiện</li>
                    </ul>
                </div>
            </div>
        </div>

        
        <div class="admin-card" style="margin-top: 24px;">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Thông Tin Nhanh</h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                        <strong style="font-size: 0.875rem;"><?php echo e($mysteryBox->request_id); ?></strong>
                    </div>
                    <?php if($mysteryBox->phone): ?>
                    <a href="tel:<?php echo e($mysteryBox->phone); ?>" style="display: flex; align-items: center; gap: 8px; color: var(--color-primary); text-decoration: none;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span style="font-size: 0.875rem;"><?php echo e($mysteryBox->phone); ?></span>
                    </a>
                    <?php endif; ?>
                    <?php if($mysteryBox->email): ?>
                    <a href="mailto:<?php echo e($mysteryBox->email); ?>" style="display: flex; align-items: center; gap: 8px; color: var(--color-primary); text-decoration: none;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span style="font-size: 0.875rem;"><?php echo e($mysteryBox->email); ?></span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.detail-section {
    padding: 24px 0;
    border-bottom: 1px solid var(--color-border-light);
}

.detail-section:first-child {
    padding-top: 0;
}

.detail-section:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.detail-section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--color-text);
    margin: 0 0 16px;
}

.detail-section-title svg {
    color: var(--color-primary);
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--color-text-light);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.detail-value {
    font-size: 1rem;
    color: var(--color-text);
}

.note-box {
    padding: 12px;
    background: rgba(63, 90, 69, 0.05);
    border: 1px solid var(--color-border);
    border-radius: 8px;
    line-height: 1.6;
    white-space: pre-wrap;
}

.text-link {
    color: var(--color-primary);
    text-decoration: none;
}

.text-link:hover {
    text-decoration: underline;
}

@media (max-width: 1023px) {
    .admin-grid {
        grid-template-columns: 1fr !important;
    }

    .detail-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\mystery-boxes\show.blade.php ENDPATH**/ ?>