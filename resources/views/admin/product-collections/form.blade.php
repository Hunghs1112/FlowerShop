@php
    $isEdit = $collection->exists;
    $preselected = $isEdit ? $selectedIds : [];
@endphp
<form id="collectionForm" method="POST" action="{{ $isEdit ? route('admin.product-collections.update', $collection) : route('admin.product-collections.store') }}">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 24px; align-items: start;">
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Thông tin bộ sưu tập</h2>
                </div>
                <div class="admin-card-body" style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Tên bộ sưu tập *</label>
                        <input type="text" name="name" value="{{ old('name', $collection->name) }}" required class="form-input" placeholder="VD: Hoa tông đỏ" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Tiêu chí (mô tả ngắn)</label>
                        <input type="text" name="criterion" value="{{ old('criterion', $collection->criterion) }}" class="form-input" placeholder="VD: Hoa có sắc đỏ, hồng đậm" style="width: 100%;">
                    </div>
                    <div style="border-top: 1px solid var(--admin-border); padding-top: 16px; display: flex; flex-direction: column; gap: 16px;">
                        <strong>English content</strong>
                        <input type="text" name="name_en" value="{{ old('name_en', $collection->name_en) }}" class="form-input" placeholder="English name" style="width: 100%;">
                        <input type="text" name="slug_en" value="{{ old('slug_en', $collection->slug_en) }}" class="form-input" placeholder="English slug" style="width: 100%;">
                        <input type="text" name="criterion_en" value="{{ old('criterion_en', $collection->criterion_en) }}" class="form-input" placeholder="English criterion" style="width: 100%;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Màu nhấn</label>
                            <input type="color" name="accent_color" value="{{ old('accent_color', $collection->accent_color ?: '#A3B18A') }}" style="width: 100%; height: 40px; padding: 2px; border: 1px solid var(--admin-border); border-radius: 6px; cursor: pointer;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Thứ tự</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $collection->sort_order ?? 0) }}" class="form-input" style="width: 100%;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Trạng thái</label>
                            <label class="admin-toggle" style="display:flex; align-items:center; gap:8px; margin-top: 10px;">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $collection->is_active ?? true) ? 'checked' : '' }}>
                                <span>Hiển thị</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card" style="position: sticky; top: 24px;">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Sản phẩm trong bộ</h2>
            </div>
            <div class="admin-card-body" style="padding: 0;">
                <div style="padding: 16px 16px 0;">
                    <input type="text" id="productSearch" placeholder="Tìm sản phẩm..." class="form-input" style="width: 100%;">
                </div>
                <div style="padding: 16px;">
                    <div style="font-size: 12px; font-weight: 600; color: var(--admin-text-muted); margin-bottom: 8px; text-transform: uppercase;">
                        Đã chọn (<span id="selectedCount">{{ count($preselected) }}</span>)
                    </div>
                    <div id="selectedProducts" style="display: flex; flex-direction: column; gap: 8px; max-height: 300px; overflow-y: auto;">
                        @if(empty($preselected))
                            <div class="empty-msg" style="text-align: center; padding: 24px; color: var(--admin-text-muted); font-size: 13px;">Chưa chọn sản phẩm</div>
                        @endif
                    </div>
                </div>
                <div style="border-top: 1px solid var(--admin-border); padding: 16px;">
                    <div style="font-size: 12px; font-weight: 600; color: var(--admin-text-muted); margin-bottom: 8px; text-transform: uppercase;">
                        Tất cả sản phẩm
                    </div>
                    <div id="allProducts" style="display: flex; flex-direction: column; gap: 6px; max-height: 360px; overflow-y: auto;">
                        @foreach($allProducts as $product)
                        <div class="product-item {{ in_array($product->id, $preselected) ? 'in-season' : '' }}" data-id="{{ $product->id }}" data-name="{{ strtolower($product->name) }}">
                            <input type="checkbox" class="product-checkbox" {{ in_array($product->id, $preselected) ? 'checked' : '' }}>
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

    <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: flex-end;">
        <a href="{{ route('admin.product-collections.index') }}" class="btn btn-secondary">Hủy</a>
        <button type="submit" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ $isEdit ? 'Cập nhật' : 'Tạo bộ sưu tập' }}
        </button>
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
.product-item:hover { background: var(--admin-border); }
.product-item.in-season { border: 2px solid var(--admin-primary); }
.product-item input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; flex-shrink: 0; }
.product-info { flex: 1; min-width: 0; }
.product-name { font-size: 13px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.product-meta { font-size: 11px; color: var(--admin-text-muted); }
</style>

@push('scripts')
<script>
(function() {
    const form = document.getElementById('collectionForm');
    const productIdsInput = null; // submit form đẩy mảng product_ids[] thẳng từ DOM
    const selectedCount = document.getElementById('selectedCount');
    const selectedContainer = document.getElementById('selectedProducts');
    const allContainer = document.getElementById('allProducts');

    // Inject hidden product_ids[] inputs into form on submit
    function injectProductIds() {
        form.querySelectorAll('input[name="product_ids[]"][data-injected]').forEach(i => i.remove());
        document.querySelectorAll('#allProducts .product-item input:checked').forEach(cb => {
            const id = cb.closest('.product-item').dataset.id;
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'product_ids[]';
            input.value = id;
            input.dataset.injected = '1';
            form.appendChild(input);
        });
    }

    function refreshSelected() {
        const checked = document.querySelectorAll('#allProducts .product-item input:checked');
        const ids = Array.from(checked).map(cb => parseInt(cb.closest('.product-item').dataset.id));
        selectedCount.textContent = ids.length;

        // Clear and rebuild selected list
        selectedContainer.innerHTML = '';
        if (ids.length === 0) {
            selectedContainer.innerHTML = '<div class="empty-msg" style="text-align: center; padding: 24px; color: var(--admin-text-muted); font-size: 13px;">Chưa chọn sản phẩm</div>';
        } else {
            ids.forEach(id => {
                const source = allContainer.querySelector(`[data-id="${id}"]`);
                if (!source) return;
                const clone = source.cloneNode(true);
                clone.classList.add('selected');
                clone.classList.remove('in-season');
                const cb = clone.querySelector('input');
                cb.addEventListener('change', refreshSelected);
                selectedContainer.appendChild(clone);
            });
        }
    }

    // Bind initial checkbox listeners in allProducts
    document.querySelectorAll('#allProducts .product-checkbox').forEach(cb => {
        cb.addEventListener('change', refreshSelected);
    });

    // Search filter
    document.getElementById('productSearch').addEventListener('input', function() {
        const term = this.value.toLowerCase();
        document.querySelectorAll('#allProducts .product-item').forEach(item => {
            const name = item.dataset.name;
            item.style.display = name.includes(term) ? '' : 'none';
        });
    });

    form.addEventListener('submit', injectProductIds);
})();
</script>
@endpush
