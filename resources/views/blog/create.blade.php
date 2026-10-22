@extends('layouts.app')

@section('title', 'Thêm bài viết')

@section('content')
<main class="inspiration-page">
    <div class="inspiration-shell" style="max-width: 900px;">
        <section class="journal-header">
            <div class="journal-breadcrumb">
                <a href="{{ localized_route('home') }}">Trang chủ</a>
                <span aria-hidden="true">/</span>
                <a href="{{ localized_route('blog.index') }}">{{ __('ui.inspiration') }}</a>
                <span aria-hidden="true">/</span>
                <span>Thêm bài viết</span>
            </div>
            <p class="journal-eyebrow">CHIA SẺ CÂU CHUYỆN</p>
            <h1>Thêm bài viết</h1>
            <p class="journal-intro">Bài viết sẽ hiển thị với tên tác giả {{ auth()->user()->name }}.</p>
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

            <label>Tiêu đề <input class="form-input" type="text" name="title" value="{{ old('title') }}" maxlength="255" required></label>

            <label>Chuyên mục
                <select class="form-input" name="category" required>
                    @foreach(\App\Models\Post::CATEGORIES as $key => $label)
                        <option value="{{ $key }}" @selected(old('category') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label>Trích dẫn <textarea class="form-input" name="excerpt" rows="3" maxlength="500">{{ old('excerpt') }}</textarea></label>
            <label>Nội dung <textarea class="form-input" id="contentEditor" name="content" rows="14" required>{{ old('content') }}</textarea></label>
            <x-post-content-image-upload />
            <label>Ảnh thumbnail <span aria-hidden="true">*</span>
                <input class="form-input" type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.gif,.webp" required>
                <small>Ảnh đại diện của bài viết, tối đa 2 MB.</small>
            </label>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a class="btn btn-secondary" href="{{ localized_route('blog.index') }}">Hủy</a>
                <button class="btn btn-primary" type="submit">Đăng bài viết</button>
            </div>
        </form>
    </div>
</main>
@endsection
