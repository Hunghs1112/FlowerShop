@extends('layouts.app')

@section('title', $page->title)

@section('content')
<x-page-hero
    :title="$page->title"
    :description="$page->excerpt ?? 'Thông tin quan trọng về chính sách của chúng tôi'"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => $page->title]
    ]"
    :image="$pageBanner['custom'] ?? $siteBanners['about'] ?? null"
    :hideOverlay="$pageBanner['hide_overlay'] ?? ($siteBannerHideOverlay['about'] ?? false)"
    height="350px"
/>

<div class="container page-wrapper">
    <div class="page-content">
        <x-markdown-renderer :content="$page->content" class="page-body" />
    </div>
</div>
@endsection
