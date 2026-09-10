/**
 * Home Page JavaScript
 * Handles hero slider, product tabs, wishlist, and animations
 */

// Hero Text Slider with Autoplay
(function initHeroSlider() {
    const heroSection = document.getElementById('heroSection');
    if (!heroSection) return;

    const slides = heroSection.querySelectorAll('.hero-slide');
    const indicators = heroSection.querySelectorAll('.hero-indicator');
    const counterCurrent = heroSection.querySelector('.hero-counter-current');
    
    let currentSlide = 0;
    let autoplayInterval = null;
    let isPaused = false;
    const SLIDE_DURATION = 6000; // 6 seconds
    
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function goToSlide(index) {
        if (index === currentSlide) return;

        slides[currentSlide].classList.remove('active');
        indicators[currentSlide].classList.remove('active');

        currentSlide = index;

        slides[currentSlide].classList.add('active');
        indicators[currentSlide].classList.add('active');

        updateCounter();
    }

    function nextSlide() {
        goToSlide((currentSlide + 1) % slides.length);
    }

    function updateCounter() {
        if (counterCurrent) {
            counterCurrent.textContent = String(currentSlide + 1).padStart(2, '0');
        }
    }

    function startAutoplay() {
        if (autoplayInterval || prefersReducedMotion) return;
        
        autoplayInterval = setInterval(() => {
            if (!isPaused) nextSlide();
        }, SLIDE_DURATION);
    }

    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    }

    // Setup indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            goToSlide(index);
            stopAutoplay();
            startAutoplay();
        });
    });

    // Pause on hover
    heroSection.addEventListener('mouseenter', () => isPaused = true);
    heroSection.addEventListener('mouseleave', () => isPaused = false);

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            if (e.key === 'ArrowRight') nextSlide();
            else goToSlide((currentSlide - 1 + slides.length) % slides.length);
            stopAutoplay();
            startAutoplay();
        }
    });

    // Pause when tab hidden
    document.addEventListener('visibilitychange', () => {
        isPaused = document.hidden;
    });

    startAutoplay();
})();

// Products Section - Tab Switching
(function initProductTabs() {
    const tabs = document.querySelectorAll('.products-tab');
    const productsGrid = document.getElementById('productsGrid');

    if (tabs.length === 0 || !productsGrid) return;

    // Track current loading request
    let currentRequest = null;

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Don't reload if already active
            if (this.classList.contains('active')) return;

            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const category   = this.dataset.category;
            // Category ID is now embedded in the data attribute by the Blade template
            const categoryId = this.dataset.categoryId || null;
            loadProducts(category, categoryId);
        });
    });

    function loadProducts(category, categoryId) {
        // Cancel previous request if still pending
        if (currentRequest) {
            currentRequest.abort();
        }

        // Show loading state
        const loadingText = document.querySelector('[data-i18n="loading"]')?.dataset.i18nValue || 'Loading...';
        productsGrid.innerHTML = `<div class="products-loading">${loadingText}</div>`;

        // Build URL
        const url = new URL('/api/products', window.location.origin);

        if (category === 'category' && categoryId) {
            url.searchParams.append('type', 'category');
            url.searchParams.append('category_id', categoryId);
        } else {
            url.searchParams.append('type', category);
        }
        url.searchParams.append('limit', '8');

        // Create new request
        currentRequest = new AbortController();

        fetch(url.toString(), { signal: currentRequest.signal })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    renderProducts(data.data);
                } else {
                    throw new Error('Invalid response format');
                }
            })
            .catch(error => {
                if (error.name === 'AbortError') return;
                console.error('Error loading products:', error);
                productsGrid.innerHTML = '<p class="text-center">Có lỗi xảy ra khi tải sản phẩm. Vui lòng thử lại.</p>';
            })
            .finally(() => {
                currentRequest = null;
            });
    }
    
    function renderProducts(products) {
        if (products.length === 0) {
            productsGrid.innerHTML = '<p class="text-center">Không có sản phẩm nào</p>';
            return;
        }
        
        productsGrid.innerHTML = products.map(product => `
            <a href="${product.url}" class="product-card">
                <div class="product-card-image-wrapper">
                    <img src="${product.image}" alt="${product.name}" class="product-card-image" loading="lazy">

                    <button class="product-card-wishlist ${product.is_favorited ? 'active' : ''}"
                            aria-label="Thêm vào yêu thích"
                            data-product-id="${product.id}">
                        <svg fill="${product.is_favorited ? '#C85A54' : 'none'}" stroke="${product.is_favorited ? '#C85A54' : 'currentColor'}" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>

                    <div class="product-card-overlay">
                        <span class="product-card-view-button">Xem chi tiết</span>
                    </div>
                </div>

                <span class="product-card-category">${product.category || 'Hoa tươi'}</span>
                <h3 class="product-card-name">${product.name}</h3>
                <div class="product-card-price-wrapper">
                    <span class="product-card-price">${product.formatted_price}</span>
                </div>
            </a>
        `).join('');
        
        // Re-initialize wishlist handlers for new products
        initWishlistForNewProducts();
    }
    
    function initWishlistForNewProducts() {
        const wishlistButtons = productsGrid.querySelectorAll('.product-card-wishlist');
        
        wishlistButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const productId = this.dataset.productId;
                if (productId && typeof toggleFavorite === 'function') {
                    toggleFavorite(parseInt(productId));
                }
            });
        });
    }
    
    // Load best-selling products on page load
    loadProducts('best-selling', null);
})();

// Wishlist Toggle
(function initWishlist() {
    const wishlistButtons = document.querySelectorAll('.product-wishlist-desktop, .product-wishlist-mobile');
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            this.classList.toggle('active');
            
            const isActive = this.classList.contains('active');
            console.log('Wishlist toggled:', isActive);
            
            // TODO: Implement backend save
        });
    });
})();

// Brand Values - Scroll Animation
(function initBrandValuesAnimation() {
    const brandValueItems = document.querySelectorAll('.brand-value-item');
    
    if (brandValueItems.length === 0) return;
    
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    
    if (prefersReducedMotion) {
        brandValueItems.forEach(item => item.classList.add('visible'));
        return;
    }
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.2,
        rootMargin: '0px 0px -50px 0px'
    });
    
    brandValueItems.forEach(item => observer.observe(item));
})();
