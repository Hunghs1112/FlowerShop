<?php $__env->startSection('title', $product->display_name); ?>

<?php $__env->startSection('content'); ?>
    
<!-- Breadcrumb -->
<div class="container">
    <nav class="breadcrumb">
        <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
        <span>/</span>
        <a href="<?php echo e(route('products.index')); ?>">Sản phẩm</a>
        <?php if($product->category): ?>
            <span>/</span>
            <a href="<?php echo e(route('products.index')); ?>?categories[]=<?php echo e($product->category->id); ?>"><?php echo e($product->category->name); ?></a>
        <?php endif; ?>
        <span>/</span>
        <span><?php echo e($product->display_name); ?></span>
    </nav>
</div>

<!-- Product Detail Section -->
<div class="container">
    <div class="product-detail">
        <!-- Left: Product Gallery -->
        <div class="product-gallery">

            
            <div class="gallery-thumb-strip" id="thumbStrip">
                <?php $__empty_1 = true; $__currentLoopData = $product->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <button type="button"
                            class="gallery-thumb <?php echo e($index === 0 ? 'active' : ''); ?>"
                            data-index="<?php echo e($index); ?>"
                            aria-label="Ảnh <?php echo e($index + 1); ?>">
                        <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>"
                             alt="<?php echo e($product->display_name); ?> ảnh <?php echo e($index + 1); ?>"
                             loading="lazy">
                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <button type="button" class="gallery-thumb active" data-index="0" aria-label="Ảnh 1">
                        <img src="<?php echo e($product->getPrimaryImageUrl()); ?>" alt="<?php echo e($product->name); ?>" loading="lazy">
                    </button>
                <?php endif; ?>
            </div>

            
            <div class="gallery-main" id="galleryMain">
                <?php $__empty_1 = true; $__currentLoopData = $product->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="gallery-slide <?php echo e($index === 0 ? 'active' : ''); ?>" data-index="<?php echo e($index); ?>">
                        <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>"
                             alt="<?php echo e($product->display_name); ?>"
                             loading="<?php echo e($index === 0 ? 'eager' : 'lazy'); ?>">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="gallery-slide active" data-index="0">
                        <img src="<?php echo e($product->getPrimaryImageUrl()); ?>" alt="<?php echo e($product->display_name); ?>" loading="eager">
                    </div>
                <?php endif; ?>

                
                <?php if($product->is_featured): ?>
                    <div class="gallery-badge">Nổi bật</div>
                <?php endif; ?>

                
                <button type="button" class="gallery-arrow-btn gallery-prev" id="galleryPrev" aria-label="Ảnh trước">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button type="button" class="gallery-arrow-btn gallery-next" id="galleryNext" aria-label="Ảnh tiếp">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                
                <div class="gallery-dots" id="galleryDots">
                    <?php $__empty_1 = true; $__currentLoopData = $product->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <button type="button"
                                class="gallery-dot <?php echo e($index === 0 ? 'active' : ''); ?>"
                                data-index="<?php echo e($index); ?>"
                                aria-label="Ảnh <?php echo e($index + 1); ?>"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <button type="button" class="gallery-dot active" data-index="0"></button>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Right: Product Information -->
        <div class="product-info">
            <!-- Discount Badge (if featured) -->
            <?php if($product->is_featured): ?>
                <div class="discount-badge">Nổi bật</div>
            <?php endif; ?>

            <!-- Product Title -->
            <h1 class="product-title"><?php echo e($product->display_name); ?></h1>

            <!-- Rating -->
            <div class="rating">
                <div class="rating-stars">
                    <span class="star">☆</span>
                    <span class="star">☆</span>
                    <span class="star">☆</span>
                    <span class="star">☆</span>
                    <span class="star">☆</span>
                    <span class="rating-value">(0.0)</span>
                </div>
                <span class="rating-count">(0) đánh giá</span>
            </div>

            <!-- Price -->
            <div class="price-section">
                <div class="price-main">
                    <span class="price-sale"><?php echo e(number_format($product->price, 0, ',', '.')); ?> đ</span>
                </div>
            </div>

            <?php if($product->category): ?>
                <div class="options">
                    <label class="options-label">Danh mục</label>
                    <div class="options-buttons">
                        <button class="option-btn active"><?php echo e($product->category->name); ?></button>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Stock -->
            <div class="stock"><?php echo e($product->stock); ?> sản phẩm có sẵn</div>

            <!-- Quantity + Add to Cart -->
            <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <div class="cart-actions">
                    <div class="quantity">
                        <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?php echo e($product->stock); ?>" readonly>
                        <button type="button" class="qty-btn" onclick="increaseQty(<?php echo e($product->stock); ?>)">+</button>
                    </div>
                    <button type="submit" class="btn-add-cart" <?php echo e($product->stock <= 0 ? 'disabled' : ''); ?>>
                        Thêm vào giỏ
                    </button>
                </div>
            </form>

            <!-- Buy Now -->
            <button class="btn-buy-now" onclick="quickOrder(<?php echo e($product->id); ?>)" <?php echo e($product->stock <= 0 ? 'disabled' : ''); ?>>
                Đặt hàng nhanh
            </button>

            <!-- Product Benefits -->
            <div class="benefits">
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="benefit-text">Hoa tươi 100%</div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="benefit-text">Giao hàng nhanh 2-4h</div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="benefit-text">Miễn phí thiệp & giao hàng</div>
                </div>
            </div>

            <!-- Collapsible Information -->
            <div class="accordion">
                <div class="accordion-item">
                    <button class="accordion-header">
                        <span>Ưu điểm nổi bật</span>
                        <div class="accordion-icon">+</div>
                    </button>
                    <div class="accordion-content">
                        <?php if($product->short_description): ?>
                            <p><?php echo e($product->display_short_description); ?></p>
                        <?php else: ?>
                            <p><?php echo e($product->name); ?> - Hoa tươi nhập khẩu cao cấp, được chăm sóc và bảo quản tốt nhất để giữ độ tươi lâu.</p>
                        <?php endif; ?>
                        <ul>
                            <li>Hoa tươi 100%, nhập khẩu trực tiếp</li>
                            <li>Được bó bởi florist chuyên nghiệp</li>
                            <li>Giao hàng nhanh trong 2-4 giờ</li>
                            <li>Miễn phí thiệp chúc mừng</li>
                            <li>Cam kết hoa giống hình 100%</li>
                        </ul>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">
                        <span>Ý nghĩa & Dịp tặng</span>
                        <div class="accordion-icon">+</div>
                    </button>
                    <div class="accordion-content">
                        <?php if($product->description): ?>
                            <p><?php echo nl2br(e($product->description)); ?></p>
                        <?php else: ?>
                            <p><?php echo e($product->name); ?> thích hợp tặng cho nhiều dịp đặc biệt:</p>
                            <ul>
                                <li><strong>Sinh nhật:</strong> Thể hiện lời chúc mừng và tình cảm</li>
                                <li><strong>Kỷ niệm:</strong> Ghi dấu những khoảnh khắc đáng nhớ</li>
                                <li><strong>Chúc mừng:</strong> Khai trương, thăng chức, tốt nghiệp</li>
                                <li><strong>Lãng mạn:</strong> Tỏ tình, cầu hôn, kỷ niệm tình yêu</li>
                                <li><strong>Chia buồn:</strong> Chia sẻ nỗi đau mất mát</li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">
                        <span>Hướng dẫn bảo quản</span>
                        <div class="accordion-icon">+</div>
                    </button>
                    <div class="accordion-content">
                        <ol>
                            <li>Cắt chéo 2-3cm cuống hoa khi nhận</li>
                            <li>Thay nước sạch mỗi 2 ngày một lần</li>
                            <li>Đặt bình hoa ở nơi thoáng mát, tránh ánh nắng trực tiếp</li>
                            <li>Tỉa bỏ lá héo và hoa úa để giữ độ tươi</li>
                            <li>Có thể thêm thuốc giữ hoa tươi vào nước</li>
                            <li>Tránh đặt gần trái cây chín (sinh khí ethylene làm héo hoa)</li>
                        </ol>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">
                        <span>Chính sách đổi trả</span>
                        <div class="accordion-icon">+</div>
                    </button>
                    <div class="accordion-content">
                        <p>Chúng tôi cam kết chất lượng hoa tươi 100%. Nếu hoa không đúng mô tả hoặc có vấn đề về chất lượng, quý khách vui lòng liên hệ ngay trong vòng 2 giờ kể từ khi nhận hàng để được hỗ trợ đổi/trả hoặc hoàn tiền.</p>
                        <p><strong>Điều kiện đổi trả:</strong></p>
                        <ul>
                            <li>Hoa không đúng như hình ảnh mô tả</li>
                            <li>Hoa bị héo, úa hoặc hư hỏng khi giao</li>
                            <li>Thiếu số lượng hoặc sai loại hoa</li>
                        </ul>
                        <p><em>Lưu ý: Chúng tôi không nhận đổi/trả đối với hoa đã qua sử dụng hoặc bảo quản không đúng cách.</em></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommended Products Section -->
    <div class="recommended">
        <div class="recommended-header">
            <h2>Có thể bạn cũng thích</h2>
        </div>
        <div class="products-grid">
            <?php $__empty_1 = true; $__currentLoopData = $recommendedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recommendedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('products.show', $recommendedProduct->display_slug ?? $recommendedProduct->id)); ?>" class="product-card">
                    <div class="product-card-image">
                        <img src="<?php echo e($recommendedProduct->getPrimaryImageUrl()); ?>" alt="<?php echo e($recommendedProduct->name); ?>">
                    </div>
                    <div class="product-card-content">
                        <div class="product-card-category"><?php echo e($recommendedProduct->category->name ?? 'Hoa tươi'); ?></div>
                        <h3 class="product-card-title"><?php echo e($recommendedProduct->name); ?></h3>
                        <div class="product-card-price">
                            <span class="price-sale"><?php echo e(number_format($recommendedProduct->price, 0, ',', '.')); ?> đ</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <!-- Fallback if no recommended products -->
                <div class="product-card">
                    <div class="product-card-image">
                        <img src="<?php echo e(asset('images/detail/detail-3.jpg')); ?>" alt="Hoa hồng">
                    </div>
                    <div class="product-card-content">
                        <div class="product-card-category">Hoa tươi</div>
                        <h3 class="product-card-title">Đang cập nhật sản phẩm</h3>
                        <div class="product-card-price">
                            <span class="price-sale">0 đ</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recently Viewed Section -->
    <div class="recently-viewed">
        <div class="section-header">
            <h2>Sản phẩm khác</h2>
        </div>
        <div class="products-grid-small">
            <?php $__empty_1 = true; $__currentLoopData = $recentlyViewed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $viewedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('products.show', $viewedProduct->display_slug ?? $viewedProduct->id)); ?>" class="product-card">
                    <div class="product-card-image">
                        <img src="<?php echo e($viewedProduct->getPrimaryImageUrl()); ?>" alt="<?php echo e($viewedProduct->name); ?>">
                    </div>
                    <div class="product-card-content">
                        <div class="product-card-category"><?php echo e($viewedProduct->category->name ?? 'Hoa tươi'); ?></div>
                        <h3 class="product-card-title"><?php echo e($viewedProduct->name); ?></h3>
                        <div class="product-card-price">
                            <span class="price-sale"><?php echo e(number_format($viewedProduct->price, 0, ',', '.')); ?> đ</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <!-- Fallback if no products -->
                <div class="product-card">
                    <div class="product-card-image">
                        <img src="<?php echo e(asset('images/detail/detail-4.jpg')); ?>" alt="Hoa">
                    </div>
                    <div class="product-card-content">
                        <div class="product-card-category">Hoa tươi</div>
                        <h3 class="product-card-title">Đang cập nhật</h3>
                        <div class="product-card-price">
                            <span class="price-sale">0 đ</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Floating Back to Top Button -->
<button class="back-to-top" id="backToTop" aria-label="Về đầu trang">
    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
</button>

<?php $__env->startPush('scripts'); ?>
<script>
    // ── Gallery ──
    (function initGallery() {
        const slides    = document.querySelectorAll('.gallery-slide');
        const thumbs    = document.querySelectorAll('.gallery-thumb');
        const dots      = document.querySelectorAll('.gallery-dot');
        const prevBtn   = document.getElementById('galleryPrev');
        const nextBtn   = document.getElementById('galleryNext');

        if (slides.length === 0) return;

        // Ẩn arrow khi chỉ có 1 ảnh
        if (slides.length === 1) {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
        }

        let current = 0;

        function goTo(index) {
            if (index === current && slides.length > 1) return;

            slides[current].classList.remove('active');
            if (thumbs[current])  thumbs[current].classList.remove('active');
            if (dots[current])    dots[current].classList.remove('active');

            current = (index + slides.length) % slides.length;

            slides[current].classList.add('active');
            if (thumbs[current]) {
                thumbs[current].classList.add('active');
                thumbs[current].scrollIntoView({ block: 'nearest', inline: 'nearest', behavior: 'smooth' });
            }
            if (dots[current]) dots[current].classList.add('active');
        }

        thumbs.forEach(btn => btn.addEventListener('click', () => goTo(parseInt(btn.dataset.index))));
        dots.forEach(btn => btn.addEventListener('click', () => goTo(parseInt(btn.dataset.index))));
        if (prevBtn) prevBtn.addEventListener('click', () => goTo(current - 1));
        if (nextBtn) nextBtn.addEventListener('click', () => goTo(current + 1));

        // Keyboard
        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowLeft')  goTo(current - 1);
            if (e.key === 'ArrowRight') goTo(current + 1);
        });

        // Touch swipe
        const viewer = document.getElementById('galleryMain');
        if (viewer) {
            let startX = 0;
            viewer.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
            viewer.addEventListener('touchend', e => {
                const diff = startX - e.changedTouches[0].clientX;
                if (Math.abs(diff) > 40) goTo(diff > 0 ? current + 1 : current - 1);
            }, { passive: true });
        }
    })();

    // Quantity controls
    function increaseQty(max) {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value) || 1;
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value) || 1;
        if (current > 1) {
            input.value = current - 1;
        }
    }

    function quickOrder(productId) {
        <?php if(auth()->guard()->check()): ?>
            window.location.href = '<?php echo e(route("checkout.index")); ?>';
        <?php else: ?>
            alert('Vui lòng đăng nhập để đặt hàng nhanh');
            window.location.href = '<?php echo e(route("login")); ?>';
        <?php endif; ?>
    }

    // Accordion functionality
    document.addEventListener('DOMContentLoaded', function() {
        const accordionHeaders = document.querySelectorAll('.accordion-header');
        
        accordionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const item = this.parentElement;
                const content = item.querySelector('.accordion-content');
                const icon = this.querySelector('.accordion-icon');
                const isActive = item.classList.contains('active');
                
                // Close all accordion items
                document.querySelectorAll('.accordion-item').forEach(i => {
                    i.classList.remove('active');
                    i.querySelector('.accordion-icon').textContent = '+';
                });
                
                // Open clicked item if it was closed
                if (!isActive) {
                    item.classList.add('active');
                    icon.textContent = '−';
                }
            });
        });

        // Back to top button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Product card hover effect
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const img = this.querySelector('.product-card-image img');
                if (img) {
                    img.style.transform = 'scale(1.05)';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                const img = this.querySelector('.product-card-image img');
                if (img) {
                    img.style.transform = 'scale(1)';
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/products/detail.blade.php ENDPATH**/ ?>