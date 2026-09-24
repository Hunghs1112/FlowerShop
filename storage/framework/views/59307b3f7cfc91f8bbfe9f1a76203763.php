<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description' => '',
    'label' => '',
    'breadcrumbs' => [],
    'image' => null,
    'variant' => 'default'
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
    'label' => '',
    'breadcrumbs' => [],
    'image' => null,
    'variant' => 'default'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section class="page-hero <?php echo e($image ? 'page-hero--with-image' : ''); ?> <?php echo e($variant === 'compact' ? 'page-hero--compact' : ''); ?>">
    <?php if($image): ?>
        <div class="page-hero-background">
            <img 
                src="<?php echo e(asset($image)); ?>" 
                alt="<?php echo e($title); ?>"
                class="page-hero-background-image"
                loading="eager"
            >
        </div>
    <?php endif; ?>
    
    <div class="page-hero-container container">
        <?php if(count($breadcrumbs) > 0): ?>
            <nav class="page-hero-breadcrumb" aria-label="Breadcrumb">
                <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="page-hero-breadcrumb-item">
                        <?php if($index > 0): ?>
                            <span class="page-hero-breadcrumb-separator">/</span>
                        <?php endif; ?>
                        <?php if(isset($breadcrumb['url'])): ?>
                            <a href="<?php echo e($breadcrumb['url']); ?>" class="page-hero-breadcrumb-link"><?php echo e($breadcrumb['label']); ?></a>
                        <?php else: ?>
                            <span class="page-hero-breadcrumb-current"><?php echo e($breadcrumb['label']); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
        <?php endif; ?>
        
        <div class="page-hero-content">
            <?php if($label): ?>
                <span class="page-hero-label"><?php echo e($label); ?></span>
            <?php endif; ?>
            
            <h1 class="page-hero-title"><?php echo e($title); ?></h1>
            
            <?php if($description): ?>
                <p class="page-hero-description"><?php echo e($description); ?></p>
            <?php endif; ?>
            
            <?php echo e($slot); ?>

        </div>
    </div>
    
    <?php if(!$image): ?>
        <div class="page-hero-decoration">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 20C100 20 120 40 120 60C120 80 110 90 100 90C90 90 80 80 80 60C80 40 100 20 100 20Z" stroke-width="2"/>
                <path d="M100 90C100 90 85 95 75 105C65 115 65 130 75 140C85 150 100 150 100 150" stroke-width="2"/>
                <path d="M100 90C100 90 115 95 125 105C135 115 135 130 125 140C115 150 100 150 100 150" stroke-width="2"/>
                <circle cx="100" cy="160" r="8" stroke-width="2"/>
            </svg>
        </div>
    <?php endif; ?>
</section>
<?php /**PATH /root/FlowerShop/resources/views/components/page-hero.blade.php ENDPATH**/ ?>