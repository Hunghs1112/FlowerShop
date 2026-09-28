<?php $__env->startSection('title', $mysteryContent['success_page_title']); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginala9d931d4f11b4d2850df99e991db1dca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9d931d4f11b4d2850df99e991db1dca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-hero','data' => ['title' => ''.e($mysteryContent['success_page_title']).'','description' => ''.e($mysteryContent['success_page_description']).'','breadcrumbs' => [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Hộp Hoa Bí Ẩn', 'url' => route('mystery-box.index')],
        ['label' => 'Thành công']
    ],'image' => $siteBanners['mystery-box'] ?? null,'height' => '350px']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($mysteryContent['success_page_title']).'','description' => ''.e($mysteryContent['success_page_description']).'','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Hộp Hoa Bí Ẩn', 'url' => route('mystery-box.index')],
        ['label' => 'Thành công']
    ]),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($siteBanners['mystery-box'] ?? null),'height' => '350px']); ?>
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
    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h1 class="success-title"><?php echo e($mysteryContent['success_title']); ?></h1>
            
            <div class="request-id">
                <span class="request-id-label"><?php echo e($mysteryContent['success_request_id_label']); ?></span>
                <span class="request-id-value"><?php echo e($mysteryBoxRequest->request_id); ?></span>
            </div>

            <div class="success-message">
                <p><?php echo e($mysteryContent['success_message']); ?></p>
                <p><?php echo e($mysteryContent['success_contact_message']); ?> <strong><?php echo e($mysteryBoxRequest->phone); ?></strong> trong thời gian sớm nhất.</p>
            </div>

            <div class="summary-box">
                <h3><?php echo e($mysteryContent['success_summary_title']); ?></h3>
                
                <div class="summary-grid">
                    <div class="summary-item">
                        <span class="summary-label"><?php echo e($mysteryContent['success_style_label']); ?></span>
                        <span class="summary-value"><?php echo e($mysteryBoxRequest->style); ?></span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label"><?php echo e($mysteryContent['success_color_label']); ?></span>
                        <span class="summary-value">
                            <?php $__currentLoopData = $mysteryBoxRequest->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="color-badge"><?php echo e($color); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label"><?php echo e($mysteryContent['success_preference_label']); ?></span>
                        <span class="summary-value">
                            <?php $__currentLoopData = $mysteryBoxRequest->preferences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="pref-badge"><?php echo e($pref); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label"><?php echo e($mysteryContent['success_budget_label']); ?></span>
                        <span class="summary-value"><?php echo e($mysteryBoxRequest->budget_range); ?></span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label"><?php echo e($mysteryContent['success_surprise_label']); ?></span>
                        <span class="summary-value"><?php echo e($mysteryBoxRequest->surprise_level); ?></span>
                    </div>

                    <?php if($mysteryBoxRequest->note): ?>
                    <div class="summary-item full-width">
                        <span class="summary-label"><?php echo e($mysteryContent['success_note_label']); ?></span>
                        <span class="summary-value"><?php echo e($mysteryBoxRequest->note); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="success-actions">
                <a href="<?php echo e(route('home')); ?>" class="btn btn-outline btn-lg">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <?php echo e($mysteryContent['success_home_label']); ?>

                </a>
            </div>
        </div>
    </div>
</div>

<style>
.success-container {
    max-width: 800px;
    margin: 0 auto;
    padding: var(--space-8) 0;
}

.success-card {
    background: var(--color-white);
    border: 1px solid var(--color-border-light);
    border-radius: var(--radius-lg);
    padding: var(--space-8);
    text-align: center;
}

.success-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto var(--space-6);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #3F5A45 0%, #5A7C5E 100%);
    border-radius: var(--radius-full);
    color: var(--color-white);
}

.success-title {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 600;
    color: var(--color-text);
    margin: 0 0 var(--space-6);
}

.request-id {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-5);
    background: var(--color-botanical-pale);
    border: 2px solid var(--color-primary);
    border-radius: var(--radius-lg);
    margin-bottom: var(--space-6);
}

.request-id-label {
    font-size: 0.875rem;
    color: var(--color-text-light);
}

.request-id-value {
    font-family: 'IBM Plex Mono', monospace;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--color-primary);
}

.success-message {
    margin: var(--space-6) 0;
    padding: var(--space-5);
    background: rgba(63, 90, 69, 0.05);
    border-radius: var(--radius-md);
}

.success-message p {
    margin: 0 0 var(--space-2);
    line-height: 1.6;
    color: var(--color-text);
}

.success-message p:last-child {
    margin-bottom: 0;
}

.summary-box {
    margin: var(--space-6) 0;
    padding: var(--space-6);
    background: var(--color-cream);
    border-radius: var(--radius-lg);
    text-align: left;
}

.summary-box h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--color-text);
    margin: 0 0 var(--space-5);
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--space-4);
}

.summary-item {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.summary-item.full-width {
    grid-column: 1 / -1;
}

.summary-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--color-text-light);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.summary-value {
    font-size: 1rem;
    color: var(--color-text);
}

.color-badge,
.pref-badge {
    display: inline-block;
    padding: var(--space-1) var(--space-3);
    background: var(--color-white);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-full);
    font-size: 0.875rem;
    margin-right: var(--space-2);
    margin-bottom: var(--space-2);
}

.success-actions {
    margin-top: var(--space-6);
    display: flex;
    justify-content: center;
    gap: var(--space-3);
}

@media (max-width: 767px) {
    .success-card {
        padding: var(--space-6);
    }

    .success-title {
        font-size: 1.5rem;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .success-actions {
        flex-direction: column;
    }

    .success-actions .btn {
        width: 100%;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/mystery-box/success.blade.php ENDPATH**/ ?>