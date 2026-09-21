@extends('layouts.admin')

@section('page-title', 'Chỉnh Sửa VIP Level')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Chỉnh Sửa VIP Level</h1>
        <p class="admin-page-subtitle">{{ $vipLevel->name }}</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.vip-levels.index') }}" class="btn btn-outline">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay lại
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.vip-levels.update', $vipLevel) }}" method="POST">
    @csrf
    @method('PATCH')

    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px;">
        {{-- Main Content --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Basic Info --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Thông Tin VIP Level</h2>
                </div>
                <div class="admin-card-body">
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div class="form-group">
                            <label for="name" class="form-label required">Tên VIP Level</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $vipLevel->name) }}" 
                                   class="form-input @error('name') form-input-error @enderror" 
                                   required>
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4" 
                                      class="form-input form-textarea @error('description') form-input-error @enderror">{{ old('description', $vipLevel->description) }}</textarea>
                            @error('description')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="priority" class="form-label required">Thứ tự ưu tiên</label>
                            <input type="number" 
                                   id="priority" 
                                   name="priority" 
                                   value="{{ old('priority', $vipLevel->priority) }}" 
                                   class="form-input @error('priority') form-input-error @enderror" 
                                   min="0" 
                                   required>
                            <small class="form-help">Số càng nhỏ, thứ tự hiển thị càng cao (0 = cao nhất)</small>
                            @error('priority')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $vipLevel->is_active) ? 'checked' : '' }}>
                                <span>Hoạt động</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Assignment --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Sản Phẩm Được Phép Hiển Thị</h2>
                    <p style="color: var(--admin-text-secondary); font-size: 14px; margin-top: 4px;">
                        Chọn các sản phẩm mà VIP level này có thể xem
                    </p>
                </div>
                <div class="admin-card-body">
                    <div style="margin-bottom: 16px;">
                        <input type="text" 
                               id="product-search" 
                               placeholder="Tìm kiếm sản phẩm..." 
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;">
                    </div>

                    <div style="display: flex; gap: 8px; margin-bottom: 16px;">
                        <button type="button" id="select-all" class="btn btn-sm btn-outline">Chọn tất cả</button>
                        <button type="button" id="deselect-all" class="btn btn-sm btn-outline">Bỏ chọn tất cả</button>
                        <span style="margin-left: auto; color: var(--admin-text-secondary); font-size: 14px; align-self: center;">
                            <span id="selected-count">{{ $vipLevel->products->count() }}</span> / {{ $allProducts->count() }} được chọn
                        </span>
                    </div>

                    <div id="product-list" style="max-height: 500px; overflow-y: auto; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md);">
                        @foreach($allProducts as $product)
                            <label class="product-item" data-product-name="{{ strtolower($product->name) }}" style="display: flex; align-items: center; padding: 12px 16px; border-bottom: 1px solid var(--admin-border); cursor: pointer; transition: background 0.2s;">
                                <input type="checkbox" 
                                       name="product_ids[]" 
                                       value="{{ $product->id }}" 
                                       class="product-checkbox"
                                       {{ $vipLevel->products->contains($product->id) ? 'checked' : '' }}
                                       style="margin-right: 12px;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 500; color: var(--admin-text-primary);">{{ $product->name }}</div>
                                    <div style="font-size: 13px; color: var(--admin-text-secondary); margin-top: 2px;">
                                        {{ number_format($product->price) }}đ
                                        @if($product->category)
                                            • {{ $product->category->name }}
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Submit --}}
            <div class="admin-card">
                <div class="admin-card-body">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Cập nhật
                    </button>
                </div>
            </div>

            {{-- User Stats --}}
            @if($vipLevel->users->count() > 0)
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Người Dùng</h2>
                </div>
                <div class="admin-card-body">
                    <div style="text-align: center;">
                        <div style="font-size: 32px; font-weight: 700; color: var(--admin-text-primary);">
                            {{ $vipLevel->users->count() }}
                        </div>
                        <div style="font-size: 14px; color: var(--admin-text-secondary); margin-top: 4px;">
                            người dùng
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</form>

{{-- User List for this VIP Level --}}
@if($vipLevel->users->count() > 0)
<div class="admin-card" style="margin-top: 24px;">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Danh Sách Người Dùng ({{ $vipLevel->users->count() }})</h2>
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th style="width: 100px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vipLevel->users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-mono">{{ $user->phone ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn-icon" 
                                   title="Xem chi tiết">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('product-search');
    const productItems = document.querySelectorAll('.product-item');
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const selectedCountEl = document.getElementById('selected-count');
    const selectAllBtn = document.getElementById('select-all');
    const deselectAllBtn = document.getElementById('deselect-all');

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        productItems.forEach(item => {
            const productName = item.dataset.productName;
            if (productName.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Update count
    function updateCount() {
        const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
        selectedCountEl.textContent = checkedCount;
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateCount);
    });

    // Select all
    selectAllBtn.addEventListener('click', function() {
        const visibleCheckboxes = Array.from(checkboxes).filter(cb => {
            return cb.closest('.product-item').style.display !== 'none';
        });
        visibleCheckboxes.forEach(cb => cb.checked = true);
        updateCount();
    });

    // Deselect all
    deselectAllBtn.addEventListener('click', function() {
        const visibleCheckboxes = Array.from(checkboxes).filter(cb => {
            return cb.closest('.product-item').style.display !== 'none';
        });
        visibleCheckboxes.forEach(cb => cb.checked = false);
        updateCount();
    });

    // Hover effect
    productItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.background = 'var(--admin-bg-secondary)';
        });
        item.addEventListener('mouseleave', function() {
            this.style.background = 'transparent';
        });
    });
});
</script>
@endpush
@endsection
