<?php $__env->startSection('title', 'Chỉnh sửa Variant - ' . $variant->sku); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-100 mb-2">Chỉnh sửa Variant</h1>
        <p class="text-slate-400">
            Sản phẩm gốc: <span class="text-cyan-400"><?php echo e($product->name); ?></span> 
            <span class="text-slate-600">•</span> 
            SKU: <span class="text-cyan-400"><?php echo e($variant->sku); ?></span>
        </p>
    </div>

    <form action="<?php echo e(route('admin.products.variants.update', [$product->id, $variant->id])); ?>" 
          method="POST" 
          enctype="multipart/form-data"
          class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Thông tin cơ bản -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Thông tin cơ bản
            </h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        SKU <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           name="sku" 
                           value="<?php echo e(old('sku', $variant->sku)); ?>"
                           required
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Tên variant (tùy chọn)
                    </label>
                    <input type="text" 
                           name="name" 
                           value="<?php echo e(old('name', $variant->name)); ?>"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="Để trống sẽ dùng tên sản phẩm gốc">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="mt-1 text-xs text-slate-500">
                        <?php if($variant->name): ?>
                            Tên riêng được đặt. Để trống để dùng: "<?php echo e($product->name); ?>"
                        <?php else: ?>
                            Đang dùng tên gốc: "<?php echo e($product->name); ?>"
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Mô tả riêng (tùy chọn)
                </label>
                <textarea name="description" 
                          rows="3"
                          class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                          placeholder="Mô tả đặc điểm riêng của variant này..."><?php echo e(old('description', $variant->description)); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <!-- Thuộc tính -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Thuộc tính
            </h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Màu sắc</label>
                    <input type="text" 
                           name="color" 
                           value="<?php echo e(old('color', $variant->color)); ?>"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Kích thước</label>
                    <input type="text" 
                           name="size" 
                           value="<?php echo e(old('size', $variant->size)); ?>"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    <?php $__errorArgs = ['size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <!-- Giá & Tồn kho -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Giá & Tồn kho
            </h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Giá bán (VNĐ)
                    </label>
                    <input type="number" 
                           name="price" 
                           value="<?php echo e(old('price', $variant->price)); ?>"
                           step="1000"
                           min="0"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="Để trống dùng giá gốc">
                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="mt-1 text-xs text-slate-500">
                        <?php if($variant->price): ?>
                            Giá gốc: <?php echo e(number_format($product->price)); ?>₫
                        <?php else: ?>
                            Đang dùng giá gốc: <?php echo e(number_format($product->price)); ?>₫
                        <?php endif; ?>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Tồn kho <span class="text-red-400">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           value="<?php echo e(old('stock', $variant->stock)); ?>"
                           required
                           min="0"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <!-- Ảnh hiện tại -->
        <?php if($variant->images->isNotEmpty()): ?>
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Ảnh hiện tại
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php $__currentLoopData = $variant->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="relative group">
                    <img src="<?php echo e($image->image_url); ?>" 
                         alt="Variant image"
                         class="w-full h-32 object-cover rounded-lg border border-slate-700">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition rounded-lg flex items-center justify-center">
                        <label class="cursor-pointer opacity-0 group-hover:opacity-100 transition">
                            <input type="checkbox" 
                                   name="delete_images[]" 
                                   value="<?php echo e($image->id); ?>"
                                   class="w-5 h-5">
                            <span class="ml-2 text-white text-sm">Xóa</span>
                        </label>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <p class="mt-3 text-sm text-slate-400">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Chọn ảnh cần xóa, sau đó nhấn "Cập nhật" ở cuối trang
            </p>
        </div>
        <?php endif; ?>

        <!-- Thêm ảnh mới -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Thêm ảnh mới
            </h2>
            
            <?php if($variant->images->isEmpty()): ?>
            <p class="text-sm text-slate-400 mb-4">
                Variant này chưa có ảnh riêng. Đang hiển thị ảnh từ sản phẩm gốc.
            </p>
            <?php endif; ?>

            <div class="border-2 border-dashed border-slate-700 rounded-lg p-6 text-center hover:border-cyan-500 transition">
                <input type="file" 
                       name="images[]" 
                       id="images"
                       multiple
                       accept="image/*"
                       class="hidden"
                       onchange="previewImages(event)">
                <label for="images" class="cursor-pointer">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-slate-300 mb-1">Nhấn để chọn ảnh</p>
                    <p class="text-sm text-slate-500">PNG, JPG, GIF, WEBP (tối đa 2MB mỗi ảnh)</p>
                </label>
            </div>

            <div id="preview" class="mt-4 grid grid-cols-4 gap-3"></div>

            <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-400"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Cài đặt -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Cài đặt
            </h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               <?php echo e(old('is_active', $variant->is_active) ? 'checked' : ''); ?>

                               class="w-5 h-5 bg-slate-900 border border-slate-700 rounded text-cyan-500 focus:ring-cyan-500 focus:ring-offset-slate-800">
                        <span class="text-slate-300">Kích hoạt variant</span>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Thứ tự sắp xếp</label>
                    <input type="number" 
                           name="sort_order" 
                           value="<?php echo e(old('sort_order', $variant->sort_order)); ?>"
                           min="0"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-slate-700">
            <form action="<?php echo e(route('admin.products.variants.destroy', [$product->id, $variant->id])); ?>" 
                  method="POST" 
                  onsubmit="return confirm('Bạn có chắc muốn xóa variant này? Tất cả ảnh và dữ liệu sẽ bị xóa vĩnh viễn!')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        class="px-6 py-3 bg-red-600/10 hover:bg-red-600/20 text-red-400 rounded-lg transition border border-red-600/20">
                    Xóa Variant
                </button>
            </form>

            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('admin.products.variants.index', $product->id)); ?>" 
                   class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-slate-100 rounded-lg transition">
                    Hủy
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-orange-600 hover:bg-orange-500 text-white rounded-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Cập nhật Variant
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function previewImages(event) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    
    const files = event.target.files;
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative group';
            div.innerHTML = `
                <img src="${e.target.result}" 
                     class="w-full h-24 object-cover rounded-lg border border-slate-700">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition rounded-lg flex items-center justify-center">
                    <span class="text-white text-xs opacity-0 group-hover:opacity-100 transition">Ảnh mới ${i + 1}</span>
                </div>
            `;
            preview.appendChild(div);
        };
        
        reader.readAsDataURL(file);
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/admin/products/variants/edit.blade.php ENDPATH**/ ?>