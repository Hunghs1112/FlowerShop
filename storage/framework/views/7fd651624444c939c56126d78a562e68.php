<?php $__env->startSection('title', $page->title); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginala9d931d4f11b4d2850df99e991db1dca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9d931d4f11b4d2850df99e991db1dca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-hero','data' => ['title' => $page->title,'description' => $page->excerpt ?? 'Thông tin quan trọng về chính sách của chúng tôi','breadcrumbs' => [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => $page->title]
    ],'image' => $pageBanner['custom'] ?? $siteBanners['about'] ?? null,'height' => '350px']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page->title),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page->excerpt ?? 'Thông tin quan trọng về chính sách của chúng tôi'),'breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => $page->title]
    ]),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageBanner['custom'] ?? $siteBanners['about'] ?? null),'height' => '350px']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala9d931d4f11b4d2850df99e991db1dca)): ?>
<?php $attributes = $__attributesOriginala9d931d4f11b4d2850df99e991db1dca; ?>
<?php unset($__attributesOriginala9d931d4f11b4d2850df99e991db1dca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala9d931d4f11b4d2850df99e991db1dca)): ?>
<?php $component = $__componentOriginala9d931d4f11b4d2850df99e991db1dca; ?>
<?php unset($__componentOriginala9d931d4f11b4d2850df99e991db1dca); ?>
<?php endif; ?>

<div class="container page-wrapper">
    <div class="page-content">
        <?php if (isset($component)) { $__componentOriginal5d01bba82580f3fe260d7edec2ceb896 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5d01bba82580f3fe260d7edec2ceb896 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.markdown-renderer','data' => ['content' => $page->content,'class' => 'page-body']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('markdown-renderer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page->content),'class' => 'page-body']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5d01bba82580f3fe260d7edec2ceb896)): ?>
<?php $attributes = $__attributesOriginal5d01bba82580f3fe260d7edec2ceb896; ?>
<?php unset($__attributesOriginal5d01bba82580f3fe260d7edec2ceb896); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5d01bba82580f3fe260d7edec2ceb896)): ?>
<?php $component = $__componentOriginal5d01bba82580f3fe260d7edec2ceb896; ?>
<?php unset($__componentOriginal5d01bba82580f3fe260d7edec2ceb896); ?>
<?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/pages/policy.blade.php ENDPATH**/ ?>