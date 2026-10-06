<?php $__env->startSection('page-title', 'Chi Tiết Liên Hệ'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Liên Hệ #<?php echo e($inquiry->id); ?></h1>
        <p class="admin-page-subtitle">Ngày tạo: <?php echo e($inquiry->created_at->format('d/m/Y H:i')); ?></p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px;">
    
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    Thông Tin Khách Hàng
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    <div>
                        <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Tên</div>
                        <div style="font-weight: 600; font-size: 15px;"><?php echo e($inquiry->name); ?></div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Điện Thoại</div>
                        <div style="font-weight: 600; font-size: 15px; font-family: var(--admin-font-mono);"><?php echo e($inquiry->phone); ?></div>
                    </div>
                    <?php if($inquiry->email): ?>
                    <div>
                        <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Email</div>
                        <div style="font-weight: 500; font-size: 15px;"><?php echo e($inquiry->email); ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if($inquiry->zalo_id): ?>
                    <div>
                        <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Zalo ID</div>
                        <div style="font-weight: 500; font-size: 15px; font-family: var(--admin-font-mono);"><?php echo e($inquiry->zalo_id); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if($inquiry->message): ?>
                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--admin-border);">
                    <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Tin Nhắn</div>
                    <div style="background: var(--admin-bg-content); padding: 16px; border-radius: var(--admin-radius-md); font-size: 14px; line-height: 1.6;">
                        <?php echo e($inquiry->message); ?>

                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if(count($inquiry->product_ids ?? []) > 0): ?>
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    Sản Phẩm Quan Tâm (<?php echo e(count($inquiry->product_ids ?? [])); ?>)
                </h2>
            </div>
            <div class="admin-card-body">
                <div class="stock-list">
                    <?php $__currentLoopData = $inquiry->getProducts(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="stock-item">
                        <div class="stock-product">
                            <img src="<?php echo e($product->getPrimaryImageUrl()); ?>" alt="<?php echo e($product->name); ?>">
                            <div>
                                <div class="stock-name"><?php echo e($product->name); ?></div>
                                <div class="stock-category"><?php echo e(number_format($product->price, 0, ',', '.')); ?>₫</div>
                            </div>
                        </div>
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" target="_blank" class="btn btn-secondary btn-sm">
                            Xem
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Trạng Thái
                </h2>
            </div>
            <div class="admin-card-body">
                <form action="<?php echo e(route('admin.inquiries.updateStatus', $inquiry)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <select name="status" class="input-sm" style="width: 100%;">
                            <option value="new" <?php echo e($inquiry->status == 'new' ? 'selected' : ''); ?>>🆕 Mới</option>
                            <option value="contacted" <?php echo e($inquiry->status == 'contacted' ? 'selected' : ''); ?>>📞 Đã liên hệ</option>
                            <option value="completed" <?php echo e($inquiry->status == 'completed' ? 'selected' : ''); ?>>✅ Hoàn thành</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Cập Nhật
                    </button>
                </form>
            </div>
        </div>

        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Chi Tiết
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <div style="font-size: 12px; color: var(--admin-text-muted); margin-bottom: 4px;">Ngày Tạo</div>
                        <div style="font-weight: 600; font-family: var(--admin-font-mono);"><?php echo e($inquiry->created_at->format('d/m/Y H:i')); ?></div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: var(--admin-text-muted); margin-bottom: 4px;">Nguồn</div>
                        <div>
                            <?php if($inquiry->user): ?>
                                <span class="badge badge-info">Thành viên</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Khách vãng lai</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\inquiries\show.blade.php ENDPATH**/ ?>