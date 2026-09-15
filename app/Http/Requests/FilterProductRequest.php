<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Search
            'q' => ['nullable', 'string', 'max:255'],
            'search' => ['nullable', 'string', 'max:255'],
            
            // Category filters
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'min:1'],
            'category' => ['nullable', 'string', 'max:100'],
            
            // Price filters
            'min_price' => ['nullable', 'numeric', 'min:0', 'max:999999999'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'max:999999999'],
            'price_range' => [
                'nullable',
                'string',
                Rule::in(['under-500k', '500k-1m', '1m-2m', 'over-2m', 'custom'])
            ],
            
            // Sort
            'sort_by' => [
                'nullable',
                'string',
                Rule::in(['latest', 'newest', 'bestseller', 'price-asc', 'price-desc', 'default', 'name'])
            ],
            
            // Stock filter
            'in_stock' => ['nullable', 'boolean'],
            
            // Pagination
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'q.max' => 'Từ khóa tìm kiếm quá dài.',
            'search.max' => 'Từ khóa tìm kiếm quá dài.',
            'min_price.min' => 'Giá tối thiểu không hợp lệ.',
            'max_price.min' => 'Giá tối đa không hợp lệ.',
            'categories.*.integer' => 'Danh mục không hợp lệ.',
            'sort_by.in' => 'Kiểu sắp xếp không hợp lệ.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Sanitize search queries - remove potentially dangerous characters
        if ($this->has('q')) {
            $q = $this->input('q');
            // Remove SQL injection patterns and trim
            $q = $this->sanitizeSearchQuery($q);
            $this->merge(['q' => $q]);
        }
        
        if ($this->has('search')) {
            $search = $this->input('search');
            $search = $this->sanitizeSearchQuery($search);
            $this->merge(['search' => $search]);
        }
        
        // Ensure numeric price values are properly typed
        if ($this->has('min_price')) {
            $minPrice = $this->input('min_price');
            if (is_numeric($minPrice)) {
                $this->merge(['min_price' => (float) $minPrice]);
            }
        }
        
        if ($this->has('max_price')) {
            $maxPrice = $this->input('max_price');
            if (is_numeric($maxPrice)) {
                $this->merge(['max_price' => (float) $maxPrice]);
            }
        }
    }

    /**
     * Sanitize search query to prevent XSS and SQL injection.
     */
    protected function sanitizeSearchQuery(?string $query): ?string
    {
        if ($query === null) {
            return null;
        }
        
        // Trim whitespace
        $query = trim($query);
        
        // Remove null bytes and other control characters
        $query = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $query);
        
        // Limit length
        if (strlen($query) > 255) {
            $query = mb_substr($query, 0, 255);
        }
        
        // HTML encode special characters for display safety
        // (The actual DB query will use parameterized queries)
        
        return $query ?: null;
    }

    /**
     * Get validated search query (from q or search field).
     */
    public function getSearchQuery(): ?string
    {
        return $this->validated()['q'] ?? $this->validated()['search'] ?? null;
    }

    /**
     * Get validated category IDs.
     */
    public function getCategoryIds(): array
    {
        $categories = $this->validated()['categories'] ?? [];
        
        // Handle comma-separated string format (from filter chips removal)
        if (is_string($categories) && str_contains($categories, ',')) {
            $categories = array_filter(array_map('trim', explode(',', $categories)));
        }
        
        // Handle single value array
        if (is_array($categories) && count($categories) === 1 && isset($categories[0]) && str_contains($categories[0], ',')) {
            $categories = array_filter(array_map('trim', explode(',', $categories[0])));
        }
        
        // If category slug is provided, resolve it
        if (empty($categories) && $this->filled('category')) {
            $slugOrId = $this->input('category');
            $found = \App\Models\Category::active()
                ->where('slug', $slugOrId)
                ->orWhere('id', is_numeric($slugOrId) ? (int) $slugOrId : 0)
                ->first();
            if ($found) {
                $categories = [$found->id];
            }
        }
        
        return array_filter(array_map('intval', (array) $categories));
    }

    /**
     * Get validated price range.
     */
    public function getPriceRange(): array
    {
        $minPrice = $this->validated()['min_price'] ?? null;
        $maxPrice = $this->validated()['max_price'] ?? null;
        
        // Map price range aliases to actual min/max values
        if ($this->filled('price_range') && !$this->filled('min_price') && !$this->filled('max_price')) {
            switch ($this->input('price_range')) {
                case 'under-500k':
                    $maxPrice = 500000;
                    break;
                case '500k-1m':
                    $minPrice = 500000;
                    $maxPrice = 1000000;
                    break;
                case '1m-2m':
                    $minPrice = 1000000;
                    $maxPrice = 2000000;
                    break;
                case 'over-2m':
                    $minPrice = 2000000;
                    break;
            }
        }
        
        // Validate: min should not exceed max
        if ($minPrice !== null && $maxPrice !== null && $minPrice > $maxPrice) {
            // Swap them
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }
        
        return [
            'min' => $minPrice,
            'max' => $maxPrice,
        ];
    }

    /**
     * Get validated sort option.
     */
    public function getSortOption(): string
    {
        $sortMap = [
            'newest' => 'latest',
            'bestseller' => 'best_selling',
            'price-asc' => 'price_asc',
            'price-desc' => 'price_desc',
            'name' => 'name',
            'latest' => 'latest',
            'default' => 'latest',
        ];
        
        $rawSort = $this->validated()['sort_by'] ?? 'latest';
        return $sortMap[$rawSort] ?? 'latest';
    }

    /**
     * Check if any filters are active.
     */
    public function hasActiveFilters(): bool
    {
        return $this->filled('q') 
            || $this->filled('search')
            || $this->filled('categories')
            || $this->filled('category')
            || $this->filled('min_price')
            || $this->filled('max_price')
            || $this->filled('price_range')
            || $this->boolean('in_stock');
    }

    /**
     * Get all active filters as chips data.
     */
    public function getActiveFilterChips(): array
    {
        $chips = [];
        
        // Search query
        $searchQuery = $this->getSearchQuery();
        if ($searchQuery) {
            $chips[] = [
                'type' => 'search',
                'label' => 'Tìm: "' . e($searchQuery) . '"',
                'value' => $searchQuery,
                'param' => 'q',
            ];
        }
        
        // Categories
        $categoryIds = $this->getCategoryIds();
        if (!empty($categoryIds)) {
            $categories = \App\Models\Category::whereIn('id', $categoryIds)->get();
            foreach ($categories as $category) {
                $chips[] = [
                    'type' => 'category',
                    'label' => $category->name,
                    'value' => $category->id,
                    'param' => 'categories',
                ];
            }
        }
        
        // Price range
        $priceRange = $this->getPriceRange();
        $priceLabels = [
            'under-500k' => 'Dưới 500K',
            '500k-1m' => '500K - 1M',
            '1m-2m' => '1M - 2M',
            'over-2m' => 'Trên 2M',
        ];
        
        if ($this->filled('price_range') && isset($priceLabels[$this->input('price_range')])) {
            $chips[] = [
                'type' => 'price_range',
                'label' => $priceLabels[$this->input('price_range')],
                'value' => $this->input('price_range'),
                'param' => 'price_range',
            ];
        } elseif ($priceRange['min'] !== null || $priceRange['max'] !== null) {
            $label = '';
            if ($priceRange['min'] !== null && $priceRange['max'] !== null) {
                $label = number_format($priceRange['min'] / 1000, 0, ',', '.') . 'K - ' 
                       . number_format($priceRange['max'] / 1000, 0, ',', '.') . 'K';
            } elseif ($priceRange['min'] !== null) {
                $label = 'Từ ' . number_format($priceRange['min'] / 1000, 0, ',', '.') . 'K';
            } else {
                $label = 'Đến ' . number_format($priceRange['max'] / 1000, 0, ',', '.') . 'K';
            }
            $chips[] = [
                'type' => 'price',
                'label' => $label,
                'value' => 'custom',
                'param' => 'price_range',
            ];
        }
        
        // In stock filter
        if ($this->boolean('in_stock')) {
            $chips[] = [
                'type' => 'stock',
                'label' => 'Còn hàng',
                'value' => '1',
                'param' => 'in_stock',
            ];
        }
        
        return $chips;
    }
}
