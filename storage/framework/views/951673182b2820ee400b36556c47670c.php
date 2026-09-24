<?php $__env->startSection('title', $product->display_name); ?>

<?php $__env->startSection('content'); ?>

<!-- Product Detail Section -->
<div class="product-detail">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo e(route('home')); ?>"><?php echo e(content('breadcrumb_home', 'Trang chủ')); ?></a>
            <span class="separator">/</span>
            <a href="<?php echo e(route('products.index')); ?>"><?php echo e(content('breadcrumb_products', 'Sản phẩm')); ?></a>
            <?php if($product->category): ?>
                <span class="separator">/</span>
                <a href="<?php echo e(route('products.index')); ?>?categories[]=<?php echo e($product->category->id); ?>"><?php echo e($product->category->name); ?></a>
            <?php endif; ?>
            <?php if($product->subcategory): ?>
                <span class="separator">/</span>
                <span><?php echo e($product->subcategory->name); ?></span>
            <?php endif; ?>
            <span class="separator">/</span>
            <span class="current"><?php echo e($product->display_name); ?></span>
        </nav>

        <div class="product-detail-grid">

            
            <div class="product-gallery">
                <?php
                    $galleryImages = $product->productImages()->images()->get();
                    $galleryVideos = $product->productImages()->videos()->get();
                    if ($galleryImages->isEmpty() && $galleryVideos->isEmpty()) {
                        $galleryImages = collect([
                            (object) ['image_path' => null, 'id' => 0, 'media_type' => 'image'],
                        ]);
                    }
                    $mainImage = $galleryImages->first();
                ?>

                
                <div class="gallery-item--main">
                    <img src="<?php echo e($mainImage && $mainImage->image_path ? asset('storage/' . $mainImage->image_path) : $product->getPrimaryImageUrl()); ?>"
                         alt="<?php echo e($product->display_name); ?>"
                         loading="eager"
                         id="mainImage"
                         style="display: block;">
                    
                    <video id="mainVideo" controls style="display: none; width: 100%; height: 100%; object-fit: contain; border-radius: 8px; background: #000;">
                        <source src="" type="video/mp4" id="mainVideoSource">
                        Your browser does not support video.
                    </video>

                    
                    <?php if($product->discount_percent): ?>
                        <span class="discount-badge">-<?php echo e($product->discount_percent); ?>%</span>
                    <?php endif; ?>
                </div>

                
                <?php if($galleryImages->count() > 1 || $galleryVideos->count() > 0): ?>
                    <div class="gallery-thumbnails">
                        <?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="gallery-item--thumb <?php echo e($index === 0 ? 'active' : ''); ?>" 
                                 data-type="image"
                                 onclick="changeMainMedia('<?php echo e($image->image_path ? asset('storage/' . $image->image_path) : $product->getPrimaryImageUrl()); ?>', 'image', null, this)">
                                <img src="<?php echo e($image->image_path ? asset('storage/' . $image->image_path) : $product->getPrimaryImageUrl()); ?>"
                                     alt="<?php echo e($product->display_name); ?>"
                                     loading="lazy">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php $__currentLoopData = $galleryVideos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="gallery-item--thumb" 
                                 data-type="video"
                                 onclick="changeMainMedia('<?php echo e(asset('storage/' . $video->image_path)); ?>', 'video', '<?php echo e($video->mime_type); ?>', this)">
                                <div style="position: relative; width: 100%; height: 100%;">
                                    <video style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                                        <source src="<?php echo e(asset('storage/' . $video->image_path)); ?>" type="<?php echo e($video->mime_type); ?>">
                                    </video>
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 32px; height: 32px; background: rgba(0,0,0,0.6); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="product-info">

                
                <?php if($product->discount_percent): ?>
                    <div class="info-badge">-<?php echo e($product->discount_percent); ?>%</div>
                <?php elseif($product->is_featured): ?>
                    <div class="info-badge"><?php echo e(content('product_featured_badge', 'Nổi bật')); ?></div>
                <?php endif; ?>

                
                <h1 class="product-title"><?php echo e($product->display_name); ?></h1>

                
                <div class="product-rating">
                    <div class="rating-stars" aria-hidden="true">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <span class="rating-value">(0.0)</span>
                    <span class="rating-count">(0) <?php echo e(content('product_reviews_suffix', 'đánh giá')); ?></span>
                </div>

                
                <div class="price-section">
                    <div class="price-row">
                        <span class="price-sale"><?php echo e(number_format($product->sale_price ?? $product->price, 0, ',', '.')); ?> đ</span>
                        <?php if($product->original_price && $product->original_price > ($product->sale_price ?? $product->price)): ?>
                            <span class="price-original"><?php echo e(number_format($product->original_price, 0, ',', '.')); ?> đ</span>
                        <?php endif; ?>
                    </div>
                    <?php if($product->original_price && $product->original_price > ($product->sale_price ?? $product->price)): ?>
                        <div class="price-saved">
                            Tiết kiệm <?php echo e(number_format($product->original_price - ($product->sale_price ?? $product->price), 0, ',', '.')); ?> đ
                        </div>
                    <?php endif; ?>
                </div>

                
                <?php if($product->variants && $product->variants->count() > 0): ?>
                    <div class="product-options">
                        <label class="options-label">Chọn phiên bản</label>
                        <div class="options-buttons" id="variantSelector">
                            <?php $__currentLoopData = $product->variants->where('is_active', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Get all images with fallback to product images
                                    $variantImages = $variant->getAllImages();
                                    $variantImageUrls = $variantImages->map(function($img) {
                                        $path = $img->image_path;
                                        // Handle both ProductImage and ProductVariantImage
                                        if (str_starts_with($path, 'images/')) {
                                            $path = preg_replace('#^/?images/#', '', $path);
                                        }
                                        return asset('storage/' . $path);
                                    })->values();
                                ?>
                                <button type="button" 
                                        class="option-btn variant-option <?php echo e($index === 0 ? 'active' : ''); ?>" 
                                        data-variant-id="<?php echo e($variant->id); ?>"
                                        data-variant-sku="<?php echo e($variant->sku); ?>"
                                        data-variant-name="<?php echo e($variant->name ?? $variant->sku); ?>"
                                        data-variant-price="<?php echo e($variant->price ?? $product->price); ?>"
                                        data-variant-stock="<?php echo e($variant->stock ?? $product->stock); ?>"
                                        data-variant-images="<?php echo e(json_encode($variantImageUrls)); ?>"
                                        onclick="selectVariant(this)">
                                    <?php echo e($variant->name ?? $variant->sku); ?>

                                    <?php if($variant->color): ?>
                                        <span style="font-size: 0.85em; color: var(--color-text-muted);"><?php echo e($variant->color); ?></span>
                                    <?php endif; ?>
                                    <?php if($variant->size): ?>
                                        <span style="font-size: 0.85em; color: var(--color-text-muted);"><?php echo e($variant->size); ?></span>
                                    <?php endif; ?>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php elseif($product->volume || $product->size): ?>
                    <div class="product-options">
                        <label class="options-label">Dung tích</label>
                        <div class="options-buttons">
                            <button type="button" class="option-btn active"><?php echo e($product->volume ?? $product->size); ?></button>
                        </div>
                    </div>
                <?php endif; ?>

                
                <?php if($product->short_description): ?>
                    <div class="product-description">
                        <p><?php echo e($product->short_description); ?></p>
                    </div>
                <?php endif; ?>

                
                <div class="product-stock"><?php echo e($product->stock); ?> <?php echo e(content('product_stock_suffix', 'sản phẩm có sẵn')); ?></div>

                
                <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="cart-form" id="cartForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>" id="productIdInput">
                    <input type="hidden" name="variant_id" value="" id="variantIdInput">
                    <div class="cart-actions">
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" onclick="decreaseQty()" aria-label="<?php echo e(content('product_qty_decrease', 'Giảm')); ?>">−</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?php echo e($product->stock); ?>" readonly>
                            <button type="button" class="qty-btn" onclick="increaseQty(<?php echo e($product->stock); ?>)" aria-label="<?php echo e(content('product_qty_increase', 'Tăng')); ?>">+</button>
                        </div>
                        <button type="submit" class="btn-add-cart" id="addToCartBtn" <?php echo e($product->stock <= 0 ? 'disabled' : ''); ?>>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <?php echo e(content('product_add_to_cart', 'Thêm vào giỏ')); ?>

                        </button>
                    </div>
                </form>

                
                <button type="button" class="btn-buy-now" onclick="quickOrder(<?php echo e($product->id); ?>)" <?php echo e($product->stock <= 0 ? 'disabled' : ''); ?>>
                    <?php echo e(content('product_buy_now', 'Đặt hàng nhanh')); ?>

                </button>

                
                <div class="product-accordion">
                    <?php if($product->description): ?>
                        <div class="accordion-item">
                            <button type="button" class="accordion-header">
                                <span>Mô tả sản phẩm</span>
                                <span class="accordion-icon" aria-hidden="true">+</span>
                            </button>
                            <div class="accordion-content">
                                <?php if (isset($component)) { $__componentOriginal5d01bba82580f3fe260d7edec2ceb896 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5d01bba82580f3fe260d7edec2ceb896 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.markdown-renderer','data' => ['content' => $product->description]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('markdown-renderer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->description)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5d01bba82580f3fe260d7edec2ceb896)): ?>
<?php $attributes = $__attributesOriginal5d01bba82580f3fe260d7edec2ceb896; ?>
<?php unset($__attributesOriginal5d01bba82580f3fe260d7edec2ceb896); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5d01bba82580f3fe260d7edec2ceb896)): ?>
<?php $component = $__componentOriginal5d01bba82580f3fe260d7edec2ceb896; ?>
<?php unset($__componentOriginal5d01bba82580f3fe260d7edec2ceb896); ?>
<?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="accordion-item">
                        <button type="button" class="accordion-header">
                            <span>Chính sách đổi trả</span>
                            <span class="accordion-icon" aria-hidden="true">+</span>
                        </button>
                        <div class="accordion-content">
                            <?php if($product->return_policy): ?>
                                <?php if (isset($component)) { $__componentOriginal5d01bba82580f3fe260d7edec2ceb896 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5d01bba82580f3fe260d7edec2ceb896 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.markdown-renderer','data' => ['content' => $product->return_policy]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('markdown-renderer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->return_policy)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5d01bba82580f3fe260d7edec2ceb896)): ?>
<?php $attributes = $__attributesOriginal5d01bba82580f3fe260d7edec2ceb896; ?>
<?php unset($__attributesOriginal5d01bba82580f3fe260d7edec2ceb896); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5d01bba82580f3fe260d7edec2ceb896)): ?>
<?php $component = $__componentOriginal5d01bba82580f3fe260d7edec2ceb896; ?>
<?php unset($__componentOriginal5d01bba82580f3fe260d7edec2ceb896); ?>
<?php endif; ?>
                            <?php else: ?>
                                <p>Chúng tôi cam kết chất lượng sản phẩm 100%. Nếu sản phẩm có vấn đề về chất lượng hoặc không đúng mô tả, quý khách vui lòng liên hệ trong vòng 7 ngày để được đổi/trả hoặc hoàn tiền.</p>
                                <p><strong>Điều kiện đổi trả:</strong></p>
                                <ul>
                                    <li>Sản phẩm còn nguyên seal, chưa qua sử dụng</li>
                                    <li>Còn hóa đơn mua hàng</li>
                                    <li>Lỗi từ nhà sản xuất</li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


<section class="recommended" style="margin-bottom: 4rem;">
    <div class="container">
        <h2 class="section-header"><?php echo e(content('product_recommended_title', 'Có thể bạn cũng thích')); ?></h2>
        <div class="products-grid">
            <?php $__empty_1 = true; $__currentLoopData = $recommendedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recommendedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $recommendedProduct]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recommendedProduct)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="empty-text"><?php echo e(content('product_recommended_empty', 'Đang cập nhật sản phẩm...')); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="recently-viewed" style="margin-bottom: 4rem;">
    <div class="container">
        <h2 class="section-header"><?php echo e(content('product_recently_viewed_title', 'Sản phẩm đã xem gần đây')); ?></h2>
        <div class="products-grid">
            <?php $__empty_1 = true; $__currentLoopData = $recentlyViewed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $viewedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $viewedProduct]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($viewedProduct)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="empty-text"><?php echo e(content('product_recently_viewed_empty', 'Chưa có sản phẩm đã xem.')); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
    let currentStock = <?php echo e($product->stock); ?>;
    let currentVariantImages = [];
    let originalImages = [];
    
    // Store original product images on page load
    document.addEventListener('DOMContentLoaded', function() {
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.gallery-item--thumb');
        
        if (mainImage && mainImage.src) {
            originalImages.push(mainImage.src);
        }
        
        thumbnails.forEach(thumb => {
            const img = thumb.querySelector('img');
            if (img && img.src && thumb.dataset.type === 'image') {
                if (!originalImages.includes(img.src)) {
                    originalImages.push(img.src);
                }
            }
        });
        
        // Set first variant as selected if exists
        const firstVariant = document.querySelector('.variant-option');
        if (firstVariant) {
            selectVariant(firstVariant);
        }
    });
    
    // Select variant and update UI
    function selectVariant(button) {
        // Update active state
        document.querySelectorAll('.variant-option').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        
        // Get variant data
        const variantId = button.dataset.variantId;
        const variantPrice = parseFloat(button.dataset.variantPrice);
        const variantStock = parseInt(button.dataset.variantStock);
        const variantImages = JSON.parse(button.dataset.variantImages || '[]');
        
        // Update hidden form inputs
        document.getElementById('variantIdInput').value = variantId;
        
        // Update price display
        const priceElement = document.querySelector('.price-sale');
        if (priceElement) {
            priceElement.textContent = new Intl.NumberFormat('vi-VN').format(variantPrice) + ' đ';
        }
        
        // Update stock display and controls
        currentStock = variantStock;
        const stockElement = document.querySelector('.product-stock');
        if (stockElement) {
            stockElement.textContent = variantStock + ' <?php echo e(content("product_stock_suffix", "sản phẩm có sẵn")); ?>';
        }
        
        // Update quantity max
        const qtyInput = document.getElementById('quantity');
        if (qtyInput) {
            qtyInput.max = variantStock;
            if (parseInt(qtyInput.value) > variantStock) {
                qtyInput.value = Math.max(1, variantStock);
            }
        }
        
        // Update add to cart button state
        const addToCartBtn = document.getElementById('addToCartBtn');
        const buyNowBtn = document.querySelector('.btn-buy-now');
        if (addToCartBtn) {
            if (variantStock <= 0) {
                addToCartBtn.disabled = true;
                if (buyNowBtn) buyNowBtn.disabled = true;
            } else {
                addToCartBtn.disabled = false;
                if (buyNowBtn) buyNowBtn.disabled = false;
            }
        }
        
        // Update gallery images - always use variant images (fallback already included in data)
        if (variantImages.length > 0) {
            currentVariantImages = variantImages;
            updateGallery(variantImages);
        }
    }
    
    // Update gallery with variant images
    function updateGallery(images) {
        const mainImage = document.getElementById('mainImage');
        const mainVideo = document.getElementById('mainVideo');
        const thumbnailsContainer = document.querySelector('.gallery-thumbnails');
        
        // Hide video, show image
        if (mainVideo) {
            mainVideo.style.display = 'none';
        }
        if (mainImage) {
            mainImage.style.display = 'block';
            // Set first image as main
            if (images.length > 0) {
                mainImage.src = images[0];
            }
        }
        
        // Update thumbnails
        if (thumbnailsContainer) {
            if (images.length > 1) {
                thumbnailsContainer.innerHTML = images.map((img, index) => `
                    <div class="gallery-item--thumb ${index === 0 ? 'active' : ''}" 
                         data-type="image"
                         onclick="changeMainMedia('${img}', 'image', null, this)">
                        <img src="${img}" alt="Product image" loading="lazy">
                    </div>
                `).join('');
                thumbnailsContainer.style.display = 'grid';
            } else {
                // Hide thumbnails if only one image
                thumbnailsContainer.style.display = 'none';
            }
        }
    }

    // Change main media (image or video) on thumbnail click
    function changeMainMedia(src, type, mimeType, thumbElement) {
        const mainImage = document.getElementById('mainImage');
        const mainVideo = document.getElementById('mainVideo');
        const mainVideoSource = document.getElementById('mainVideoSource');
        
        if (type === 'video') {
            // Show video, hide image
            mainImage.style.display = 'none';
            mainVideo.style.display = 'block';
            mainVideoSource.src = src;
            mainVideoSource.type = mimeType;
            mainVideo.load();
        } else {
            // Show image, hide video
            mainVideo.style.display = 'none';
            mainImage.style.display = 'block';
            mainImage.src = src;
        }
        
        // Update active state
        document.querySelectorAll('.gallery-item--thumb').forEach(thumb => {
            thumb.classList.remove('active');
        });
        thumbElement.classList.add('active');
    }

    // Quantity controls
    function increaseQty(max) {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value) || 1;
        const actualMax = currentStock || max;
        if (current < actualMax) {
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
                const isActive = item.classList.contains('active');

                // Close all
                document.querySelectorAll('.accordion-item').forEach(i => {
                    i.classList.remove('active');
                });

                // Open clicked if it was closed
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
        
        // Auto-select first variant if exists
        const firstVariant = document.querySelector('.variant-option.active');
        if (firstVariant) {
            selectVariant(firstVariant);
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/products/detail.blade.php ENDPATH**/ ?>