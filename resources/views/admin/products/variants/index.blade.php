@extends('layouts.admin')

@section('title', 'Quản lý Variants - ' . $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2 flex items-center gap-3">
                <div class="w-2 h-8 bg-gradient-to-b from-cyan-400 to-blue-500 rounded-full"></div>
                Quản lý Variants
            </h1>
            <div class="flex items-center gap-2 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>Sản phẩm:</span>
                <span class="text-cyan-400 font-medium">{{ $product->name }}</span>
                <span class="text-slate-600">•</span>
                <span class="text-sm bg-slate-700 px-2 py-1 rounded">{{ $variants->count() }} variants</span>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}" 
               class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-100 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Quay lại danh sách
            </a>
            <a href="{{ route('admin.products.variants.create', $product->id) }}" 
               class="px-4 py-2 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-500 hover:to-red-500 text-white rounded-lg transition flex items-center gap-2 shadow-lg shadow-orange-600/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm Variant
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg backdrop-blur-sm">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-emerald-400">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if($variants->isEmpty())
    <div class="bg-slate-800 border border-slate-700 rounded-xl p-12 text-center">
        <div class="text-slate-400 mb-4">
            <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl flex items-center justify-center">
                <svg class="w-12 h-12 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-slate-300 mb-2">Chưa có variant nào</h3>
            <p class="text-sm">Tạo variants để quản lý các phiên bản khác nhau của sản phẩm</p>
        </div>
        <a href="{{ route('admin.products.variants.create', $product->id) }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white rounded-lg transition shadow-lg shadow-cyan-600/25">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tạo variant đầu tiên
        </a>
    </div>
    @else
    <div class="grid gap-4">
        @foreach($variants as $variant)
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 hover:border-slate-600 transition-all duration-200 hover:shadow-lg hover:shadow-slate-900/50 group">
            <div class="flex items-start gap-6">
                <!-- Ảnh -->
                <div class="flex-shrink-0">
                    @if($variant->images && $variant->images->isNotEmpty())
                        <div class="relative overflow-hidden rounded-xl">
                            <img src="{{ $variant->images->first()->image_url }}" 
                                 alt="{{ $variant->getDisplayName() }}"
                                 class="w-24 h-24 object-cover border border-slate-700 transition-transform duration-200 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
                        </div>
                    @else
                        <div class="w-24 h-24 bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Thông tin -->
                <div class="flex-grow">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-slate-100 mb-2 flex items-center gap-2">
                                {{ $variant->getDisplayName() }}
                                @if(!$variant->name)
                                    <span class="text-xs text-slate-500 font-normal bg-slate-700 px-2 py-1 rounded-full">(từ sản phẩm gốc)</span>
                                @endif
                            </h3>
                            <p class="text-sm text-slate-400 font-mono bg-slate-700/50 px-2 py-1 rounded inline-block">
                                SKU: {{ $variant->sku }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($variant->is_active)
                                <span class="px-3 py-1.5 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-full border border-emerald-500/20 flex items-center gap-1">
                                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                                    Đang bán
                                </span>
                            @else
                                <span class="px-3 py-1.5 bg-slate-700 text-slate-400 text-xs font-medium rounded-full border border-slate-600 flex items-center gap-1">
                                    <div class="w-2 h-2 bg-slate-500 rounded-full"></div>
                                    Tạm dừng
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        @if($variant->color)
                        <div class="bg-slate-700/30 rounded-lg p-3">
                            <p class="text-xs text-slate-500 mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm0 2h12v11H4V4z" clip-rule="evenodd"/>
                                </svg>
                                Màu sắc
                            </p>
                            <p class="text-sm text-slate-200 font-medium">{{ $variant->color }}</p>
                        </div>
                        @endif

                        @if($variant->size)
                        <div class="bg-slate-700/30 rounded-lg p-3">
                            <p class="text-xs text-slate-500 mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                Kích thước
                            </p>
                            <p class="text-sm text-slate-200 font-medium">{{ $variant->size }}</p>
                        </div>
                        @endif

                        <div class="bg-gradient-to-br from-cyan-500/10 to-blue-500/10 border border-cyan-500/20 rounded-lg p-3">
                            <p class="text-xs text-cyan-400 mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                                Giá bán
                            </p>
                            <p class="text-base font-bold text-cyan-400">
                                {{ number_format($variant->getDisplayPrice()) }}₫
                                @if(!$variant->price)
                                    <span class="text-xs text-slate-500 font-normal ml-1">(gốc)</span>
                                @endif
                            </p>
                        </div>

                        <div class="bg-slate-700/30 rounded-lg p-3">
                            <p class="text-xs text-slate-500 mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                Tồn kho
                            </p>
                            <p class="text-sm text-slate-200 font-medium flex items-center gap-2">
                                {{ $variant->stock }} 
                                @if($variant->stock < 10)
                                    <span class="text-orange-400 text-xs bg-orange-400/10 px-2 py-1 rounded-full border border-orange-400/20">Thấp</span>
                                @elseif($variant->stock > 50)
                                    <span class="text-emerald-400 text-xs bg-emerald-400/10 px-2 py-1 rounded-full border border-emerald-400/20">Cao</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-700">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.products.variants.edit', [$product->id, $variant->id]) }}"
                               class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-100 text-sm rounded-lg transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Chỉnh sửa
                            </a>
                            <form action="{{ route('admin.products.variants.destroy', [$product->id, $variant->id]) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Bạn có chắc muốn xóa variant này?')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600/10 hover:bg-red-600/20 text-red-400 text-sm rounded-lg transition border border-red-600/20 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Xóa
                                </button>
                            </form>
                        </div>
                        
                        <div class="flex items-center gap-3 text-xs text-slate-500">
                            @if($variant->images->count() > 1)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $variant->images->count() }} ảnh
                                </span>
                            @endif
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1v0a1 1 0 011 1v3M7 4H5a2 2 0 00-2 2v1a1 1 0 001 1h16a1 1 0 001-1V6a2 2 0 00-2-2h-2M7 4h10"/>
                                </svg>
                                #{{ $variant->sort_order }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
/* Custom animations for better UX */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.group:hover {
    animation: fadeInUp 0.2s ease-out;
}

/* Pulse animation for active status */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
@endsection
