@extends('layouts.admin')

@section('page-title', 'Chi Tiết Liên Hệ')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">Liên Hệ #{{ $inquiry->id }}</h1>
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline">Quay Lại</a>
    </div>

    <div class="admin-grid">
        <div class="admin-main">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Thông Tin Khách Hàng</h2>
                </div>
                <div class="admin-card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Tên</label>
                            <span>{{ $inquiry->name }}</span>
                        </div>
                        <div class="info-item">
                            <label>Điện thoại</label>
                            <span>{{ $inquiry->phone }}</span>
                        </div>
                        @if($inquiry->email)
                            <div class="info-item">
                                <label>Email</label>
                                <span>{{ $inquiry->email }}</span>
                            </div>
                        @endif
                        @if($inquiry->zalo_id)
                            <div class="info-item">
                                <label>Zalo ID</label>
                                <span>{{ $inquiry->zalo_id }}</span>
                            </div>
                        @endif
                    </div>
                    @if($inquiry->message)
                        <div class="message-box">
                            <label>Tin Nhắn</label>
                            <p>{{ $inquiry->message }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Sản Phẩm ({{ count($inquiry->product_ids ?? []) }})</h2>
                </div>
                <div class="admin-card-body">
                    <div class="products-list">
                        @foreach($inquiry->getProducts() as $product)
                            <div class="product-item">
                                <img src="{{ $product->getPrimaryImage() }}" alt="{{ $product->name }}">
                                <div class="product-info">
                                    <h4>{{ $product->name }}</h4>
                                    <p>{{ number_format($product->price, 0, ',', '.') }}₫</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-sidebar">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Trạng Thái</h2>
                </div>
                <div class="admin-card-body">
                    <form action="{{ route('admin.inquiries.updateStatus', $inquiry) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <select name="status" class="form-input">
                                <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>Mới</option>
                                <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>Đã liên hệ</option>
                                <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Cập Nhật Trạng Thái</button>
                    </form>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Chi Tiết</h2>
                </div>
                <div class="admin-card-body">
                    <div class="detail-list">
                        <div class="detail-item">
                            <label>Ngày Tạo</label>
                            <span>{{ $inquiry->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($inquiry->user)
                            <div class="detail-item">
                                <label>Tài Khoản</label>
                                <span class="badge badge-secondary">Thành viên</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
        gap: var(--space-1);
    }
    
    .info-item label {
        font-size: var(--font-size-sm);
        font-weight: var(--font-semibold);
        color: var(--color-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .message-box {
        margin-top: var(--space-6);
        padding-top: var(--space-6);
        border-top: 1px solid var(--color-border);
    }
    
    .message-box label {
        display: block;
        font-size: var(--font-size-sm);
        font-weight: var(--font-semibold);
        color: var(--color-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: var(--space-2);
    }
    
    .message-box p {
        line-height: 1.7;
        color: var(--color-text);
    }
    
    .products-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
    }
    
    .product-item {
        display: flex;
        gap: var(--space-3);
        padding: var(--space-3);
        background-color: var(--color-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
    }
    
    .product-item img {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-sm);
        object-fit: cover;
    }
    
    .product-info h4 {
        font-size: var(--font-size-base);
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-1);
    }
    
    .product-info p {
        font-size: var(--font-size-sm);
        color: var(--color-accent-warm);
        font-weight: var(--font-semibold);
    }
    
    .detail-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .detail-item label {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
    }
</style>
@endpush
@endsection
