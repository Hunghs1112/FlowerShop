@extends('layouts.app')

@section('title', 'Đăng ký tài khoản')

@section('content')
<div class="auth-split">

    {{-- ═══════ LEFT: Botanical Panel ═══════ --}}
    <div class="auth-panel">
        <div class="auth-panel__overlay"></div>

        {{-- Decorative botanical elements --}}
        <div class="auth-panel__botanical">
            <svg class="auth-panel__flower" viewBox="0 0 320 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="160" cy="130" r="35" stroke="rgba(255,255,255,0.6)" stroke-width="1.5"/>
                <circle cx="185" cy="108" r="28" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/>
                <circle cx="198" cy="138" r="30" stroke="rgba(255,255,255,0.55)" stroke-width="1.5"/>
                <circle cx="185" cy="162" r="26" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/>
                <circle cx="160" cy="175" r="32" stroke="rgba(255,255,255,0.6)" stroke-width="1.5"/>
                <circle cx="135" cy="162" r="27" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/>
                <circle cx="122" cy="138" r="30" stroke="rgba(255,255,255,0.55)" stroke-width="1.5"/>
                <circle cx="135" cy="108" r="28" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/>
                <circle cx="160" cy="138" r="18" fill="rgba(255,255,255,0.4)"/>
                <line x1="160" y1="175" x2="160" y2="300" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
                <path d="M160 210 Q120 200 100 220" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" fill="none"/>
                <path d="M160 230 Q200 220 220 240" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" fill="none"/>
                <path d="M160 250 Q130 245 115 260" stroke="rgba(255,255,255,0.25)" stroke-width="1.5" fill="none"/>
            </svg>

            <svg class="auth-panel__leaf1" viewBox="0 0 120 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M60 10 Q20 30 10 60 Q30 50 60 70 Q90 50 110 60 Q100 30 60 10Z" fill="rgba(255,255,255,0.4)"/>
                <line x1="60" y1="10" x2="60" y2="70" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
            </svg>

            <svg class="auth-panel__leaf2" viewBox="0 0 100 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M50 5 Q15 25 8 50 Q28 42 50 60 Q72 42 92 50 Q85 25 50 5Z" fill="rgba(255,255,255,0.35)"/>
                <line x1="50" y1="5" x2="50" y2="60" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
            </svg>

            <svg class="auth-panel__leaf3" viewBox="0 0 90 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M45 5 Q12 22 5 45 Q24 38 45 55 Q66 38 85 45 Q78 22 45 5Z" fill="rgba(255,255,255,0.3)"/>
                <line x1="45" y1="5" x2="45" y2="55" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
            </svg>

            <svg class="auth-panel__leaf4" viewBox="0 0 110 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M55 5 Q18 25 10 55 Q30 45 55 65 Q80 45 100 55 Q92 25 55 5Z" fill="rgba(255,255,255,0.32)"/>
                <line x1="55" y1="5" x2="55" y2="65" stroke="rgba(255,255,255,0.22)" stroke-width="1"/>
            </svg>

            <div class="auth-panel__dot1"></div>
            <div class="auth-panel__dot2"></div>
            <div class="auth-panel__dot3"></div>
            <div class="auth-panel__dot4"></div>
            <div class="auth-panel__dot5"></div>
        </div>

        {{-- Panel content --}}
        <div class="auth-panel__content">
            <div class="auth-panel__brand">
                <div class="auth-panel__brand-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.38a48.474 48.474 0 00-6-.37c-2.032 0-4.034.125-6 .37m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.17c0 .62-.504 1.124-1.125 1.124H4.125A1.125 1.125 0 013 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265zm-3 0a.375.375 0 11-.53 0l.265-.265.265.265zm6 0a.375.375 0 11-.53 0l.265-.265.265.265z"/>
                    </svg>
                </div>
                <span class="auth-panel__brand-name">Lâm Nhiên Thảo</span>
            </div>

            <blockquote class="auth-panel__quote">
                Đăng ký ngay để nhận<br>
                <em>ưu đãi đặc biệt</em><br>
                dành riêng cho thành viên.
            </blockquote>

            <p class="auth-panel__subtext">
                Tham gia cộng đồng yêu hoa tại Lâm Nhiên Thảo. Đăng ký nhanh chóng để theo dõi đơn hàng, lưu sản phẩm yêu thích và nhận ưu đãi hấp dẫn.
            </p>

            <div class="auth-panel__badges">
                <span class="auth-panel__badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Đăng ký trong 30 giây
                </span>
                <span class="auth-panel__badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                    Miễn phí vận chuyển
                </span>
                <span class="auth-panel__badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Không phí ẩn
                </span>
            </div>
        </div>
    </div>

    {{-- ═══════ RIGHT: Form Panel ═══════ --}}
    <div class="auth-form-panel">
        <div class="auth-form-wrap">

            <div class="auth-card">

                {{-- Tabs: Login / Register --}}
                <div class="auth-tabs">
                    <a href="{{ route('login') }}" class="auth-tab">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="auth-tab is-active">Đăng ký</a>
                </div>

                {{-- Header --}}
                <div class="auth-header">
                    <h1 class="auth-title">Tạo tài khoản mới</h1>
                    <p class="auth-subtitle">
                        Tham gia cùng hơn 10.000+ khách hàng yêu hoa tại Lâm Nhiên Thảo.
                    </p>
                </div>

                {{-- Success Message --}}
                @if(session('status'))
                    <div class="auth-alert auth-alert--success">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                {{-- Error Messages --}}
                @if($errors->any())
                    <div class="auth-alert auth-alert--error">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- Register Form --}}
                <form method="POST" action="{{ route('register') }}" class="auth-form" id="register-form">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-input @error('name') error @enderror"
                            placeholder="Nguyễn Văn A"
                            required
                            autofocus
                            autocomplete="name"
                        >
                        @error('name')
                            <span class="form-error">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-input @error('email') error @enderror"
                            placeholder="email@example.com"
                            required
                            autocomplete="email"
                        >
                        @error('email')
                            <span class="form-error">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Số điện thoại <span style="color: var(--color-text-muted); font-weight:400;">(tùy chọn)</span></label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="form-input @error('phone') error @enderror"
                            placeholder="0901 234 567"
                            autocomplete="tel"
                        >
                        @error('phone')
                            <span class="form-error">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <div class="form-password-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input @error('password') error @enderror"
                                placeholder="Ít nhất 8 ký tự"
                                required
                                autocomplete="new-password"
                                minlength="8"
                            >
                            <button type="button" class="form-password-toggle" onclick="togglePassword('password', this)" aria-label="Hiện/Ẩn mật khẩu">
                                <svg class="icon-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <svg class="icon-eye-off" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="form-error">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                        <div class="form-password-wrap">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-input"
                                placeholder="Nhập lại mật khẩu"
                                required
                                autocomplete="new-password"
                            >
                            <button type="button" class="form-password-toggle" onclick="togglePassword('password_confirmation', this)" aria-label="Hiện/Ẩn mật khẩu">
                                <svg class="icon-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <svg class="icon-eye-off" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="form-checkbox-group" style="margin-top: -4px;">
                        <input
                            type="checkbox"
                            id="terms"
                            name="terms"
                            class="form-checkbox"
                            required
                        >
                        <label for="terms" class="form-checkbox-label">
                            Tôi đồng ý với <a href="{{ route('policy.terms') }}" target="_blank">Điều khoản dịch vụ</a> và <a href="{{ route('policy.baomat') }}" target="_blank">Chính sách bảo mật</a>
                        </label>
                    </div>

                    <button type="submit" class="auth-submit" id="register-btn">
                        Tạo tài khoản
                    </button>
                </form>

                {{-- Login link --}}
                <div class="auth-footer">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}" class="auth-footer-link">Đăng nhập ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const eyeOn = btn.querySelector('.icon-eye');
    const eyeOff = btn.querySelector('.icon-eye-off');
    if (input.type === 'password') {
        input.type = 'text';
        eyeOn.style.display = 'none';
        eyeOff.style.display = '';
    } else {
        input.type = 'password';
        eyeOn.style.display = '';
        eyeOff.style.display = 'none';
    }
}

// Loading state on submit
document.getElementById('register-form')?.addEventListener('submit', function() {
    const btn = document.getElementById('register-btn');
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'Đang xử lý...';
    }
});
</script>
@endsection
