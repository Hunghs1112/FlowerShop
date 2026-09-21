@extends('layouts.admin')

@section('title', 'Tạo Variant Mới - ' . $product->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-100 mb-2">Tạo Variant Mới</h1>
        <p class="text-slate-400">
            Sản phẩm gốc: <span class="text-cyan-400">{{ $product->name }}</span>
        </p>
    </div>

    <form action="{{ route('admin.products.variants.store', $product->id) }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf

        <!-- Thông tin cơ bản -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Thông tin cơ bản
            </h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        SKU <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           name="sku" 
                           value="{{ old('sku') }}"
                           required
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="VD: ROSE-RED-M">
                    @error('sku')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Tên variant (tùy chọn)
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="Để trống sẽ dùng tên sản phẩm gốc">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">
                        Để trống để dùng: "{{ $product->name }}"
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Mô tả riêng (tùy chọn)
                </label>
                <textarea name="description" 
                          rows="3"
                          class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                          placeholder="Mô tả đặc điểm riêng của variant này...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Thuộc tính -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Thuộc tính
            </h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Màu sắc</label>
                    <input type="text" 
                           name="color" 
                           value="{{ old('color') }}"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="VD: Đỏ tươi, Hồng phớt">
                    @error('color')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Kích thước</label>
                    <input type="text" 
                           name="size" 
                           value="{{ old('size') }}"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="VD: Small, Medium, Large">
                    @error('size')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Trọng lượng (gram)</label>
                    <input type="number" 
                           name="weight" 
                           value="{{ old('weight') }}"
                           step="0.01"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="VD: 500">
                    @error('weight')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Kích thước (DxRxC cm)</label>
                    <input type="text" 
                           name="dimensions" 
                           value="{{ old('dimensions') }}"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="VD: 30x40x50">
                    @error('dimensions')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Giá & Tồn kho -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Giá & Tồn kho
            </h2>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Giá bán (VNĐ)
                    </label>
                    <input type="number" 
                           name="price" 
                           value="{{ old('price') }}"
                           step="1000"
                           min="0"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="Để trống dùng giá gốc">
                    @error('price')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">
                        Giá gốc: {{ number_format($product->price) }}₫
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Giá so sánh (VNĐ)</label>
                    <input type="number" 
                           name="compare_at_price" 
                           value="{{ old('compare_at_price') }}"
                           step="1000"
                           min="0"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                           placeholder="VD: 1500000">
                    @error('compare_at_price')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Tồn kho <span class="text-red-400">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           value="{{ old('stock', 0) }}"
                           required
                           min="0"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    @error('stock')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Thêm ảnh -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Hình ảnh
            </h2>
            
            <p class="text-sm text-slate-400 mb-4">
                Nếu không tải ảnh, variant sẽ sử dụng ảnh từ sản phẩm gốc
            </p>

            <div class="border-2 border-dashed border-slate-700 rounded-lg p-6 text-center hover:border-cyan-500 transition">
                <input type="file" 
                       name="images[]" 
                       id="images"
                       multiple
                       accept="image/*"
                       class="hidden"
                       onchange="previewImages(event)">
                <label for="images" class="cursor-pointer">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-slate-300 mb-1">Nhấn để chọn ảnh</p>
                    <p class="text-sm text-slate-500">PNG, JPG, GIF, WEBP (tối đa 2MB mỗi ảnh)</p>
                </label>
            </div>

            <div id="preview" class="mt-4 grid grid-cols-4 gap-3"></div>

            @error('images.*')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Cài đặt -->
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                <div class="w-1 h-6 bg-cyan-400 rounded"></div>
                Cài đặt
            </h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               checked
                               class="w-5 h-5 bg-slate-900 border border-slate-700 rounded text-cyan-500 focus:ring-cyan-500 focus:ring-offset-slate-800">
                        <span class="text-slate-300">Kích hoạt variant</span>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Thứ tự sắp xếp</label>
                    <input type="number" 
                           name="sort_order" 
                           value="{{ old('sort_order', 0) }}"
                           min="0"
                           class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-700">
            <a href="{{ route('admin.products.variants.index', $product->id) }}" 
               class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-slate-100 rounded-lg transition">
                Hủy
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Tạo Variant
            </button>
        </div>
    </form>
</div>

<script>
function previewImages(event) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    
    const files = event.target.files;
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative group';
            div.innerHTML = `
                <img src="${e.target.result}" 
                     class="w-full h-24 object-cover rounded-lg border border-slate-700">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition rounded-lg flex items-center justify-center">
                    <span class="text-white text-xs opacity-0 group-hover:opacity-100 transition">Ảnh ${i + 1}</span>
                </div>
            `;
            preview.appendChild(div);
        };
        
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
