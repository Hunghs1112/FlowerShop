<?php $__env->startSection('title', 'Hộp Hoa Bí Ẩn'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginala9d931d4f11b4d2850df99e991db1dca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9d931d4f11b4d2850df99e991db1dca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-hero','data' => ['title' => 'Hộp Hoa Bí Ẩn','description' => 'Để LNT chọn hoa, bạn giữ lại niềm vui bất ngờ','breadcrumbs' => [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Hộp Hoa Bí Ẩn']
    ],'image' => $siteBanners['mystery-box'] ?? null,'height' => '350px']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hộp Hoa Bí Ẩn','description' => 'Để LNT chọn hoa, bạn giữ lại niềm vui bất ngờ','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Hộp Hoa Bí Ẩn']
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
    <div class="mystery-box-container">
        <div class="mystery-box-content">
            <div class="mystery-box-intro">
                <h2>Khám Phá Điều Bất Ngờ</h2>
                <p>Bạn không chọn sản phẩm cụ thể. Chỉ cần cung cấp nhu cầu của mình, và LNT sẽ lựa chọn những bông hoa đẹp nhất dành riêng cho bạn.</p>
            </div>

            <form id="mysteryBoxForm" action="<?php echo e(route('mystery-box.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step-item active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-label">Phong cách</div>
                    </div>
                    <div class="step-item" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Màu sắc</div>
                    </div>
                    <div class="step-item" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-label">Sở thích</div>
                    </div>
                    <div class="step-item" data-step="4">
                        <div class="step-number">4</div>
                        <div class="step-label">Ngân sách</div>
                    </div>
                    <div class="step-item" data-step="5">
                        <div class="step-number">5</div>
                        <div class="step-label">Mức độ bất ngờ</div>
                    </div>
                    <div class="step-item" data-step="6">
                        <div class="step-number">6</div>
                        <div class="step-label">Ghi chú</div>
                    </div>
                    <div class="step-item" data-step="7">
                        <div class="step-number">7</div>
                        <div class="step-label">Xác nhận</div>
                    </div>
                </div>

                <!-- Step 1: Style -->
                <div class="step-content active" data-step="1">
                    <h3 class="step-title">Chọn Phong Cách</h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = ['Thanh lịch', 'Lãng mạn', 'Tự nhiên', 'Tối giản', 'Sang trọng']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="selection-card">
                            <input type="radio" name="style" value="<?php echo e($style); ?>" <?php echo e(old('style') == $style ? 'checked' : ''); ?> required>
                            <div class="card-content">
                                <div class="card-icon">
                                    <?php if($style == 'Thanh lịch'): ?>
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    <?php elseif($style == 'Lãng mạn'): ?>
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    <?php elseif($style == 'Tự nhiên'): ?>
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    <?php elseif($style == 'Tối giản'): ?>
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    <?php else: ?>
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                    <?php endif; ?>
                                </div>
                                <div class="card-title"><?php echo e($style); ?></div>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['style'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="form-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Step 2: Colors -->
                <div class="step-content" data-step="2">
                    <h3 class="step-title">Chọn Màu Sắc (có thể chọn nhiều)</h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = ['Trắng', 'Kem', 'Hồng', 'Xanh', 'Đỏ', 'Pastel', 'Không giới hạn']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="selection-card">
                            <input type="checkbox" name="colors[]" value="<?php echo e($color); ?>" <?php echo e(is_array(old('colors')) && in_array($color, old('colors')) ? 'checked' : ''); ?>>
                            <div class="card-content">
                                <div class="color-preview" style="background-color: <?php echo e($color == 'Trắng' ? '#FFFFFF' : 
                                    ($color == 'Kem' ? '#FFF8DC' : 
                                    ($color == 'Hồng' ? '#FFB6C1' : 
                                    ($color == 'Xanh' ? '#87CEEB' : 
                                    ($color == 'Đỏ' ? '#DC143C' : 
                                    ($color == 'Pastel' ? 'linear-gradient(135deg, #FFB6C1 0%, #87CEEB 100%)' : '#E5E7EB')))))); ?>; <?php echo e($color == 'Không giới hạn' ? 'background: linear-gradient(135deg, #FFB6C1 0%, #87CEEB 50%, #FFF8DC 100%);' : ''); ?>"></div>
                                <div class="card-title"><?php echo e($color); ?></div>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['colors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="form-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Step 3: Preferences -->
                <div class="step-content" data-step="3">
                    <h3 class="step-title">Sở Thích (có thể chọn nhiều)</h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = ['Nhiều hoa', 'Ít hoa', 'Nhiều lá', 'Nhẹ nhàng', 'Nổi bật', 'Tự nhiên']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="selection-card">
                            <input type="checkbox" name="preferences[]" value="<?php echo e($pref); ?>" <?php echo e(is_array(old('preferences')) && in_array($pref, old('preferences')) ? 'checked' : ''); ?>>
                            <div class="card-content">
                                <div class="card-title"><?php echo e($pref); ?></div>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['preferences'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="form-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Step 4: Budget -->
                <div class="step-content" data-step="4">
                    <h3 class="step-title">Ngân Sách</h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = ['500k-1M' => '500.000đ - 1.000.000đ', '1M-2M' => '1.000.000đ - 2.000.000đ', '2M-5M' => '2.000.000đ - 5.000.000đ', '5M+' => '5.000.000đ+']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="selection-card">
                            <input type="radio" name="budget_range" value="<?php echo e($value); ?>" <?php echo e(old('budget_range') == $value ? 'checked' : ''); ?> required>
                            <div class="card-content">
                                <div class="card-title"><?php echo e($label); ?></div>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['budget_range'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="form-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Step 5: Surprise Level -->
                <div class="step-content" data-step="5">
                    <h3 class="step-title">Mức Độ Bất Ngờ</h3>
                    <div class="selection-grid">
                        <?php $__currentLoopData = ['Bất ngờ hoàn toàn', 'Bất ngờ một phần', 'Muốn giữ một vài yêu cầu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="selection-card">
                            <input type="radio" name="surprise_level" value="<?php echo e($level); ?>" <?php echo e(old('surprise_level') == $level ? 'checked' : ''); ?> required>
                            <div class="card-content">
                                <div class="card-title"><?php echo e($level); ?></div>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['surprise_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="form-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Step 6: Note -->
                <div class="step-content" data-step="6">
                    <h3 class="step-title">Ghi Chú</h3>
                    <div class="form-group">
                        <label for="name" class="form-label required">Họ và tên</label>
                        <input type="text" id="name" name="name" 
                               value="<?php echo e($user ? $user->name : old('name')); ?>" 
                               class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="form-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label required">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo e($user ? $user->phone : old('phone')); ?>" 
                               class="form-input <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="form-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email (tùy chọn)</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo e($user ? $user->email : old('email')); ?>" 
                               class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="form-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label for="note" class="form-label">Yêu cầu riêng</label>
                        <textarea id="note" name="note" rows="4" 
                                  class="form-input form-textarea <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  placeholder="Ví dụ: Không dùng hoa đỏ"><?php echo e(old('note')); ?></textarea>
                        <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="form-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Step 7: Confirmation -->
                <div class="step-content" data-step="7">
                    <h3 class="step-title">Xác Nhận Mystery Box</h3>
                    
                    <div class="summary-box">
                        <div class="summary-section">
                            <h4>Thông Tin Đã Chọn</h4>
                            <div class="summary-item">
                                <span class="summary-label">Phong cách:</span>
                                <span class="summary-value" id="summary-style">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Bảng màu:</span>
                                <span class="summary-value" id="summary-colors">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Sở thích:</span>
                                <span class="summary-value" id="summary-preferences">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Ngân sách:</span>
                                <span class="summary-value" id="summary-budget">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Mức độ bất ngờ:</span>
                                <span class="summary-value" id="summary-surprise">-</span>
                            </div>
                        </div>

                        <div class="disclaimer">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p>Mystery Box được LNT tuyển chọn dựa trên hoa sẵn có, mùa hoa và chất lượng tại thời điểm chuẩn bị. Một số loại hoa có thể được thay thế bằng lựa chọn tương đương nếu cần.</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="step-navigation">
                    <button type="button" class="btn btn-outline btn-lg" id="prevBtn" style="display: none;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Quay lại
                    </button>
                    <button type="button" class="btn btn-primary btn-lg" id="nextBtn">
                        Tiếp theo
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" style="display: none;">
                        Xác nhận yêu cầu
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo e(asset('css/mystery-box.css')); ?>">
<script src="<?php echo e(asset('js/mystery-box.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/mystery-box/index.blade.php ENDPATH**/ ?>