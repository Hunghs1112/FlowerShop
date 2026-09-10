{{-- Inspiration/Blog Section --}}
<section class="inspiration-section">
    <div class="inspiration-container">
        {{-- Header --}}
        <div class="inspiration-header">
            <div class="inspiration-eyebrow">{{ __('messages.home.inspiration_eyebrow') ?? 'GÓC NHỎ CỦA CHÚNG TÔI' }}</div>
            <h2 class="inspiration-heading">{{ __('messages.home.inspiration_title') }}</h2>
            <p class="inspiration-description">{{ __('messages.home.inspiration_subtitle') }}</p>
        </div>
        
        {{-- Blog Grid --}}
        @if(isset($latestPosts) && $latestPosts->count() > 0)
        <div class="inspiration-grid">
            @foreach($latestPosts as $post)
            <a href="{{ locale_route('blog.show', $post->slug) }}" class="blog-card">
                <div class="blog-card-image-container">
                    <img 
                        src="{{ $post->image_url }}" 
                        alt="{{ $post->title }}"
                        class="blog-card-image"
                        loading="lazy"
                    >
                    <span class="blog-card-category">{{ __('messages.blog.post_label') ?? 'Bài viết' }}</span>
                </div>
                <div class="blog-card-content">
                    <h3 class="blog-card-title">{{ $post->title }}</h3>
                    <p class="blog-card-excerpt">{{ Str::limit($post->excerpt ?? $post->content, 100) }}</p>
                        <span class="blog-card-link">
                            {{ __('messages.blog.read_more') }}
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        @endif
        
        {{-- View All Button --}}
        <div class="inspiration-footer">
            <a href="{{ locale_route('blog.index') }}" class="inspiration-view-all">
                {{ __('messages.common.view_all') }}
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
