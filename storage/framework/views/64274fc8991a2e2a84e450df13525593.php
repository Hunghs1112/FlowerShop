<?php $__env->startSection('title', 'Quản lý Variants - ' . $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">Quản lý Variants</h1>
            <p class="text-slate-400">Sản phẩm: <span class="text-cyan-400"><?php echo e($product->name); ?></span></p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('admin.products.index')); ?>" 
               class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-100 rounded-lg transition">
                ← Quay lại danh sách
            </a>
            <a href="<?php echo e(route('admin.products.variants.create', $product->id)); ?>" 
               class="px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm Variant
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
        <p class="text-emerald-400"><?php echo e(session('success')); ?></p>
    </div>
    <?php endif; ?>

    <?php if($variants->isEmpty()): ?>
    <div class="bg-slate-800 border border-slate-700 rounded-lg p-12 text-center">
        <div class="text-slate-400 mb-4">
            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-lg">Chưa có variant nào</p>
        </div>
        <a href="<?php echo e(route('admin.products.variants.create', $product->id)); ?>" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition">
            Tạo variant đầu tiên
        </a>
    </div>
    <?php else: ?>
    <div class="grid gap-4">
        <?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 hover:border-slate-600 transition">
            <div class="flex items-start gap-6">
                <!-- Ảnh -->
                <div class="flex-shrink-0">
                    <?php if($variant->images && $variant->images->isNotEmpty()): ?>
                        <img src="<?php echo e(asset('storage/' . $variant->images->first()->image_path)); ?>" 
                             alt="<?php echo e($variant->getDisplayName()); ?>"
                             class="w-24 h-24 object-cover rounded-lg border border-slate-700">
                    <?php else: ?>
                        <div class="w-24 h-24 bg-slate-700 rounded-lg flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Thông tin -->
                <div class="flex-grow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-xl font-bold text-slate-100 mb-1">
                                <?php echo e($variant->getDisplayName()); ?>

                                <?php if(!$variant->name): ?>
                                    <span class="text-xs text-slate-500 font-normal ml-2">(từ sản phẩm gốc)</span>
                                <?php endif; ?>
                            </h3>
                            <p class="text-sm text-slate-400 font-mono">SKU: <?php echo e($variant->sku); ?></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <?php if($variant->is_active): ?>
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-full border border-emerald-500/20">
                                    Đang bán
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-slate-700 text-slate-400 text-xs font-medium rounded-full border border-slate-600">
                                    Tạm dừng
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <?php if($variant->color): ?>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Màu sắc</p>
                            <p class="text-sm text-slate-200"><?php echo e($variant->color); ?></p>
                        </div>
                        <?php endif; ?>

                        <?php if($variant->size): ?>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Kích thước</p>
                            <p class="text-sm text-slate-200"><?php echo e($variant->size); ?></p>
                        </div>
                        <?php endif; ?>

                        <div>
                            <p class="text-xs text-slate-500 mb-1">Giá bán</p>
                            <p class="text-base font-semibold text-cyan-400">
                                <?php echo e(number_format($variant->getDisplayPrice())); ?>₫
                                <?php if(!$variant->price): ?>
                                    <span class="text-xs text-slate-500 font-normal ml-1">(gốc)</span>
                                <?php endif; ?>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 mb-1">Tồn kho</p>
                            <p class="text-sm text-slate-200 font-medium">
                                <?php echo e($variant->stock); ?> 
                                <?php if($variant->stock < 10): ?>
                                    <span class="text-orange-400">⚠️</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 pt-3 border-t border-slate-700">
                        <a href="<?php echo e(route('admin.products.variants.edit', [$product->id, $variant->id])); ?>"
                           class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-100 text-sm rounded-lg transition">
                            Chỉnh sửa
                        </a>
                        <form action="<?php echo e(route('admin.products.variants.destroy', [$product->id, $variant->id])); ?>" 
                              method="POST" 
                              onsubmit="return confirm('Bạn có chắc muốn xóa variant này?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600/10 hover:bg-red-600/20 text-red-400 text-sm rounded-lg transition border border-red-600/20">
                                Xóa
                            </button>
                        </form>
                        
                        <?php if($variant->images->count() > 1): ?>
                        <span class="ml-auto text-xs text-slate-500">
                            <?php echo e($variant->images->count()); ?> ảnh
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/admin/products/variants/index.blade.php ENDPATH**/ ?>