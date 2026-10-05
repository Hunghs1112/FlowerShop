@extends('layouts.app')

@section('title', 'Tài khoản')

@section('content')
<section class="profile-page">
<div class="container profile-container">
    <header class="profile-heading">
        <div>
            <p class="profile-eyebrow">KHÔNG GIAN CỦA BẠN</p>
            <h1>Tài khoản</h1>
            <p class="profile-heading-copy">Quản lý thông tin cá nhân và theo dõi những yêu cầu đặt hoa của bạn.</p>
        </div>
        <a class="profile-back-link" href="{{ route('home') }}">← Tiếp tục mua sắm</a>
    </header>

    <div class="profile-dashboard">
        <aside class="profile-sidebar" aria-label="Tóm tắt tài khoản">
            <div class="profile-identity">
                <div class="profile-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <div class="profile-identity-copy">
                    <span class="profile-kicker">THÀNH VIÊN</span>
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>
                </div>
            </div>
            <nav class="profile-nav" aria-label="Điều hướng tài khoản">
                <a href="#profile-information"><span>01</span> Thông tin hồ sơ</a>
                <a href="#profile-password"><span>02</span> Bảo mật</a>
                <a href="#profile-inquiries"><span>03</span> Yêu cầu của tôi <i>{{ $inquiries->total() }}</i></a>
            </nav>
            <p class="profile-sidebar-note">Thông tin của bạn được sử dụng để hỗ trợ các đơn hoa và yêu cầu tư vấn.</p>
        </aside>

        <!-- Account Main Content -->
        <div class="account-main profile-main">
            <!-- Profile Information -->
            <div class="account-card" id="profile-information">
                <div class="account-card-header">
                    <h2 class="account-card-title">Thông tin hồ sơ</h2>
                    <p>Cập nhật cách chúng tôi liên hệ với bạn.</p>
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
            <div class="account-card" id="profile-password">
                <div class="account-card-header">
                    <h2 class="account-card-title">Đổi mật khẩu</h2>
                    <p>Dùng mật khẩu mạnh để bảo vệ tài khoản của bạn.</p>
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
            <div class="account-card" id="profile-inquiries">
                <div class="account-card-header">
                    <h2 class="account-card-title">Yêu cầu của tôi</h2>
                    <p>Lịch sử tư vấn và yêu cầu đặt hoa.</p>
                </div>
                <div class="account-card-body">
                    @if($inquiries->count() > 0)
                        <div class="inquiry-list">
                            @foreach($inquiries as $inquiry)
                                <div class="inquiry-item">
                                    <div class="inquiry-header">
                                        <div class="inquiry-id">#{{ $inquiry->id }}</div>
                                        <span class="badge badge-{{ $inquiry->status }}">
                                            {{ match($inquiry->status) {'new' => 'Mới', 'contacted' => 'Đã liên hệ', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã hủy', default => ucfirst($inquiry->status)} }}
                                        </span>
                                    </div>
                                    <div class="inquiry-meta">
                                        <span>{{ $inquiry->created_at->format('d/m/Y · H:i') }}</span>
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
</section>

@endsection
