@php($item = $item ?? null)
<div class="admin-card" style="max-width:900px;"><div class="admin-card-body">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
        @foreach(['country' => 'Quốc gia', 'flower' => 'Tên loài hoa', 'latin' => 'Tên Latin', 'region' => 'Vùng trồng', 'coordinate' => 'Tọa độ', 'slug' => 'Slug'] as $field => $label)
            <label>{{ $label }}<input name="{{ $field }}" value="{{ old($field, data_get($item, $field)) }}" {{ in_array($field, ['country','flower','latin','region','coordinate']) ? 'required' : '' }} style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        @endforeach
        <label>Tọa độ X trên map<input type="number" name="map_x" min="0" max="1000" required value="{{ old('map_x', $item?->map_x ?? 0) }}" style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <label>Tọa độ Y trên map<input type="number" name="map_y" min="0" max="520" required value="{{ old('map_y', $item?->map_y ?? 0) }}" style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <label>Thứ tự<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $item?->sort_order ?? 0) }}" style="display:block;width:100%;height:42px;margin-top:6px;padding:0 12px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);"></label>
        <label>Ảnh hoa<input type="file" name="image" accept="image/*" {{ $item ? '' : 'required' }} style="display:block;width:100%;margin-top:6px;"></label>
    </div>
    @if($item?->image)<img src="{{ $item->image_url }}" alt="{{ $item->flower }}" style="width:180px;height:140px;object-fit:cover;border-radius:8px;margin-top:20px;">@endif
    <label style="display:flex;gap:8px;align-items:center;margin-top:20px;"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}> Hiển thị trên map</label>
    <button class="btn btn-primary" type="submit" style="margin-top:24px;">Lưu thay đổi</button>
</div></div>
