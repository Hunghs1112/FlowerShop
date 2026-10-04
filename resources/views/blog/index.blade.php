@extends('layouts.app')

@section('title', 'Bài viết')

@section('content')
<x-page-hero 
    title="Bài viết"
    description="Khám phá những câu chuyện thú vị về hoa, cách chăm sóc và cảm hứng trang trí"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Bài viết']
    ]"
    :image="$siteBanners['blog'] ?? null"
    :hideOverlay="$siteBannerHideOverlay['blog'] ?? false"
    height="420px"
/>

<div class="container page-wrapper">
    <!-- Search Bar -->
    <div class="blog-search">
        <form method="GET" action="{{ route('blog.index') }}" class="search-form">
            <input type="text" name="search" placeholder="Tìm kiếm bài viết..." 
                   value="{{ request('search') }}" class="search-input">
            <button type="submit" class="search-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- Posts Grid -->
    @if($posts->count() > 0)
        <div class="blog-grid">
            @foreach($posts as $post)
                <article class="post-card">
                    <div class="post-card-image">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            @if($post->thumbnail)
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                            @else
                                <div class="post-card-placeholder">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                        </a>
                    </div>
                    
                    <div class="post-card-body">
                        <div class="post-card-meta">
                            <span class="post-card-date">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $post->published_at->translatedFormat('d M, Y') }}
                            </span>
                            <span class="post-card-reading-time">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $post->getReadingTime() }} phút đọc
                            </span>
                        </div>
                        
                        <h2 class="post-card-title">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h2>
                        
                        <p class="post-card-excerpt">
                            {{ Str::limit($post->excerpt, 150) }}
                        </p>
                        
                        <a href="{{ route('blog.show', $post->slug) }}" class="post-card-link">
                            Xem thêm
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3>Không có bài viết nào</h3>
            <p>{{ request('search') ? 'Thử tìm kiếm với từ khóa khác' : 'Hiện chưa có bài viết nào.' }}</p>
            @if(request('search'))
                <a href="{{ route('blog.index') }}" class="btn btn-primary">Quay lại</a>
            @endif
        </div>
    @endif
</div>

@endsection
