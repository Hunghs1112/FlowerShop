@extends('layouts.admin')

@section('page-title', 'Thêm Sản Phẩm')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Thêm Sản Phẩm Mới</h1>
        <p class="admin-page-subtitle">Tạo sản phẩm mới cho cửa hàng</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.catalog.index', ['tab' => 'products']) }}" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-error" style="margin-bottom: 24px;">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <strong>Có lỗi xảy ra:</strong>
            <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px;">
        {{-- Main Content --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Basic Info --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">
                        <div class="admin-card-title-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        Thông Tin Sản Phẩm
                    </h2>
                </div>
                <div class="admin-card-body">
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tên Sản Phẩm <span style="color: var(--admin-error);">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; transition: all 0.2s;" 
                                   required autofocus>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" 
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; font-family: var(--admin-font-mono);">
                            <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Để trống sẽ tự tạo</small>
                        </div>

                        <div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Danh Mục Chính <span style="color: var(--admin-error);">*</span></label>
                            <select name="category_id" style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; background: white;" required>
                                <option value="">-- Chọn danh mục chính --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Có thể thêm sản phẩm trực tiếp vào danh mục chính.</small>
                        </div>

                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Danh Mục Phụ</label>
                            <select name="subcategory_id" id="subcategorySelect" style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; background: white;">
                                <option value="">-- Không chọn danh mục phụ --</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->category->name }} → {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Không bắt buộc. Nếu chọn, danh mục chính sẽ tự động khớp theo danh mục phụ</small>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả Ngắn</label>
                            <textarea name="short_description" rows="3" 
                                      style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;">{{ old('short_description') }}</textarea>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả Chi Tiết</label>
                            <textarea name="description" rows="6"
                                      style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;">{{ old('description') }}</textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Chiều Dài</label>
                                <input type="text" name="length" value="{{ old('length') }}"
                                       style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;"
                                       placeholder="VD: 50cm, 60cm">
                            </div>

                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Xuất Xứ</label>
                                <input type="text" name="origin" value="{{ old('origin') }}"
                                       style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;"
                                       placeholder="VD: Việt Nam, Hà Lan">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Số Lượng Order Tối Thiểu</label>
                                <input type="number" name="min_order_quantity" value="{{ old('min_order_quantity', 1) }}"
                                       style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;"
                                       min="1">
                            </div>

                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Quy Cách</label>
                                <input type="text" name="specification" value="{{ old('specification') }}"
                                       style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;"
                                       placeholder="VD: Bó 10 bông, Hộp 20 cây">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Images --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">
                        <div class="admin-card-title-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        Hình Ảnh
                    </h2>
                </div>
                <div class="admin-card-body">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tải Lên Hình Ảnh</label>
                        <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/gif,image/webp" id="imageInput" onchange="previewImages(this)"
                               style="width: 100%; height: 44px; padding: 8px 14px; border: 2px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; cursor: pointer;">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">jpg, png, gif, webp – tối đa {{ $maxImages ?? 10 }} ảnh, mỗi ảnh &lt; 2 MB.</small>
                    </div>

                    <div id="imagePreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 12px; margin-top: 16px;"></div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Pricing & Stock --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">
                        <div class="admin-card-title-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Giá & Tồn Kho
                    </h2>
                </div>
                <div class="admin-card-body">
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Giá (₫) <span style="color: var(--admin-error);">*</span></label>
                            <input type="number" name="price" value="{{ old('price') }}" 
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;" 
                                   required min="0" step="1000">
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Số Lượng <span style="color: var(--admin-error);">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" 
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;" 
                                   required min="0">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">
                        <div class="admin-card-title-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Trạng Thái
                    </h2>
                </div>
                <div class="admin-card-body">
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                            <span style="font-size: 14px; font-weight: 500;">Kích hoạt</span>
                        </label>

                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                   style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                            <span style="font-size: 14px; font-weight: 500;">Sản phẩm nổi bật</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px; font-size: 15px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tạo Sản Phẩm
            </button>
        </div>
    </div>
</form>

@push('scripts')
<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.cssText = 'position: relative; border-radius: var(--admin-radius-md); overflow: hidden; aspect-ratio: 1;';
                div.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endpush
@endsection
