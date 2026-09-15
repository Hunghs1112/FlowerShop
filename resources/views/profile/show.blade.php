@extends('layouts.app')

@section('title', 'Tài khoản')

@section('content')
<x-page-hero 
    title="Tài khoản"
    description="Quản lý thông tin cá nhân và đơn hàng"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Tài khoản']
    ]"
    height="350px"
/>

<div class="container page-wrapper">
    <div class="account-layout">
        <!-- Account Sidebar -->
        <aside class="account-sidebar">
            <div class="account-user">
                <div class="account-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="account-user-info">
                    <h3>{{ auth()->user()->name }}</h3>
                    <p>{{ auth()->user()->email }}</p>
                </div>
            </div>

            <nav class="account-nav">
                <a href="{{ route('profile.show') }}" class="account-nav-item active">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Hồ sơ
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="account-nav-item">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Đăng xuất
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Account Main Content -->
        <div class="account-main">
            <!-- Profile Information -->
            <div class="account-card">
                <div class="account-card-header">
                    <h2 class="account-card-title">Thông tin hồ sơ</h2>
                </div>
                <div class="account-card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" id="name" name="name" 
                                       value="{{ old('name', auth()->user()->name) }}" 
                                       class="form-input @error('name') error @enderror" required>
                                @error('name')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email', auth()->user()->email) }}" 
                                       class="form-input @error('email') error @enderror" required>
                                @error('email')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}" 
                                       class="form-input @error('phone') error @enderror">
                                @error('phone')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <textarea id="address" name="address" rows="3" 
                                          class="form-input @error('address') error @enderror">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="account-card">
                <div class="account-card-header">
                    <h2 class="account-card-title">Đổi mật khẩu</h2>
                </div>
                <div class="account-card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="form-input @error('current_password') error @enderror" required>
                            @error('current_password')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" id="password" name="password" 
                                       class="form-input @error('password') error @enderror" required>
                                @error('password')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="form-input" required>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Inquiry History -->
            <div class="account-card">
                <div class="account-card-header">
                    <h2 class="account-card-title">Yêu cầu của tôi</h2>
                </div>
                <div class="account-card-body">
                    @if($inquiries->count() > 0)
                        <div class="inquiry-list">
                            @foreach($inquiries as $inquiry)
                                <div class="inquiry-item">
                                    <div class="inquiry-header">
                                        <div class="inquiry-id">#{{ $inquiry->id }}</div>
                                        <span class="badge badge-{{ $inquiry->status }}">
                                            {{ ucfirst($inquiry->status) }}
                                        </span>
                                    </div>
                                    <div class="inquiry-meta">
                                        <span>{{ $inquiry->created_at->format('M d, Y \a\t H:i') }}</span>
                                        <span>•</span>
                                        <span>{{ count($inquiry->product_ids ?? []) }} sản phẩm</span>
                                    </div>
                                    @if($inquiry->message)
                                        <p class="inquiry-message">{{ Str::limit($inquiry->message, 100) }}</p>
                                    @endif
                                    <div class="inquiry-products">
                                        @foreach($inquiry->getProducts() as $product)
                                            <a href="{{ route('products.show', $product->display_slug) }}" class="inquiry-product">
                                                <img src="{{ $product->getPrimaryImageUrl() }}" alt="{{ $product->name }}">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state-sm">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p>Bạn chưa có yêu cầu nào.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Xem sản phẩm</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
