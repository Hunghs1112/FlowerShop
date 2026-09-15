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
    :image="$siteBanners['about'] ?? null"
    height="350px"
/>

<div class="container page-wrapper">
    <div class="page-content">
        <div class="page-body">
            {!! nl2br(e($page->content)) !!}
        </div>
    </div>
</div>
@endsection
