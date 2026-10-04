@extends('layouts.app')

@section('title', 'Đăng ký đối tác B2C')

@php
$b2cBanner = $siteBanners['b2c'] ?? null;
@endphp

@section('content')
    <x-page-hero
        title="Đăng ký đối tác B2C"
        description="Trở thành đối tác B2C của Lâm Nhiên Thảo để tiếp cận nguồn hoa tươi chất lượng, giá xuất xưởng cùng nhiều ưu đãi độc quyền dành cho cửa hàng và thợ cắm hoa."
        label="B2C Partnership"
        :breadcrumbs="[
            ['label' => 'Trang chủ', 'url' => route('home')],
            ['label' => 'Đăng ký B2C'],
        ]"
        :image="$b2cBanner"
        height="420px"
    />

    @php
        // Lấy flash message từ session (fallback không phải AJAX)
        $showSuccessScreen = session('b2c_success') ? true : false;
    @endphp

    <section class="b2c-section">
        <div class="container">
            <div class="b2c-layout">

                {{-- ── Sidebar: lợi ích ─────────────────────────────── --}}
                <aside class="b2c-sidebar">
                    <span class="b2c-sidebar-label">Vì sao chọn Lâm Nhiên Thảo?</span>
                    <h2 class="b2c-sidebar-title">Đối tác tin cậy của hơn 500+ cửa hàng hoa</h2>
                    <p class="b2c-sidebar-text">
                        Chúng tôi cung cấp nguồn hoa tươi ổn định với giá xuất xưởng, hỗ trợ vận chuyển nhanh
                        và chính sách đổi trả linh hoạt dành riêng cho đối tác B2C.
                    </p>

                    <ul class="b2c-benefits">
                        <li>
                            <span class="b2c-benefit-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            <div>
                                <strong>Giá xuất xưởng cạnh tranh</strong>
                                <span>Chiết khấu hấp dẫn theo doanh số tháng.</span>
                            </div>
                        </li>
                        <li>
                            <span class="b2c-benefit-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h12"/>
                                </svg>
                            </span>
                            <div>
                                <strong>Vận chuyển nhanh chóng</strong>
                                <span>Giao tận nơi trong vòng 24 giờ nội thành.</span>
                            </div>
                        </li>
                        <li>
                            <span class="b2c-benefit-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3s3 1.343 3 3-1.343 3-3 3m0-12V5m0 14v-2m9-7h-2M5 12H3m13.95 6.95l-1.414-1.414M7.464 7.464L6.05 6.05m12.9 0l-1.414 1.414M7.464 16.536L6.05 17.95"/>
                                </svg>
                            </span>
                            <div>
                                <strong>Hỗ trợ chuyên nghiệp</strong>
                                <span>Đội ngũ tư vấn riêng cho từng đối tác.</span>
                            </div>
                        </li>
                        <li>
                            <span class="b2c-benefit-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </span>
                            <div>
                                <strong>Chất lượng đảm bảo</strong>
                                <span>Cam kết hoa tươi, hoàn tiền nếu không hài lòng.</span>
                            </div>
                        </li>
                    </ul>
                </aside>

                {{-- ── Form panel ─────────────────────────────────────── --}}
                <div class="b2c-form-panel">

                    @if($showSuccessScreen)
                        {{-- Success screen (khi submit không phải AJAX) --}}
                        <div class="b2c-success" id="b2cSuccessScreen">
                            <div class="b2c-success-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h2>Đăng ký thành công!</h2>
                            <p>
                                Cảm ơn bạn đã đăng ký làm đối tác B2C của Lâm Nhiên Thảo.<br>
                                Đội ngũ của chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ làm việc.
                            </p>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Về trang chủ</a>
                        </div>
                    @else
                        {{-- ── Stepper ────────────────────────────────────── --}}
                        <div class="b2c-stepper" aria-label="Tiến trình đăng ký">
                            <div class="b2c-step b2c-step--active" data-step="1">
                                <span class="b2c-step-number">1</span>
                                <span class="b2c-step-label">Thông tin cơ bản</span>
                            </div>
                            <div class="b2c-step-divider" aria-hidden="true"></div>
                            <div class="b2c-step" data-step="2">
                                <span class="b2c-step-number">2</span>
                                <span class="b2c-step-label">Thông tin doanh nghiệp</span>
                            </div>
                        </div>

                        {{-- Form errors (server-side, fallback) --}}
                        @if($errors->any())
                            <div class="b2c-alert b2c-alert--error" role="alert">
                                <strong>Vui lòng kiểm tra lại thông tin:</strong>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            id="b2cForm"
                            action="{{ route('b2c.store') }}"
                            method="POST"
                            novalidate
                            class="b2c-form"
                        >
                            @csrf

                            {{-- ──────────── STEP 1 ──────────── --}}
                            <fieldset class="b2c-step-panel b2c-step-panel--active" data-step="1" aria-labelledby="b2cStep1Title">
                                <h3 id="b2cStep1Title" class="b2c-step-title">Bước 1 · Thông tin cơ bản</h3>
                                <p class="b2c-step-subtitle">Cho chúng tôi biết về loại hình kinh doanh của bạn.</p>

                                <div class="form-group">
                                    <label class="form-label form-label-required">Loại hình kinh doanh</label>
                                    <div class="b2c-radio-grid" role="radiogroup" aria-required="true">
                                        @foreach($businessTypes as $value => $label)
                                            <label class="b2c-radio-card">
                                                <input
                                                    type="radio"
                                                    name="business_type"
                                                    value="{{ $value }}"
                                                    data-validate="required"
                                                    {{ old('business_type') === $value ? 'checked' : '' }}
                                                >
                                                <span class="b2c-radio-card-content">
                                                    <span class="b2c-radio-card-icon" aria-hidden="true">
                                                        @switch($value)
                                                            @case('traditional_shop')
                                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l1-5h16l1 5M5 9v11h14V9M9 13h6"/></svg>
                                                                @break
                                                            @case('event_decor')
                                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                                                @break
                                                            @case('florist')
                                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.5C10 4 7 4 5 6s-1 6 1 7c2 1 5 0 6-2 1 2 4 3 6 2 2-1 3-5 1-7s-5-2-7 .5zM12 13v8"/></svg>
                                                                @break
                                                            @case('online_shop')
                                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                                                @break
                                                        @endswitch
                                                    </span>
                                                    <span class="b2c-radio-card-label">{{ $label }}</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <p class="b2c-field-error" data-error-for="business_type"></p>
                                </div>

                                <div class="form-group">
                                    <label for="contact_name" class="form-label form-label-required">Họ và tên người liên hệ</label>
                                    <input
                                        type="text"
                                        id="contact_name"
                                        name="contact_name"
                                        class="form-input"
                                        placeholder="Nguyễn Văn A"
                                        value="{{ old('contact_name') }}"
                                        data-validate="required|max:255"
                                        autocomplete="name"
                                    >
                                    <p class="b2c-field-error" data-error-for="contact_name"></p>
                                </div>

                                <div class="form-group">
                                    <label for="contact_email" class="form-label">Email <span class="b2c-label-hint">(không bắt buộc)</span></label>
                                    <input
                                        type="email"
                                        id="contact_email"
                                        name="contact_email"
                                        class="form-input"
                                        placeholder="email@example.com"
                                        value="{{ old('contact_email') }}"
                                        data-validate="email|max:255"
                                        autocomplete="email"
                                    >
                                    <p class="b2c-field-error" data-error-for="contact_email"></p>
                                </div>

                                <div class="b2c-step-actions">
                                    <span></span>
                                    <button type="button" class="btn btn-primary btn-lg" data-action="next">
                                        Tiếp tục
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </button>
                                </div>
                            </fieldset>

                            {{-- ──────────── STEP 2 ──────────── --}}
                            <fieldset class="b2c-step-panel" data-step="2" aria-labelledby="b2cStep2Title" hidden>
                                <h3 id="b2cStep2Title" class="b2c-step-title">Bước 2 · Thông tin doanh nghiệp</h3>
                                <p class="b2c-step-subtitle">Hoàn tất thông tin để chúng tôi có thể hỗ trợ bạn tốt nhất.</p>

                                <div class="form-group">
                                    <label for="business_name" class="form-label form-label-required">Tên cửa hàng / đơn vị</label>
                                    <input
                                        type="text"
                                        id="business_name"
                                        name="business_name"
                                        class="form-input"
                                        placeholder="Shop Hoa Tươi ABC"
                                        value="{{ old('business_name') }}"
                                        data-validate="required|max:255"
                                    >
                                    <p class="b2c-field-error" data-error-for="business_name"></p>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="form-label form-label-required">Địa chỉ</label>
                                    <input
                                        type="text"
                                        id="address"
                                        name="address"
                                        class="form-input"
                                        placeholder="123 Nguyễn Huệ, Quận 1, TP. HCM"
                                        value="{{ old('address') }}"
                                        data-validate="required|max:500"
                                        autocomplete="street-address"
                                    >
                                    <p class="b2c-field-error" data-error-for="address"></p>
                                </div>

                                <div class="b2c-grid-2">
                                    <div class="form-group">
                                        <label for="phone" class="form-label form-label-required">Số điện thoại</label>
                                        <input
                                            type="tel"
                                            id="phone"
                                            name="phone"
                                            class="form-input"
                                            placeholder="0901234567"
                                            value="{{ old('phone') }}"
                                            data-validate="required|phone"
                                            autocomplete="tel"
                                        >
                                        <p class="b2c-field-error" data-error-for="phone"></p>
                                    </div>

                                    <div class="form-group">
                                        <label for="years_in_business" class="form-label form-label-required">Số năm hoạt động</label>
                                        <input
                                            type="number"
                                            id="years_in_business"
                                            name="years_in_business"
                                            class="form-input"
                                            placeholder="VD: 3"
                                            min="0"
                                            max="200"
                                            value="{{ old('years_in_business') }}"
                                            data-validate="required|integer|min:0"
                                        >
                                        <p class="b2c-field-error" data-error-for="years_in_business"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="social_media" class="form-label form-label-required">Trang mạng xã hội</label>
                                    <input
                                        type="url"
                                        id="social_media"
                                        name="social_media"
                                        class="form-input"
                                        placeholder="https://facebook.com/your-shop"
                                        value="{{ old('social_media') }}"
                                        data-validate="required|url|max:500"
                                    >
                                    <p class="b2c-field-error" data-error-for="social_media"></p>
                                </div>

                                <div class="b2c-grid-2">
                                    <div class="form-group">
                                        <label for="tax_code" class="form-label form-label-required">Mã số thuế (MST)</label>
                                        <input
                                            type="text"
                                            id="tax_code"
                                            name="tax_code"
                                            class="form-input"
                                            placeholder="0123456789"
                                            value="{{ old('tax_code') }}"
                                            data-validate="required|max:50"
                                        >
                                        <p class="b2c-field-error" data-error-for="tax_code"></p>
                                    </div>

                                    <div class="form-group">
                                        <label for="business_license" class="form-label form-label-required">Số giấy phép kinh doanh</label>
                                        <input
                                            type="text"
                                            id="business_license"
                                            name="business_license"
                                            class="form-input"
                                            placeholder='VD: 41A8023456 hoặc "Đang xin cấp"'
                                            value="{{ old('business_license') }}"
                                            data-validate="required|max:100"
                                            list="b2cLicenseHints"
                                        >
                                        <datalist id="b2cLicenseHints">
                                            <option value="Đang xin cấp">
                                            <option value="Chưa có">
                                        </datalist>
                                        <p class="b2c-field-hint">Có thể nhập "Đang xin cấp" hoặc "Chưa có".</p>
                                        <p class="b2c-field-error" data-error-for="business_license"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="vat_email" class="form-label form-label-required">Email nhận hóa đơn VAT</label>
                                    <input
                                        type="email"
                                        id="vat_email"
                                        name="vat_email"
                                        class="form-input"
                                        placeholder="accounting@example.com"
                                        value="{{ old('vat_email') }}"
                                        data-validate="required|email|max:255"
                                    >
                                    <p class="b2c-field-error" data-error-for="vat_email"></p>
                                </div>

                                <div class="b2c-step-actions">
                                    <button type="button" class="btn btn-outline btn-lg" data-action="prev">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                        </svg>
                                        Quay lại
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg" data-action="submit" id="b2cSubmitBtn">
                                        <span class="b2c-submit-text">Gửi đăng ký</span>
                                        <span class="b2c-submit-spinner" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </fieldset>

                            {{-- ──────────── SUCCESS ──────────── --}}
                            <div class="b2c-step-panel b2c-success-panel" data-step="success" hidden>
                                <div class="b2c-success">
                                    <div class="b2c-success-icon" aria-hidden="true">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <h2>Đăng ký thành công!</h2>
                                    <p id="b2cSuccessMessage">
                                        Cảm ơn bạn đã đăng ký làm đối tác B2C của Lâm Nhiên Thảo.<br>
                                        Đội ngũ của chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ làm việc.
                                    </p>
                                    <div class="b2c-success-actions">
                                        <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
                                        <button type="button" class="btn btn-outline" id="b2cResetBtn">Đăng ký thêm</button>
                                    </div>
                                </div>
                            </div>

                            {{-- ──────────── ERROR ──────────── --}}
                            <div class="b2c-step-panel b2c-error-panel" data-step="error" hidden>
                                <div class="b2c-success b2c-error">
                                    <div class="b2c-success-icon b2c-success-icon--error" aria-hidden="true">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 19h14.14c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z"/>
                                        </svg>
                                    </div>
                                    <h2>Đã có lỗi xảy ra</h2>
                                    <p id="b2cErrorMessage">Vui lòng thử lại sau hoặc liên hệ với chúng tôi qua hotline.</p>
                                    <button type="button" class="btn btn-primary" id="b2cRetryBtn">Thử lại</button>
                                </div>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <style>
        /* ==========================================================================
           B2C Section
           ========================================================================== */
        .b2c-section {
            padding: var(--space-9) 0 var(--space-10);
            background-color: var(--color-cream);
        }

        .b2c-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.4fr);
            gap: var(--space-8);
            align-items: start;
        }

        /* === SIDEBAR === */
        .b2c-sidebar {
            background-color: var(--color-white);
            border-radius: var(--radius-lg);
            padding: var(--space-7);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 96px;
        }

        .b2c-sidebar-label {
            display: inline-block;
            font-family: 'Inter', sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--color-primary);
            margin-bottom: var(--space-3);
        }

        .b2c-sidebar-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.5rem, 2.4vw, 2rem);
            font-weight: 500;
            color: var(--color-text);
            margin: 0 0 var(--space-3);
            line-height: 1.25;
        }

        .b2c-sidebar-text {
            font-size: 0.9375rem;
            line-height: 1.7;
            color: var(--color-text-light);
            margin: 0 0 var(--space-6);
        }

        .b2c-benefits {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .b2c-benefits li {
            display: flex;
            gap: var(--space-3);
            align-items: flex-start;
        }

        .b2c-benefits strong {
            display: block;
            font-size: 0.9375rem;
            color: var(--color-text);
            margin-bottom: 2px;
        }

        .b2c-benefits span {
            font-size: 0.8125rem;
            color: var(--color-text-light);
            line-height: 1.5;
        }

        .b2c-benefit-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-botanical-pale);
            color: var(--color-primary);
            border-radius: 50%;
        }

        .b2c-benefit-icon svg {
            width: 18px;
            height: 18px;
        }

        /* === FORM PANEL === */
        .b2c-form-panel {
            background-color: var(--color-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: var(--space-8);
            min-height: 460px;
        }

        /* === STEPPER === */
        .b2c-stepper {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-7);
            padding-bottom: var(--space-5);
            border-bottom: 1px solid var(--color-border-light);
        }

        .b2c-step {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            color: var(--color-text-light);
            transition: color var(--transition-fast);
            flex: 0 0 auto;
        }

        .b2c-step--active,
        .b2c-step--done {
            color: var(--color-primary);
        }

        .b2c-step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-cream-darker);
            font-weight: 600;
            font-size: 0.875rem;
            transition: all var(--transition-fast);
        }

        .b2c-step--active .b2c-step-number,
        .b2c-step--done .b2c-step-number {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .b2c-step-label {
            font-size: 0.875rem;
            font-weight: 500;
        }

        .b2c-step-divider {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, var(--color-border) 50%, transparent 0);
            background-size: 12px 1px;
            background-repeat: repeat-x;
        }

        /* === STEP PANELS === */
        .b2c-step-panel {
            margin: 0;
            padding: 0;
            border: 0;
            min-width: 0;
        }

        .b2c-step-panel[hidden] {
            display: none !important;
        }

        .b2c-step-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--color-text);
            margin: 0 0 var(--space-2);
        }

        .b2c-step-subtitle {
            font-size: 0.9375rem;
            color: var(--color-text-light);
            margin: 0 0 var(--space-6);
        }

        .b2c-step-actions {
            display: flex;
            justify-content: space-between;
            gap: var(--space-4);
            margin-top: var(--space-8);
            padding-top: var(--space-6);
            border-top: 1px solid var(--color-border-light);
        }

        .b2c-label-hint {
            font-weight: 400;
            color: var(--color-text-light);
            font-size: 0.8125rem;
        }

        .b2c-field-hint {
            font-size: 0.8125rem;
            color: var(--color-text-light);
            margin: var(--space-2) 0 0;
        }

        .b2c-field-error {
            display: none;
            font-size: 0.8125rem;
            color: var(--color-error);
            margin: var(--space-2) 0 0;
        }

        .b2c-field-error.is-visible {
            display: block;
        }

        .form-input.is-invalid,
        .form-textarea.is-invalid,
        .form-select.is-invalid {
            border-color: var(--color-error);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        /* === RADIO CARDS === */
        .b2c-radio-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: var(--space-3);
        }

        .b2c-radio-card {
            display: block;
            cursor: pointer;
            position: relative;
        }

        .b2c-radio-card input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            width: 0;
            height: 0;
        }

        .b2c-radio-card-content {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-4);
            background-color: var(--color-cream);
            border: 1px solid var(--color-border-light);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
            min-height: 64px;
        }

        .b2c-radio-card:hover .b2c-radio-card-content {
            border-color: var(--color-primary-light);
            background-color: var(--color-white);
        }

        .b2c-radio-card input:checked + .b2c-radio-card-content {
            border-color: var(--color-primary);
            background-color: var(--color-botanical-pale);
            box-shadow: 0 0 0 1px var(--color-primary);
        }

        .b2c-radio-card input:focus-visible + .b2c-radio-card-content {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }

        .b2c-radio-card-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-white);
            border-radius: var(--radius-sm);
            color: var(--color-primary);
        }

        .b2c-radio-card-icon svg {
            width: 22px;
            height: 22px;
        }

        .b2c-radio-card-label {
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--color-text);
            line-height: 1.3;
        }

        .b2c-radio-card.is-invalid .b2c-radio-card-content {
            border-color: var(--color-error);
        }

        /* === GRID === */
        .b2c-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: var(--space-4);
        }

        /* === ALERT === */
        .b2c-alert {
            padding: var(--space-4) var(--space-5);
            border-radius: var(--radius-md);
            margin-bottom: var(--space-5);
            font-size: 0.875rem;
        }

        .b2c-alert--error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .b2c-alert ul {
            margin: var(--space-2) 0 0 var(--space-5);
            padding: 0;
        }

        /* === SUBMIT BUTTON LOADING === */
        #b2cSubmitBtn {
            position: relative;
            min-width: 180px;
        }

        #b2cSubmitBtn .b2c-submit-spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid currentColor;
            border-top-color: transparent;
            border-radius: 50%;
            animation: b2c-spin 0.6s linear infinite;
            margin-left: var(--space-2);
        }

        #b2cSubmitBtn.is-loading .b2c-submit-spinner {
            display: inline-block;
        }

        #b2cSubmitBtn.is-loading .b2c-submit-text {
            opacity: 0.7;
        }

        @keyframes b2c-spin {
            to { transform: rotate(360deg); }
        }

        /* === SUCCESS / ERROR === */
        .b2c-success {
            text-align: center;
            padding: var(--space-8) var(--space-4);
        }

        .b2c-success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto var(--space-5);
            border-radius: 50%;
            background-color: var(--color-botanical-pale);
            color: var(--color-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .b2c-success-icon svg {
            width: 40px;
            height: 40px;
        }

        .b2c-success-icon--error {
            background-color: #fef2f2;
            color: var(--color-error);
        }

        .b2c-success h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--color-text);
            margin: 0 0 var(--space-3);
        }

        .b2c-success p {
            font-size: 0.9375rem;
            color: var(--color-text-light);
            line-height: 1.6;
            margin: 0 0 var(--space-6);
        }

        .b2c-success-actions {
            display: inline-flex;
            gap: var(--space-3);
            flex-wrap: wrap;
            justify-content: center;
        }

        /* === RESPONSIVE === */
        @media (max-width: 1023px) {
            .b2c-section {
                padding: var(--space-7) 0 var(--space-8);
            }

            .b2c-layout {
                grid-template-columns: 1fr;
                gap: var(--space-6);
            }

            .b2c-sidebar {
                position: static;
            }

            .b2c-form-panel {
                padding: var(--space-6);
            }
        }

        @media (max-width: 767px) {
            .b2c-section {
                padding: var(--space-6) 0 var(--space-7);
            }

            .b2c-form-panel {
                padding: var(--space-5);
                border-radius: var(--radius-md);
            }

            .b2c-sidebar {
                padding: var(--space-5);
            }

            .b2c-step-label {
                display: none;
            }

            .b2c-step-divider {
                flex: 1;
            }

            .b2c-step-number {
                width: 28px;
                height: 28px;
                font-size: 0.8125rem;
            }

            .b2c-step-title {
                font-size: 1.25rem;
            }

            .b2c-step-subtitle {
                font-size: 0.875rem;
            }

            .b2c-radio-grid {
                grid-template-columns: 1fr;
                gap: var(--space-2);
            }

            .b2c-radio-card-content {
                padding: var(--space-3);
                min-height: 56px;
            }

            .b2c-radio-card-icon {
                width: 36px;
                height: 36px;
            }

            .b2c-radio-card-icon svg {
                width: 18px;
                height: 18px;
            }

            .b2c-grid-2 {
                grid-template-columns: 1fr;
                gap: var(--space-3);
            }

            .b2c-step-actions {
                flex-direction: column-reverse;
                gap: var(--space-3);
                margin-top: var(--space-6);
                padding-top: var(--space-5);
            }

            .b2c-step-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .b2c-step-actions .btn[data-action="prev"] svg {
                order: -1;
            }

            .b2c-step-actions .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: var(--space-2);
            }

            #b2cSubmitBtn {
                width: 100%;
            }
        }
    </style>

    @if(!$showSuccessScreen)
        <script>
        (function () {
            'use strict';

            const form         = document.getElementById('b2cForm');
            if (!form) return;

            const csrfToken    = document.querySelector('meta[name="csrf-token"]').content;
            const submitBtn    = document.getElementById('b2cSubmitBtn');
            const stepperSteps = form.parentElement.querySelectorAll('.b2c-step');
            const panels       = {
                1:       form.querySelector('.b2c-step-panel[data-step="1"]'),
                2:       form.querySelector('.b2c-step-panel[data-step="2"]'),
                success: form.querySelector('.b2c-step-panel[data-step="success"]'),
                error:   form.querySelector('.b2c-step-panel[data-step="error"]'),
            };

            // ── Validators ────────────────────────────────────────
            const validators = {
                required: (val) => val !== null && val !== undefined && String(val).trim() !== '' || 'Vui lòng nhập thông tin này.',
                email:    (val) => {
                    if (!val) return true;
                    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) || 'Email không đúng định dạng.';
                },
                url:      (val) => {
                    if (!val) return true;
                    try { new URL(val); return true; } catch (_) { return 'Đường dẫn không hợp lệ (phải bắt đầu bằng http:// hoặc https://).'; }
                },
                phone:    (val) => {
                    if (!val) return true;
                    return /^[0-9+\-\s().]+$/.test(val) || 'Số điện thoại không hợp lệ.';
                },
                integer:  (val) => {
                    if (val === '' || val === null) return true;
                    return /^-?\d+$/.test(String(val)) || 'Vui lòng nhập số nguyên.';
                },
                min:      (val, rule) => {
                    const n = Number(val);
                    if (val === '' || isNaN(n)) return true;
                    return n >= Number(rule) || `Giá trị tối thiểu là ${rule}.`;
                },
                max:      (val, rule) => {
                    if (val === null || val === undefined) return true;
                    return String(val).length <= Number(rule) || `Không được vượt quá ${rule} ký tự.`;
                },
            };

            function validateField(input) {
                const rules = (input.dataset.validate || '').split('|').filter(Boolean);
                if (!rules.length) return true;

                // Radio inputs share validation rules — handle as group.
                if (input.type === 'radio') {
                    const name     = input.name;
                    const group    = form.querySelectorAll(`input[name="${name}"]`);
                    const required = rules.includes('required');
                    const checked  = Array.from(group).some(r => r.checked);
                    if (required && !checked) return 'Vui lòng chọn một lựa chọn.';
                    return true;
                }

                const value = input.value;
                for (const rule of rules) {
                    let [key, param] = rule.split(':');
                    const fn = validators[key];
                    if (!fn) continue;
                    const result = fn(value, param);
                    if (result !== true) return result;
                }
                return true;
            }

            function clearFieldError(name) {
                const errorEl = form.querySelector(`[data-error-for="${name}"]`);
                if (errorEl) {
                    errorEl.textContent = '';
                    errorEl.classList.remove('is-visible');
                }
                form.querySelectorAll(`[name="${name}"]`).forEach(el => {
                    el.classList.remove('is-invalid');
                    const card = el.closest('.b2c-radio-card');
                    if (card) card.classList.remove('is-invalid');
                });
            }

            function showFieldError(name, message) {
                const errorEl = form.querySelector(`[data-error-for="${name}"]`);
                if (errorEl) {
                    errorEl.textContent = message;
                    errorEl.classList.add('is-visible');
                }
                form.querySelectorAll(`[name="${name}"]`).forEach(el => {
                    el.classList.add('is-invalid');
                    const card = el.closest('.b2c-radio-card');
                    if (card) card.classList.add('is-invalid');
                });
            }

            // ── Step navigation ───────────────────────────────────
            function showStep(stepNumber) {
                Object.entries(panels).forEach(([key, panel]) => {
                    if (!panel) return;
                    panel.hidden = String(key) !== String(stepNumber);
                });

                stepperSteps.forEach(stepEl => {
                    const s = Number(stepEl.dataset.step);
                    stepEl.classList.toggle('b2c-step--active', s === Number(stepNumber));
                    stepEl.classList.toggle('b2c-step--done', s < Number(stepNumber));
                });

                if (Number(stepNumber) <= 2) {
                    window.scrollTo({ top: form.getBoundingClientRect().top + window.scrollY - 100, behavior: 'smooth' });
                }
            }

            function validateStep(stepNumber) {
                const panel = panels[stepNumber];
                if (!panel) return true;

                let firstError = null;
                let valid = true;

                panel.querySelectorAll('[data-validate]').forEach(input => {
                    const result = validateField(input);
                    if (result === true) {
                        clearFieldError(input.name);
                    } else {
                        showFieldError(input.name, result);
                        if (!firstError) firstError = input;
                        valid = false;
                    }
                });

                if (firstError) {
                    if (firstError.type !== 'radio') {
                        firstError.focus({ preventScroll: false });
                    }
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                return valid;
            }

            // ── Form events ───────────────────────────────────────
            form.querySelectorAll('[data-action="next"]').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (validateStep(1)) {
                        showStep(2);
                    }
                });
            });

            form.querySelectorAll('[data-action="prev"]').forEach(btn => {
                btn.addEventListener('click', () => showStep(1));
            });

            // Live validation: clear error on input.
            form.querySelectorAll('[data-validate]').forEach(input => {
                input.addEventListener('input', () => clearFieldError(input.name));
                input.addEventListener('change', () => clearFieldError(input.name));
            });

            // ── Submit ────────────────────────────────────────────
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                if (!validateStep(2)) return;

                // Lock UI
                submitBtn.classList.add('is-loading');
                submitBtn.disabled = true;
                const originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="b2c-submit-text">Đang gửi...</span><span class="b2c-submit-spinner"></span>';
                submitBtn.classList.add('is-loading');

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify(Object.fromEntries(new FormData(form))),
                    });

                    let data = {};
                    try { data = await response.json(); } catch (_) {}

                    if (response.ok && data.success !== false) {
                        showStep('success');
                        // Hide stepper
                        const stepper = form.parentElement.querySelector('.b2c-stepper');
                        if (stepper) stepper.style.display = 'none';
                        return;
                    }

                    // Validation errors from server (Laravel 422).
                    if (response.status === 422 && data.errors) {
                        // Switch to step 2 if business errors are step 2 fields, otherwise step 1.
                        const hasStep1Error = Object.keys(data.errors).some(k => ['business_type','contact_name','contact_email'].includes(k));
                        showStep(hasStep1Error ? 1 : 2);
                        Object.entries(data.errors).forEach(([field, messages]) => {
                            const msg = Array.isArray(messages) ? messages[0] : messages;
                            showFieldError(field, msg);
                        });
                        return;
                    }

                    // Other failure
                    throw new Error(data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
                } catch (err) {
                    console.error('[B2C] Submit error:', err);
                    const errorPanel  = panels.error;
                    const errorMsgEl  = document.getElementById('b2cErrorMessage');
                    if (errorMsgEl) {
                        errorMsgEl.textContent = err.message || 'Vui lòng thử lại sau hoặc liên hệ với chúng tôi qua hotline.';
                    }
                    if (errorPanel) {
                        errorPanel.hidden = false;
                        Object.entries(panels).forEach(([k, p]) => { if (p && k !== 'error') p.hidden = true; });
                        const stepper = form.parentElement.querySelector('.b2c-stepper');
                        if (stepper) stepper.style.display = 'none';
                    }
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                    submitBtn.classList.remove('is-loading');
                }
            });

            // Reset
            const resetBtn = document.getElementById('b2cResetBtn');
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    form.reset();
                    form.querySelectorAll('.b2c-field-error').forEach(el => {
                        el.textContent = '';
                        el.classList.remove('is-visible');
                    });
                    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    const stepper = form.parentElement.querySelector('.b2c-stepper');
                    if (stepper) stepper.style.display = '';
                    showStep(1);
                });
            }

            const retryBtn = document.getElementById('b2cRetryBtn');
            if (retryBtn) {
                retryBtn.addEventListener('click', () => {
                    const stepper = form.parentElement.querySelector('.b2c-stepper');
                    if (stepper) stepper.style.display = '';
                    showStep(2);
                });
            }

            // ── Initial focus ─────────────────────────────────────
            const firstField = panels[1]?.querySelector('input:not([type="hidden"])');
            // Don't auto-focus to avoid jumping on page load.
        })();
        </script>
    @endif
@endsection
