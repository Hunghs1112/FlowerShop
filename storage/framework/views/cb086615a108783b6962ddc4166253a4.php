<?php $__env->startSection('page-title', 'Quản Lý Banner'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Banner</h1>
        <p class="admin-page-subtitle">Banner slider hiển thị ở trang chủ</p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Banner
        </a>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success" style="margin-bottom: 24px;">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <?php if($banners->isEmpty()): ?>
            <div style="padding: 48px; text-align: center; color: var(--admin-text-muted);">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 16px; opacity: 0.3;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p style="font-size: 15px; margin: 0 0 8px;">Chưa có banner nào</p>
                <p style="font-size: 13px; margin: 0;">Nhấn nút "Thêm Banner" để tạo banner mới.</p>
            </div>
        <?php else: ?>
            <div class="banners-list">
                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="banner-item" data-id="<?php echo e($banner->id); ?>" style="display: flex; gap: 20px; padding: 20px; border-bottom: 1px solid var(--admin-border); align-items: center;">
                        
                        
                        <div class="banner-drag-handle" style="cursor: grab; color: var(--admin-text-muted); flex-shrink: 0;">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 3h2v2H9V3zm0 4h2v2H9V7zm0 4h2v2H9v-2zm0 4h2v2H9v-2zm0 4h2v2H9v-2zm4-16h2v2h-2V3zm0 4h2v2h-2V7zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2z"/>
                            </svg>
                        </div>

                        
                        <div class="banner-preview" style="flex-shrink: 0; width: 200px; border-radius: 8px; overflow: hidden; border: 2px solid var(--admin-border);">
                            <img src="<?php echo e($banner->image_url); ?>" alt="<?php echo e($banner->title ?? 'Banner'); ?>" style="width: 100%; height: 80px; object-fit: cover; display: block;">
                        </div>

                        
                        <div class="banner-info" style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                <?php if($banner->title): ?>
                                    <h3 style="margin: 0; font-size: 15px; font-weight: 600; color: var(--admin-text-primary);"><?php echo e($banner->title); ?></h3>
                                <?php else: ?>
                                    <h3 style="margin: 0; font-size: 15px; font-weight: 600; color: var(--admin-text-muted); font-style: italic;">Banner #<?php echo e($banner->id); ?></h3>
                                <?php endif; ?>
                                <span class="badge badge-<?php echo e($banner->is_active ? 'success' : 'secondary'); ?>" style="font-size: 11px;">
                                    <?php echo e($banner->is_active ? 'Hiển thị' : 'Ẩn'); ?>

                                </span>
                                <span class="badge badge-info" style="font-size: 11px;">
                                    <?php echo e($banner->location ?? 'home'); ?>

                                </span>
                            </div>
                            <?php if($banner->subtitle): ?>
                                <p style="margin: 0 0 8px; font-size: 13px; color: var(--admin-text-secondary); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo e($banner->subtitle); ?>

                                </p>
                            <?php endif; ?>
                            <div style="display: flex; gap: 16px; font-size: 12px; color: var(--admin-text-muted);">
                                <span>
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 4px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                    Thứ tự: <?php echo e($banner->sort_order); ?>

                                </span>
                                <?php if($banner->hasCta()): ?>
                                    <span>
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 4px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                        <?php echo e($banner->cta_text); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="banner-actions" style="flex-shrink: 0; display: flex; gap: 8px;">
                            <a href="<?php echo e(route('admin.banners.edit', $banner)); ?>" class="btn btn-secondary btn-sm" title="Chỉnh sửa">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="<?php echo e(route('admin.banners.destroy', $banner)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Xóa banner này?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if($banners->count() > 0): ?>
    <div class="admin-card" style="margin-top: 24px;">
        <div class="admin-card-body">
            <div style="display: flex; align-items: start; gap: 12px;">
                <div style="flex-shrink: 0; width: 40px; height: 40px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="none" stroke="#3b82f6" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <h3 style="margin: 0 0 8px; font-size: 14px; font-weight: 600; color: var(--admin-text-primary);">Lưu ý về Banner</h3>
                    <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: var(--admin-text-secondary); line-height: 1.6;">
                        <li><strong>Text tùy chọn:</strong> Nếu ảnh banner đã có text, bạn không cần nhập Title/Subtitle.</li>
                        <li><strong>Kích thước:</strong> Khuyến nghị 1920×800px hoặc 1600×600px.</li>
                        <li><strong>Tự động chuyển:</strong> Banner sẽ tự động chuyển sau 5 giây.</li>
                        <li><strong>Hiển thị:</strong> Chỉ banner có trạng thái "Hiển thị" mới xuất hiện ở trang chủ.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.badge {
    display: inline-block;
    padding: 3px 8px;
    font-size: 11px;
    font-weight: 600;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    border-radius: 4px;
}
.badge-success {
    background: #d1fae5;
    color: #065f46;
}
.badge-secondary {
    background: #e5e7eb;
    color: #6b7280;
}
.badge-info {
    background: #dbeafe;
    color: #1e40af;
}
.alert {
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
}
.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/admin/banners/index.blade.php ENDPATH**/ ?>