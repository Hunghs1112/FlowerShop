<table class="admin-table">
    <thead>
        <tr>
            <th style="width: 80px;">Hình Ảnh</th>
            <th>Tên Danh Mục</th>
            <th>Slug</th>
            <th style="width: 120px;">Danh Mục Phụ</th>
            <th style="width: 100px;">Sản Phẩm</th>
            <th style="width: 120px;">Trạng Thái</th>
            <th style="width: 120px;">Thao Tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
            <tr>
                <td data-label="Hình Ảnh">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="table-image">
                    @else
                        <div class="table-image" style="width: 56px; height: 56px; background: var(--admin-bg-content); display: flex; align-items: center; justify-content: center; border-radius: var(--admin-radius-md);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24" style="color: var(--admin-text-muted);">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </td>
                <td data-label="Tên Danh Mục">
                    <div class="table-product-name">{{ $category->name }}</div>
                </td>
                <td data-label="Slug" class="text-mono" style="color: var(--admin-text-secondary);">
                    {{ $category->slug }}
                </td>
                <td data-label="Danh Mục Phụ">
                    <span class="badge badge-info">{{ $category->subcategories_count ?? 0 }}</span>
                </td>
                <td data-label="Sản Phẩm">
                    <span class="badge badge-secondary">{{ $category->products_count ?? 0 }}</span>
                </td>
                <td data-label="Trạng Thái">
                    <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ $category->is_active ? 'Hoạt động' : 'Tạm ngưng' }}
                    </span>
                </td>
                <td data-label="Thao Tác">
                    <div class="table-actions">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-icon" title="Sửa">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-icon-danger" title="Xóa" 
                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?\n\nHành động này không thể hoàn tác.')">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state-sm">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <p>Không tìm thấy danh mục nào</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
