@extends('layouts.app')

@section('title', __('storefront.blog_title'))

@php
    $journalCategories = [
        'all' => __('storefront.all'),
        ] + collect(\App\Models\Post::CATEGORIES)->mapWithKeys(fn ($label, $key) => [$key => __('storefront.post_category_' . str_replace('-', '_', $key))])->all();

    $resolveCategory = fn ($post) => $post->category ?: 'cam-hung';

    $featuredPost = $posts->getCollection()->first();
    $gridPosts = $posts->getCollection()->skip(1);
@endphp

@section('content')
<main class="inspiration-page">
    <div class="inspiration-shell">
        <section class="journal-header">
            <div class="journal-breadcrumb">
                <a href="{{ localized_route('home') }}">{{ __('ui.home') }}</a>
                <span aria-hidden="true">/</span>
                <span>{{ __('ui.inspiration') }}</span>
            </div>

            <p class="journal-eyebrow">{{ __('storefront.blog_eyebrow') }}</p>
            <h1>LNT Journal</h1>
            <p class="journal-intro">{{ __('storefront.blog_intro') }}</p>

            <div class="journal-toolbar">
                <div class="journal-tabs" role="group" aria-label="{{ __('storefront.blog_categories') }}">
                    @foreach($journalCategories as $key => $label)
                        <a class="journal-tab" href="{{ localized_route('blog.index', array_filter(['category' => $key === 'all' ? null : $key, 'search' => $search])) }}" aria-pressed="{{ ($category ?? null) === ($key === 'all' ? null : $key) ? 'true' : 'false' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                <form method="GET" action="{{ localized_route('blog.index') }}" class="journal-search" role="search">
                    @if($category)<input type="hidden" name="category" value="{{ $category }}">@endif
                    <label class="sr-only" for="journal-search-input">{{ __('storefront.search_articles') }}</label>
                    <input id="journal-search-input" type="search" name="search" value="{{ $search }}" placeholder="{{ __('storefront.search_articles') }}">
                    <button type="submit" aria-label="{{ __('storefront.searching') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-4-4"></path></svg>
                    </button>
                </form>

                <a class="btn btn-primary" href="{{ localized_route('blog.create') }}">{{ __('storefront.add_article') }}</a>
            </div>
        </section>

        @if($showingFeedbackFallback)
            <p class="journal-empty">{{ __('storefront.empty_category') }}</p>
        @endif

        @if($featuredPost)
            <a class="journal-feature" data-category="{{ $resolveCategory($featuredPost) }}" href="{{ localized_route('blog.show', $featuredPost->display_slug) }}">
                <div class="journal-cover journal-cover--feature">
                    <span class="journal-mark">LNT JOURNAL</span>
                    <span class="journal-issue">{{ __('storefront.latest_issue') }}</span>
                    <img src="{{ $featuredPost->image_url }}" alt="{{ $featuredPost->display_title }}" loading="eager">
                </div>
                <div class="journal-feature-copy">
                    <span class="journal-kicker">{{ __('storefront.latest_issue') }} · {{ $journalCategories[$resolveCategory($featuredPost)] }}</span>
                    <h2>{{ $featuredPost->display_title }}</h2>
                    <p>{{ Str::limit($featuredPost->display_excerpt ?: strip_tags($featuredPost->display_content), 180) }}</p>
                    <span class="journal-meta">{{ $featuredPost->published_at->translatedFormat('d.m.Y') }}@if($featuredPost->author) · {{ $featuredPost->author->name }}@endif · {{ __('storefront.read_article') }} <span aria-hidden="true">→</span></span>
                </div>
            </a>
        @endif

        <div class="journal-grid" id="journal-grid">
            @foreach($gridPosts as $post)
                @php($cardCategory = $resolveCategory($post))
                <a class="journal-card" data-category="{{ $cardCategory }}" href="{{ localized_route('blog.show', $post->display_slug) }}">
                    <div class="journal-cover">
                        <span class="journal-mark">LNT JOURNAL</span>
                        <span class="journal-issue">{{ $post->published_at->format('d.m.Y') }}</span>
                        <img src="{{ $post->image_url }}" alt="{{ $post->display_title }}" loading="lazy">
                    </div>
                    <h3>{{ $post->display_title }}</h3>
                    <p>{{ Str::limit($post->display_excerpt ?: strip_tags($post->display_content), 120) }}</p>
                    <span class="journal-meta">{{ $journalCategories[$cardCategory] }}@if($post->author) · {{ $post->author->name }}@endif</span>
                </a>
            @endforeach
        </div>

        @if($posts->isEmpty())
            <p class="journal-empty">{{ __('storefront.empty_journal') }}</p>
        @endif

        @if($posts->hasPages())
            <nav class="journal-pagination" aria-label="{{ __('storefront.blog_pagination') }}">
                {{ $posts->onEachSide(1)->links() }}
            </nav>
        @endif
    </div>
</main>

@endsection
