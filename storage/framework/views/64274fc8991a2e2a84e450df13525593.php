<?php $__env->startSection('title', 'Quản lý Variants - ' . $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="variant-page-header">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: var(--space-4);">
        <div>
            <h1>Quản lý Variants</h1>
            <div class="variant-page-meta">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>Sản phẩm:</span>
                <span class="product-name"><?php echo e($product->name); ?></span>
                <span style="color: var(--color-border);">•</span>
                <span class="badge badge-secondary-light"><?php echo e($variants->count()); ?> variants</span>
            </div>
        </div>
        <div class="variant-page-actions">
            <a href="<?php echo e(route('admin.catalog.index', ['tab' => 'products'])); ?>" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Quay lại danh sách
            </a>
            <a href="<?php echo e(route('admin.products.variants.create', $product->id)); ?>" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm Variant
            </a>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
<div class="admin-alert success">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<?php if($variants->isEmpty()): ?>
<div class="variant-empty-state">
    <div class="variant-empty-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
    </div>
    <h3 class="variant-empty-title">Chưa có variant nào</h3>
    <p class="variant-empty-description">Tạo variants để quản lý các phiên bản khác nhau của sản phẩm</p>
    <a href="<?php echo e(route('admin.products.variants.create', $product->id)); ?>" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tạo variant đầu tiên
    </a>
</div>
<?php else: ?>
<div style="display: flex; flex-direction: column; gap: var(--space-4);">
    <?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="variant-card">
        <div class="variant-card-content">
            <div class="variant-image">
                <?php if($variant->images && $variant->images->isNotEmpty()): ?>
                    <img src="<?php echo e($variant->images->first()->image_url); ?>" alt="<?php echo e($variant->getDisplayName()); ?>">
                <?php else: ?>
                    <div class="variant-image-placeholder">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>

            <div class="variant-info">
                <div class="variant-header">
                    <div>
                        <h3 class="variant-title">
                            <?php echo e($variant->getDisplayName()); ?>

                            <?php if(!$variant->name): ?>
                                <span class="badge badge-sm" style="font-weight: normal;">(từ sản phẩm gốc)</span>
                            <?php endif; ?>
                        </h3>
                        <span class="variant-sku">SKU: <?php echo e($variant->sku); ?></span>
                    </div>
                    <div class="variant-status">
                        <?php if($variant->is_active): ?>
                            <span class="status-badge active">Đang bán</span>
                        <?php else: ?>
                            <span class="status-badge inactive">Tạm dừng</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="variant-details-grid">
                    <?php if($variant->color): ?>
                    <div class="variant-detail-item">
                        <div class="variant-detail-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm0 2h12v11H4V4z" clip-rule="evenodd"/>
                            </svg>
                            Màu sắc
                        </div>
                        <div class="variant-detail-value"><?php echo e($variant->color); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if($variant->size): ?>
                    <div class="variant-detail-item">
                        <div class="variant-detail-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            Kích thước
                        </div>
                        <div class="variant-detail-value"><?php echo e($variant->size); ?></div>
                    </div>
                    <?php endif; ?>

                    <div class="variant-detail-item highlight">
                        <div class="variant-detail-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            Giá bán
                        </div>
                        <div class="variant-detail-value">
                            <?php echo e(number_format($variant->getDisplayPrice())); ?>₫
                            <?php if(!$variant->price): ?>
                                <span style="font-size: var(--text-xs); color: var(--color-text-lighter); font-weight: normal;">(gốc)</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="variant-detail-item">
                        <div class="variant-detail-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Tồn kho
                        </div>
                        <div class="variant-detail-value">
                            <?php echo e($variant->stock); ?>

                            <?php if($variant->stock < 10): ?>
                                <span class="stock-warning low">Thấp</span>
                            <?php elseif($variant->stock > 50): ?>
                                <span class="stock-warning high">Cao</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="variant-actions">
                    <div class="variant-action-buttons">
                        <a href="<?php echo e(route('admin.products.variants.edit', [$product->id, $variant->id])); ?>" class="btn btn-secondary btn-sm">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Chỉnh sửa
                        </a>
                        <form action="<?php echo e(route('admin.products.variants.destroy', [$product->id, $variant->id])); ?>" 
                              method="POST" 
                              onsubmit="return confirm('Bạn có chắc muốn xóa variant này?')"
                              style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm" style="background: rgba(166, 83, 78, 0.1); color: var(--color-error); border: 1px solid rgba(166, 83, 78, 0.3);">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Xóa
                            </button>
                        </form>
                    </div>
                    
                    <div class="variant-meta">
                        <?php if($variant->images->count() > 1): ?>
                            <span class="variant-meta-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <?php echo e($variant->images->count()); ?> ảnh
                            </span>
                        <?php endif; ?>
                        <span class="variant-meta-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1v0a1 1 0 011 1v3M7 4H5a2 2 0 00-2 2v1a1 1 0 001 1h16a1 1 0 001-1V6a2 2 0 00-2-2h-2M7 4h10"/>
                            </svg>
                            #<?php echo e($variant->sort_order); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/admin/products/variants/index.blade.php ENDPATH**/ ?>