<nav class="navbar" id="navbar">
    <div class="navbar-container">

        {{-- ─── Logo ─────────────────────────────────────────── --}}
        <a href="{{ route('home') }}" class="navbar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="{{ $siteSettings['site_name'] ?? config('app.name') }}" class="navbar-logo-img">
        </a>

        {{-- ─── Desktop Navigation ──────────────────────────── --}}
        <ul class="navbar-nav">

            {{-- Trang chủ --}}
            <li class="navbar-nav-item">
                <a href="{{ route('home') }}" class="navbar-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Trang chủ
                </a>
            </li>

            {{-- Sản phẩm — Mega Menu (danh mục từ DB) --}}
            <li class="navbar-nav-item" data-dropdown="mega">
                <a href="{{ route('products.index') }}" class="navbar-nav-link {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'active' : '' }}">
                    Sản phẩm
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>

                <div class="navbar-mega-menu">
                    @if($navCategories->isNotEmpty())
                        <div class="mega-menu-grid-simple">
                            @foreach($navCategories as $navCat)
                                <a href="{{ route('categories.show', $navCat->display_slug) }}" class="mega-menu-item">
                                    {{ $navCat->display_name }}
                                </a>
                            @endforeach
                            
                            {{-- Tất cả sản phẩm --}}
                            <a href="{{ route('products.index') }}" class="mega-menu-item mega-menu-item-all">
                                Xem tất cả sản phẩm
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="mega-menu-grid-simple">
                            <a href="{{ route('products.index') }}" class="mega-menu-item mega-menu-item-all">
                                Xem tất cả sản phẩm
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </li>

            {{-- Góc cảm hứng — link thẳng, không dropdown hardcode --}}
            <li class="navbar-nav-item">
                <a href="{{ route('blog.index') }}" class="navbar-nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                    Góc cảm hứng
                </a>
            </li>

            {{-- Thông tin — dropdown từ $navPages DB --}}
            @if($navPages->isNotEmpty())
            <li class="navbar-nav-item" data-dropdown="standard">
                <a href="#" class="navbar-nav-link">
                    Thông tin
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                <div class="navbar-dropdown">
                    @foreach($navPages as $navPage)
                        @if($navPage->slug !== 'lien-he')
                            <a href="{{ route('policy', $navPage->slug) }}" class="navbar-dropdown-item">{{ $navPage->title }}</a>
                        @endif
                    @endforeach
                    <a href="{{ route('guide') }}" class="navbar-dropdown-item">Hướng dẫn đặt hàng</a>
                </div>
            </li>
            @endif

            {{-- B2B --}}
            <li class="navbar-nav-item">
                <a href="{{ route('b2c') }}" class="navbar-nav-link {{ request()->routeIs('b2c') ? 'active' : '' }}">
                    B2B
                </a>
            </li>

        </ul>

        {{-- ─── Right Actions ──────────────────────────────── --}}
        <div class="navbar-actions">
            @php
                $cartCount = auth()->check()
                    ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
                    : \App\Models\CartItem::where('session_id', session()->getId())->sum('quantity');
            @endphp

            <button type="button" class="navbar-action-btn theme-toggle" data-theme-toggle aria-label="Chuyển giao diện">
                <svg class="theme-icon-light" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3V2m0 20v-1m9-9h1M2 12h1m15.36-6.36.71-.71M4.93 19.07l.71-.71m12.72 0 .71.71M4.93 4.93l.71.71M17 12a5 5 0 11-10 0 5 5 0 0110 0z"/>
                </svg>
                <svg class="theme-icon-dark" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>

            {{-- Search --}}
            <button class="navbar-action-btn navbar-search-btn" id="searchToggle" title="Tìm kiếm" aria-label="Tìm kiếm" aria-expanded="false">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}" class="navbar-action-btn navbar-cart-btn" title="Giỏ hàng" aria-label="Giỏ hàng">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>

                    {{-- User Menu --}}
                    @auth
                        <div class="navbar-user-menu">
                            <button class="navbar-user-toggle" id="userMenuToggle" aria-label="Tài khoản" aria-expanded="false">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>{{ Str::limit(auth()->user()->name, 10) }}</span>
                            </button>
                            <div class="navbar-dropdown" id="userMenuDropdown">
                                <a href="{{ route('profile.show') }}" class="navbar-dropdown-item">Tài khoản</a>
                                @if(auth()->user()->isAdmin())
                                    <div class="navbar-dropdown-divider"></div>
                                    <a href="{{ route('admin.dashboard') }}" class="navbar-dropdown-item">Quản trị</a>
                                @endif
                                <div class="navbar-dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" class="navbar-logout-form">
                                    @csrf
                                    <button type="submit" class="navbar-dropdown-item navbar-dropdown-btn">Đăng xuất</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="navbar-action-btn navbar-auth-btn" title="Đăng nhập" aria-label="Đăng nhập">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            @endauth

            {{-- Mobile Toggle (CSS-based hamburger for crisp icon + animation) --}}
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

{{-- ─── Search Overlay ─────────────────────────────────── --}}
<div class="search-overlay" id="searchOverlay">
    <div class="search-overlay-container">
        <form action="{{ route('products.index') }}" method="GET" class="search-form" id="searchForm">
            <div class="search-input-wrapper">
                <input
                    type="text"
                    name="q"
                    class="search-input"
                    placeholder="Tìm kiếm sản phẩm..."
                    value="{{ request('q') ?: request('search') }}"
                    autocomplete="off"
                    aria-label="Tìm kiếm sản phẩm"
                    id="searchInput"
                >
                <button type="button" class="search-clear-btn" id="searchClear" aria-label="Xóa tìm kiếm" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <button type="submit" class="search-submit-btn">
                Tìm kiếm
            </button>
        </form>
    </div>
</div>

{{-- ─── Mobile Menu (sibling of <nav>, NOT inside it, so position:fixed uses viewport) ─── --}}
<div class="navbar-mobile-menu" id="mobileMenu">

        {{-- Mobile Actions (cart, favorites, search-like quick links) --}}
        <ul class="mobile-menu-actions">
            <li>
                <a href="{{ route('cart.index') }}" class="mobile-menu-action-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span>Giỏ hàng</span>
                    @if($cartCount > 0)
                        <span class="mobile-menu-badge">{{ $cartCount }}</span>
                    @endif
                </a>
            </li>
        </ul>

        <ul class="navbar-mobile-nav">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>

            {{-- Sản phẩm accordion --}}
            <li class="navbar-mobile-accordion-item">
                <button class="navbar-mobile-accordion-toggle" aria-expanded="false">
                    Sản phẩm
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="navbar-mobile-accordion-content">
                    <div class="navbar-mobile-accordion-links">
                        @foreach($navCategories->take(8) as $navCat)
                            <a href="{{ route('categories.show', $navCat->display_slug) }}" class="navbar-mobile-accordion-link">{{ $navCat->display_name }}</a>
                        @endforeach
                        <a href="{{ route('products.index') }}" class="navbar-mobile-accordion-link">Tất cả sản phẩm</a>
                    </div>
                </div>
            </li>

            {{-- Góc cảm hứng --}}
            <li><a href="{{ route('blog.index') }}">Bài viết</a></li>

            {{-- Thông tin accordion từ DB pages --}}
            @if($navPages->isNotEmpty())
            <li class="navbar-mobile-accordion-item">
                <button class="navbar-mobile-accordion-toggle" aria-expanded="false">
                    Thông tin
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="navbar-mobile-accordion-content">
                    <div class="navbar-mobile-accordion-links">
                        @foreach($navPages as $navPage)
                            @if($navPage->slug !== 'lien-he')
                                <a href="{{ route('policy', $navPage->slug) }}" class="navbar-mobile-accordion-link">{{ $navPage->title }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </li>
            @endif

            {{-- B2B --}}
            <li><a href="{{ route('b2c') }}">B2B</a></li>

            @auth
                <div class="mobile-menu-divider"></div>
                <li><a href="{{ route('profile.show') }}">Tài khoản</a></li>
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}">Quản trị</a></li>
                @endif
                <div class="mobile-menu-divider"></div>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="navbar-logout-form">
                        @csrf
                        <button type="submit" class="mobile-menu-logout-btn">Đăng xuất</button>
                    </form>
                </li>
            @else
                <div class="mobile-menu-divider"></div>
                <li><a href="{{ route('login') }}">Đăng nhập</a></li>
            @endauth
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

    // ── Search Overlay ────────────────────────────────────
    const searchToggle = document.getElementById('searchToggle');
    const searchOverlay = document.getElementById('searchOverlay');
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');

    function openSearch() {
        searchOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        searchToggle.setAttribute('aria-expanded', 'true');
        searchInput?.focus();
    }

    function closeSearch() {
        searchOverlay.classList.remove('active');
        document.body.style.overflow = '';
        searchToggle.setAttribute('aria-expanded', 'false');
    }

    if (searchToggle && searchOverlay) {
        searchToggle.addEventListener('click', openSearch);
    }

    if (searchOverlay) {
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay) {
                closeSearch();
            }
        });
    }

    // Search input clear button
    if (searchInput && searchClear) {
        searchInput.addEventListener('input', function() {
            searchClear.style.display = this.value ? 'flex' : 'none';
        });

        searchClear.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
            searchClear.style.display = 'none';
        });
    }

    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchOverlay?.classList.contains('active')) {
            closeSearch();
        }
    });
});
</script>
