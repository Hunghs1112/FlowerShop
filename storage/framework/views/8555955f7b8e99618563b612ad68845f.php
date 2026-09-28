<?php $__env->startSection('page-title', 'Quản Lý Catalog'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Catalog</h1>
        <p class="admin-page-subtitle">Quản lý danh mục, danh mục phụ và sản phẩm trong một giao diện thống nhất</p>
    </div>
    <div class="admin-page-actions">
        <?php if($activeTab === 'categories'): ?>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm Danh Mục
            </a>
        <?php elseif($activeTab === 'subcategories'): ?>
            <a href="<?php echo e(route('admin.subcategories.create')); ?>" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm Danh Mục Phụ
            </a>
        <?php elseif($activeTab === 'products'): ?>
            <a href="<?php echo e(route('admin.products.template')); ?>" class="btn btn-secondary" target="_blank">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Tải Template
            </a>
            <a href="<?php echo e(route('admin.products.import')); ?>" class="btn btn-secondary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Import CSV
            </a>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm Sản Phẩm
            </a>
        <?php endif; ?>
    </div>
</div>


<div class="catalog-tabs" style="margin-bottom: 24px;">
    <div class="admin-card">
        <div class="admin-card-body" style="padding: 0;">
            <div class="tab-nav">
                <a href="<?php echo e(route('admin.catalog.index', ['tab' => 'categories'] + request()->except('tab', 'page'))); ?>" 
                   class="tab-item <?php echo e($activeTab === 'categories' ? 'active' : ''); ?>">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>Danh Mục Chính</span>
                    <span class="tab-badge"><?php echo e($allCategories->count()); ?></span>
                </a>
                <a href="<?php echo e(route('admin.catalog.index', ['tab' => 'subcategories'] + request()->except('tab', 'page'))); ?>" 
                   class="tab-item <?php echo e($activeTab === 'subcategories' ? 'active' : ''); ?>">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Danh Mục Phụ</span>
                    <span class="tab-badge"><?php echo e(\App\Models\Subcategory::count()); ?></span>
                </a>
                <a href="<?php echo e(route('admin.catalog.index', ['tab' => 'products'] + request()->except('tab', 'page'))); ?>" 
                   class="tab-item <?php echo e($activeTab === 'products' ? 'active' : ''); ?>">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Sản Phẩm</span>
                    <span class="tab-badge"><?php echo e(\App\Models\Product::count()); ?></span>
                </a>
            </div>
        </div>
    </div>
</div>


<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <input type="hidden" name="tab" value="<?php echo e($activeTab); ?>">
            
            <input type="text" name="search" placeholder="Tìm kiếm..." 
                   value="<?php echo e(request('search')); ?>" class="input-sm">
            
            <?php if($activeTab === 'subcategories' || $activeTab === 'products'): ?>
                <select name="category_id" class="input-sm" id="filter-category">
                    <option value="">Tất cả danh mục</option>
                    <?php $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            <?php endif; ?>

            <?php if($activeTab === 'products'): ?>
                <select name="subcategory_id" class="input-sm" id="filter-subcategory">
                    <option value="">Tất cả danh mục phụ</option>
                    <?php if(request('category_id')): ?>
                        <?php
                            $selectedCategory = $allCategories->find(request('category_id'));
                            $subcategoriesForFilter = $selectedCategory ? $selectedCategory->subcategories : collect([]);
                        ?>
                        <?php $__currentLoopData = $subcategoriesForFilter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($subcategory->id); ?>" <?php echo e(request('subcategory_id') == $subcategory->id ? 'selected' : ''); ?>>
                                <?php echo e($subcategory->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            <?php endif; ?>
            
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
            
            <?php if(request()->hasAny(['search', 'category_id', 'subcategory_id', 'status'])): ?>
                <a href="<?php echo e(route('admin.catalog.index', ['tab' => $activeTab])); ?>" class="btn btn-secondary btn-sm">Xóa lọc</a>
            <?php endif; ?>
        </form>
    </div>
</div>


<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            
            <?php if($activeTab === 'categories'): ?>
                <?php echo $__env->make('admin.catalog.partials.categories-table', ['categories' => $categories], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php elseif($activeTab === 'subcategories'): ?>
                <?php echo $__env->make('admin.catalog.partials.subcategories-table', ['subcategories' => $subcategories], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php elseif($activeTab === 'products'): ?>
                <?php echo $__env->make('admin.catalog.partials.products-table', ['products' => $products], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
            
        </div>
    </div>
</div>



<style>
/* Tab Navigation Styles */
.tab-nav {
    display: flex;
    border-bottom: 1px solid var(--admin-border-color);
}

.tab-item {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 16px 24px;
    color: var(--admin-text-secondary);
    text-decoration: none;
    font-weight: 500;
    border-bottom: 3px solid transparent;
    transition: all 0.2s ease;
    position: relative;
}

.tab-item:hover {
    color: var(--admin-primary);
    background: var(--admin-bg-hover);
}

.tab-item.active {
    color: var(--admin-primary);
    border-bottom-color: var(--admin-primary);
    background: var(--admin-bg-hover);
}

.tab-item svg {
    flex-shrink: 0;
}

.tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    padding: 0 8px;
    background: var(--admin-bg-content);
    color: var(--admin-text-secondary);
    font-size: 12px;
    font-weight: 600;
    border-radius: 12px;
}

.tab-item.active .tab-badge {
    background: var(--admin-primary);
    color: white;
}

/* Responsive Tabs */
@media (max-width: 768px) {
    .tab-item span:not(.tab-badge) {
        display: none;
    }
    
    .tab-item {
        padding: 12px 16px;
    }
}
</style>

<?php if($activeTab === 'products'): ?>
<script>
// Dynamic subcategory filter based on category selection
document.getElementById('filter-category')?.addEventListener('change', function() {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('filter-subcategory');
    
    if (!subcategorySelect) return;
    
    if (!categoryId) {
        subcategorySelect.innerHTML = '<option value="">Tất cả danh mục phụ</option>';
        return;
    }
    
    // Reload with category filter to update subcategories
    const url = new URL(window.location.href);
    url.searchParams.set('category_id', categoryId);
    url.searchParams.delete('subcategory_id');
    window.location.href = url.toString();
});
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/admin/catalog/index.blade.php ENDPATH**/ ?>