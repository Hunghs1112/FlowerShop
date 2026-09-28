<?php $__env->startSection('title', $mysteryContent['hero_title']); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginala9d931d4f11b4d2850df99e991db1dca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9d931d4f11b4d2850df99e991db1dca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-hero','data' => ['title' => ''.e($mysteryContent['hero_title']).'','description' => ''.e($mysteryContent['hero_description']).'','breadcrumbs' => [['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Hộp Hoa Bí Ẩn']],'image' => $siteBanners['mystery-box'] ?? null,'height' => '350px']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($mysteryContent['hero_title']).'','description' => ''.e($mysteryContent['hero_description']).'','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Hộp Hoa Bí Ẩn']]),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($siteBanners['mystery-box'] ?? null),'height' => '350px']); ?>
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
    <div class="mystery-box-container">
        <div class="mystery-box-content">
            <div class="mystery-box-intro">
                <h2><?php echo e($mysteryContent['intro_title']); ?></h2>
                <p><?php echo e($mysteryContent['intro_description']); ?></p>
            </div>

            <form id="mysteryBoxForm" action="<?php echo e(route('mystery-box.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="step-indicator">
                    <?php $__currentLoopData = $mysteryContent['step_labels']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="step-item <?php echo e($index === 0 ? 'active' : ''); ?>" data-step="<?php echo e($index + 1); ?>">
                            <div class="step-number"><?php echo e($index + 1); ?></div>
                            <div class="step-label"><?php echo e($label); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="step-content active" data-step="1">
                    <h3 class="step-title"><?php echo e($mysteryContent['style_title']); ?></h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = $mysteryContent['styles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="selection-card"><input type="radio" name="style" value="<?php echo e($style); ?>" <?php echo e(old('style') === $style ? 'checked' : ''); ?> required><div class="card-content"><div class="card-title"><?php echo e($style); ?></div></div></label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['style'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="step-content" data-step="2">
                    <h3 class="step-title"><?php echo e($mysteryContent['color_title']); ?></h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = $mysteryContent['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="selection-card"><input type="checkbox" name="colors[]" value="<?php echo e($color); ?>" <?php echo e(in_array($color, old('colors', [])) ? 'checked' : ''); ?>><div class="card-content"><div class="card-title"><?php echo e($color); ?></div></div></label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['colors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="step-content" data-step="3">
                    <h3 class="step-title"><?php echo e($mysteryContent['preference_title']); ?></h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = $mysteryContent['preferences']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preference): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="selection-card"><input type="checkbox" name="preferences[]" value="<?php echo e($preference); ?>" <?php echo e(in_array($preference, old('preferences', [])) ? 'checked' : ''); ?>><div class="card-content"><div class="card-title"><?php echo e($preference); ?></div></div></label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['preferences'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="step-content" data-step="4">
                    <h3 class="step-title"><?php echo e($mysteryContent['budget_title']); ?></h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = $mysteryContent['budgets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="selection-card"><input type="radio" name="budget_range" value="<?php echo e($budget['value']); ?>" <?php echo e(old('budget_range') === $budget['value'] ? 'checked' : ''); ?> required><div class="card-content"><div class="card-title"><?php echo e($budget['label']); ?></div></div></label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['budget_range'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="step-content" data-step="5">
                    <h3 class="step-title"><?php echo e($mysteryContent['surprise_title']); ?></h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = $mysteryContent['surprise_levels']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="selection-card"><input type="radio" name="surprise_level" value="<?php echo e($level); ?>" <?php echo e(old('surprise_level') === $level ? 'checked' : ''); ?> required><div class="card-content"><div class="card-title"><?php echo e($level); ?></div></div></label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['surprise_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="step-content" data-step="6">
                    <h3 class="step-title"><?php echo e($mysteryContent['note_title']); ?></h3>
                    <div class="form-group"><label for="name" class="form-label required"><?php echo e($mysteryContent['name_label']); ?></label><input id="name" type="text" name="name" value="<?php echo e(old('name', $user?->name)); ?>" class="form-input" required></div>
                    <div class="form-group"><label for="phone" class="form-label required"><?php echo e($mysteryContent['phone_label']); ?></label><input id="phone" type="tel" name="phone" value="<?php echo e(old('phone', $user?->phone)); ?>" class="form-input" required></div>
                    <div class="form-group"><label for="email" class="form-label"><?php echo e($mysteryContent['email_label']); ?></label><input id="email" type="email" name="email" value="<?php echo e(old('email', $user?->email)); ?>" class="form-input"></div>
                    <div class="form-group"><label for="note" class="form-label"><?php echo e($mysteryContent['request_label']); ?></label><textarea id="note" name="note" rows="4" class="form-input form-textarea" placeholder="<?php echo e($mysteryContent['request_placeholder']); ?>"><?php echo e(old('note')); ?></textarea></div>
                </div>

                <div class="step-content" data-step="7">
                    <h3 class="step-title"><?php echo e($mysteryContent['confirm_title']); ?></h3>
                    <div class="summary-box">
                        <div class="summary-section"><h4><?php echo e($mysteryContent['selected_info_title']); ?></h4>
                            <div class="summary-item"><span class="summary-label"><?php echo e($mysteryContent['style_summary_label']); ?></span><span class="summary-value" id="summary-style">-</span></div>
                            <div class="summary-item"><span class="summary-label"><?php echo e($mysteryContent['color_summary_label']); ?></span><span class="summary-value" id="summary-colors">-</span></div>
                            <div class="summary-item"><span class="summary-label"><?php echo e($mysteryContent['preference_summary_label']); ?></span><span class="summary-value" id="summary-preferences">-</span></div>
                            <div class="summary-item"><span class="summary-label"><?php echo e($mysteryContent['budget_summary_label']); ?></span><span class="summary-value" id="summary-budget">-</span></div>
                            <div class="summary-item"><span class="summary-label"><?php echo e($mysteryContent['surprise_summary_label']); ?></span><span class="summary-value" id="summary-surprise">-</span></div>
                        </div>
                        <div class="disclaimer"><p><?php echo e($mysteryContent['disclaimer']); ?></p></div>
                    </div>
                </div>

                <div class="step-navigation">
                    <button type="button" class="btn btn-outline btn-lg" id="prevBtn" style="display:none;">Quay lại</button>
                    <button type="button" class="btn btn-primary btn-lg" id="nextBtn">Tiếp theo</button>
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" style="display:none;">Xác nhận yêu cầu</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo e(asset('css/mystery-box.css')); ?>">
<script src="<?php echo e(asset('js/mystery-box.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/mystery-box/index.blade.php ENDPATH**/ ?>