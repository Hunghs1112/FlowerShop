@extends('layouts.app')

@section('title', $post->title)

@section('content')
<x-page-hero
    title="{{ $post->title }}"
    :description="$post->excerpt ?? ''"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Bài viết', 'url' => route('blog.index')],
        ['label' => Str::limit($post->title, 30)]
    ]"
    :image="$siteBanners['blog'] ?? null"
    height="350px"
/>

<div class="container page-wrapper">
    <div class="page-content">
        <!-- Post Meta -->
        <div class="post-detail-meta">
            <span class="post-meta-item">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $post->published_at->translatedFormat('d M, Y') }}
            </span>
            <span class="post-meta-item">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $post->getReadingTime() }} phút đọc
            </span>
        </div>

        <!-- Featured Image -->
        @if($post->thumbnail)
            <div class="post-featured-image">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
            </div>
        @endif

        <!-- Post Content -->
        <x-markdown-renderer :content="$post->content" />

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <section class="related-posts">
                <h2 class="section-title">Bài viết liên quan</h2>
                <div class="blog-grid">
                    @foreach($relatedPosts as $relatedPost)
                        <article class="post-card">
                            @if($relatedPost->thumbnail)
                                <div class="post-card-image">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}">
                                        <img src="{{ $relatedPost->image_url }}" alt="{{ $relatedPost->title }}">
                                    </a>
                                </div>
                            @endif
                            
                            <div class="post-card-body">
                                <div class="post-card-meta">
                                    <span class="post-card-date">
                                        {{ $relatedPost->published_at->translatedFormat('d M, Y') }}
                                    </span>
                                </div>
                                
                                <h3 class="post-card-title">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h3>
                                
                                <p class="post-card-excerpt">
                                    {{ Str::limit($relatedPost->excerpt, 100) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Back to list --}}
        <div class="post-navigation">
            <a href="{{ route('blog.index') }}" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Quay lại danh sách
            </a>
        </div>
    </div>
</div>
@endsection
