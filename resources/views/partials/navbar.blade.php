<nav class="navbar" id="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="navbar-logo">
            <svg class="navbar-logo-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span class="navbar-logo-text">Lâm Nhiên Thảo</span>
        </a>

        <!-- Main Navigation -->
        <ul class="navbar-nav">
            <!-- Trang chủ -->
            <li class="navbar-nav-item">
                <a href="{{ route('home') }}" class="navbar-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Trang chủ
                </a>
            </li>
            
            <!-- Sản phẩm - Mega Menu -->
            <li class="navbar-nav-item" data-dropdown="mega">
                <a href="{{ route('products.index') }}" class="navbar-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    Sản phẩm
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                
                <!-- Mega Menu -->
                <div class="navbar-mega-menu">
                    <div class="mega-menu-grid">
                        {{-- Columns dynamically from DB categories --}}
                        @if($navCategories->isNotEmpty())
                            @foreach($navCategories->chunk(ceil($navCategories->count() / 3)) as $chunkIndex => $chunk)
                            <div class="mega-menu-column">
                                @if($chunkIndex === 0)
                                    <h3 class="mega-menu-heading">Danh mục hoa</h3>
                                @elseif($chunkIndex === 1)
                                    <h3 class="mega-menu-heading">Khám phá thêm</h3>
                                @else
                                    <h3 class="mega-menu-heading">Bộ sưu tập</h3>
                                @endif
                                <div class="mega-menu-links">
                                    @foreach($chunk as $navCat)
                                        <a href="{{ route('categories.show', $navCat->slug) }}" class="mega-menu-link">{{ $navCat->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="mega-menu-column">
                                <h3 class="mega-menu-heading">Sản phẩm</h3>
                                <div class="mega-menu-links">
                                    <a href="{{ route('products.index') }}" class="mega-menu-link">Tất cả sản phẩm</a>
                                </div>
                            </div>
                        @endif

                        <!-- Khám phá -->
                        <div class="mega-menu-column">
                            <h3 class="mega-menu-heading">Khám phá</h3>
                            <div class="mega-menu-links">
                                <a href="{{ route('products.index', ['sort_by' => 'newest']) }}" class="mega-menu-link">Hoa mới về</a>
                                <a href="{{ route('products.index', ['sort_by' => 'bestseller']) }}" class="mega-menu-link">Hoa bán chạy</a>
                                <a href="{{ route('products.index', ['price_range' => 'under-500k']) }}" class="mega-menu-link">Dưới 500.000đ</a>
                                <a href="{{ route('products.index', ['price_range' => '500k-1m']) }}" class="mega-menu-link">500k – 1 triệu</a>
                                <a href="{{ route('products.index', ['price_range' => 'over-2m']) }}" class="mega-menu-link">Cao cấp trên 2 triệu</a>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="mega-menu-featured">
                            <img 
                                src="{{ asset('images/navbar/navbar-featured.jpg') }}" 
                                alt="Bộ sưu tập hoa mới"
                                class="mega-menu-featured-image"
                            >
                            <div class="mega-menu-featured-overlay">
                                <div class="mega-menu-featured-title">BST hoa mới</div>
                                <a href="{{ route('products.index', ['sort_by' => 'newest']) }}" class="mega-menu-featured-link">
                                    Khám phá
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            
            <!-- Trang điểm -> Tính năng -->
            <li class="navbar-nav-item" data-dropdown="standard">
                <a href="#" class="navbar-nav-link">
                    Tính năng
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                
                <!-- Standard Dropdown -->
                <div class="navbar-dropdown">
                    <a href="{{ route('about') }}" class="navbar-dropdown-item">Giới thiệu</a>
                    <a href="{{ route('policy', 'chinh-sach-giao-hang') }}" class="navbar-dropdown-item">Dịch vụ giao hoa</a>
                    <a href="{{ route('policy', 'huong-dan-mua-hang') }}" class="navbar-dropdown-item">Hướng dẫn mua hàng</a>
                    <a href="{{ route('policy', 'chinh-sach-doi-tra') }}" class="navbar-dropdown-item">Chính sách đổi trả</a>
                    <a href="{{ route('blog.index') }}" class="navbar-dropdown-item">Góc cảm hứng</a>
                </div>
            </li>
            
            <!-- Góc làm đẹp -->
            <li class="navbar-nav-item" data-dropdown="standard">
                <a href="{{ route('blog.index') }}" class="navbar-nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                    Góc cảm hứng
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                
                <!-- Standard Dropdown -->
                <div class="navbar-dropdown">
                    <a href="{{ route('blog.index') }}?category=care" class="navbar-dropdown-item">Chăm sóc hoa</a>
                    <a href="{{ route('blog.index') }}?category=meaning" class="navbar-dropdown-item">Ý nghĩa các loài hoa</a>
                    <a href="{{ route('blog.index') }}?category=tips" class="navbar-dropdown-item">Cách giữ hoa tươi lâu</a>
                    <a href="{{ route('blog.index') }}?category=art" class="navbar-dropdown-item">Nghệ thuật cắm hoa</a>
                    <a href="{{ route('blog.index') }}?category=trends" class="navbar-dropdown-item">Xu hướng hoa</a>
                    <a href="{{ route('blog.index') }}?category=story" class="navbar-dropdown-item">Câu chuyện thương hiệu</a>
                </div>
            </li>
            
            <!-- Liên hệ -->
            <li class="navbar-nav-item" data-dropdown="standard">
                <a href="{{ route('contact') }}" class="navbar-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                    Liên hệ
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                
                <!-- Standard Dropdown with Contact Info -->
                <div class="navbar-dropdown">
                    <a href="{{ route('contact') }}" class="navbar-dropdown-item">Thông tin cửa hàng</a>
                    <a href="{{ route('contact') }}#contact-form" class="navbar-dropdown-item">Liên hệ chúng tôi</a>
                    <a href="{{ route('policy', 'huong-dan-mua-hang') }}" class="navbar-dropdown-item">Hướng dẫn mua hàng</a>
                    <a href="{{ route('policy', 'chinh-sach-giao-hang') }}" class="navbar-dropdown-item">Chính sách giao hàng</a>
                    <a href="{{ route('policy', 'chinh-sach-doi-tra') }}" class="navbar-dropdown-item">Chính sách đổi trả</a>
                    
                    <div class="navbar-dropdown-contact">
                        <div class="navbar-dropdown-contact-label">Hotline</div>
                        <a href="tel:{{ preg_replace('/\D/', '', $siteSettings['phone']) }}" class="navbar-dropdown-contact-value">{{ $siteSettings['phone'] }}</a>
                    </div>
                </div>
            </li>
        </ul>

        <!-- Right Actions -->
        <div class="navbar-actions">
            <!-- Search -->
            <button class="navbar-action-btn" id="searchToggle" title="Tìm kiếm" aria-label="Tìm kiếm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            <!-- Wishlist -->
            <a href="{{ route('favorites.index') }}" class="navbar-action-btn" title="Yêu thích" aria-label="Yêu thích">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </a>

            <!-- Cart -->
            <a href="{{ route('cart.index') }}" class="navbar-action-btn" title="Giỏ hàng" aria-label="Giỏ hàng">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                @php
                    $cartCount = session('cart') ? count(session('cart')) : 0;
                @endphp
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>

            <!-- User Menu -->
            @auth
                <div class="navbar-user-menu">
                    <button class="navbar-user-toggle" id="userMenuToggle" aria-label="Menu người dùng" aria-expanded="false">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ Str::limit(auth()->user()->name, 10) }}</span>
                    </button>
                    <div class="navbar-dropdown" id="userMenuDropdown">
                        <a href="{{ route('profile.show') }}" class="navbar-dropdown-item">
                            Tài khoản của tôi
                        </a>
                        <a href="{{ route('checkout.success') }}" class="navbar-dropdown-item">
                            Đơn hàng
                        </a>
                        <a href="{{ route('favorites.index') }}" class="navbar-dropdown-item">
                            Yêu thích
                        </a>
                        @if(auth()->user()->isAdmin())
                            <div class="navbar-dropdown-divider"></div>
                            <a href="{{ route('admin.dashboard') }}" class="navbar-dropdown-item">
                                Quản trị
                            </a>
                        @endif
                        <div class="navbar-dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="navbar-dropdown-item" style="width: 100%; text-align: left; font-family: inherit; font-size: inherit;">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="navbar-action-btn" title="Đăng nhập" aria-label="Đăng nhập">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            @endauth

            <!-- Mobile Menu Toggle -->
            <button class="navbar-mobile-toggle" id="mobileMenuToggle" aria-label="Menu" aria-expanded="false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="navbar-mobile-menu" id="mobileMenu">
        <ul class="navbar-mobile-nav">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>
            
            <!-- Mobile Accordion: Sản phẩm -->
            <li class="navbar-mobile-accordion-item">
                <button class="navbar-mobile-accordion-toggle" aria-expanded="false">
                    Sản phẩm
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="navbar-mobile-accordion-content">
                    <div class="navbar-mobile-accordion-links">
                        @foreach($navCategories->take(6) as $navCat)
                            <a href="{{ route('categories.show', $navCat->slug) }}" class="navbar-mobile-accordion-link">{{ $navCat->name }}</a>
                        @endforeach
                        <a href="{{ route('products.index') }}" class="navbar-mobile-accordion-link">Tất cả sản phẩm</a>
                    </div>
                </div>
            </li>
            
            <!-- Mobile Accordion: Tính năng -->
            <li class="navbar-mobile-accordion-item">
                <button class="navbar-mobile-accordion-toggle" aria-expanded="false">
                    Tính năng
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="navbar-mobile-accordion-content">
                    <div class="navbar-mobile-accordion-links">
                        <a href="{{ route('about') }}" class="navbar-mobile-accordion-link">Giới thiệu</a>
                        <a href="{{ route('policy', 'chinh-sach-giao-hang') }}" class="navbar-mobile-accordion-link">Dịch vụ giao hoa</a>
                        <a href="{{ route('policy', 'huong-dan-mua-hang') }}" class="navbar-mobile-accordion-link">Hướng dẫn mua hàng</a>
                        <a href="{{ route('policy', 'chinh-sach-doi-tra') }}" class="navbar-mobile-accordion-link">Chính sách đổi trả</a>
                    </div>
                </div>
            </li>
            
            <!-- Mobile Accordion: Góc cảm hứng -->
            <li class="navbar-mobile-accordion-item">
                <button class="navbar-mobile-accordion-toggle" aria-expanded="false">
                    Góc cảm hứng
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="navbar-mobile-accordion-content">
                    <div class="navbar-mobile-accordion-links">
                        <a href="{{ route('blog.index') }}?category=care" class="navbar-mobile-accordion-link">Chăm sóc hoa</a>
                        <a href="{{ route('blog.index') }}?category=meaning" class="navbar-mobile-accordion-link">Ý nghĩa hoa</a>
                        <a href="{{ route('blog.index') }}?category=trends" class="navbar-mobile-accordion-link">Xu hướng hoa</a>
                        <a href="{{ route('blog.index') }}?category=story" class="navbar-mobile-accordion-link">Câu chuyện</a>
                    </div>
                </div>
            </li>
            
            <li><a href="{{ route('contact') }}">Liên hệ</a></li>
            
            @auth
                <div style="height: 1px; background-color: var(--color-border); margin: var(--space-4) 0;"></div>
                <li><a href="{{ route('profile.show') }}">Tài khoản của tôi</a></li>
                <li><a href="{{ route('checkout.success') }}">Đơn hàng</a></li>
                <li><a href="{{ route('favorites.index') }}">Yêu thích</a></li>
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}">Quản trị</a></li>
                @endif
                <div style="height: 1px; background-color: var(--color-border); margin: var(--space-4) 0;"></div>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: left; background: transparent; border: none; padding: var(--space-4); color: var(--color-text-primary); font-size: 16px; font-weight: 500; cursor: pointer; font-family: inherit;">
                            Đăng xuất
                        </button>
                    </form>
                </li>
            @else
                <div style="height: 1px; background-color: var(--color-border); margin: var(--space-4) 0;"></div>
                <li><a href="{{ route('login') }}">Đăng nhập</a></li>
            @endauth
        </ul>
    </div>
</nav>

<script>
    // Dropdown Management
    document.addEventListener('DOMContentLoaded', function() {
        let activeDropdown = null;
        let closeTimeout = null;
        
        // Desktop dropdown items
        const dropdownItems = document.querySelectorAll('.navbar-nav-item[data-dropdown]');
        
        dropdownItems.forEach(item => {
            const link = item.querySelector('.navbar-nav-link');
            const dropdown = item.querySelector('.navbar-mega-menu, .navbar-dropdown');
            
            if (!dropdown) return;
            
            // Mouse enter
            item.addEventListener('mouseenter', () => {
                if (window.innerWidth >= 1024) {
                    clearTimeout(closeTimeout);
                    
                    // Close active dropdown if different
                    if (activeDropdown && activeDropdown !== item) {
                        activeDropdown.classList.remove('dropdown-active');
                        const activeMenu = activeDropdown.querySelector('.navbar-mega-menu, .navbar-dropdown');
                        if (activeMenu) activeMenu.classList.remove('active');
                    }
                    
                    // Open current dropdown
                    item.classList.add('dropdown-active');
                    dropdown.classList.add('active');
                    activeDropdown = item;
                    
                    // Update aria
                    link.setAttribute('aria-expanded', 'true');
                }
            });
            
            // Mouse leave
            item.addEventListener('mouseleave', () => {
                if (window.innerWidth >= 1024) {
                    closeTimeout = setTimeout(() => {
                        item.classList.remove('dropdown-active');
                        dropdown.classList.remove('active');
                        link.setAttribute('aria-expanded', 'false');
                        if (activeDropdown === item) {
                            activeDropdown = null;
                        }
                    }, 150);
                }
            });
        });
        
        // Click outside to close
        document.addEventListener('click', (e) => {
            if (activeDropdown && !activeDropdown.contains(e.target)) {
                activeDropdown.classList.remove('dropdown-active');
                const activeMenu = activeDropdown.querySelector('.navbar-mega-menu, .navbar-dropdown');
                if (activeMenu) activeMenu.classList.remove('active');
                activeDropdown = null;
            }
        });
        
        // ESC key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && activeDropdown) {
                activeDropdown.classList.remove('dropdown-active');
                const activeMenu = activeDropdown.querySelector('.navbar-mega-menu, .navbar-dropdown');
                if (activeMenu) activeMenu.classList.remove('active');
                activeDropdown = null;
            }
        });
        
        // Mobile accordion
        const accordionToggles = document.querySelectorAll('.navbar-mobile-accordion-toggle');
        accordionToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const isActive = this.classList.contains('active');
                
                // Close all accordions
                accordionToggles.forEach(t => {
                    t.classList.remove('active');
                    t.setAttribute('aria-expanded', 'false');
                    t.nextElementSibling.classList.remove('active');
                });
                
                // Open clicked accordion if it was closed
                if (!isActive) {
                    this.classList.add('active');
                    this.setAttribute('aria-expanded', 'true');
                    content.classList.add('active');
                }
            });
        });
        
        // Sticky navbar on scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // User menu toggle
        const userMenuToggle = document.getElementById('userMenuToggle');
        const userMenuDropdown = document.getElementById('userMenuDropdown');
        
        if (userMenuToggle && userMenuDropdown) {
            userMenuToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const isActive = userMenuDropdown.classList.contains('active');
                userMenuDropdown.classList.toggle('active');
                userMenuToggle.setAttribute('aria-expanded', !isActive);
            });
            
            document.addEventListener('click', (e) => {
                if (!userMenuToggle.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                    userMenuDropdown.classList.remove('active');
                    userMenuToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
        
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', () => {
                const isActive = mobileMenu.classList.contains('active');
                mobileMenu.classList.toggle('active');
                document.body.style.overflow = !isActive ? 'hidden' : '';
                mobileMenuToggle.setAttribute('aria-expanded', !isActive);
            });
            
            // Close mobile menu on link click
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = '';
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                });
            });
        }
        
        // Close mobile menu on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024 && mobileMenu) {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
                if (mobileMenuToggle) {
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });
    });
</script>