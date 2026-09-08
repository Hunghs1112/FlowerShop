@extends('layouts.admin')

@section('page-title', 'Cài Đặt')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">Cài Đặt Hệ Thống</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="settings-grid">
            <!-- General Settings -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Cài Đặt Chung</h2>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label required">Tên Trang Web</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Lâm Nhiên Thảo') }}" 
                               class="form-input @error('site_name') error @enderror" required>
                        @error('site_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Slogan</label>
                        <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" 
                               class="form-input @error('site_tagline') error @enderror">
                        @error('site_tagline')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mô Tả Trang Web</label>
                        <textarea name="site_description" rows="3" 
                                  class="form-input @error('site_description') error @enderror">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                        @error('site_description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Logo Trang Web</label>
                        <input type="file" name="site_logo" accept="image/*" class="form-input">
                        <small class="form-help">Kích thước khuyến nghị: 200x60px</small>
                        @if(isset($settings['site_logo']))
                            <div class="existing-image">
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" style="max-width: 200px; margin-top: 1rem;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Thông Tin Liên Hệ</h2>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}" 
                               class="form-input @error('email') error @enderror">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Điện Thoại</label>
                        <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" 
                               class="form-input @error('phone') error @enderror">
                        @error('phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Địa Chỉ</label>
                        <textarea name="address" rows="3" 
                                  class="form-input @error('address') error @enderror">{{ old('address', $settings['address'] ?? '') }}</textarea>
                        @error('address')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Zalo ID / Số điện thoại Zalo</label>
                        <input type="text" name="zalo_id" value="{{ old('zalo_id', $settings['zalo_id'] ?? '') }}" 
                               class="form-input @error('zalo_id') error @enderror" placeholder="Số điện thoại đăng ký Zalo">
                        @error('zalo_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Giới thiệu về cửa hàng</label>
                        <textarea name="about" rows="4" 
                                  class="form-input @error('about') error @enderror" placeholder="Mô tả ngắn về cửa hàng...">{{ old('about', $settings['about'] ?? '') }}</textarea>
                        @error('about')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Mạng Xã Hội</h2>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label">Facebook</label>
                        <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" 
                               class="form-input @error('facebook_url') error @enderror" placeholder="https://facebook.com/...">
                        @error('facebook_url')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Instagram</label>
                        <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" 
                               class="form-input @error('instagram_url') error @enderror" placeholder="https://instagram.com/...">
                        @error('instagram_url')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Twitter</label>
                        <input type="url" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}" 
                               class="form-input @error('social_twitter') error @enderror" placeholder="https://twitter.com/...">
                        @error('social_twitter')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">YouTube</label>
                        <input type="url" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" 
                               class="form-input @error('social_youtube') error @enderror" placeholder="https://youtube.com/...">
                        @error('social_youtube')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Cài Đặt SEO</h2>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label">Tiêu Đề Meta</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $settings['meta_title'] ?? '') }}" 
                               class="form-input @error('meta_title') error @enderror">
                        @error('meta_title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mô Tả Meta</label>
                        <textarea name="meta_description" rows="3" 
                                  class="form-input @error('meta_description') error @enderror">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                        @error('meta_description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Từ Khóa Meta</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}" 
                               class="form-input @error('meta_keywords') error @enderror" placeholder="hoa, shop, giao hàng">
                        @error('meta_keywords')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Google Analytics ID</label>
                        <input type="text" name="google_analytics" value="{{ old('google_analytics', $settings['google_analytics'] ?? '') }}" 
                               class="form-input @error('google_analytics') error @enderror" placeholder="G-XXXXXXXXXX">
                        @error('google_analytics')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Business Hours -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Giờ Làm Việc</h2>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label">Giờ Hoạt Động</label>
                        <textarea name="business_hours" rows="5" 
                                  class="form-input @error('business_hours') error @enderror">{{ old('business_hours', $settings['business_hours'] ?? "Thứ 2 - Thứ 6: 8:00 - 18:00\nThứ 7: 8:00 - 17:00\nChủ nhật: 9:00 - 16:00") }}</textarea>
                        @error('business_hours')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Cài Đặt Email</h2>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label">Email Nhận Thông Báo Đơn Hàng</label>
                        <input type="email" name="order_notification_email" value="{{ old('order_notification_email', $settings['order_notification_email'] ?? '') }}" 
                               class="form-input @error('order_notification_email') error @enderror">
                        <small class="form-help">Email để nhận thông báo đơn hàng</small>
                        @error('order_notification_email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Nhận Liên Hệ</label>
                        <input type="email" name="contact_form_email" value="{{ old('contact_form_email', $settings['contact_form_email'] ?? '') }}" 
                               class="form-input @error('contact_form_email') error @enderror">
                        <small class="form-help">Email để nhận thông tin liên hệ từ khách hàng</small>
                        @error('contact_form_email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Lưu Cài Đặt
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-6);
    }
    
    .admin-title {
        font-size: var(--font-size-2xl);
        font-weight: var(--font-bold);
    }
    
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-6);
    }
    
    @media (max-width: 1024px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .form-help {
        display: block;
        margin-top: var(--space-2);
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
    }
    
    .existing-image img {
        border-radius: var(--radius-md);
        border: 1px solid var(--color-border);
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
    }
</style>
@endpush
@endsection
