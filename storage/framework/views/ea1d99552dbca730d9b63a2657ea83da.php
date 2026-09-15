<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description' => '',
    'breadcrumbs' => [],
    'image' => null,
    'height' => '400px'
]));

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

foreach (array_filter(([
    'title',
    'description' => '',
    'breadcrumbs' => [],
    'image' => null,
    'height' => '400px'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<section class="page-hero" style="--hero-height: <?php echo e($height); ?>">
    <?php if($image): ?>
        <img 
            src="<?php echo e(asset($image)); ?>" 
            alt="<?php echo e($title); ?>"
            class="page-hero-image"
        >
    <?php endif; ?>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <?php if(count($breadcrumbs) > 0): ?>
            <div class="page-breadcrumb">
                <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($index > 0): ?>
                        <span>/</span>
                    <?php endif; ?>
                    <?php if(isset($breadcrumb['url'])): ?>
                        <a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['label']); ?></a>
                    <?php else: ?>
                        <span><?php echo e($breadcrumb['label']); ?></span>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <h1 class="page-hero-heading"><?php echo e($title); ?></h1>
        <?php if($description): ?>
            <p class="page-hero-description"><?php echo e($description); ?></p>
        <?php endif; ?>
    </div>
</section>


<?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/components/page-hero.blade.php ENDPATH**/ ?>