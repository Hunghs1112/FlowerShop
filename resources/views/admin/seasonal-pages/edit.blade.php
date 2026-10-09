@extends('layouts.admin')

@section('page-title', 'Sửa: ' . $season['label'])

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('admin.seasonal-pages.index') }}" class="btn btn-secondary" style="padding: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="admin-page-title">{{ $season['label'] }}</h1>
                <p class="admin-page-subtitle">Cập nhật nội dung và sản phẩm hiển thị</p>
            </div>
        </div>
    </div>
    <div class="admin-page-actions">
        <button type="button" class="btn btn-primary" id="saveBtn">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Lưu Thay Đổi
        </button>
    </div>
</div>

<form id="seasonalForm" method="POST" action="{{ route('admin.seasonal-pages.update', $seasonId) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="product_ids" id="productIds" value="">
    <input type="hidden" name="data[season_id]" value="{{ $seasonId }}">

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 24px; align-items: start;">
        {{-- Left Column: Content --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">

            {{-- Hero Image --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Ảnh Hero</h2>
                </div>
                <div class="admin-card-body">
                    <div class="hero-preview" id="heroPreview" style="border-radius: 8px; overflow: hidden; border: 2px dashed var(--admin-border); background: var(--admin-bg-subtle); min-height: 180px; display: flex; align-items: center; justify-content: center;">
                        @if($heroImage)
                            <img src="{{ $heroImage }}" alt="Hero" style="width: 100%; height: 180px; object-fit: cover; display: block;">
                        @else
                            <div style="padding: 40px; text-align: center; color: var(--admin-text-muted);">
                                <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 8px; opacity: .3; display: block;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p style="font-size: 13px; margin: 0;">Chưa có ảnh hero</p>
                            </div>
                        @endif
                    </div>
                    <div style="margin-top: 12px; display: flex; gap: 8px;">
                        <label style="flex: 1;">
                            <span class="btn btn-secondary" style="width: 100%; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Tải Ảnh Lên
                                <input type="file" accept="image/*" id="heroUpload" style="display: none;">
                            </span>
                        </label>
                        @if($heroImage)
                            <button type="button" class="btn btn-secondary" id="deleteHeroBtn" style="padding: 8px 12px;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                    <p style="font-size: 12px; color: var(--admin-text-muted); margin: 8px 0 0;">Kích thước khuyến nghị: 1920 × 600px</p>
                </div>
            </div>

            {{-- Basic Info --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Thông Tin Cơ Bản</h2>
                </div>
                <div class="admin-card-body" style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Tên Trang</label>
                        <input type="text" name="data[name]" value="{{ $data['name'] ?? '' }}" class="form-input" placeholder="VD: Hội Mùa Thu" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Tagline</label>
                        <input type="text" name="data[tagline]" value="{{ $data['tagline'] ?? '' }}" class="form-input" placeholder="VD: Chuyến bay mùa lá đỏ" style="width: 100%;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Trạng Thái</label>
                            <input type="text" name="data[status]" value="{{ $data['status'] ?? '' }}" class="form-input" placeholder="VD: Đang bay" style="width: 100%;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Ngày</label>
                            <input type="date" name="data[date]" value="{{ $data['date'] ?? '' }}" class="form-input" style="width: 100%;">
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Giới Thiệu</label>
                        <textarea name="data[intro]" rows="3" class="form-input" placeholder="Mô tả ngắn về trang..." style="width: 100%; resize: vertical;">{{ $data['intro'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- CTA Section --}}
            @if(isset($data['cta']) || isset($data['extra']))
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Nút Gọi Hành Động</h2>
                </div>
                <div class="admin-card-body" style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Nhãn Nút</label>
                        <input type="text" name="data[cta][label]" value="{{ $data['cta']['label'] ?? '' }}" class="form-input" placeholder="VD: Xem bộ sưu tập" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Liên Kết</label>
                        <input type="text" name="data[cta][link]" value="{{ $data['cta']['link'] ?? '' }}" class="form-input" placeholder="/san-pham" style="width: 100%;">
                    </div>
                    @if(isset($data['extra']))
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Link Bổ Sung</label>
                        <input type="text" name="data[extra][label]" value="{{ $data['extra']['label'] ?? '' }}" class="form-input" placeholder="Nhãn link" style="width: 100%; margin-bottom: 6px;">
                        <input type="text" name="data[extra][link]" value="{{ $data['extra']['link'] ?? '' }}" class="form-input" placeholder="/bai-viet" style="width: 100%;">
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Tree Options (only for thong/danish tree) --}}
            @if($seasonId === 'thong' && isset($data['tree']))
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Cây Thông - Tùy Chọn</h2>
                </div>
                <div class="admin-card-body" style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Deadline Đặt Trước</label>
                        <input type="date" name="data[tree][deadline]" value="{{ $data['tree']['deadline'] ?? '' }}" class="form-input" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Ngày Hàng Về</label>
                        <input type="text" name="data[tree][arrival]" value="{{ $data['tree']['arrival'] ?? '' }}" class="form-input" placeholder="[ngày hàng về dự kiến]" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Mức Cọc</label>
                        <input type="text" name="data[tree][deposit]" value="{{ $data['tree']['deposit'] ?? '' }}" class="form-input" placeholder="[mức cọc, ví dụ 50%]" style="width: 100%;">
                    </div>
                </div>
            </div>
            @endif

            {{-- Trick or Treat (Halloween only) --}}
            @if($seasonId === 'halloween' && isset($data['trickTreat']))
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Hộp Hoa Bí Ẩn</h2>
                </div>
                <div class="admin-card-body" style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Tiêu Đề</label>
                        <input type="text" name="data[trickTreat][title]" value="{{ $data['trickTreat']['title'] ?? '' }}" class="form-input" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Giới Thiệu</label>
                        <textarea name="data[trickTreat][intro]" rows="2" class="form-input" style="width: 100%; resize: vertical;">{{ $data['trickTreat']['intro'] ?? '' }}</textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">TRICK - Tiêu đề</label>
                            <input type="text" name="data[trickTreat][trick][title]" value="{{ $data['trickTreat']['trick']['title'] ?? '' }}" class="form-input" style="width: 100%;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">TREAT - Tiêu đề</label>
                            <input type="text" name="data[trickTreat][treat][title]" value="{{ $data['trickTreat']['treat']['title'] ?? '' }}" class="form-input" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Palette (Autumn only) --}}
            @if($seasonId === 'thu' && isset($data['palette']))
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Bảng Màu</h2>
                </div>
                <div class="admin-card-body" style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($data['palette'] as $i => $color)
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: {{ $color[1] ?? '#ccc' }}; border: 1px solid var(--admin-border); flex-shrink: 0;"></div>
                        <input type="text" name="data[palette][{{ $i }}][0]" value="{{ $color[0] ?? '' }}" class="form-input" placeholder="Tên màu" style="flex: 1;">
                        <input type="color" name="data[palette][{{ $i }}][1]" value="{{ $color[1] ?? '#000000' }}" style="width: 36px; height: 38px; padding: 2px; border: 1px solid var(--admin-border); border-radius: 6px; cursor: pointer;">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Right Column: Products --}}
        <div class="admin-card" style="position: sticky; top: 24px;">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Sản Phẩm Hiển Thị</h2>
            </div>
            <div class="admin-card-body" style="padding: 0;">
                {{-- Search --}}
                <div style="padding: 16px 16px 0;">
                    <input type="text" id="productSearch" placeholder="Tìm sản phẩm..." class="form-input" style="width: 100%;">
                </div>

                {{-- Selected Products --}}
                <div style="padding: 16px;">
                    <div style="font-size: 12px; font-weight: 600; color: var(--admin-text-muted); margin-bottom: 8px; text-transform: uppercase;">
                        Đã Chọn (<span id="selectedCount">{{ $seasonProducts->count() }}</span>)
                    </div>
                    <div id="selectedProducts" style="display: flex; flex-direction: column; gap: 8px; max-height: 300px; overflow-y: auto;">
                        @forelse($seasonProducts as $product)
                        <div class="product-item selected" data-id="{{ $product->id }}">
                            <input type="checkbox" checked class="product-checkbox">
                            <img src="{{ $product->getPrimaryImageUrl() }}" alt="" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; flex-shrink: 0;">
                            <div class="product-info">
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-meta">{{ $product->category->name ?? '' }} · {{ number_format($product->price) }}đ</div>
                            </div>
                            <button type="button" class="remove-product" style="background: none; border: none; cursor: pointer; color: var(--admin-text-muted); padding: 4px;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        @empty
                        <div style="text-align: center; padding: 24px; color: var(--admin-text-muted); font-size: 13px;">
                            Chưa có sản phẩm nào
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- All Products --}}
                <div style="border-top: 1px solid var(--admin-border); padding: 16px;">
                    <div style="font-size: 12px; font-weight: 600; color: var(--admin-text-muted); margin-bottom: 8px; text-transform: uppercase;">
                        Tất Cả Sản Phẩm
                    </div>
                    <div id="allProducts" style="display: flex; flex-direction: column; gap: 6px; max-height: 300px; overflow-y: auto;">
                        @foreach($allProducts as $product)
                        <div class="product-item {{ $product->season_id === $seasonId ? 'in-season' : '' }}" data-id="{{ $product->id }}" data-name="{{ strtolower($product->name) }}">
                            <input type="checkbox" class="product-checkbox" {{ $product->season_id === $seasonId ? 'checked' : '' }}>
                            <img src="{{ $product->getPrimaryImageUrl() }}" alt="" style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px; flex-shrink: 0;">
                            <div class="product-info">
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-meta">{{ $product->category->name ?? '' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
.product-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px;
    border-radius: 8px;
    background: var(--admin-bg-subtle);
    transition: background 0.15s;
}
.product-item:hover {
    background: var(--admin-border);
}
.product-item.in-season {
    border: 2px solid var(--admin-primary);
}
.product-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
    flex-shrink: 0;
}
.product-info {
    flex: 1;
    min-width: 0;
}
.product-name {
    font-size: 13px;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.product-meta {
    font-size: 11px;
    color: var(--admin-text-muted);
}
.remove-product:hover {
    color: #dc2626 !important;
}
</style>

@push('scripts')
<script>
(function() {
    const form = document.getElementById('seasonalForm');
    const saveBtn = document.getElementById('saveBtn');
    const productIdsInput = document.getElementById('productIds');
    const selectedCount = document.getElementById('selectedCount');

    // Collect selected product IDs
    function updateSelectedIds() {
        const checked = document.querySelectorAll('#allProducts .product-item input:checked');
        const ids = Array.from(checked).map(cb => parseInt(cb.closest('.product-item').dataset.id));
        productIdsInput.value = JSON.stringify(ids);
        selectedCount.textContent = ids.length;

        // Move checked items to selected
        checked.forEach(cb => {
            const item = cb.closest('.product-item');
            const selectedContainer = document.getElementById('selectedProducts');
            const emptyMsg = selectedContainer.querySelector('.empty-msg');
            if (emptyMsg) emptyMsg.remove();

            // Check if already in selected
            if (!selectedContainer.querySelector(`[data-id="${item.dataset.id}"]`)) {
                const clone = item.cloneNode(true);
                clone.classList.add('selected');
                clone.classList.remove('in-season');
                clone.querySelector('input').addEventListener('change', handleCheck);
                selectedContainer.appendChild(clone);
            }

            item.classList.add('in-season');
            item.classList.remove('selected');
        });

        // Remove unchecked from selected
        document.querySelectorAll('#selectedProducts .product-item input:not(:checked)').forEach(cb => {
            const item = cb.closest('.product-item');
            const original = document.querySelector(`#allProducts [data-id="${item.dataset.id}"]`);
            if (original) {
                original.checked = false;
                original.closest('.product-item').classList.remove('in-season');
            }
            item.remove();
        });

        // Show empty message if no selected
        if (selectedContainer.children.length === 0) {
            selectedContainer.innerHTML = '<div class="empty-msg" style="text-align: center; padding: 24px; color: var(--admin-text-muted); font-size: 13px;">Chưa có sản phẩm nào</div>';
        }
    }

    function handleCheck() {
        updateSelectedIds();
    }

    // Checkbox listeners
    document.querySelectorAll('#allProducts .product-checkbox, #selectedProducts .product-checkbox').forEach(cb => {
        cb.addEventListener('change', handleCheck);
    });

    // Remove button
    document.querySelectorAll('.remove-product').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.product-item');
            item.querySelector('input').checked = false;
            updateSelectedIds();
        });
    });

    // Search
    document.getElementById('productSearch').addEventListener('input', function() {
        const term = this.value.toLowerCase();
        document.querySelectorAll('#allProducts .product-item').forEach(item => {
            const name = item.dataset.name;
            item.style.display = name.includes(term) ? '' : 'none';
        });
    });

    // Hero Upload
    document.getElementById('heroUpload')?.addEventListener('change', function() {
        if (!this.files.length) return;
        const fd = new FormData();
        fd.append('file', this.files[0]);
        fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        fetch(`/admin/seasonal-pages/{{ $seasonId }}/hero`, {
            method: 'POST',
            body: fd
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('heroPreview').innerHTML = `<img src="${data.imageUrl}" alt="Hero" style="width: 100%; height: 180px; object-fit: cover; display: block;">`;
                // Add delete button
                document.getElementById('deleteHeroBtn')?.remove();
                const uploadBtn = document.querySelector('#heroUpload').closest('label').parentElement;
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.id = 'deleteHeroBtn';
                deleteBtn.className = 'btn btn-secondary';
                deleteBtn.style.cssText = 'padding: 8px 12px;';
                deleteBtn.innerHTML = '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
                deleteBtn.addEventListener('click', deleteHero);
                uploadBtn.appendChild(deleteBtn);
            }
        });
    });

    // Delete Hero
    function deleteHero() {
        if (!confirm('Xóa ảnh hero này?')) return;
        fetch(`/admin/seasonal-pages/{{ $seasonId }}/hero`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('heroPreview').innerHTML = `
                    <div style="padding: 40px; text-align: center; color: var(--admin-text-muted);">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 8px; opacity: .3; display: block;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p style="font-size: 13px; margin: 0;">Chưa có ảnh hero</p>
                    </div>`;
                document.getElementById('deleteHeroBtn')?.remove();
            }
        });
    }
    document.getElementById('deleteHeroBtn')?.addEventListener('click', deleteHero);

    // Save
    saveBtn.addEventListener('click', function() {
        updateSelectedIds();
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="animate-spin"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Đang lưu...';

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(new FormData(form))
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                saveBtn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Đã Lưu!';
                saveBtn.style.background = '#10b981';
                setTimeout(() => {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Lưu Thay Đổi';
                    saveBtn.style.background = '';
                }, 2000);
            }
        })
        .catch(() => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = 'Lưu Thay Đổi';
            alert('Lỗi khi lưu. Vui lòng thử lại.');
        });
    });

    // Initial
    updateSelectedIds();
})();
</script>
@endpush
@endsection
