<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $page = $this->route('page');

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'header_image' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề trang là bắt buộc',
            'title.max' => 'Tiêu đề trang không được vượt quá 255 ký tự',
            'content.required' => 'Nội dung trang là bắt buộc',
            'slug.unique' => 'Slug trang đã tồn tại',
            'meta_title.max' => 'Meta title không được vượt quá 255 ký tự',
            'meta_description.max' => 'Meta description không được vượt quá 500 ký tự',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Auto-generate slug if empty
        if (empty($this->input('slug')) && !empty($this->input('title'))) {
            $this->merge(['slug' => Str::slug($this->input('title'))]);
        }

        // Set boolean defaults
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
