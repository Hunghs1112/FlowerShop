<?php $__env->startSection('page-title', 'Trang'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Trang</h1>
        <p class="admin-page-subtitle">Quản lý các trang tĩnh của website</p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.pages.create')); ?>" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Trang
        </a>
    </div>
</div>


<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <input type="text" name="search" placeholder="Tìm kiếm trang..." 
                   value="<?php echo e(request('search')); ?>" class="input-sm">
            <select name="status" class="input-sm">
                <option value="">Tất cả trạng thái</option>
                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Kích hoạt</option>
                <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Không kích hoạt</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            <?php if(request()->has('search') || request()->has('status')): ?>
                <a href="<?php echo e(route('admin.pages.index')); ?>" class="btn btn-secondary btn-sm">Xóa lọc</a>
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
                        <th>Tiêu Đề</th>
                        <th>Slug</th>
                        <th style="width: 160px;">Cập Nhật</th>
                        <th style="width: 120px;">Trạng Thái</th>
                        <th style="width: 140px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="table-product-name"><?php echo e($page->title); ?></div>
                            </td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);"><?php echo e($page->slug); ?></td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);"><?php echo e($page->updated_at->format('d/m/Y H:i')); ?></td>
                            <td>
                                <span class="badge <?php echo e($page->is_active ? 'badge-success' : 'badge-secondary'); ?>">
                                    <?php echo e($page->is_active ? 'Hoạt động' : 'Tạm ngưng'); ?>

                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?php echo e($page->slug === 'lien-he' ? route('contact') : route('policy', $page->slug)); ?>" class="btn-icon" title="Xem" target="_blank">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="<?php echo e(route('admin.pages.edit', $page)); ?>" class="btn-icon" title="Sửa">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="<?php echo e(route('admin.pages.destroy', $page)); ?>" method="POST" class="inline-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Xóa" 
                                                onclick="return confirm('Bạn có chắc muốn xóa trang này?\n\nHành động này không thể hoàn tác.')">
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
                            <td colspan="5">
                                <div class="empty-state-sm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p>Không tìm thấy trang nào</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\pages\index.blade.php ENDPATH**/ ?>