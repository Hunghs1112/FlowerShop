<nav class="navbar" id="navbar">
    <div class="navbar-container">

        
        <a href="<?php echo e(route('home')); ?>" class="navbar-logo">
            <svg class="navbar-logo-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span class="navbar-logo-text"><?php echo e($siteSettings['site_name'] ?? config('app.name')); ?></span>
        </a>

        
        <ul class="navbar-nav">

            
            <li class="navbar-nav-item">
                <a href="<?php echo e(route('home')); ?>" class="navbar-nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                    <?php echo e(__('messages.nav.home')); ?>

                </a>
            </li>

            
            <li class="navbar-nav-item" data-dropdown="mega">
                <a href="<?php echo e(route('products.index')); ?>" class="navbar-nav-link <?php echo e(request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'active' : ''); ?>">
                    <?php echo e(__('messages.nav.products')); ?>

                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>

                <div class="navbar-mega-menu">
                    <div class="mega-menu-grid">

                        
                        <?php if($navCategories->isNotEmpty()): ?>
                            <?php $__currentLoopData = $navCategories->chunk(ceil($navCategories->count() / 3)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkIndex => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mega-menu-column">
                                <h3 class="mega-menu-heading">
                                    <?php if($chunkIndex === 0): ?> <?php echo e(__('messages.nav.categories')); ?>

                                    <?php elseif($chunkIndex === 1): ?> <?php echo e(__('messages.nav.explore')); ?>

                                    <?php else: ?> <?php echo e(__('messages.nav.collections')); ?>

                                    <?php endif; ?>
                                </h3>
                                <div class="mega-menu-links">
                                    <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('categories.show', $navCat->display_slug)); ?>" class="mega-menu-link"><?php echo e($navCat->display_name); ?></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="mega-menu-column">
                                <h3 class="mega-menu-heading"><?php echo e(__('messages.nav.products')); ?></h3>
                                <div class="mega-menu-links">
                                    <a href="<?php echo e(route('products.index')); ?>" class="mega-menu-link"><?php echo e(__('messages.nav.all_products')); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>

                        
                        <div class="mega-menu-column">
                            <h3 class="mega-menu-heading"><?php echo e(__('messages.nav.view_by') ?? 'Xem theo'); ?></h3>
                            <div class="mega-menu-links">
                                <a href="<?php echo e(route('products.index', ['sort_by' => 'newest'])); ?>" class="mega-menu-link"><?php echo e(__('messages.nav.new_flowers')); ?></a>
                                <a href="<?php echo e(route('products.index', ['sort_by' => 'bestseller'])); ?>" class="mega-menu-link"><?php echo e(__('messages.nav.best_sellers')); ?></a>
                                <a href="<?php echo e(route('products.index')); ?>" class="mega-menu-link"><?php echo e(__('messages.nav.all_products')); ?></a>
                            </div>
                        </div>

                        
                        <div class="mega-menu-featured">
                            <img
                                src="<?php echo e(asset('images/navbar/navbar-featured.jpg')); ?>"
                                alt="<?php echo e(__('messages.nav.new_collection')); ?>"
                                class="mega-menu-featured-image"
                            >
                            <div class="mega-menu-featured-overlay">
                                <div class="mega-menu-featured-title"><?php echo e(__('messages.nav.new_bst')); ?></div>
                                <a href="<?php echo e(route('products.index', ['sort_by' => 'newest'])); ?>" class="mega-menu-featured-link">
                                    <?php echo e(__('messages.nav.explore')); ?>

                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </li>

            
            <li class="navbar-nav-item">
                <a href="<?php echo e(route('blog.index')); ?>" class="navbar-nav-link <?php echo e(request()->routeIs('blog.*') ? 'active' : ''); ?>">
                    <?php echo e(__('messages.nav.blog')); ?>

                </a>
            </li>

            
            <?php if($navPages->isNotEmpty()): ?>
            <li class="navbar-nav-item" data-dropdown="standard">
                <a href="#" class="navbar-nav-link">
                    <?php echo e(__('messages.nav.information')); ?>

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
                <a href="<?php echo e(route('contact')); ?>" class="navbar-nav-link <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>">
                    <?php echo e(__('messages.nav.contact')); ?>

                </a>
            </li>

        </ul>

        
        <div class="navbar-actions">

            
            <button class="navbar-action-btn" id="searchToggle" title="<?php echo e(__('messages.nav.search')); ?>" aria-label="<?php echo e(__('messages.nav.search')); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            
            <a href="<?php echo e(route('cart.index')); ?>" class="navbar-action-btn" title="<?php echo e(__('messages.nav.cart')); ?>" aria-label="<?php echo e(__('messages.nav.cart')); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <?php $cartCount = session('cart') ? count(session('cart')) : 0; ?>
                <?php if($cartCount > 0): ?>
                    <span class="cart-badge"><?php echo e($cartCount); ?></span>
                <?php endif; ?>
            </a>

                    
                    <?php if(auth()->guard()->check()): ?>
                        <div class="navbar-user-menu">
                            <button class="navbar-user-toggle" id="userMenuToggle" aria-label="<?php echo e(__('messages.nav.account')); ?>" aria-expanded="false">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span><?php echo e(Str::limit(auth()->user()->name, 10)); ?></span>
                            </button>
                            <div class="navbar-dropdown" id="userMenuDropdown">
                                <a href="<?php echo e(route('profile.show')); ?>" class="navbar-dropdown-item"><?php echo e(__('messages.nav.account')); ?></a>
                                <?php if(auth()->user()->isAdmin()): ?>
                                    <div class="navbar-dropdown-divider"></div>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="navbar-dropdown-item"><?php echo e(__('messages.nav.admin')); ?></a>
                                <?php endif; ?>
                                <div class="navbar-dropdown-divider"></div>
                                <form action="<?php echo e(route('logout')); ?>" method="POST" class="navbar-logout-form">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="navbar-dropdown-item navbar-dropdown-btn"><?php echo e(__('messages.nav.logout')); ?></button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="navbar-action-btn" title="<?php echo e(__('messages.nav.login')); ?>" aria-label="<?php echo e(__('messages.nav.login')); ?>">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            <?php endif; ?>

            
            <button class="navbar-mobile-toggle" id="mobileMenuToggle" aria-label="Menu" aria-expanded="false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    
    <div class="navbar-mobile-menu" id="mobileMenu">

        <ul class="navbar-mobile-nav">
            <li><a href="<?php echo e(route('home')); ?>"><?php echo e(__('messages.nav.home')); ?></a></li>

            
            <li class="navbar-mobile-accordion-item">
                <button class="navbar-mobile-accordion-toggle" aria-expanded="false">
                    <?php echo e(__('messages.nav.products')); ?>

                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="navbar-mobile-accordion-content">
                    <div class="navbar-mobile-accordion-links">
                        <?php $__currentLoopData = $navCategories->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('categories.show', $navCat->display_slug)); ?>" class="navbar-mobile-accordion-link"><?php echo e($navCat->display_name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('products.index')); ?>" class="navbar-mobile-accordion-link"><?php echo e(__('messages.nav.all_products')); ?></a>
                    </div>
                </div>
            </li>

            
            <li><a href="<?php echo e(route('blog.index')); ?>"><?php echo e(__('messages.nav.blog')); ?></a></li>

            
            <?php if($navPages->isNotEmpty()): ?>
            <li class="navbar-mobile-accordion-item">
                <button class="navbar-mobile-accordion-toggle" aria-expanded="false">
                    <?php echo e(__('messages.nav.information')); ?>

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

            
            <li><a href="<?php echo e(route('contact')); ?>"><?php echo e(__('messages.nav.contact')); ?></a></li>

            <?php if(auth()->guard()->check()): ?>
                <div class="mobile-menu-divider"></div>
                <li><a href="<?php echo e(route('profile.show')); ?>"><?php echo e(__('messages.nav.account')); ?></a></li>
                <?php if(auth()->user()->isAdmin()): ?>
                    <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('messages.nav.admin')); ?></a></li>
                <?php endif; ?>
                <div class="mobile-menu-divider"></div>
                <li>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="navbar-logout-form">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="mobile-menu-logout-btn"><?php echo e(__('messages.nav.logout')); ?></button>
                    </form>
                </li>
            <?php else: ?>
                <div class="mobile-menu-divider"></div>
                <li><a href="<?php echo e(route('login')); ?>"><?php echo e(__('messages.nav.login')); ?></a></li>
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