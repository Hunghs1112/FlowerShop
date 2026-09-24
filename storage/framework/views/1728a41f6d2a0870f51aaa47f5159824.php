
<section class="mystery-box-section">
    <div class="container">
        <div class="mystery-box-wrapper">
            
            <div class="mystery-box-content">
                <span class="mystery-box-eyebrow">✨ LNT Flower</span>
                <h2 class="mystery-box-title">Hộp Hoa Bí Ẩn</h2>
                <p class="mystery-box-description">
                    Để chúng tôi làm bất ngờ bạn. Chỉ cần chia sẻ sở thích của mình,
                    và LNT sẽ tuyển chọn những bông hoa tươi đẹp nhất dành riêng cho bạn.
                    Mỗi hộp là một bất ngờ độc đáo, được thiết kế theo mùa và phong cách riêng.
                </p>

                <div class="mystery-box-features">
                    <div class="mystery-feature">
                        <div class="mystery-feature-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <div class="mystery-feature-text">
                            <h4>Thiết kế độc đáo</h4>
                            <p>Mỗi hộp được thiết kế theo mùa và xu hướng hiện tại</p>
                        </div>
                    </div>

                    <div class="mystery-feature">
                        <div class="mystery-feature-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>
                            </svg>
                        </div>
                        <div class="mystery-feature-text">
                            <h4>Bất ngờ mỗi lần</h4>
                            <p>Hoa được tuyển chọn ngẫu nhiên, không giống ai</p>
                        </div>
                    </div>

                    <div class="mystery-feature">
                        <div class="mystery-feature-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div class="mystery-feature-text">
                            <h4>Tặng kèm thiệp</h4>
                            <p>Gửi gắm lời yêu thương đến người thân yêu</p>
                        </div>
                    </div>
                </div>

                <a href="<?php echo e(route('mystery-box.index')); ?>" class="mystery-box-cta">
                    <span>Khám phá ngay</span>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>

            
            <div class="mystery-box-visual">
                <div class="mystery-box-image-container">
                    <?php if(($siteBanners['mystery-box'] ?? null)): ?>
                        <img src="<?php echo e(asset('storage/' . $siteBanners['mystery-box'])); ?>"
                             alt="Hộp Hoa Bí Ẩn"
                             class="mystery-box-image">
                    <?php else: ?>
                        <div class="mystery-box-illustration">
                            <svg viewBox="0 0 300 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                                
                                <ellipse cx="150" cy="380" rx="100" ry="15" fill="rgba(63,90,69,0.1)"/>

                                
                                <rect x="50" y="200" width="200" height="180" rx="8" fill="#F7F4ED" stroke="#DDDCD3" stroke-width="2"/>

                                
                                <rect x="45" y="160" width="210" height="50" rx="6" fill="#E8EEE3" stroke="#A3B8A1" stroke-width="2"/>

                                
                                <rect x="140" y="160" width="20" height="180" fill="#D4969A"/>
                                <rect x="50" y="230" width="200" height="20" fill="#D4969A"/>

                                
                                <ellipse cx="150" cy="155" rx="35" ry="20" fill="#D4969A"/>
                                <circle cx="150" cy="155" r="12" fill="#A85C55"/>

                                
                                <g class="flower-anim-1">
                                    <circle cx="80" cy="140" r="8" fill="#E8B4B8" opacity="0.8"/>
                                    <circle cx="80" cy="140" r="4" fill="#D4969A"/>
                                    <path d="M80 140 L75 120" stroke="#3F5A45" stroke-width="1.5"/>
                                    <path d="M80 140 L85 122" stroke="#3F5A45" stroke-width="1.5"/>
                                </g>

                                <g class="flower-anim-2">
                                    <circle cx="220" cy="145" r="7" fill="#E8B4B8" opacity="0.8"/>
                                    <circle cx="220" cy="145" r="3" fill="#D4969A"/>
                                    <path d="M220 145 L215 128" stroke="#3F5A45" stroke-width="1.5"/>
                                    <path d="M220 145 L225 130" stroke="#3F5A45" stroke-width="1.5"/>
                                </g>

                                
                                <path d="M60 250 Q40 230 50 210 Q60 230 70 250" fill="#A3B8A1" opacity="0.6"/>
                                <path d="M240 260 Q260 240 250 220 Q240 240 230 260" fill="#A3B8A1" opacity="0.6"/>
                                <path d="M100 280 Q80 260 90 240 Q100 260 110 280" fill="#71856F" opacity="0.5"/>
                                <path d="M200 285 Q220 265 210 245 Q200 265 190 285" fill="#71856F" opacity="0.5"/>

                                
                                <circle cx="75" cy="280" r="6" fill="#D4969A" opacity="0.7"/>
                                <circle cx="225" cy="275" r="5" fill="#E8B4B8" opacity="0.7"/>
                                <circle cx="100" cy="340" r="4" fill="#D4969A" opacity="0.6"/>
                                <circle cx="200" cy="345" r="5" fill="#E8B4B8" opacity="0.6"/>

                                
                                <text x="150" y="300" text-anchor="middle" font-family="serif" font-size="48" fill="#3F5A45" opacity="0.15">?</text>
                            </svg>
                        </div>
                    <?php endif; ?>

                    <div class="mystery-box-badge">
                        <span>Mystery</span>
                    </div>
                </div>

                
                <div class="mystery-float float-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C13.5 2.5 15 4.5 15 7C15 9.5 13.5 11 12 11C10.5 11 9 9.5 9 7C9 4.5 10.5 2.5 12 2Z"/>
                        <path d="M12 11C13.5 11.5 16 13 16 16C16 19 14 21 12 21C10 21 8 19 8 16C8 13 10.5 11.5 12 11Z" opacity="0.6"/>
                    </svg>
                </div>
                <div class="mystery-float float-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L13.5 6L18 6.5L15 9.5L16 14L12 12L8 14L9 9.5L6 6.5L10.5 6L12 2Z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.mystery-box-section {
    padding: var(--space-9) 0;
    background: linear-gradient(180deg, var(--color-cream) 0%, var(--color-botanical-pale) 100%);
    overflow: hidden;
}

.mystery-box-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-9);
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.mystery-box-content {
    padding-right: var(--space-8);
}

.mystery-box-eyebrow {
    display: inline-block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--color-accent);
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: var(--space-3);
}

.mystery-box-title {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    font-weight: 600;
    color: var(--color-primary-dark);
    line-height: 1.2;
    margin-bottom: var(--space-5);
}

.mystery-box-description {
    font-size: 1.0625rem;
    line-height: 1.8;
    color: var(--color-text-light);
    margin-bottom: var(--space-6);
}

.mystery-box-features {
    display: flex;
    flex-direction: column;
    gap: var(--space-5);
    margin-bottom: var(--space-7);
}

.mystery-feature {
    display: flex;
    align-items: flex-start;
    gap: var(--space-4);
}

.mystery-feature-icon {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-white);
    border: 1px solid var(--color-border-light);
    border-radius: var(--radius-md);
    color: var(--color-accent);
    flex-shrink: 0;
    transition: all var(--transition-normal);
}

.mystery-feature:hover .mystery-feature-icon {
    background: var(--color-accent);
    color: var(--color-white);
    border-color: var(--color-accent);
    transform: scale(1.05);
}

.mystery-feature-text h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1.0625rem;
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: var(--space-1);
}

.mystery-feature-text p {
    font-size: 0.9375rem;
    color: var(--color-text-light);
    margin: 0;
    line-height: 1.5;
}

.mystery-box-cta {
    display: inline-flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-4) var(--space-6);
    background: var(--color-primary);
    color: var(--color-white);
    border-radius: var(--radius-md);
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all var(--transition-normal);
    box-shadow: 0 4px 14px rgba(63, 90, 69, 0.25);
}

.mystery-box-cta:hover {
    background: var(--color-primary-dark);
    color: var(--color-white);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(63, 90, 69, 0.35);
}

.mystery-box-cta svg {
    transition: transform var(--transition-normal);
}

.mystery-box-cta:hover svg {
    transform: translateX(4px);
}

.mystery-box-visual {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.mystery-box-image-container {
    position: relative;
    width: 100%;
    max-width: 380px;
}

.mystery-box-image {
    width: 100%;
    height: auto;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
}

.mystery-box-illustration {
    width: 100%;
    max-width: 300px;
    animation: float-box 4s ease-in-out infinite;
}

@keyframes float-box {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.mystery-box-badge {
    position: absolute;
    top: -10px;
    right: -10px;
    background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
    color: var(--color-white);
    padding: var(--space-3) var(--space-5);
    border-radius: var(--radius-full);
    font-size: 0.8125rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    box-shadow: 0 4px 15px rgba(168, 92, 85, 0.4);
    animation: badge-pulse 2s ease-in-out infinite;
}

@keyframes badge-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.mystery-float {
    position: absolute;
    color: var(--color-primary-lighter);
    animation: float-element 3s ease-in-out infinite;
}

.float-1 {
    top: 10%;
    left: 0;
    animation-delay: 0s;
}

.float-2 {
    bottom: 20%;
    right: 5%;
    animation-delay: 1s;
}

@keyframes float-element {
    0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.6; }
    50% { transform: translateY(-10px) rotate(5deg); opacity: 0.9; }
}

/* Flower animation */
.flower-anim-1, .flower-anim-2 {
    animation: flower-sway 3s ease-in-out infinite;
    transform-origin: center bottom;
}

.flower-anim-2 {
    animation-delay: 0.5s;
}

@keyframes flower-sway {
    0%, 100% { transform: rotate(-3deg); }
    50% { transform: rotate(3deg); }
}

/* Responsive */
@media (max-width: 1024px) {
    .mystery-box-wrapper {
        grid-template-columns: 1fr;
        gap: var(--space-7);
    }

    .mystery-box-content {
        padding-right: 0;
        text-align: center;
    }

    .mystery-box-features {
        align-items: center;
    }

    .mystery-feature {
        max-width: 400px;
        text-align: left;
    }
}

@media (max-width: 768px) {
    .mystery-box-section {
        padding: var(--space-7) 0;
    }

    .mystery-box-title {
        font-size: 2.25rem;
    }

    .mystery-box-description {
        font-size: 1rem;
    }

    .mystery-box-cta {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .mystery-box-title {
        font-size: 1.875rem;
    }

    .mystery-box-features {
        gap: var(--space-4);
    }

    .mystery-feature-icon {
        width: 40px;
        height: 40px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .mystery-box-illustration,
    .mystery-float,
    .flower-anim-1,
    .flower-anim-2,
    .mystery-box-badge {
        animation: none;
    }
}
</style>
<?php /**PATH /root/FlowerShop/resources/views/home/sections/mystery-box-banner.blade.php ENDPATH**/ ?>