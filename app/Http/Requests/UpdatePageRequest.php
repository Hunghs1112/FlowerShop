<?php

namespace App\Http\Requests;

use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
        $isPolicy = $page instanceof Page && in_array($page->slug, Page::POLICY_SLUGS, true);

        if ($isPolicy) {
            return [
                'title' => 'required|string|max:255',
                'slug' => 'prohibited',
                'content' => 'prohibited',
                'policy_intro' => 'nullable|string|max:1000',
                'policy_updated_at_display' => 'nullable|string|max:60',
                'policy_content_override' => 'nullable|string|max:200000',
                'is_active' => 'boolean',
            ];
        }

        return [
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', 'unique:pages,slug,' . $page->id, Rule::notIn(Page::STATIC_SLUGS)],
            'content' => 'required|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'header_image' => 'nullable|string|max:500',
            'hide_header_overlay' => 'boolean',
            'policy_content_override' => 'prohibited',
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
        // Keep fixed policy slugs out of the generic slug generation path.
        $page = $this->route('page');
        $isPolicy = $page instanceof Page && in_array($page->slug, Page::POLICY_SLUGS, true);
        if (!$isPolicy && empty($this->input('slug')) && !empty($this->input('title'))) {
            $this->merge(['slug' => Str::slug($this->input('title'))]);
        }

        // Set boolean defaults
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'hide_header_overlay' => $this->boolean('hide_header_overlay'),
        ]);
    }
}
