@extends('layouts.app')

@section('title', 'Sản phẩm yêu thích')

@section('content')
{{-- Page Hero --}}
<x-page-hero 
    title="Sản phẩm yêu thích"
    subtitle="Những sản phẩm bạn đã lưu"
/>

{{-- Favorites Content --}}
<section class="favorites-section">
    <div class="container">
        @if($favorites->isEmpty())
            {{-- Empty State --}}
            <div class="favorites-empty">
                <svg class="favorites-empty__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <h3 class="favorites-empty__title">Chưa có sản phẩm yêu thích</h3>
                <p class="favorites-empty__text">Hãy khám phá và lưu những sản phẩm bạn thích để xem lại sau</p>
                <a href="{{ route('products.index') }}" class="btn btn--primary">
                    Khám phá sản phẩm
                </a>
            </div>
        @else
            {{-- Favorites Grid --}}
            <div class="favorites-header">
                <p class="favorites-count">{{ $favorites->total() }} sản phẩm</p>
            </div>

            <div class="products-grid">
                @foreach($favorites as $favorite)
                    <x-product-card :product="$favorite->product" />
                @endforeach
            </div>

        @endif
    </div>
</section>
@endsection
