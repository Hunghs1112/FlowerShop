{{-- Mystery Box Banner Section --}}
<section class="mystery-box-banner">
    <div class="mystery-box-banner-container">
        {{-- Banner Background Image --}}
        <div class="mystery-box-banner-background">
            <img 
                src="{{ $siteBanners['mystery-box'] ?? asset('images/banners/mystery-box-hero.jpg') }}"
                alt="Hộp Hoa Bí Ẩn"
                class="mystery-box-banner-image"
                loading="lazy"
            >
            {{-- Overlay gradient --}}
            <div class="mystery-box-banner-overlay"></div>
        </div>

        {{-- Banner Content --}}
        <div class="mystery-box-banner-content">
            <div class="mystery-box-banner-wrapper">
                <div class="mystery-box-banner-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v-4m0 0l-3 3m3-3l3 3m0 8v4m0 0l-3-3m3 3l3-3m-9-6.5h-2.5a2.5 2.5 0 0 0-2.5 2.5v7a2.5 2.5 0 0 0 2.5 2.5h11a2.5 2.5 0 0 0 2.5-2.5v-7a2.5 2.5 0 0 0-2.5-2.5h-2.5"/>
                    </svg>
                </div>
                
                <h2 class="mystery-box-banner-title">Hộp Hoa Bí Ẩn</h2>
                
                <p class="mystery-box-banner-description">
                    Để chúng tôi làm bất ngờ bạn. Chỉ cần chia sẻ sở thích của mình, và LNT sẽ tuyển chọn những bông hoa tươi đẹp nhất dành riêng cho bạn.
                </p>
                
                <a href="{{ route('mystery-box.index') }}" class="mystery-box-banner-cta">
                    Khám Phá Ngay
                    <svg class="mystery-box-banner-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.mystery-box-banner {
    position: relative;
    width: 100%;
    padding: 60px 20px;
    background: linear-gradient(135deg, #f3e7f0 0%, #f9f0f6 100%);
}

.mystery-box-banner-container {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    border-radius: 16px;
    overflow: hidden;
    height: 320px;
    display: flex;
    align-items: center;
}

.mystery-box-banner-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.mystery-box-banner-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.mystery-box-banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0) 100%);
    z-index: 2;
}

.mystery-box-banner-content {
    position: relative;
    z-index: 3;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
}

.mystery-box-banner-wrapper {
    padding: 40px;
    color: white;
}

.mystery-box-banner-icon {
    width: 60px;
    height: 60px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.mystery-box-banner-icon svg {
    width: 32px;
    height: 32px;
    stroke: currentColor;
}

.mystery-box-banner-title {
    font-size: 36px;
    font-weight: 700;
    margin: 0 0 12px 0;
    line-height: 1.2;
    letter-spacing: -0.5px;
}

.mystery-box-banner-description {
    font-size: 16px;
    line-height: 1.6;
    margin: 0 0 24px 0;
    opacity: 0.95;
    max-width: 500px;
    font-weight: 400;
}

.mystery-box-banner-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: white;
    color: #d92e66;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid white;
}

.mystery-box-banner-cta:hover {
    background: transparent;
    color: white;
    border-color: white;
    transform: translateX(2px);
}

.mystery-box-banner-cta-icon {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    transition: transform 0.3s ease;
}

.mystery-box-banner-cta:hover .mystery-box-banner-cta-icon {
    transform: translateX(3px);
}

/* Responsive */
@media (max-width: 768px) {
    .mystery-box-banner {
        padding: 40px 20px;
    }

    .mystery-box-banner-container {
        height: 280px;
        border-radius: 12px;
    }

    .mystery-box-banner-wrapper {
        padding: 30px;
    }

    .mystery-box-banner-title {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .mystery-box-banner-description {
        font-size: 14px;
        margin-bottom: 20px;
    }

    .mystery-box-banner-cta {
        padding: 12px 24px;
        font-size: 14px;
    }

    .mystery-box-banner-overlay {
        background: linear-gradient(90deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
    }
}

@media (max-width: 480px) {
    .mystery-box-banner {
        padding: 30px 16px;
    }

    .mystery-box-banner-container {
        height: 240px;
        border-radius: 10px;
    }

    .mystery-box-banner-wrapper {
        padding: 20px;
    }

    .mystery-box-banner-title {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .mystery-box-banner-description {
        font-size: 13px;
        margin-bottom: 16px;
    }

    .mystery-box-banner-cta {
        padding: 10px 20px;
        font-size: 13px;
    }

    .mystery-box-banner-icon {
        width: 50px;
        height: 50px;
        margin-bottom: 12px;
    }

    .mystery-box-banner-icon svg {
        width: 28px;
        height: 28px;
    }
}
</style>
