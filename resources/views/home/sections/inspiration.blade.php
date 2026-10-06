{{-- Inspiration/Blog Section --}}
<section class="inspiration-section">
    <div class="container">
        {{-- Header --}}
        <div class="inspiration-section-header">
            <span class="inspiration-section-label">{{ content('home_journal_label', 'LNT Journal') }}</span>
            <h2 class="inspiration-section-title">{{ content('home_journal_title', 'Những câu chuyện tuyệt đẹp') }}</h2>
            <p class="inspiration-section-description">
                {{ content('inspiration_description', 'Khám phá những câu chuyện thú vị về hoa, cách chăm sóc và những ý tưởng trang trí độc đáo.') }}
            </p>
        </div>
        
        {{-- Blog Grid --}}
        @if(isset($latestPosts) && $latestPosts->count() > 0)
        <div class="inspiration-grid">
            @foreach($latestPosts as $post)
            <article class="inspiration-card">
                <a href="{{ route('blog.show', $post->slug) }}" class="inspiration-card-image-link">
                    <img 
                        src="{{ $post->image_url }}" 
                        alt="{{ $post->title }}"
                        class="inspiration-card-image"
                        loading="lazy"
                        width="600"
                        height="400"
                    >
                    <span class="inspiration-card-badge">{{ content('inspiration_badge', 'Bài viết') }}</span>
                </a>
                <div class="inspiration-card-content">
                    <time class="inspiration-card-date">{{ $post->created_at->format('d/m/Y') }}</time>
                    <h3 class="inspiration-card-title">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    <p class="inspiration-card-excerpt">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}</p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="inspiration-card-link">
                        {{ content('inspiration_read_more', 'Đọc tiếp') }}
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @endif
        
        {{-- View All Button --}}
        <div class="inspiration-section-footer">
            <a href="{{ route('blog.index') }}" class="btn btn-outline">
                {{ content('inspiration_view_all', 'Xem tất cả bài viết') }}
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
