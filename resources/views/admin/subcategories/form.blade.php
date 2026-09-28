<div class="admin-card">
    <div class="admin-card-body">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
            {{-- Left Column - Main Info --}}
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">
                        Danh Mục Cha <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="category_id" 
                            {{ isset($isEdit) && $isEdit ? 'class="auto-save-select" data-entity="subcategories" data-id="' . $subcategory->id . '"' : '' }}
                            required
                            style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; background: white;">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">
                        Tên Danh Mục Phụ <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $subcategory->name ?? '') }}" 
                           {{ isset($isEdit) && $isEdit ? 'class="auto-save-input" data-entity="subcategories" data-id="' . $subcategory->id . '"' : '' }}
                           required
                           placeholder="Nhập tên danh mục phụ"
                           style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;">
                    @error('name')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Slug</label>
                    <input type="text" 
                           name="slug" 
                           value="{{ old('slug', $subcategory->slug ?? '') }}" 
                           {{ isset($isEdit) && $isEdit ? 'class="auto-save-input" data-entity="subcategories" data-id="' . $subcategory->id . '"' : '' }}
                           placeholder="ten-danh-muc-phu (tự động tạo nếu để trống)"
                           style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; font-family: 'JetBrains Mono', monospace;">
                    @error('slug')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả</label>
                    <textarea name="description" 
                              rows="4" 
                              {{ isset($isEdit) && $isEdit ? 'class="auto-save-input" data-entity="subcategories" data-id="' . $subcategory->id . '"' : '' }}
                              style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;">{{ old('description', $subcategory->description ?? '') }}</textarea>
                </div>
            </div>

            {{-- Right Column - Settings & Image --}}
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Trạng Thái</label>
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; background: var(--admin-bg-content); border-radius: var(--admin-radius-md); border: 1px solid var(--admin-border);">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $subcategory->is_active ?? true) ? 'checked' : '' }}
                               {{ isset($isEdit) && $isEdit ? 'class="auto-save-checkbox" data-entity="subcategories" data-id="' . $subcategory->id . '"' : '' }}
                               style="width: 18px; height: 18px; cursor: pointer;">
                        <span style="font-size: 14px; color: var(--admin-text-primary);">Kích hoạt danh mục phụ</span>
                    </label>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Thứ Tự Hiển Thị</label>
                    <input type="number" 
                           name="sort_order" 
                           value="{{ old('sort_order', $subcategory->sort_order ?? 0) }}" 
                           {{ isset($isEdit) && $isEdit ? 'class="auto-save-input" data-entity="subcategories" data-id="' . $subcategory->id . '"' : '' }}
                           min="0"
                           style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Hình Ảnh</label>
                    <div style="position: relative;">
                        @if(isset($subcategory) && $subcategory->image)
                            <div class="subcategory-image-container" style="position: relative; display: inline-block; margin-bottom: 12px;">
                                <img src="{{ $subcategory->image_url }}" 
                                     alt="Current image" 
                                     style="width: 100%; height: auto; border-radius: var(--admin-radius-md); border: 1px solid var(--admin-border);">
                                <button type="button"
                                        onclick="deleteSubcategoryImage({{ $subcategory->id }}, this)"
                                        title="Xóa ảnh"
                                        style="position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; background: rgba(239, 68, 68, 0.9); color: white; border: 2px solid white; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endif
                        <input type="file" 
                               name="image" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               {{ isset($isEdit) && $isEdit ? 'class="auto-save-file" data-entity="subcategories" data-id="' . $subcategory->id . '" data-field="image" data-upload-url="' . route('admin.subcategories.uploadImage', $subcategory) . '"' : '' }}
                               style="width: 100%; padding: 10px; border: 1px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 13px; cursor: pointer;">
                        <p style="font-size: 12px; color: var(--admin-text-muted); margin-top: 6px;">
                            JPG, PNG, GIF, WEBP. Tối đa 2MB
                        </p>
                    </div>
                    @error('image')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
