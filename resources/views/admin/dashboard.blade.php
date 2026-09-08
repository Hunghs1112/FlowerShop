@extends('layouts.admin')

@section('page-title', 'Bảng Điều Khiển')

@section('content')
<div class="admin-content">
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Tổng Sản Phẩm</div>
                <div class="stat-value">{{ $stats['products'] }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-accent">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Danh Mục</div>
                <div class="stat-value">{{ $stats['categories'] }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Liên Hệ</div>
                <div class="stat-value">{{ $stats['inquiries'] }}</div>
                @if($stats['new_inquiries'] > 0)
                    <div class="stat-badge">{{ $stats['new_inquiries'] }} mới</div>
                @endif
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Người Dùng</div>
                <div class="stat-value">{{ $stats['users'] }}</div>
            </div>
        </div>
    </div>

    <div class="admin-grid">
        <!-- Recent Inquiries -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Liên Hệ Gần Đây</h2>
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline">Xem Tất Cả</a>
            </div>
            <div class="admin-card-body">
                @if($recentInquiries->count() > 0)
                    <div class="admin-table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Khách Hàng</th>
                                    <th>Điện Thoại</th>
                                    <th>Sản Phẩm</th>
                                    <th>Trạng Thái</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentInquiries as $inquiry)
                                    <tr>
                                        <td><span class="text-mono">#{{ $inquiry->id }}</span></td>
                                        <td>{{ $inquiry->name }}</td>
                                        <td>{{ $inquiry->phone }}</td>
                                        <td>{{ count($inquiry->product_ids ?? []) }} sản phẩm</td>
                                        <td><span class="badge badge-{{ $inquiry->status }}">{{ $inquiry->status == 'pending' ? 'Chờ xử lý' : ($inquiry->status == 'contacted' ? 'Đã liên hệ' : 'Hoàn thành') }}</span></td>
                                        <td>{{ $inquiry->created_at->format('d/m, H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state-sm">
                        <p>Chưa có liên hệ nào</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Cảnh Báo Tồn Kho Thấp</h2>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline">Tất Cả Sản Phẩm</a>
            </div>
            <div class="admin-card-body">
                @if($lowStockProducts->count() > 0)
                    <div class="stock-list">
                        @foreach($lowStockProducts as $product)
                            <div class="stock-item">
                                <div class="stock-product">
                                    <img src="{{ $product->getPrimaryImage() }}" alt="{{ $product->name }}">
                                    <div>
                                        <div class="stock-name">{{ $product->name }}</div>
                                        <div class="stock-category">{{ $product->category->name ?? 'Chưa phân loại' }}</div>
                                    </div>
                                </div>
                                <div class="stock-quantity">
                                    <span class="badge badge-{{ $product->stock == 0 ? 'danger' : 'warning' }}">
                                        Còn {{ $product->stock }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-sm">
                        <p>Tất cả sản phẩm đều đủ hàng</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: var(--space-6);
        margin-bottom: var(--space-8);
    }
    
    .stat-card {
        display: flex;
        gap: var(--space-4);
        padding: var(--space-6);
        background-color: var(--color-bg-secondary);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        flex-shrink: 0;
    }
    
    .stat-icon-primary {
        background-color: rgba(56, 189, 248, 0.1);
        color: var(--color-accent-cool);
    }
    
    .stat-icon-accent {
        background-color: rgba(249, 115, 22, 0.1);
        color: var(--color-accent-warm);
    }
    
    .stat-icon-warning {
        background-color: rgba(245, 158, 11, 0.1);
        color: #F59E0B;
    }
    
    .stat-icon-success {
        background-color: rgba(34, 211, 238, 0.1);
        color: #22D3EE;
    }
    
    .stat-content {
        flex: 1;
    }
    
    .stat-label {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
        margin-bottom: var(--space-1);
    }
    
    .stat-value {
        font-size: var(--font-size-3xl);
        font-weight: var(--font-bold);
    }
    
    .stat-badge {
        display: inline-block;
        margin-top: var(--space-2);
        padding: var(--space-1) var(--space-2);
        background-color: var(--color-accent-warm);
        color: white;
        font-size: var(--font-size-xs);
        font-weight: var(--font-semibold);
        border-radius: var(--radius-sm);
    }
    
    .admin-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: var(--space-6);
    }
    
    @media (max-width: 1200px) {
        .admin-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .stock-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
    }
    
    .stock-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-3);
        background-color: var(--color-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
    }
    
    .stock-product {
        display: flex;
        gap: var(--space-3);
        align-items: center;
    }
    
    .stock-product img {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-sm);
        object-fit: cover;
    }
    
    .stock-name {
        font-weight: var(--font-semibold);
        font-size: var(--font-size-sm);
    }
    
    .stock-category {
        font-size: var(--font-size-xs);
        color: var(--color-text-secondary);
    }
    
    .text-mono {
        font-family: var(--font-mono);
    }
    
    .empty-state-sm {
        text-align: center;
        padding: var(--space-8);
        color: var(--color-text-secondary);
    }
</style>
@endpush
@endsection
