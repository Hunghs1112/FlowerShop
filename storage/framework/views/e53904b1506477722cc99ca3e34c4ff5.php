
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product', 'showQuickAdd' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product', 'showQuickAdd' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $primaryImage = $product->productImages()->where('is_primary', true)->first()
        ?? $product->productImages()->first();
    $secondaryImage = $product->productImages()->skip(1)->first();
?>

<article class="product-card">
    <a href="<?php echo e(route('products.show', $product->display_slug)); ?>" class="product-card__full-link" aria-label="<?php echo e($product->display_name); ?>">
        <div class="product-card__image-wrap">
            
            <img
                src="<?php echo e($primaryImage?->image_url ?? asset('images/products/placeholder.jpg')); ?>"
                alt="<?php echo e($product->display_name); ?>"
                class="product-card__image product-card__image--primary"
                loading="lazy"
                width="300"
                height="375"
            >

            
            <?php if($secondaryImage): ?>
                <img
                    src="<?php echo e($secondaryImage->image_url); ?>"
                    alt="<?php echo e($product->display_name); ?>"
                    class="product-card__image product-card__image--secondary"
                    loading="lazy"
                    width="300"
                    height="375"
                >
            <?php endif; ?>

            
            <?php if($product->is_featured): ?>
                <span class="product-card__badge product-card__badge--featured">
                    Nổi bật
                </span>
            <?php endif; ?>

            
            <div class="product-card__overlay">
                <span class="product-card__cta">
                    <span>Xem chi tiết</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </span>
            </div>
        </div>

        
        <div class="product-card__info">
            <?php if($product->subcategory): ?>
                <span class="product-card__category"><?php echo e($product->subcategory->name); ?></span>
            <?php elseif($product->category): ?>
                <span class="product-card__category"><?php echo e($product->category->display_name); ?></span>
            <?php endif; ?>

            <h3 class="product-card__name">
                <?php echo e($product->display_name); ?>

            </h3>

            <div class="product-card__price-row">
                <span class="product-card__price">
                    <?php echo e(number_format($product->price, 0, ',', '.')); ?>đ
                </span>
            </div>
        </div>
    </a>

    <button
        type="button"
        class="product-card__wishlist <?php echo e($product->isFavoritedBy(auth()->user()) ? 'active' : ''); ?>"
        aria-label="Yêu thích"
        title="Yêu thích"
        data-product-id="<?php echo e($product->id); ?>"
    >
        <svg viewBox="0 0 24 24" fill="<?php echo e($product->isFavoritedBy(auth()->user()) ? 'currentColor' : 'none'); ?>" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
    </button>
</article>
<?php /**PATH D:\Github\FlowerShop\resources\views\components\product-card.blade.php ENDPATH**/ ?>