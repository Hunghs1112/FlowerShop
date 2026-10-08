@php($item = $item ?? null)
<div class="admin-card" style="max-width:900px;"><div class="admin-card-body">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
        <label>TITLE (optional — shown on hover)<input name="title" value="{{ old('title', $item?->title) }}" placeholder="e.g. LNT Journal Số 03" style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <label>ALT TEXT<input name="alt_text" value="{{ old('alt_text', $item?->alt_text) }}" placeholder="Mô tả ảnh cho screen reader" required style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <label style="grid-column:1/-1;">CAPTION<textarea name="caption" rows="2" placeholder="Chú thích hiển thị dưới ảnh" style="display:block;width:100%;margin-top:6px;padding:8px 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);resize:vertical;">{{ old('caption', $item?->caption) }}</textarea></label>
        <label>THỨ TỰ (số nhỏ hiển thị trước)<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $item?->sort_order ?? 0) }}" style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <label>ẢNH (JPG/PNG/WebP, tối đa 8MB)<input type="file" name="image" accept="image/*" {{ $item ? '' : 'required' }} style="display:block;width:100%;margin-top:6px;"></label>
    </div>
    @if($item?->image)
        <div style="margin-top:16px;">
            <img src="{{ $item->image_url }}" alt="{{ $item->alt_text ?? $item->title }}" style="max-width:320px;max-height:240px;object-fit:cover;border-radius:8px;border:1px solid var(--admin-border);">
            <p style="margin-top:6px;font-size:0.85rem;color:var(--color-text-light);">Ảnh hiện tại</p>
        </div>
    @endif
    <label style="display:flex;gap:8px;align-items:center;margin-top:20px;">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}>
        Hiển thị trên trang chủ
    </label>
    <button class="btn btn-primary" type="submit" style="margin-top:24px;">Lưu thay đổi</button>
</div></div>
