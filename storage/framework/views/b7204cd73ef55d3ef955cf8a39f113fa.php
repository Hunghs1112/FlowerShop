<div class="admin-card">
    <div class="admin-card-body">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">
                        Danh Mục Cha <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="category_id" 
                            <?php if(isset($isEdit) && $isEdit): ?> class="auto-save-select" data-entity="subcategories" data-id="<?php echo e($subcategory->id); ?>" data-save-url="<?php echo e(route('admin.subcategories.autoSave', $subcategory)); ?>" <?php endif; ?>
                            required
                            style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; background: white;">
                        <option value="">-- Chọn danh mục --</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $subcategory->category_id ?? '') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">
                        Tên Danh Mục Phụ <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="<?php echo e(old('name', $subcategory->name ?? '')); ?>" 
                           <?php if(isset($isEdit) && $isEdit): ?> class="auto-save-input" data-entity="subcategories" data-id="<?php echo e($subcategory->id); ?>" data-save-url="<?php echo e(route('admin.subcategories.autoSave', $subcategory)); ?>" <?php endif; ?>
                           required
                           placeholder="Nhập tên danh mục phụ"
                           style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Slug</label>
                    <input type="text" 
                           name="slug" 
                           value="<?php echo e(old('slug', $subcategory->slug ?? '')); ?>" 
                           <?php if(isset($isEdit) && $isEdit): ?> class="auto-save-input" data-entity="subcategories" data-id="<?php echo e($subcategory->id); ?>" data-save-url="<?php echo e(route('admin.subcategories.autoSave', $subcategory)); ?>" <?php endif; ?>
                           placeholder="ten-danh-muc-phu (tự động tạo nếu để trống)"
                           style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; font-family: 'JetBrains Mono', monospace;">
                    <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả</label>
                    <textarea name="description" 
                              rows="4" 
                              <?php if(isset($isEdit) && $isEdit): ?> class="auto-save-input" data-entity="subcategories" data-id="<?php echo e($subcategory->id); ?>" data-save-url="<?php echo e(route('admin.subcategories.autoSave', $subcategory)); ?>" <?php endif; ?>
                              style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;"><?php echo e(old('description', $subcategory->description ?? '')); ?></textarea>
                </div>
            </div>

            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Trạng Thái</label>
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; background: var(--admin-bg-content); border-radius: var(--admin-radius-md); border: 1px solid var(--admin-border);">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               <?php echo e(old('is_active', $subcategory->is_active ?? true) ? 'checked' : ''); ?>

                               <?php if(isset($isEdit) && $isEdit): ?> class="auto-save-checkbox" data-entity="subcategories" data-id="<?php echo e($subcategory->id); ?>" data-save-url="<?php echo e(route('admin.subcategories.autoSave', $subcategory)); ?>" <?php endif; ?>
                               style="width: 18px; height: 18px; cursor: pointer;">
                        <span style="font-size: 14px; color: var(--admin-text-primary);">Kích hoạt danh mục phụ</span>
                    </label>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Thứ Tự Hiển Thị</label>
                    <input type="number" 
                           name="sort_order" 
                           value="<?php echo e(old('sort_order', $subcategory->sort_order ?? 0)); ?>" 
                           <?php if(isset($isEdit) && $isEdit): ?> class="auto-save-input" data-entity="subcategories" data-id="<?php echo e($subcategory->id); ?>" data-save-url="<?php echo e(route('admin.subcategories.autoSave', $subcategory)); ?>" <?php endif; ?>
                           min="0"
                           style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Hình Ảnh</label>
                    <div style="position: relative;">
                        <?php if(isset($subcategory) && $subcategory->image): ?>
                            <div class="subcategory-image-container" style="position: relative; display: inline-block; margin-bottom: 12px;">
                                <img src="<?php echo e($subcategory->image_url); ?>" 
                                     alt="Current image" 
                                     style="width: 100%; height: auto; border-radius: var(--admin-radius-md); border: 1px solid var(--admin-border);">
                                <button type="button"
                                        onclick="deleteSubcategoryImage(<?php echo e($subcategory->id); ?>, this)"
                                        title="Xóa ảnh"
                                        style="position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; background: rgba(239, 68, 68, 0.9); color: white; border: 2px solid white; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        <?php endif; ?>
                        <input type="file" 
                               name="image" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               <?php echo e(isset($isEdit) && $isEdit ? 'class="auto-save-file" data-entity="subcategories" data-id="' . $subcategory->id . '" data-field="image" data-upload-url="' . route('admin.subcategories.uploadImage', $subcategory) . '"' : ''); ?>

                               style="width: 100%; padding: 10px; border: 1px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 13px; cursor: pointer;">
                        <p style="font-size: 12px; color: var(--admin-text-muted); margin-top: 6px;">
                            JPG, PNG, GIF, WEBP. Tối đa 2MB
                        </p>
                    </div>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\Github\FlowerShop\resources\views\admin\subcategories\form.blade.php ENDPATH**/ ?>