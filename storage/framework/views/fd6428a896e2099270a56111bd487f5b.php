<?php $__env->startSection('page-title', 'Bảng Điều Khiển'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Bảng Điều Khiển</h1>
        <p class="admin-page-subtitle">Xin chào! Chào mừng bạn quay trở lại Lâm Nhiên Thảo.</p>
    </div>
</div>


<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon stat-icon-primary">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Tổng Sản Phẩm</div>
            <div class="stat-value"><?php echo e($stats['products'] ?? 0); ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon-success">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Danh Mục</div>
            <div class="stat-value"><?php echo e($stats['categories'] ?? 0); ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon-warning">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Liên Hệ</div>
            <div class="stat-value"><?php echo e($stats['inquiries'] ?? 0); ?></div>
            <?php if(($stats['new_inquiries'] ?? 0) > 0): ?>
                <span class="stat-badge"><?php echo e($stats['new_inquiries']); ?> liên hệ mới</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon-info">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Người Dùng</div>
            <div class="stat-value"><?php echo e($stats['users'] ?? 0); ?></div>
        </div>
    </div>
</div>


<div class="admin-grid">
    
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                Liên Hệ Gần Đây
            </h2>
            <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="btn btn-secondary btn-sm">Xem Tất Cả</a>
        </div>
        <div class="admin-card-body">
            <?php if($recentInquiries->count() > 0): ?>
                <div class="admin-table-wrapper" style="margin: -24px; padding: 0;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Khách Hàng</th>
                                <th>Điện Thoại</th>
                                <th>Sản Phẩm</th>
                                <th>Trạng Thái</th>
                                <th>Ngày</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentInquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label="ID"><span class="text-mono">#<?php echo e($inquiry->id); ?></span></td>
                                    <td data-label="Khách Hàng">
                                        <div style="font-weight: 600;"><?php echo e($inquiry->name); ?></div>
                                    </td>
                                    <td data-label="Điện Thoại" class="text-mono"><?php echo e($inquiry->phone); ?></td>
                                    <td data-label="Sản Phẩm"><?php echo e(count($inquiry->product_ids ?? [])); ?> sản phẩm</td>
                                    <td data-label="Trạng Thái">
                                        <?php
                                            $statusMap = [
                                                'pending' => ['class' => 'badge-warning', 'label' => 'Chờ xử lý'],
                                                'contacted' => ['class' => 'badge-info', 'label' => 'Đã liên hệ'],
                                                'completed' => ['class' => 'badge-success', 'label' => 'Hoàn thành'],
                                            ];
                                            $status = $statusMap[$inquiry->status] ?? ['class' => 'badge-secondary', 'label' => $inquiry->status];
                                        ?>
                                        <span class="badge <?php echo e($status['class']); ?>"><?php echo e($status['label']); ?></span>
                                    </td>
                                    <td data-label="Ngày" class="text-muted"><?php echo e($inquiry->created_at->format('d/m, H:i')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state-sm">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p>Chưa có liên hệ nào</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                Cảnh Báo Tồn Kho
            </h2>
            <a href="<?php echo e(route('admin.catalog.index', ['tab' => 'products'])); ?>" class="btn btn-secondary btn-sm">Tất Cả Sản Phẩm</a>
        </div>
        <div class="admin-card-body">
            <?php if($lowStockProducts->count() > 0): ?>
                <div class="stock-list">
                    <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="stock-item">
                            <div class="stock-product">
                                <img src="<?php echo e($product->getPrimaryImageUrl()); ?>" alt="<?php echo e($product->name); ?>">
                                <div>
                                    <div class="stock-name"><?php echo e($product->name); ?></div>
                                    <div class="stock-category"><?php echo e($product->category->name ?? 'Chưa phân loại'); ?></div>
                                </div>
                            </div>
                            <span class="badge <?php echo e($product->stock == 0 ? 'badge-danger' : 'badge-warning'); ?>">
                                <?php echo e($product->stock == 0 ? 'Hết hàng' : 'Còn ' . $product->stock); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="empty-state-sm">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>Tất cả sản phẩm đều đủ hàng</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>