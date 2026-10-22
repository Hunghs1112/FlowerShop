@extends('layouts.app')

@section('title', __('account.favorites_title'))

@section('content')
{{-- Page Hero --}}
<x-page-hero 
    :title="__('account.favorites_title')"
    :subtitle="__('account.favorites_subtitle')"
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
                <h3 class="favorites-empty__title">{{ __('account.favorites_empty_title') }}</h3>
                <p class="favorites-empty__text">{{ __('account.favorites_empty_text') }}</p>
                <a href="{{ localized_route('products.index') }}" class="btn btn--primary">
                    {{ __('account.explore_products') }}
                </a>
            </div>
        @else
            {{-- Favorites Grid --}}
            <div class="favorites-header">
                <p class="favorites-count">{{ __('account.products_count', ['count' => $favorites->total()]) }}</p>
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
