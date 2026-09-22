<?php $__env->startSection('page-title', 'Quản Lý Danh Mục Phụ'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Danh Mục Phụ</h1>
        <p class="admin-page-subtitle">Quản lý các danh mục phụ của cửa hàng</p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.subcategories.create')); ?>" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Danh Mục Phụ
        </a>
    </div>
</div>


<div class="admin-filters-card">
    <form method="GET" action="<?php echo e(route('admin.subcategories.index')); ?>" class="admin-filters">
        <div class="filter-group">
            <input type="text" 
                   name="search" 
                   placeholder="Tìm kiếm danh mục phụ..." 
                   value="<?php echo e(request('search')); ?>"
                   class="filter-input">
        </div>

        <div class="filter-group">
            <select name="category_id" class="filter-select">
                <option value="">Tất cả danh mục</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="filter-group">
            <select name="status" class="filter-select">
                <option value="">Tất cả trạng thái</option>
                <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Hoạt động</option>
                <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Tạm ngưng</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Tìm Kiếm
            </button>
            <?php if(request()->hasAny(['search', 'category_id', 'status'])): ?>
                <a href="<?php echo e(route('admin.subcategories.index')); ?>" class="btn btn-secondary">
                    Xóa Bộ Lọc
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>


<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Hình Ảnh</th>
                        <th>Tên Danh Mục Phụ</th>
                        <th>Slug</th>
                        <th style="width: 150px;">Danh Mục Cha</th>
                        <th style="width: 100px;">Sản Phẩm</th>
                        <th style="width: 120px;">Trạng Thái</th>
                        <th style="width: 120px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <?php if($subcategory->image): ?>
                                    <img src="<?php echo e($subcategory->image_url); ?>" alt="<?php echo e($subcategory->name); ?>" class="table-image">
                                <?php else: ?>
                                    <div class="table-image" style="width: 56px; height: 56px; background: var(--admin-bg-content); display: flex; align-items: center; justify-content: center; border-radius: var(--admin-radius-md);">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24" style="color: var(--admin-text-muted);">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="table-product-name"><?php echo e($subcategory->name); ?></div>
                            </td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);"><?php echo e($subcategory->slug); ?></td>
                            <td>
                                <span class="badge badge-info"><?php echo e($subcategory->category->name); ?></span>
                            </td>
                            <td>
                                <span class="badge badge-secondary"><?php echo e($subcategory->products_count ?? 0); ?></span>
                            </td>
                            <td>
                                <span class="badge <?php echo e($subcategory->is_active ? 'badge-success' : 'badge-secondary'); ?>">
                                    <?php echo e($subcategory->is_active ? 'Hoạt động' : 'Tạm ngưng'); ?>

                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?php echo e(route('admin.subcategories.edit', $subcategory)); ?>" class="btn-icon" title="Sửa">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="<?php echo e(route('admin.subcategories.destroy', $subcategory)); ?>" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa danh mục phụ này?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Xóa">
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
                            <td colspan="7" style="text-align: center; padding: 48px 24px; color: var(--admin-text-muted);">
                                Không có danh mục phụ nào
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/admin/subcategories/index.blade.php ENDPATH**/ ?>