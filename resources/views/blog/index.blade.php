@extends('layouts.app')

@section('title', 'Góc cảm hứng')

@php
    $journalCategories = [
        'all' => 'Tất cả',
    ] + \App\Models\Post::CATEGORIES;

    $resolveCategory = fn ($post) => $post->category ?: 'cam-hung';

    $featuredPost = $posts->getCollection()->first();
    $gridPosts = $posts->getCollection()->skip(1);
@endphp

@section('content')
<main class="inspiration-page">
    <div class="inspiration-shell">
        <section class="journal-header">
            <div class="journal-breadcrumb">
                <a href="{{ route('home') }}">Trang chủ</a>
                <span aria-hidden="true">/</span>
                <span>Góc cảm hứng</span>
            </div>

            <p class="journal-eyebrow">GÓC CẢM HỨNG</p>
            <h1>LNT Journal</h1>
            <p class="journal-intro">Tạp chí trên chuyến bay: câu chuyện từ những vùng đất hoa, sổ tay chăm hoa và cảm hứng cho những nơi tuyệt đẹp.</p>

            <div class="journal-toolbar">
                <div class="journal-tabs" role="group" aria-label="Chuyên mục bài viết">
                    @foreach($journalCategories as $key => $label)
                        <a class="journal-tab" href="{{ route('blog.index', array_filter(['category' => $key === 'all' ? null : $key, 'search' => $search])) }}" aria-pressed="{{ ($category ?? null) === ($key === 'all' ? null : $key) ? 'true' : 'false' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                <form method="GET" action="{{ route('blog.index') }}" class="journal-search" role="search">
                    @if($category)<input type="hidden" name="category" value="{{ $category }}">@endif
                    <label class="sr-only" for="journal-search-input">Tìm kiếm bài viết</label>
                    <input id="journal-search-input" type="search" name="search" value="{{ $search }}" placeholder="Tìm trong journal...">
                    <button type="submit" aria-label="Tìm kiếm">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-4-4"></path></svg>
                    </button>
                </form>

                <a class="btn btn-primary" href="{{ route('blog.create') }}">Thêm bài viết</a>
            </div>
        </section>

        @if($showingProjectFallback)
            <p class="journal-empty">Chuyên mục này chưa có bài viết. Dưới đây là các dự án đã hợp tác với đối tác.</p>
        @endif

        @if($featuredPost)
            <a class="journal-feature" data-category="{{ $resolveCategory($featuredPost) }}" href="{{ route('blog.show', $featuredPost->slug) }}">
                <div class="journal-cover journal-cover--feature">
                    <span class="journal-mark">LNT JOURNAL</span>
                    <span class="journal-issue">SỐ MỚI NHẤT</span>
                    <img src="{{ $featuredPost->image_url }}" alt="{{ $featuredPost->title }}" loading="eager">
                </div>
                <div class="journal-feature-copy">
                    <span class="journal-kicker">SỐ MỚI NHẤT · {{ $journalCategories[$resolveCategory($featuredPost)] }}</span>
                    <h2>{{ $featuredPost->title }}</h2>
                    <p>{{ Str::limit($featuredPost->excerpt ?: strip_tags($featuredPost->content), 180) }}</p>
                    <span class="journal-meta">{{ $featuredPost->published_at->translatedFormat('d.m.Y') }}@if($featuredPost->author) · {{ $featuredPost->author->name }}@endif · Đọc bài <span aria-hidden="true">→</span></span>
                </div>
            </a>
        @endif

        <div class="journal-grid" id="journal-grid">
            @foreach($gridPosts as $post)
                @php($cardCategory = $resolveCategory($post))
                <a class="journal-card" data-category="{{ $cardCategory }}" href="{{ route('blog.show', $post->slug) }}">
                    <div class="journal-cover">
                        <span class="journal-mark">LNT JOURNAL</span>
                        <span class="journal-issue">{{ $post->published_at->format('d.m.Y') }}</span>
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="lazy">
                    </div>
                    <h3>{{ $post->title }}</h3>
                    <p>{{ Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}</p>
                    <span class="journal-meta">{{ $journalCategories[$cardCategory] }}@if($post->author) · {{ $post->author->name }}@endif</span>
                </a>
            @endforeach
        </div>

        <p class="journal-empty" id="journal-empty" hidden>Chuyên mục này sẽ sớm có những câu chuyện đầu tiên.</p>

        @if($posts->hasPages())
            <nav class="journal-pagination" aria-label="Phân trang bài viết">
                {{ $posts->onEachSide(1)->links() }}
            </nav>
        @endif
    </div>
</main>

@endsection
