<nav class="navbar" id="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <a href="{{ locale_route('home') }}" class="navbar-logo">
            <svg class="navbar-logo-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span class="navbar-logo-text">Petals & Bloom</span>
        </a>

        <!-- Main Navigation -->
        <ul class="navbar-nav">
            <li class="navbar-nav-item">
                <a href="{{ locale_route('home') }}" class="navbar-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Trang chủ
                </a>
            </li>
            <li class="navbar-nav-item">
                <a href="{{ locale_route('products.index') }}" class="navbar-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    Hoa tươi
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                <div class="navbar-dropdown">
                    <a href="{{ locale_route('products.index') }}?type=fresh" class="navbar-dropdown-item">Hoa tươi trong ngày</a>
                    <a href="{{ locale_route('products.index') }}?type=seasonal" class="navbar-dropdown-item">Hoa theo mùa</a>
                    <a href="{{ locale_route('products.index') }}?type=exotic" class="navbar-dropdown-item">Hoa nhiệt đới</a>
                </div>
            </li>
            <li class="navbar-nav-item">
                <a href="{{ locale_route('categories.index') }}" class="navbar-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    Hoa nhập khẩu
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                <div class="navbar-dropdown">
                    <a href="{{ locale_route('categories.index') }}?region=holland" class="navbar-dropdown-item">Hoa Hà Lan</a>
                    <a href="{{ locale_route('categories.index') }}?region=ecuador" class="navbar-dropdown-item">Hoa Ecuador</a>
                    <a href="{{ locale_route('categories.index') }}?region=japan" class="navbar-dropdown-item">Hoa Nhật Bản</a>
                </div>
            </li>
            <li class="navbar-nav-item">
                <a href="{{ locale_route('products.index') }}?category=bouquet" class="navbar-nav-link">
                    Bó hoa
                </a>
            </li>
            <li class="navbar-nav-item">
                <a href="{{ locale_route('products.index') }}?category=box" class="navbar-nav-link">
                    Hộp hoa
                </a>
            </li>
            <li class="navbar-nav-item">
                <a href="{{ locale_route('products.index') }}?category=wedding" class="navbar-nav-link">
                    Hoa cưới
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                <div class="navbar-dropdown">
                    <a href="{{ locale_route('products.index') }}?category=bridal" class="navbar-dropdown-item">Hoa cô dâu</a>
                    <a href="{{ locale_route('products.index') }}?category=decoration" class="navbar-dropdown-item">Trang trí tiệc cưới</a>
                    <a href="{{ locale_route('products.index') }}?category=bridesmaid" class="navbar-dropdown-item">Hoa phù dâu</a>
                </div>
            </li>
            <li class="navbar-nav-item">
                <a href="{{ locale_route('blog.index') }}" class="navbar-nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                    Góc làm đẹp
                </a>
            </li>
            <li class="navbar-nav-item">
                <a href="{{ locale_route('contact') }}" class="navbar-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                    Liên hệ
                </a>
            </li>
        </ul>

        <!-- Right Actions -->
        <div class="navbar-actions">
            <!-- Search -->
            <button class="navbar-action-btn" title="Tìm kiếm" aria-label="Tìm kiếm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            <!-- Wishlist -->

            <!-- Cart -->
            <a href="{{ locale_route('cart.index') }}" class="navbar-action-btn" title="Giỏ hàng" aria-label="Giỏ hàng">
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
                    <button class="navbar-user-toggle" id="userMenuToggle" aria-label="Menu người dùng">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ Str::limit(auth()->user()->name, 10) }}</span>
                    </button>
                    <div class="navbar-dropdown" id="userMenuDropdown">
                        <a href="{{ locale_route('profile.show') }}" class="navbar-dropdown-item">
                            Tài khoản của tôi
                        </a>
                        <a href="{{ locale_route('checkout.success') }}" class="navbar-dropdown-item">
                            Đơn hàng
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
            <button class="navbar-mobile-toggle" id="mobileMenuToggle" aria-label="Menu">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="navbar-mobile-menu" id="mobileMenu">
        <ul class="navbar-mobile-nav">
            <li><a href="{{ locale_route('products.index') }}">Hoa tươi</a></li>
            <li><a href="{{ locale_route('categories.index') }}">Hoa nhập khẩu</a></li>
            <li><a href="{{ locale_route('products.index') }}?category=bouquet">Bó hoa</a></li>
            <li><a href="{{ locale_route('products.index') }}?category=box">Hộp hoa</a></li>
            <li><a href="{{ locale_route('products.index') }}?category=wedding">Hoa cưới</a></li>
            <li><a href="{{ locale_route('blog.index') }}">Góc làm đẹp</a></li>
            <li><a href="{{ locale_route('contact') }}">Liên hệ</a></li>
            @auth
                <div style="height: 1px; background-color: var(--color-border); margin: var(--space-4) 0;"></div>
                <li><a href="{{ locale_route('profile.show') }}">Tài khoản của tôi</a></li>
                <li><a href="{{ locale_route('checkout.success') }}">Đơn hàng</a></li>
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
    // Sticky navbar shadow on scroll
    const navbar = document.getElementById('navbar');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 10) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });

    // User menu dropdown toggle
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userMenuDropdown = document.getElementById('userMenuDropdown');
    
    if (userMenuToggle && userMenuDropdown) {
        userMenuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenuDropdown.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!userMenuToggle.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                userMenuDropdown.classList.remove('active');
            }
        });
    }

    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });

        // Close mobile menu on link click
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }

    // Close mobile menu on window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024 && mobileMenu) {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
</script>
