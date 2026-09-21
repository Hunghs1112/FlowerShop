<table class="admin-table">
    <thead>
        <tr>
            <th style="width: 80px;">Hình Ảnh</th>
            <th>Tên Sản Phẩm</th>
            <th style="width: 120px;">SKU</th>
            <th>Danh Mục</th>
            <th style="width: 140px;">Giá</th>
            <th style="width: 100px;">Tồn Kho</th>
            <th style="width: 120px;">Trạng Thái</th>
            <th style="width: 120px;">Thao Tác</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td data-label="Hình Ảnh">
                    <?php if($product->productImages->where('is_primary', true)->first()): ?>
                        <img src="<?php echo e(asset('storage/' . $product->productImages->where('is_primary', true)->first()->image_path)); ?>" 
                             alt="<?php echo e($product->name); ?>" class="table-image">
                    <?php elseif($product->productImages->first()): ?>
                        <img src="<?php echo e(asset('storage/' . $product->productImages->first()->image_path)); ?>" 
                             alt="<?php echo e($product->name); ?>" class="table-image">
                    <?php else: ?>
                        <div class="table-image" style="width: 56px; height: 56px; background: var(--admin-bg-content); display: flex; align-items: center; justify-content: center; border-radius: var(--admin-radius-md);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24" style="color: var(--admin-text-muted);">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </td>
                <td data-label="Tên Sản Phẩm">
                    <div class="table-product-name"><?php echo e($product->name); ?></div>
                    <?php if($product->short_description): ?>
                        <div class="table-product-desc"><?php echo e(Str::limit($product->short_description, 60)); ?></div>
                    <?php endif; ?>
                </td>
                <td data-label="SKU" class="text-mono" style="color: var(--admin-text-secondary);">
                    <?php echo e($product->sku ?? '-'); ?>

                </td>
                <td data-label="Danh Mục">
                    <div style="font-size: 0.875rem; color: var(--admin-text-primary);">
                        <?php echo e($product->category->name ?? '-'); ?>

                    </div>
                    <?php if($product->subcategory): ?>
                        <div style="font-size: 0.8125rem; color: var(--admin-text-secondary); margin-top: 2px;">
                            <?php echo e($product->subcategory->name); ?>

                        </div>
                    <?php endif; ?>
                </td>
                <td data-label="Giá">
                    <div style="font-weight: 600; color: var(--admin-color-primary);">
                        <?php echo e(number_format($product->price, 0, ',', '.')); ?>₫
                    </div>
                    <?php if($product->sale_price && $product->sale_price < $product->price): ?>
                        <div style="font-size: 0.8125rem; color: var(--admin-text-muted); text-decoration: line-through;">
                            <?php echo e(number_format($product->sale_price, 0, ',', '.')); ?>₫
                        </div>
                    <?php endif; ?>
                </td>
                <td data-label="Tồn Kho">
                    <?php if($product->stock > 0): ?>
                        <span class="badge badge-success"><?php echo e($product->stock); ?></span>
                    <?php else: ?>
                        <span class="badge badge-danger">Hết hàng</span>
                    <?php endif; ?>
                </td>
                <td data-label="Trạng Thái">
                    <span class="badge <?php echo e($product->is_active ? 'badge-success' : 'badge-secondary'); ?>">
                        <?php echo e($product->is_active ? 'Hoạt động' : 'Tạm ngưng'); ?>

                    </span>
                </td>
                <td data-label="Thao Tác">
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
                <td colspan="8">
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
<?php /**PATH /root/FlowerShop/resources/views/admin/catalog/partials/products-table.blade.php ENDPATH**/ ?>