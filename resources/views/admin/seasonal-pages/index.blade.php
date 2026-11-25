@extends('layouts.admin')

@section('page-title', 'Trang Mùa Lễ Hội')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Trang Mùa Lễ Hội</h1>
        <p class="admin-page-subtitle">Quản lý 3 trang lễ hội gốc và thêm các trang lễ hội mới theo giao diện Hội Mùa Thu</p>
    </div>
    <div class="admin-page-actions">
        <button type="button" class="btn btn-primary" id="toggleCreate">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm trang lễ hội
        </button>
    </div>
</div>

<div class="admin-card" id="createCard" style="display: none; margin-bottom: 24px;">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Thêm trang lễ hội mới</h2>
    </div>
    <div class="admin-card-body">
        <p style="font-size: 13px; color: var(--admin-text-muted); margin: 0 0 16px;">
            Trang mới dùng đúng giao diện của <strong>Hội Mùa Thu</strong>. Sau khi tạo, bạn chỉnh được tên, các đề mục, ảnh và sản phẩm ở trang sửa.
            Trang Halloween và Cây Thông vẫn giữ giao diện riêng.
        </p>

        <form method="POST" action="{{ route('admin.seasonal-pages.store') }}" id="createForm">
            @csrf
            <div class="season-form-grid">
                <div>
                    <label class="season-label">Tên Trang <span style="color:#dc2626">*</span></label>
                    <input type="text" name="name" class="form-input" required maxlength="150" placeholder="VD: Lễ Tình Nhân" value="{{ old('name') }}">
                </div>
                <div>
                    <label class="season-label">Đường Dẫn (slug)</label>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="font-size: 12px; color: var(--admin-text-muted); white-space: nowrap;">/mua-le-hoi/</span>
                        <input type="text" name="slug" class="form-input" maxlength="150" placeholder="le-tinh-nhan" value="{{ old('slug') }}">
                    </div>
                    <p class="season-hint">Để trống sẽ tự tạo từ tên trang.</p>
                </div>
                <div>
                    <label class="season-label">Mã Chuyến Bay</label>
                    <input type="text" name="code" class="form-input" maxlength="10" placeholder="VD: VAL" value="{{ old('code') }}">
                </div>
                <div>
                    <label class="season-label">Trạng Thái</label>
                    <input type="text" name="status" class="form-input" maxlength="100" placeholder="VD: Đang bay" value="{{ old('status') }}">
                </div>
                <div>
                    <label class="season-label">Ngày</label>
                    <input type="date" name="date" class="form-input" value="{{ old('date') }}">
                </div>
                <div>
                    <label class="season-label">Tagline</label>
                    <input type="text" name="tagline" class="form-input" maxlength="255" placeholder="VD: Chuyến bay mùa yêu thương" value="{{ old('tagline') }}">
                </div>
                <div style="grid-column: 1 / -1;">
                    <label class="season-label">Giới Thiệu</label>
                    <textarea name="intro" rows="2" class="form-input" maxlength="2000" placeholder="Mô tả ngắn hiển thị dưới tiêu đề trang">{{ old('intro') }}</textarea>
                </div>
                <div>
                    <label class="season-label">Nhãn Nút</label>
                    <input type="text" name="cta_label" class="form-input" maxlength="150" placeholder="Xem bộ sưu tập" value="{{ old('cta_label') }}">
                </div>
                <div>
                    <label class="season-label">Liên Kết Nút</label>
                    <input type="text" name="cta_link" class="form-input" maxlength="500" placeholder="/san-pham" value="{{ old('cta_link') }}">
                </div>
                <div>
                    <label class="season-label">Link Bổ Sung — Nhãn</label>
                    <input type="text" name="extra_label" class="form-input" maxlength="255" placeholder="Đọc trên LNT Journal →" value="{{ old('extra_label') }}">
                </div>
                <div>
                    <label class="season-label">Link Bổ Sung — Liên Kết</label>
                    <input type="text" name="extra_link" class="form-input" maxlength="500" placeholder="/bai-viet" value="{{ old('extra_link') }}">
                </div>
            </div>

            @if($errors->any())
                <p style="color:#dc2626; font-size:13px; margin:14px 0 0;">{{ $errors->first() }}</p>
            @endif

            <div style="display: flex; gap: 10px; margin-top: 18px;">
                <button type="submit" class="btn btn-primary">Tạo trang</button>
                <button type="button" class="btn btn-secondary" id="cancelCreate">Hủy</button>
            </div>
        </form>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
    @foreach($seasons as $id => $season)
    <div class="season-card-wrap">
        <a href="{{ route('admin.seasonal-pages.edit', $id) }}" class="season-card">
            <div class="season-card-icon">
                @switch($id)
                    @case('thu')
                        <span style="font-size: 40px;">🍂</span>
                        @break
                    @case('halloween')
                        <span style="font-size: 40px;">🎃</span>
                        @break
                    @case('thong')
                        <span style="font-size: 40px;">🎄</span>
                        @break
                    @default
                        <span style="font-size: 40px;">🌸</span>
                @endswitch
            </div>
            <div class="season-card-content">
                <h3>{{ $season['label'] }}</h3>
                <p>/mua-le-hoi/{{ $season['slug'] }}</p>
                <span class="season-badge {{ $season['custom'] ? 'is-custom' : '' }}">{{ $season['layout_label'] }}</span>
            </div>
            <div class="season-card-arrow">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </a>
        @if($season['custom'])
            <form method="POST" action="{{ route('admin.seasonal-pages.destroy', $id) }}" class="season-delete" onsubmit="return confirm('Xóa trang lễ hội “{{ $season['label'] }}”? Sản phẩm của trang sẽ được bỏ gán mùa.');">
                @csrf
                @method('DELETE')
                <button type="submit" title="Xóa trang">Xóa</button>
            </form>
        @endif
    </div>
    @endforeach
</div>

<style>
.season-card-wrap { position: relative; }
.season-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 24px;
    background: var(--admin-bg);
    border: 1px solid var(--admin-border);
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    height: 100%;
}
.season-card:hover {
    border-color: var(--admin-primary);
    background: var(--admin-bg-subtle);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.season-card-icon {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--admin-bg-subtle);
    border-radius: 12px;
    flex-shrink: 0;
}
.season-card-content { flex: 1; min-width: 0; }
.season-card-content h3 { margin: 0 0 4px; font-size: 16px; font-weight: 600; }
.season-card-content p { margin: 0 0 8px; font-size: 12px; color: var(--admin-text-muted); word-break: break-all; }
.season-card-arrow { color: var(--admin-text-muted); align-self: center; }
.season-badge {
    display: inline-block;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 999px;
    background: var(--admin-bg-subtle);
    border: 1px solid var(--admin-border);
    color: var(--admin-text-muted);
}
.season-badge.is-custom { border-color: var(--admin-primary); color: var(--admin-primary); }
.season-delete { position: absolute; top: 12px; right: 12px; }
.season-delete button {
    background: none;
    border: 1px solid var(--admin-border);
    color: #dc2626;
    border-radius: 8px;
    padding: 4px 10px;
    font-size: 12px;
    cursor: pointer;
    background: var(--admin-bg);
}
.season-delete button:hover { border-color: #dc2626; }
.season-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.season-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
.season-hint { margin: 4px 0 0; font-size: 11px; color: var(--admin-text-muted); }
@media (max-width: 720px) { .season-form-grid { grid-template-columns: 1fr; } }
</style>

@push('scripts')
<script>
(function () {
    const card = document.getElementById('createCard');
    const toggle = document.getElementById('toggleCreate');
    const cancel = document.getElementById('cancelCreate');

    toggle?.addEventListener('click', () => {
        card.style.display = card.style.display === 'none' ? '' : 'none';
        if (card.style.display === '') card.querySelector('input[name="name"]')?.focus();
    });
    cancel?.addEventListener('click', () => { card.style.display = 'none'; });

    @if($errors->any())
        card.style.display = '';
    @endif
})();
</script>
@endpush
@endsection
