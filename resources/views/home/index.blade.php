@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    {{-- Hero Section --}}
    @include('home.sections.hero')

    {{-- Mystery Box Banner Section --}}
    @include('home.sections.mystery-box-banner')

    {{-- Best Selling Products Section --}}
    @include('home.sections.products')

    {{-- Categories Discovery Section --}}
    @include('home.sections.categories')

    {{-- Brand Values Section --}}
    @include('home.sections.brand-values')

    {{-- Inspiration/Blog Section --}}
    @include('home.sections.inspiration')

    {{-- Instagram Gallery Section --}}
    @include('home.sections.instagram')
@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
