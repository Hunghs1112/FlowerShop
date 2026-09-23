<nav class="navbar" id="navbar">
    <div class="navbar-container">

        
        <a href="<?php echo e(route('home')); ?>" class="navbar-logo">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="<?php echo e($siteSettings['site_name'] ?? config('app.name')); ?>" class="navbar-logo-img">
        </a>

        
        <ul class="navbar-nav">

            
            <li class="navbar-nav-item">
                <a href="<?php echo e(route('home')); ?>" class="navbar-nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                    Trang chủ
                </a>
            </li>

            
            <li class="navbar-nav-item" data-dropdown="mega">
                <a href="<?php echo e(route('products.index')); ?>" class="navbar-nav-link <?php echo e(request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'active' : ''); ?>">
                    Sản phẩm
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>

                <div class="navbar-mega-menu">
                    <?php if($navCategories->isNotEmpty()): ?>
                        <div class="mega-menu-grid-simple">
                            <?php $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('categories.show', $navCat->display_slug)); ?>" class="mega-menu-item">
                                    <?php echo e($navCat->display_name); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            
                            <a href="<?php echo e(route('products.index')); ?>" class="mega-menu-item mega-menu-item-all">
                                Xem tất cả sản phẩm
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="mega-menu-grid-simple">
                            <a href="<?php echo e(route('products.index')); ?>" class="mega-menu-item mega-menu-item-all">
                                Xem tất cả sản phẩm
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </li>

            
            <li class="navbar-nav-item">
                <a href="<?php echo e(route('blog.index')); ?>" class="navbar-nav-link <?php echo e(request()->routeIs('blog.*') ? 'active' : ''); ?>">
                    Góc cảm hứng
                </a>
            </li>

            
            <?php if($navPages->isNotEmpty()): ?>
            <li class="navbar-nav-item" data-dropdown="standard">
                <a href="#" class="navbar-nav-link">
                    Thông tin
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                <div class="navbar-dropdown">
                    <?php $__currentLoopData = $navPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('policy', $navPage->slug)); ?>" class="navbar-dropdown-item"><?php echo e($navPage->title); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </li>
            <?php endif; ?>

            
            <li class="navbar-nav-item">
                <a href="<?php echo e(route('b2c')); ?>" class="navbar-nav-link <?php echo e(request()->routeIs('b2c') ? 'active' : ''); ?>">
                    B2C
                </a>
            </li>

            
            <li class="navbar-nav-item">
                <a href="<?php echo e(route('about')); ?>" class="navbar-nav-link <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>">
                    Về chúng tôi
                </a>
            </li>

        </ul>

        
        <div class="navbar-actions">

            
            <button class="navbar-action-btn navbar-search-btn" id="searchToggle" title="Tìm kiếm" aria-label="Tìm kiếm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('favorites.index')); ?>" class="navbar-action-btn" title="Yêu thích" aria-label="Yêu thích">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </a>
            <?php endif; ?>

            
            <a href="<?php echo e(route('cart.index')); ?>" class="navbar-action-btn navbar-cart-btn" title="Giỏ hàng" aria-label="Giỏ hàng">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <?php 
                    $cartCount = auth()->check() 
                        ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
                        : \App\Models\CartItem::where('session_id', session()->getId())->sum('quantity');
                ?>
                <?php if($cartCount > 0): ?>
                    <span class="cart-badge"><?php echo e($cartCount); ?></span>
                <?php endif; ?>
            </a>

                    
                    <?php if(auth()->guard()->check()): ?>
                        <div class="navbar-user-menu">
                            <button class="navbar-user-toggle" id="userMenuToggle" aria-label="Tài khoản" aria-expanded="false">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span><?php echo e(Str::limit(auth()->user()->name, 10)); ?></span>
                            </button>
                            <div class="navbar-dropdown" id="userMenuDropdown">
                                <a href="<?php echo e(route('profile.show')); ?>" class="navbar-dropdown-item">Tài khoản</a>
                                <?php if(auth()->user()->isAdmin()): ?>
                                    <div class="navbar-dropdown-divider"></div>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="navbar-dropdown-item">Quản trị</a>
                                <?php endif; ?>
                                <div class="navbar-dropdown-divider"></div>
                                <form action="<?php echo e(route('logout')); ?>" method="POST" class="navbar-logout-form">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="navbar-dropdown-item navbar-dropdown-btn">Đăng xuất</button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="navbar-action-btn navbar-auth-btn" title="Đăng nhập" aria-label="Đăng nhập">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            <?php endif; ?>

            
            <button class="navbar-mobile-toggle" id="mobileMenuToggle" aria-label="Menu" aria-expanded="false" aria-controls="mobileMenu">
                <span class="hamburger-icon" aria-hidden="true">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>
    </div>

</nav>


<div class="navbar-mobile-menu" id="mobileMenu">

        
        <ul class="mobile-menu-actions">
            <li>
                <a href="<?php echo e(route('cart.index')); ?>" class="mobile-menu-action-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span>Giỏ hàng</span>
                    <?php 
                        $cartCount = auth()->check() 
                            ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
                            : \App\Models\CartItem::where('session_id', session()->getId())->sum('quantity');
                    ?>
                    <?php if($cartCount > 0): ?>
                        <span class="mobile-menu-badge"><?php echo e($cartCount); ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <?php if(auth()->guard()->check()): ?>
                <li>
                    <a href="<?php echo e(route('favorites.index')); ?>" class="mobile-menu-action-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Yêu thích</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <ul class="navbar-mobile-nav">
            <li><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>

            
            <li class="navbar-mobile-accordion-item">
                <button class="navbar-mobile-accordion-toggle" aria-expanded="false">
                    Sản phẩm
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="navbar-mobile-accordion-content">
                    <div class="navbar-mobile-accordion-links">
                        <?php $__currentLoopData = $navCategories->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('categories.show', $navCat->display_slug)); ?>" class="navbar-mobile-accordion-link"><?php echo e($navCat->display_name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('products.index')); ?>" class="navbar-mobile-accordion-link">Tất cả sản phẩm</a>
                    </div>
                </div>
            </li>

            
            <li><a href="<?php echo e(route('blog.index')); ?>">Bài viết</a></li>

            
            <?php if($navPages->isNotEmpty()): ?>
            <li class="navbar-mobile-accordion-item">
                <button class="navbar-mobile-accordion-toggle" aria-expanded="false">
                    Thông tin
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="navbar-mobile-accordion-content">
                    <div class="navbar-mobile-accordion-links">
                        <?php $__currentLoopData = $navPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('policy', $navPage->slug)); ?>" class="navbar-mobile-accordion-link"><?php echo e($navPage->title); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </li>
            <?php endif; ?>

            
            <li><a href="<?php echo e(route('b2c')); ?>">B2C</a></li>

            
            <li><a href="<?php echo e(route('about')); ?>">Về chúng tôi</a></li>

            <?php if(auth()->guard()->check()): ?>
                <div class="mobile-menu-divider"></div>
                <li><a href="<?php echo e(route('profile.show')); ?>">Tài khoản</a></li>
                <?php if(auth()->user()->isAdmin()): ?>
                    <li><a href="<?php echo e(route('admin.dashboard')); ?>">Quản trị</a></li>
                <?php endif; ?>
                <div class="mobile-menu-divider"></div>
                <li>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="navbar-logout-form">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="mobile-menu-logout-btn">Đăng xuất</button>
                    </form>
                </li>
            <?php else: ?>
                <div class="mobile-menu-divider"></div>
                <li><a href="<?php echo e(route('login')); ?>">Đăng nhập</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Desktop dropdowns ──────────────────────────────────
    let activeDropdown = null;
    let closeTimeout = null;

    document.querySelectorAll('.navbar-nav-item[data-dropdown]').forEach(item => {
        const link     = item.querySelector('.navbar-nav-link');
        const dropdown = item.querySelector('.navbar-mega-menu, .navbar-dropdown');
        if (!dropdown) return;

        item.addEventListener('mouseenter', () => {
            if (window.innerWidth < 1024) return;
            clearTimeout(closeTimeout);
            if (activeDropdown && activeDropdown !== item) {
                activeDropdown.classList.remove('dropdown-active');
                activeDropdown.querySelector('.navbar-mega-menu, .navbar-dropdown')?.classList.remove('active');
            }
            item.classList.add('dropdown-active');
            dropdown.classList.add('active');
            link?.setAttribute('aria-expanded', 'true');
            activeDropdown = item;
        });

        item.addEventListener('mouseleave', () => {
            if (window.innerWidth < 1024) return;
            closeTimeout = setTimeout(() => {
                item.classList.remove('dropdown-active');
                dropdown.classList.remove('active');
                link?.setAttribute('aria-expanded', 'false');
                if (activeDropdown === item) activeDropdown = null;
            }, 150);
        });
    });

    document.addEventListener('click', e => {
        if (activeDropdown && !activeDropdown.contains(e.target)) {
            activeDropdown.classList.remove('dropdown-active');
            activeDropdown.querySelector('.navbar-mega-menu, .navbar-dropdown')?.classList.remove('active');
            activeDropdown = null;
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && activeDropdown) {
            activeDropdown.classList.remove('dropdown-active');
            activeDropdown.querySelector('.navbar-mega-menu, .navbar-dropdown')?.classList.remove('active');
            activeDropdown = null;
        }
    });

    // ── Mobile accordion ──────────────────────────────────
    document.querySelectorAll('.navbar-mobile-accordion-toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const content  = this.nextElementSibling;
            const isActive = this.classList.contains('active');

            document.querySelectorAll('.navbar-mobile-accordion-toggle').forEach(t => {
                t.classList.remove('active');
                t.setAttribute('aria-expanded', 'false');
                t.nextElementSibling?.classList.remove('active');
            });

            if (!isActive) {
                this.classList.add('active');
                this.setAttribute('aria-expanded', 'true');
                content.classList.add('active');
            }
        });
    });

    // ── Sticky on scroll ──────────────────────────────────
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.pageYOffset > 10);
    }, { passive: true });

    // ── User menu ─────────────────────────────────────────
    const userToggle   = document.getElementById('userMenuToggle');
    const userDropdown = document.getElementById('userMenuDropdown');
    if (userToggle && userDropdown) {
        userToggle.addEventListener('click', e => {
            e.stopPropagation();
            const open = userDropdown.classList.toggle('active');
            userToggle.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', e => {
            if (!userToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('active');
                userToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // ── Mobile menu ───────────────────────────────────────
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu   = document.getElementById('mobileMenu');
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            const open = mobileMenu.classList.toggle('active');
            document.body.style.overflow = open ? 'hidden' : '';
            mobileToggle.setAttribute('aria-expanded', open);
        });

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
                mobileToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024 && mobileMenu) {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
            mobileToggle?.setAttribute('aria-expanded', 'false');
        }
    });
});
</script>
<?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/partials/navbar.blade.php ENDPATH**/ ?>