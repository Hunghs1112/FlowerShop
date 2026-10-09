@extends('layouts.admin')

@section('page-title', 'Banner Trang')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Banner Trang</h1>
        <p class="admin-page-subtitle">Ảnh header hiển thị phía trên mỗi trang. Tự động lưu khi upload hoặc thay đổi.</p>
    </div>
</div>

{{-- Info --}}
<div style="margin-bottom: 24px; padding: 12px 16px; background: #eff6ff; border-left: 3px solid #3b82f6; border-radius: 6px; font-size: 13px; color: #1e40af;">
    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 6px;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Kích thước khuyến nghị: <strong>1920 × 800px</strong> (desktop). Có thể điều chỉnh chiều cao hiển thị riêng cho từng trang.
</div>

@php
$bannerFields = [
    'home'        => ['Trang chủ',   '🏠'],
    'products'    => ['Sản phẩm',    '🌸'],
    'categories'  => ['Danh mục',    '📁'],
    'blog'        => ['Bài viết',    '📝'],
    'about'       => ['Giới thiệu',  'ℹ️'],
    'contact'     => ['Liên hệ',     '📞'],
    'b2c'         => ['B2B',         '🏪'],
    'mystery-box' => ['Mystery Box', '🎁'],
    'cart'        => ['Giỏ hàng',    '🛒'],
    'checkout'    => ['Thanh toán',  '💳'],
];
@endphp

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(420px, 1fr)); gap: 24px;">
    @foreach($bannerFields as $key => [$label, $icon])
    <div class="admin-card pb-card" data-key="{{ $key }}">
        <div class="admin-card-header">
            <h2 class="admin-card-title" style="font-size: 15px;">
                <span style="font-size: 18px; margin-right: 6px; line-height: 1;">{{ $icon }}</span>
                {{ $label }}
            </h2>
        </div>
        <div class="admin-card-body" style="padding-top: 0; display: flex; flex-direction: column; gap: 16px;">

            {{-- Preview --}}
            <div class="pb-preview-wrap" style="border-radius: 8px; overflow: hidden; border: 2px solid var(--admin-border); background: var(--admin-bg-subtle); position: relative; min-height: 90px;">
                @if(!empty($banners[$key]))
                    <img src="{{ $banners[$key] }}" alt="{{ $label }}"
                         style="width: 100%; height: 120px; object-fit: cover; display: block;">
                    <div style="position: absolute; bottom: 8px; right: 8px;">
                        <button type="button"
                                class="js-pb-delete"
                                data-key="{{ $key }}"
                                data-url="{{ route('admin.page-banners.destroy', $key) }}"
                                style="background: rgba(239,68,68,.9); color: #fff; border: none; border-radius: 6px; padding: 5px 11px; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Xóa
                        </button>
                    </div>
                @else
                    <div class="pb-empty" style="padding: 28px; text-align: center; color: var(--admin-text-muted);">
                        <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 8px; opacity: .3; display: block;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p style="font-size: 12px; margin: 0;">Chưa có ảnh</p>
                    </div>
                @endif
            </div>

            {{-- Upload --}}
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--admin-text-secondary); margin-bottom: 5px; text-transform: uppercase; letter-spacing: .4px;">Tải ảnh lên</label>
                <input type="file"
                       accept="image/*"
                       class="js-pb-upload"
                       data-key="{{ $key }}"
                       data-url="{{ route('admin.page-banners.upload', $key) }}"
                       style="width: 100%; padding: 8px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 13px; cursor: pointer; background: var(--color-surface);">
                <div class="pb-feedback" style="margin-top: 5px; font-size: 12px; min-height: 16px;"></div>
            </div>

            {{-- Chiều cao --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--admin-text-secondary); margin-bottom: 5px;">Desktop (px)</label>
                    <input type="number"
                           class="js-pb-field"
                           data-field="banner_{{ $key }}_height_desktop"
                           value="{{ $bannerSizes[$key]['desktop'] }}"
                           min="160" max="1200"
                           style="width: 100%; height: 38px; padding: 0 10px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 13px;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--admin-text-secondary); margin-bottom: 5px;">Mobile (px)</label>
                    <input type="number"
                           class="js-pb-field"
                           data-field="banner_{{ $key }}_height_mobile"
                           value="{{ $bannerSizes[$key]['mobile'] }}"
                           min="160" max="1200"
                           style="width: 100%; height: 38px; padding: 0 10px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 13px;">
                </div>
            </div>

            {{-- Ẩn overlay --}}
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; color: var(--admin-text-primary); margin: 0;">
                <input type="checkbox"
                       class="js-pb-field"
                       data-field="banner_{{ $key }}_hide_overlay"
                       data-type="checkbox"
                       {{ $hideOverlay[$key] ? 'checked' : '' }}
                       style="width: 16px; height: 16px; cursor: pointer; flex-shrink: 0;">
                <span>
                    <strong>Ẩn overlay</strong>
                    <span style="font-weight: 400; color: var(--admin-text-muted);"> — chỉ hiển thị ảnh, không phủ lớp tối</span>
                </span>
            </label>

        </div>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
(function () {
    const CSRF        = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';
    const UPDATE_URL  = '{{ route("admin.page-banners.updateField") }}';
    const DELETE_BASE = '{{ rtrim(url("admin/page-banners"), "/") }}';

    // Placeholder HTML cho ô trống
    function emptySlot() {
        return `<div class="pb-empty" style="padding:28px;text-align:center;color:var(--admin-text-muted);">
            <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 8px;opacity:.3;display:block;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p style="font-size:12px;margin:0;">Chưa có ảnh</p>
        </div>`;
    }

    function deleteBtn(key) {
        return `<button type="button" class="js-pb-delete"
            data-key="${key}" data-url="${DELETE_BASE}/${key}"
            style="background:rgba(239,68,68,.9);color:#fff;border:none;border-radius:6px;padding:5px 11px;font-size:12px;cursor:pointer;display:flex;align-items:center;gap:4px;">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>Xóa</button>`;
    }

    // ── Upload ──────────────────────────────────────────────────────
    document.querySelectorAll('.js-pb-upload').forEach(input => {
        input.addEventListener('change', function () {
            if (!this.files.length) return;
            const key      = this.dataset.key;
            const card     = this.closest('.pb-card');
            const feedback = card.querySelector('.pb-feedback');
            const wrap     = card.querySelector('.pb-preview-wrap');
            const fd       = new FormData();
            fd.append('file', this.files[0]);
            fd.append('_token', CSRF);

            feedback.style.color = 'var(--admin-text-muted)';
            feedback.textContent = 'Đang tải lên…';

            fetch(this.dataset.url, { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        wrap.style.position = 'relative';
                        wrap.innerHTML = `<img src="${data.imageUrl}" style="width:100%;height:120px;object-fit:cover;display:block;">
                            <div style="position:absolute;bottom:8px;right:8px;">${deleteBtn(key)}</div>`;
                        bindDelete(wrap);
                        feedback.style.color = '#059669';
                        feedback.textContent = '✓ Đã lưu';
                    } else {
                        feedback.style.color = '#dc2626';
                        feedback.textContent = '✗ ' + (data.message || 'Lỗi');
                    }
                    setTimeout(() => { feedback.textContent = ''; }, 3000);
                })
                .catch(() => {
                    feedback.style.color = '#dc2626';
                    feedback.textContent = '✗ Lỗi kết nối';
                    setTimeout(() => { feedback.textContent = ''; }, 3000);
                });

            this.value = '';
        });
    });

    // ── Xóa ảnh ─────────────────────────────────────────────────────
    function bindDelete(scope) {
        (scope || document).querySelectorAll('.js-pb-delete').forEach(btn => {
            btn.onclick = function () {
                if (!confirm('Xóa ảnh header này?')) return;
                const key  = this.dataset.key;
                const wrap = document.querySelector(`.pb-card[data-key="${key}"] .pb-preview-wrap`);

                fetch(this.dataset.url, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        wrap.style.position = '';
                        wrap.innerHTML = emptySlot();
                    }
                });
            };
        });
    }
    bindDelete();

    // ── Auto-save height + hide_overlay ─────────────────────────────
    const timers = {};
    document.querySelectorAll('.js-pb-field').forEach(input => {
        input.addEventListener('change', function () {
            const field = this.dataset.field;
            const value = this.dataset.type === 'checkbox'
                ? (this.checked ? '1' : '0')
                : this.value;

            clearTimeout(timers[field]);
            timers[field] = setTimeout(() => {
                fetch(UPDATE_URL, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ field, value }),
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        this.style.borderColor = '#10b981';
                        setTimeout(() => { this.style.borderColor = ''; }, 1500);
                    }
                });
            }, 500);
        });
    });
})();
</script>
@endpush
