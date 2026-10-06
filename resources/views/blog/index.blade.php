@extends('layouts.app')

@section('title', 'Góc cảm hứng')

@php
    $journalCategories = [
        'all' => 'Tất cả',
        'vung-dat' => 'Câu chuyện vùng đất',
        'cham-hoa' => 'Sổ tay chăm hoa',
        'mua-hoa' => 'Mùa hoa',
        'khong-gian' => 'Cảm hứng không gian',
        'cam-hung' => 'Cảm hứng',
        'hau-truong' => 'Hậu trường',
    ];

    $categoryPatterns = [
        'vung-dat' => ['vung dat', 'vùng đất', 'nguon goc', 'ecuador'],
        'cham-hoa' => ['cham hoa', 'chăm hoa', 'cam tu cau', 'cẩm tú cầu'],
        'mua-hoa' => ['mua hoa', 'mùa hoa', 'theo mua', 'theo mùa'],
        'khong-gian' => ['khong gian', 'không gian', 'cam hoa tai nha', 'cắm hoa tại nhà'],
        'hau-truong' => ['hau truong', 'hậu trường', 'mo thung', 'mở thùng'],
    ];

    $resolveCategory = function ($post) use ($categoryPatterns) {
        $haystack = Str::lower($post->title . ' ' . $post->slug . ' ' . ($post->excerpt ?? ''));

        foreach ($categoryPatterns as $category => $patterns) {
            foreach ($patterns as $pattern) {
                if (Str::contains($haystack, Str::lower($pattern))) {
                    return $category;
                }
            }
        }

        return 'cam-hung';
    };

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
                        <button type="button" class="journal-tab" data-category="{{ $key }}" aria-pressed="{{ $key === 'all' ? 'true' : 'false' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <form method="GET" action="{{ route('blog.index') }}" class="journal-search" role="search">
                    <label class="sr-only" for="journal-search-input">Tìm kiếm bài viết</label>
                    <input id="journal-search-input" type="search" name="search" value="{{ $search }}" placeholder="Tìm trong journal...">
                    <button type="submit" aria-label="Tìm kiếm">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-4-4"></path></svg>
                    </button>
                </form>
            </div>
        </section>

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
                    <span class="journal-meta">{{ $featuredPost->published_at->translatedFormat('d.m.Y') }} · Đọc bài <span aria-hidden="true">→</span></span>
                </div>
            </a>
        @endif

        <div class="journal-grid" id="journal-grid">
            @foreach($gridPosts as $post)
                @php($category = $resolveCategory($post))
                <a class="journal-card" data-category="{{ $category }}" href="{{ route('blog.show', $post->slug) }}">
                    <div class="journal-cover">
                        <span class="journal-mark">LNT JOURNAL</span>
                        <span class="journal-issue">{{ $post->published_at->format('d.m.Y') }}</span>
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="lazy">
                    </div>
                    <h3>{{ $post->title }}</h3>
                    <p>{{ Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}</p>
                    <span class="journal-meta">{{ $journalCategories[$category] }}</span>
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

@push('scripts')
<script>
    (() => {
        const tabs = [...document.querySelectorAll('.journal-tab')];
        const posts = [...document.querySelectorAll('.journal-feature, .journal-card')];
        const empty = document.getElementById('journal-empty');

        tabs.forEach(tab => tab.addEventListener('click', () => {
            tabs.forEach(item => item.setAttribute('aria-pressed', String(item === tab)));
            const category = tab.dataset.category;
            let visible = 0;

            posts.forEach(post => {
                const matches = category === 'all' || post.dataset.category === category;
                post.hidden = !matches;
                if (matches) visible++;
            });

            empty.hidden = visible > 0;
        }));
    })();
</script>
@endpush
@endsection
