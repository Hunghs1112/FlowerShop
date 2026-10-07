<footer class="site-footer">
    <div class="footer-container">
        <!-- Footer Main Grid -->
        <div class="footer-main">
            <!-- Column 1 - Contact from DB settings -->
            <div class="footer-column">
                <h3 class="footer-column-heading">Liên hệ</h3>

                @if(!empty($siteSettings['phone']))
                <div class="footer-contact-item">
                    <div class="footer-contact-label">Hotline</div>
                    <a href="tel:{{ preg_replace('/\D/', '', $siteSettings['phone']) }}" class="footer-contact-value footer-contact-phone">{{ $siteSettings['phone'] }}</a>
                </div>
                @endif

                @if(!empty($siteSettings['email']))
                <div class="footer-contact-item">
                    <div class="footer-contact-label">Email</div>
                    <a href="mailto:{{ $siteSettings['email'] }}" class="footer-contact-value">{{ $siteSettings['email'] }}</a>
                </div>
                @endif

                @if(!empty($siteSettings['address']))
                <div class="footer-contact-item">
                    <div class="footer-contact-label">Địa chỉ</div>
                    <span class="footer-contact-value">{{ $siteSettings['address'] }}</span>
                </div>
                @endif

                <!-- Social Icons from DB settings -->
                <div class="footer-social">
                    @if(!empty($siteSettings['instagram_url']))
                    <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="Instagram">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($siteSettings['facebook_url']))
                    <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="Facebook">
                        <svg viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($siteSettings['tiktok_url']))
                    <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="TikTok">
                        <svg viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($siteSettings['zalo_url']))
                    <a href="{{ $siteSettings['zalo_url'] }}" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="Zalo">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.445 16.295c-.222.37-.605.59-1.02.59H7.56c-.413 0-.797-.22-1.02-.59a1.18 1.18 0 0 1-.02-1.18l.845-1.56a5.94 5.94 0 0 1-.91-3.14C6.455 7.1 9.02 4.5 12 4.5s5.545 2.6 5.545 5.915c0 1.17-.33 2.26-.91 3.14l.845 1.56c.22.37.21.82-.035 1.18zM9.03 10.08c0-.27.22-.49.49-.49h.98c.27 0 .49.22.49.49v2.94c0 .27-.22.49-.49.49h-.98c-.27 0-.49-.22-.49-.49v-2.94zm3.49 2.94c0 .27-.22.49-.49.49h-.98c-.27 0-.49-.22-.49-.49v-2.94c0-.27.22-.49.49-.49h.98c.27 0 .49.22.49.49v2.94zm1.48-2.94c0 .27-.22.49-.49.49h.98c.27 0 .49-.22.49-.49v-2.94c0-.27-.22-.49-.49-.49h-.98c-.27 0-.49.22-.49.49v2.94z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($siteSettings['youtube_url']))
                    <a href="{{ $siteSettings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="YouTube">
                        <svg viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Column 2 - Categories from DB -->
            <div class="footer-column">
                <h3 class="footer-column-heading">Danh mục</h3>
                <nav class="footer-links">
                    @foreach($navCategories as $footerCat)
                        <a href="{{ route('categories.show', $footerCat->display_slug) }}" class="footer-link">{{ $footerCat->display_name }}</a>
                    @endforeach
                    @if($navCategories->isEmpty())
                        <a href="{{ route('products.index') }}" class="footer-link">Tất cả sản phẩm</a>
                    @endif
                </nav>
            </div>

            <!-- Column 3 - Information -->
            <div class="footer-column">
                <h3 class="footer-column-heading">Thông tin</h3>
                <nav class="footer-links">
                    <a href="{{ route('policy.delivery') }}" class="footer-link">Chính sách giao hàng</a>
                    <a href="{{ route('policy.baomat') }}" class="footer-link">Chính sách bảo mật</a>
                    <a href="{{ route('policy.ours') }}" class="footer-link">Chính sách của chúng tôi</a>
                    <a href="{{ route('policy.terms') }}" class="footer-link">Điều khoản dịch vụ</a>
                    <a href="{{ route('guide') }}" class="footer-link">Hướng dẫn đặt hàng</a>
                    <a href="{{ route('season.phu-kien') }}" class="footer-link">Phụ kiện cây thông</a>
                    <a href="{{ route('season.mua-le-hoi') }}" class="footer-link">Mùa lễ hội</a>
                    <a href="{{ route('contact') }}" class="footer-link">Liên hệ</a>
                </nav>
            </div>

            <!-- Column 4 - Newsletter -->
            <div class="footer-column">
                <h3 class="footer-column-heading">Bản tin</h3>
                <p class="footer-newsletter-description">Đăng ký nhận tin khuyến mãi và cập nhật mới nhất từ chúng tôi.</p>

                <form class="footer-newsletter-form" action="#" method="POST">
                    @csrf
                    <input
                        type="email"
                        name="email"
                        placeholder="Nhập email của bạn"
                        class="footer-newsletter-input"
                        required
                    >
                    <button type="submit" class="footer-newsletter-button">Đăng ký</button>
                </form>

                <p class="footer-newsletter-consent">
                    Bằng việc đăng ký, bạn đồng ý với <a href="{{ route('policy.baomat') }}">Chính sách bảo mật</a>
                </p>
            </div>
        </div>

        <!-- Footer Divider -->
        <div class="footer-divider"></div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-copyright">
                © {{ date('Y') }} {{ $siteSettings['site_name'] ?? config('app.name') }}. All rights reserved.
            </div>

            <div class="footer-bottom-right">
                <nav class="footer-bottom-links">
                    <a href="{{ route('policy.delivery') }}" class="footer-bottom-link">Chính sách giao hàng</a>
                    <a href="{{ route('policy.baomat') }}" class="footer-bottom-link">Chính sách bảo mật</a>
                    <a href="{{ route('policy.ours') }}" class="footer-bottom-link">Chính sách của chúng tôi</a>
                </nav>
            </div>
        </div>
    </div>
</footer>
