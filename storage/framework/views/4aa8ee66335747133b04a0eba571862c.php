<?php $__env->startSection('page-title', 'Sản Phẩm'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Sản Phẩm</h1>
        <p class="admin-page-subtitle">Quản lý và cập nhật danh sách sản phẩm của cửa hàng</p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Sản Phẩm
        </a>
    </div>
</div>


<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." 
                   value="<?php echo e(request('search')); ?>" class="input-sm">
            <select name="category" class="input-sm">
                <option value="">Tất cả danh mục</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="status" class="input-sm">
                <option value="">Tất cả trạng thái</option>
                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Kích hoạt</option>
                <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Không kích hoạt</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Lọc
            </button>
            <?php if(request()->has('search') || request()->has('category') || request()->has('status')): ?>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary btn-sm">Xóa lọc</a>
            <?php endif; ?>
        </form>
    </div>
</div>


<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Hình Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Danh Mục</th>
                        <th style="width: 130px;">Giá</th>
                        <th style="width: 100px;">Tồn Kho</th>
                        <th style="width: 110px;">Trạng Thái</th>
                        <th style="width: 120px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <img src="<?php echo e($product->getPrimaryImageUrl()); ?>" alt="<?php echo e($product->name); ?>" class="table-image">
                            </td>
                            <td>
                                <div class="table-product-name"><?php echo e($product->name); ?></div>
                                <?php if($product->is_featured): ?>
                                    <span class="badge badge-accent" style="margin-top: 4px;">Nổi bật</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="color: var(--admin-text-secondary);"><?php echo e($product->category->name ?? '-'); ?></span>
                            </td>
                            <td>
                                <span class="text-semibold"><?php echo e(number_format($product->price, 0, ',', '.')); ?>₫</span>
                            </td>
                            <td>
                                <?php if($product->stock == 0): ?>
                                    <span class="badge badge-danger">Hết hàng</span>
                                <?php elseif($product->stock < 10): ?>
                                    <span class="badge badge-warning">Còn <?php echo e($product->stock); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-success"><?php echo e($product->stock); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?php echo e($product->is_active ? 'badge-success' : 'badge-secondary'); ?>">
                                    <?php echo e($product->is_active ? 'Hoạt động' : 'Tạm ngưng'); ?>

                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn-icon" title="Sửa">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Xóa" 
                                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?\n\nHành động này không thể hoàn tác.')">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state-sm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p>Không tìm thấy sản phẩm nào</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php if($products->hasPages()): ?>
        <div class="admin-card-footer" style="display: flex; justify-content: center; padding: 16px;">
            <?php echo e($products->withQueryString()->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/admin/products/index.blade.php ENDPATH**/ ?>