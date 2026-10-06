<?php $__env->startSection('title', $contactPage->title ?? 'Liên hệ'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginala9d931d4f11b4d2850df99e991db1dca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9d931d4f11b4d2850df99e991db1dca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-hero','data' => ['title' => $contactPage->title ?? 'Liên hệ','description' => 'Chúng tôi luôn sẵn sàng lắng nghe bạn','breadcrumbs' => [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Liên hệ']
    ],'image' => $pageBanner['custom'] ?? $siteBanners['contact'] ?? null,'hideOverlay' => $pageBanner['hide_overlay'] ?? ($siteBannerHideOverlay['contact'] ?? false),'bannerKey' => 'contact']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contactPage->title ?? 'Liên hệ'),'description' => 'Chúng tôi luôn sẵn sàng lắng nghe bạn','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Liên hệ']
    ]),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageBanner['custom'] ?? $siteBanners['contact'] ?? null),'hideOverlay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageBanner['hide_overlay'] ?? ($siteBannerHideOverlay['contact'] ?? false)),'banner-key' => 'contact']); ?>
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
    <div class="contact-layout">
        <!-- Contact Information -->
        <div class="contact-info-wrapper">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Thông tin liên hệ</h2>
                </div>
                <div class="card-body">
                    <?php if($contactPage?->content): ?>
                        <?php if (isset($component)) { $__componentOriginal5d01bba82580f3fe260d7edec2ceb896 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5d01bba82580f3fe260d7edec2ceb896 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.markdown-renderer','data' => ['content' => $contactPage->content,'class' => 'contact-intro markdown-content']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('markdown-renderer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contactPage->content),'class' => 'contact-intro markdown-content']); ?>
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
                    <?php else: ?>
                        <p class="contact-intro">
                            Hãy liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào. Chúng tôi luôn sẵn sàng hỗ trợ bạn.
                        </p>
                    <?php endif; ?>

                    <div class="contact-methods">
                        <?php if($siteInfo['phone'] ?? null): ?>
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3>Điện thoại</h3>
                                    <p><?php echo e($siteInfo['phone']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($siteInfo['email'] ?? null): ?>
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l7.89 5.26a2 2 0 002.22 0L21 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3>Email</h3>
                                    <p><?php echo e($siteInfo['email']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($siteInfo['address'] ?? null): ?>
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1116 0z"/>
                                        <circle cx="12" cy="10" r="2.5"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3>Địa chỉ</h3>
                                    <p><?php echo e($siteInfo['address']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($siteInfo['zalo_qr']): ?>
                        <div class="zalo-section">
                            <h3>Liên hệ qua Zalo</h3>
                            <div class="zalo-qr">
                                <img src="<?php echo e(asset('storage/' . $siteInfo['zalo_qr'])); ?>" alt="Mã QR Zalo">
                                <p>Quét mã để liên hệ nhanh</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\pages\contact.blade.php ENDPATH**/ ?>