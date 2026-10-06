<?php $__env->startSection('title', 'Bản đồ nguồn gốc hoa'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Bản đồ nguồn gốc hoa</h1>
        <p class="admin-page-subtitle">Quản lý các điểm hoa hiển thị tại trang Giới thiệu</p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.flower-origins.create')); ?>" class="btn btn-primary">+ Thêm loài hoa</a>
    </div>
</div>

<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body">
        <form method="GET" style="display:flex;gap:12px;">
            <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Tìm theo quốc gia hoặc loài hoa" style="flex:1;height:44px;padding:0 14px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);">
            <button class="btn btn-secondary" type="submit">Tìm</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead><tr><th>Ảnh</th><th>Quốc gia</th><th>Loài hoa</th><th>Vùng trồng</th><th>Thứ tự</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->flower); ?>" class="table-image" style="object-fit:cover;"></td>
                        <td><?php echo e($item->country); ?></td>
                        <td><strong><?php echo e($item->flower); ?></strong><br><small><?php echo e($item->latin); ?></small></td>
                        <td><?php echo e($item->region); ?></td>
                        <td><?php echo e($item->sort_order); ?></td>
                        <td><span class="badge <?php echo e($item->is_active ? 'badge-success' : 'badge-secondary'); ?>"><?php echo e($item->is_active ? 'Hiển thị' : 'Ẩn'); ?></span></td>
                        <td><div class="table-actions">
                            <a href="<?php echo e(route('admin.flower-origins.edit', $item)); ?>" class="btn-icon" title="Sửa">✎</a>
                            <form action="<?php echo e(route('admin.flower-origins.destroy', $item)); ?>" method="POST" class="inline-form" onsubmit="return confirm('Xóa điểm hoa này?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn-icon btn-icon-danger" title="Xóa">×</button>
                            </form>
                        </div></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7">Chưa có dữ liệu.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div style="margin-top:16px;"><?php echo e($items->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\flower-origins\index.blade.php ENDPATH**/ ?>