<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Post;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $maxKb = (int) config('upload.limits.post_thumbnail.max_size', 2048);

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'category' => ['required', Rule::in(array_keys(Post::CATEGORIES))],
            'content' => 'required|string',
            'thumbnail' => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề bài viết là bắt buộc',
            'title.max' => 'Tiêu đề bài viết không được vượt quá 255 ký tự',
            'content.required' => 'Nội dung bài viết là bắt buộc',
            'slug.unique' => 'Slug bài viết đã tồn tại',
            'status.required' => 'Trạng thái bài viết là bắt buộc',
            'status.in' => 'Trạng thái bài viết không hợp lệ',
            'thumbnail.mimes' => 'Hình ảnh đại diện phải có định dạng: jpg, jpeg, png, gif, webp',
            'thumbnail.max' => 'Kích thước hình ảnh đại diện không được vượt quá ' . config('upload.limits.post_thumbnail.max_size', 2048) . ' KB',
            'published_at.date' => 'Ngày xuất bản không hợp lệ',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Auto-generate slug if empty
        if (empty($this->input('slug')) && !empty($this->input('title'))) {
            $this->merge(['slug' => Str::slug($this->input('title'))]);
        }
    }
}
