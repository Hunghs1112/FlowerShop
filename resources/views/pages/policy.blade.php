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
    height="350px"
/>

<div class="container" style="padding: var(--space-8) var(--space-4);">
    <div class="page-content">
        <div class="page-body">
            {!! nl2br(e($page->content)) !!}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .page-content {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .page-body {
        font-size: var(--font-size-base);
        line-height: 1.8;
        color: var(--color-text);
    }
    
    .page-body h2 {
        font-size: var(--font-size-2xl);
        font-weight: var(--font-bold);
        margin-top: var(--space-12);
        margin-bottom: var(--space-4);
    }
    
    .page-body h3 {
        font-size: var(--font-size-xl);
        font-weight: var(--font-semibold);
        margin-top: var(--space-8);
        margin-bottom: var(--space-3);
    }
    
    .page-body p {
        margin-bottom: var(--space-6);
        color: var(--color-text-secondary);
    }
    
    .page-body ul,
    .page-body ol {
        margin-bottom: var(--space-6);
        padding-left: var(--space-8);
    }
    
    .page-body li {
        margin-bottom: var(--space-3);
        color: var(--color-text-secondary);
    }
    
    .page-body a {
        color: var(--color-accent-cool);
        text-decoration: underline;
    }
    
    .page-body a:hover {
        color: var(--color-accent-cool-hover);
    }
    
    .page-body strong {
        color: var(--color-text);
        font-weight: var(--font-semibold);
    }
</style>
@endpush
