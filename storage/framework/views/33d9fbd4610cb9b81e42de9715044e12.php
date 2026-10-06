<?php ($item = $item ?? null); ?>
<div class="admin-card" style="max-width:900px;"><div class="admin-card-body">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
        <?php $__currentLoopData = ['country' => 'Quốc gia', 'flower' => 'Tên loài hoa', 'latin' => 'Tên Latin', 'region' => 'Vùng trồng', 'coordinate' => 'Tọa độ', 'slug' => 'Slug']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label><?php echo e($label); ?><input name="<?php echo e($field); ?>" value="<?php echo e(old($field, data_get($item, $field))); ?>" <?php echo e(in_array($field, ['country','flower','latin','region','coordinate']) ? 'required' : ''); ?> style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <label>Tọa độ X trên map<input type="number" name="map_x" min="0" max="1000" required value="<?php echo e(old('map_x', $item?->map_x ?? 0)); ?>" style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <label>Tọa độ Y trên map<input type="number" name="map_y" min="0" max="520" required value="<?php echo e(old('map_y', $item?->map_y ?? 0)); ?>" style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <label>Thứ tự<input type="number" name="sort_order" min="0" value="<?php echo e(old('sort_order', $item?->sort_order ?? 0)); ?>" style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <label>Ảnh hoa<input type="file" name="image" accept="image/*" <?php echo e($item ? '' : 'required'); ?> style="display:block;width:100%;margin-top:6px;"></label>
    </div>
    <?php if($item?->image): ?><img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->flower); ?>" style="width:180px;height:140px;object-fit:cover;border-radius:8px;margin-top:20px;"><?php endif; ?>
    <label style="display:flex;gap:8px;align-items:center;margin-top:20px;"><input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $item?->is_active ?? true) ? 'checked' : ''); ?>> Hiển thị trên map</label>
    <button class="btn btn-primary" type="submit" style="margin-top:24px;">Lưu thay đổi</button>
</div></div>
<?php /**PATH D:\Github\FlowerShop\resources\views\admin\flower-origins\form.blade.php ENDPATH**/ ?>