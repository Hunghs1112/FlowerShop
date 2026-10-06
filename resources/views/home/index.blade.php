@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="home-page">
    {{-- Hero Section --}}
    @include('home.sections.hero')

    @include('home.sections.flight-board')

    {{-- Mystery Box Banner Section --}}
    @include('home.sections.mystery-box-banner')

    {{-- Best Selling Products Section --}}
    @include('home.sections.products')

    {{-- Categories Discovery Section --}}
    @include('home.sections.categories')

    @include('home.sections.origin-map')

    {{-- Brand Values Section --}}
    @include('home.sections.brand-values')

    {{-- Inspiration/Blog Section --}}
    @include('home.sections.inspiration')

    {{-- Instagram Gallery Section --}}
    @include('home.sections.instagram')
    @include('home.sections.partner-cta')
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home-redesign.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="{{ asset('js/lnt-chuyen-hoa.js') }}" defer></script>
@endpush
