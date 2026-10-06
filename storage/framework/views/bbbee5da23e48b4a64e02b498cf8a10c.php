<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'content' => '',
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
    'content' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $markdown = is_string($content) ? $content : (string) $content;
    $html = \Illuminate\Support\Str::markdown($markdown, [
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
        'max_nesting_level' => 20,
        'renderer' => [
            'soft_break' => "<br>\n",
        ],
    ]);
?>

<div <?php echo e($attributes->class('markdown-content')); ?>>
    <?php echo $html; ?>

</div>
<?php /**PATH D:\Github\FlowerShop\resources\views\components\markdown-renderer.blade.php ENDPATH**/ ?>