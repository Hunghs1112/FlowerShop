@extends('layouts.app')

@section('title', __('storefront.add_article'))

@section('content')
<main class="inspiration-page">
    <div class="inspiration-shell" style="max-width: 900px;">
        <section class="journal-header">
            <div class="journal-breadcrumb">
                <a href="{{ localized_route('home') }}">{{ __('ui.home') }}</a>
                <span aria-hidden="true">/</span>
                <a href="{{ localized_route('blog.index') }}">{{ __('ui.inspiration') }}</a>
                <span aria-hidden="true">/</span>
                <span>{{ __('storefront.add_article') }}</span>
            </div>
            <p class="journal-eyebrow">{{ __('storefront.share_stories') }}</p>
            <h1>{{ __('storefront.add_article') }}</h1>
            <p class="journal-intro">{{ __('storefront.article_intro', ['name' => auth()->user()->name]) }}</p>
        </section>

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ localized_route('blog.store') }}" enctype="multipart/form-data" style="display:grid; gap:20px; padding:clamp(20px,4vw,40px); background:var(--color-surface); border:1px solid var(--color-border);">
            @csrf

            <label>{{ __('storefront.article_title') }} <input class="form-input" type="text" name="title" value="{{ old('title') }}" maxlength="255" required></label>

            <label>{{ __('storefront.article_category') }}
                <select class="form-input" name="category" required>
                    @foreach(\App\Models\Post::CATEGORIES as $key => $label)
                        <option value="{{ $key }}" @selected(old('category') === $key)>{{ __('storefront.post_category_' . str_replace('-', '_', $key)) }}</option>
                    @endforeach
                </select>
            </label>

            <label>{{ __('storefront.article_excerpt') }} <textarea class="form-input" name="excerpt" rows="3" maxlength="500">{{ old('excerpt') }}</textarea></label>
            <label>{{ __('storefront.article_content') }} <textarea class="form-input" id="contentEditor" name="content" rows="14" required>{{ old('content') }}</textarea></label>
            <x-post-content-image-upload />
            <label>{{ __('storefront.article_cover') }} <span aria-hidden="true">*</span>
                <input class="form-input" type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.gif,.webp" required>
                <small>{{ __('storefront.article_cover_hint') }}</small>
            </label>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a class="btn btn-secondary" href="{{ localized_route('blog.index') }}">{{ __('storefront.cancel') }}</a>
                <button class="btn btn-primary" type="submit">{{ __('storefront.publish_article') }}</button>
            </div>
        </form>
    </div>
</main>
@endsection
