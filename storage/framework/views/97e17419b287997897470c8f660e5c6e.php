<?php $__env->startSection('title', 'Đặt lại mật khẩu'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            <h1><?php echo e(config('app.name')); ?></h1>
        </div>

        <div class="auth-header">
            <h2>Đặt lại mật khẩu</h2>
            <p>Nhập mật khẩu mới của bạn</p>
        </div>

        <form method="POST" action="<?php echo e(route('password.update')); ?>" class="auth-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="token" value="<?php echo e($token); ?>">

            <div class="form-group">
                <label for="email">Địa chỉ Email</label>
                <input id="email" type="email" name="email" value="<?php echo e($email ?? old('email')); ?>" required autofocus>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu mới</label>
                <input id="password" type="password" name="password" required>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="password-confirm">Xác nhận mật khẩu</label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    Đặt lại mật khẩu
                </button>
            </div>
        </form>

        <div class="auth-links">
            <a href="<?php echo e(route('login')); ?>">Quay lại đăng nhập</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/auth/passwords/reset.blade.php ENDPATH**/ ?>