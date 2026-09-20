@extends('layouts.admin')

@section('page-title', 'Cài Đặt')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Cài Đặt Hệ Thống</h1>
        <p class="admin-page-subtitle">
            <span style="display: inline-flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></span>
                Tự động lưu đã bật
            </span>
        </p>
    </div>
</div>

{{-- Tabs Navigation --}}
<div class="settings-tabs" style="margin-bottom: 24px;">
    <div class="settings-tabs-nav" style="display: flex; gap: 8px; border-bottom: 2px solid var(--admin-border); padding-bottom: 0;">
        <button class="settings-tab-btn active" data-tab="general" style="padding: 12px 20px; background: none; border: none; border-bottom: 2px solid var(--admin-primary); margin-bottom: -2px; font-weight: 600; color: var(--admin-primary); cursor: pointer; font-size: 14px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 6px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Cài Đặt Chung
        </button>
        <button class="settings-tab-btn" data-tab="banners" style="padding: 12px 20px; background: none; border: none; border-bottom: 2px solid transparent; margin-bottom: -2px; font-weight: 500; color: var(--admin-text-secondary); cursor: pointer; font-size: 14px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 6px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Ảnh Header Trang
        </button>
    </div>
</div>

{{-- Tab Content: General Settings --}}
<div class="settings-tab-content" data-tab-content="general" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
    {{-- General Settings --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                Cài Đặt Chung
            </h2>
        </div>
        <div class="admin-card-body">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tên Trang Web</label>
                <input type="text" 
                       name="site_name" 
                       value="{{ old('site_name', $settings['site_name'] ?? 'Lâm Nhiên Thảo') }}" 
                       class="settings-auto-save"
                       style="width: 100%;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Slogan</label>
                <input type="text" 
                       name="site_tagline" 
                       value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả Trang Web</label>
                <textarea name="site_description" 
                          rows="3" 
                          class="settings-auto-save"
                          style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Logo Trang Web</label>
                <input type="file" 
                       name="site_logo" 
                       accept="image/*" 
                       class="settings-auto-save-file"
                       data-upload-url="{{ route('admin.settings.uploadLogo') }}"
                       style="width: 100%;">
                <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Kích thước khuyến nghị: 200x60px. Định dạng: jpg, png, gif, webp.</small>
                @if(!empty($settings['site_logo']))
                    <div style="margin-top: 12px; display: flex; align-items: center; gap: 12px;">
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" style="max-height: 60px; border: 1px solid var(--admin-border); border-radius: 6px; padding: 4px; background: #fff;">
                        <button type="button" class="btn btn-secondary btn-sm js-delete-logo"
                                data-url="{{ route('admin.settings.deleteLogo') }}"
                                data-confirm="Xóa logo hiện tại?">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Xóa logo
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Contact Information --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                Thông Tin Liên Hệ
            </h2>
        </div>
        <div class="admin-card-body">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Email</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email', $settings['email'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Điện Thoại</label>
                <input type="text" 
                       name="phone" 
                       value="{{ old('phone', $settings['phone'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Địa Chỉ</label>
                <textarea name="address" 
                          rows="2" 
                          class="settings-auto-save"
                          style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;">{{ old('address', $settings['address'] ?? '') }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Zalo ID</label>
                <input type="text" 
                       name="zalo_id" 
                       value="{{ old('zalo_id', $settings['zalo_id'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;" 
                       placeholder="Số điện thoại đăng ký Zalo">
            </div>

            <div class="form-group">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Giới thiệu</label>
                <textarea name="about" 
                          rows="3" 
                          class="settings-auto-save"
                          style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;" 
                          placeholder="Mô tả ngắn về cửa hàng...">{{ old('about', $settings['about'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Social Media --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                    </svg>
                </div>
                Mạng Xã Hội
            </h2>
        </div>
        <div class="admin-card-body">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Facebook</label>
                <input type="url" 
                       name="facebook_url" 
                       value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;" 
                       placeholder="https://facebook.com/...">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Instagram</label>
                <input type="url" 
                       name="instagram_url" 
                       value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;" 
                       placeholder="https://instagram.com/...">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">TikTok</label>
                <input type="url" 
                       name="tiktok_url" 
                       value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;" 
                       placeholder="https://tiktok.com/@...">
            </div>

            <div class="form-group">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">YouTube</label>
                <input type="url" 
                       name="social_youtube" 
                       value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;" 
                       placeholder="https://youtube.com/...">
            </div>
        </div>
    </div>

    {{-- Business Hours --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                Giờ Làm Việc
            </h2>
        </div>
        <div class="admin-card-body">
            <div class="form-group">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Giờ Hoạt Động</label>
                <textarea name="business_hours" 
                          rows="6" 
                          class="settings-auto-save"
                          style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical; font-family: var(--admin-font-mono);">{{ old('business_hours', $settings['business_hours'] ?? "Thứ 2 - Thứ 6: 8:00 - 18:00\nThứ 7: 8:00 - 17:00\nChủ nhật: 9:00 - 16:00") }}</textarea>
            </div>
        </div>
    </div>

    {{-- SEO Settings --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                Cài Đặt SEO
            </h2>
        </div>
        <div class="admin-card-body">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tiêu Đề Meta</label>
                <input type="text" 
                       name="meta_title" 
                       value="{{ old('meta_title', $settings['meta_title'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả Meta</label>
                <textarea name="meta_description" 
                          rows="3" 
                          class="settings-auto-save"
                          style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Từ Khóa</label>
                <input type="text" 
                       name="meta_keywords" 
                       value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;" 
                       placeholder="hoa, shop, giao hàng">
            </div>
        </div>
    </div>

    {{-- Email Settings --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                Cài Đặt Email
            </h2>
        </div>
        <div class="admin-card-body">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Email Nhận Đơn Hàng</label>
                <input type="email" 
                       name="order_notification_email" 
                       value="{{ old('order_notification_email', $settings['order_notification_email'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;">
            </div>

            <div class="form-group">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Email Nhận Liên Hệ</label>
                <input type="email" 
                       name="contact_form_email" 
                       value="{{ old('contact_form_email', $settings['contact_form_email'] ?? '') }}" 
                       class="settings-auto-save"
                       style="width: 100%;">
            </div>
        </div>
    </div>

</div>

{{-- Tab Content: Banners --}}
<div class="settings-tab-content" data-tab-content="banners" style="display: none;">
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                Ảnh Header Trang
            </h2>
        </div>
        <div class="admin-card-body">
            <p style="color: var(--admin-text-secondary); margin-bottom: 24px; padding: 12px; background: #eff6ff; border-left: 3px solid #3b82f6; border-radius: 6px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 6px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <strong>Kích thước khuyến nghị:</strong> 1600×600px (tỷ lệ 8:3) | <strong>Định dạng:</strong> JPG, PNG, WEBP | <strong>Dung lượng:</strong> Tối đa 4MB
            </p>
            
            <div class="banner-settings-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                @php
                $bannerFields = [
                    'home'       => ['Trang chủ', '🏠'],
                    'products'   => ['Sản phẩm', '🌸'],
                    'categories' => ['Danh mục', '📁'],
                    'blog'       => ['Bài viết', '📝'],
                    'about'      => ['Giới thiệu', 'ℹ️'],
                    'contact'    => ['Liên hệ', '📞'],
                    'cart'       => ['Giỏ hàng', '🛒'],
                    'checkout'   => ['Thanh toán', '💳'],
                ];
                @endphp
                @foreach($bannerFields as $key => [$label, $icon])
                <div class="banner-field-item" style="padding: 20px; border: 1px solid var(--admin-border); border-radius: 8px; background: #fafafa;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 12px;">
                        <span style="font-size: 18px; margin-right: 6px;">{{ $icon }}</span>
                        {{ $label }}
                    </label>
                    
                    @if(isset($banners[$key]) && $banners[$key])
                        <div class="banner-preview" style="margin-bottom: 12px; border: 2px solid var(--admin-border); border-radius: 8px; overflow: hidden; position: relative; background: #fff;">
                            <img src="{{ $banners[$key] }}" alt="{{ $label }}" style="width: 100%; height: auto; display: block;">
                            <div style="position: absolute; bottom: 8px; right: 8px; display: flex; gap: 8px;">
                                <button type="button"
                                        class="btn btn-secondary btn-sm js-delete-banner"
                                        data-url="{{ route('admin.settings.deleteBanner', ['key' => $key]) }}"
                                        data-confirm="Xóa ảnh header '{{ $label }}'?"
                                        style="background: rgba(239, 68, 68, 0.95); color: white; padding: 6px 12px; font-size: 12px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Xóa
                                </button>
                            </div>
                        </div>
                    @else
                        <div style="margin-bottom: 12px; padding: 40px; border: 2px dashed var(--admin-border); border-radius: 8px; text-align: center; background: #f9f9f9; color: var(--admin-text-muted);">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 8px; opacity: 0.3;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p style="font-size: 13px;">Chưa có ảnh</p>
                        </div>
                    @endif
                    
                    <input type="file" 
                           name="banner_{{ $key }}" 
                           accept="image/*" 
                           class="settings-auto-save-banner"
                           data-field="banner_{{ $key }}"
                           data-upload-url="{{ route('admin.settings.uploadBanner', ['key' => $key]) }}"
                           style="width: 100%; padding: 10px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 13px; cursor: pointer;">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/admin-auto-save.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    // Tab switching
    const tabButtons = document.querySelectorAll('.settings-tab-btn');
    const tabContents = document.querySelectorAll('.settings-tab-content');
    
    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Update button states
            tabButtons.forEach(b => {
                b.classList.remove('active');
                b.style.borderBottomColor = 'transparent';
                b.style.color = 'var(--admin-text-secondary)';
                b.style.fontWeight = '500';
            });
            this.classList.add('active');
            this.style.borderBottomColor = 'var(--admin-primary)';
            this.style.color = 'var(--admin-primary)';
            this.style.fontWeight = '600';
            
            // Update content visibility
            tabContents.forEach(content => {
                if (content.dataset.tabContent === targetTab) {
                    content.style.display = targetTab === 'general' ? 'grid' : 'block';
                } else {
                    content.style.display = 'none';
                }
            });
        });
    });

    async function handleDelete(button) {
        if (!confirm(button.dataset.confirm || 'Bạn có chắc?')) {
            return;
        }
        button.disabled = true;
        try {
            const res = await fetch(button.dataset.url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });
            if (res.ok) {
                location.reload();
            } else {
                Toast.error('Xóa thất bại. Vui lòng thử lại.');
                button.disabled = false;
            }
        } catch (err) {
            console.error(err);
            Toast.error('Lỗi mạng. Vui lòng thử lại.');
            button.disabled = false;
        }
    }

    document.querySelectorAll('.js-delete-logo, .js-delete-banner').forEach(function (btn) {
        btn.addEventListener('click', function () { handleDelete(btn); });
    });

    // Banner file upload
    document.querySelectorAll('.settings-auto-save-banner').forEach(function(input) {
        input.addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const field = input.dataset.field;
            const uploadUrl = input.dataset.uploadUrl;
            
            Toast.info('Đang tải lên...');

            const formData = new FormData();
            formData.append('file', file);
            formData.append('field', field);

            try {
                const res = await fetch(uploadUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (res.ok) {
                    Toast.success('Đã tải lên');
                    setTimeout(() => location.reload(), 500);
                } else {
                    Toast.error('Tải lên thất bại');
                }
            } catch (err) {
                console.error(err);
                Toast.error('Lỗi kết nối');
            }
        });
    });
});
</script>
@endpush
@endsection
