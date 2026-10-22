<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Str;

// Helper functions for FlowerShop application

function content(string $key, mixed $default = ''): mixed
{
    $translated = __("content.{$key}");

    return $translated === "content.{$key}" || $translated === '' ? $default : $translated;
}

/**
 * Walk a JSON-decoded array and replace every "key" with "key_en"
 * value when the current app locale is English and a "key_en" sibling exists.
 * Works recursively for nested arrays (objects) and list items.
 */
function localize_json_data(array $data): array
{
    if (app()->getLocale() !== 'en') {
        return $data;
    }

    $result = [];
    foreach ($data as $key => $value) {
        // Skip _en suffix keys — their base key handles them
        if (str_ends_with((string) $key, '_en')) {
            continue;
        }

        $enKey = $key . '_en';
        if (array_key_exists($enKey, $data)) {
            $enValue = $data[$enKey];
            $result[$key] = is_array($enValue) ? localize_json_data($enValue) : $enValue;
        } elseif (is_array($value)) {
            if (array_is_list($value)) {
                $result[$key] = array_map(
                    fn ($item) => is_array($item) ? localize_json_data($item) : $item,
                    $value
                );
            } else {
                $result[$key] = localize_json_data($value);
            }
        } else {
            $result[$key] = $value;
        }
    }

    return $result;
}

function localized_route(string $name, mixed $parameters = [], bool $absolute = true): string
{
    $locale = request()->segment(1) === 'en' ? 'en' : app()->getLocale();
    $localizedName = $locale === 'en' ? "en.{$name}" : $name;

    return route(Route::has($localizedName) ? $localizedName : $name, $parameters, $absolute);
}

function locale_url(string $locale): string
{
    abort_unless(in_array($locale, ['vi', 'en'], true), 404);

    $route = request()->route();
    $name = $route?->getName();
    $name = str_starts_with((string) $name, 'en.') ? substr($name, 3) : $name;
    $parameters = $route?->parameters() ?? [];

    $slugRoutes = [
        'products.show' => [Product::class, 'product', true],
        'categories.show' => [Category::class, 'category', true],
        'blog.show' => [Post::class, 'post', true],
        'policy' => [Page::class, 'slug', false],
    ];

    if (isset($slugRoutes[$name])) {
        [$model, $parameter, $hasEnglishSlug] = $slugRoutes[$name];
        if (isset($parameters[$parameter])) {
            $record = $model::where('slug', $parameters[$parameter])
                ->when($hasEnglishSlug, fn ($query) => $query->orWhere('slug_en', $parameters[$parameter]))
                ->first();
            $parameters[$parameter] = $locale === 'en' && $hasEnglishSlug && $record?->slug_en
                ? $record->slug_en
                : ($record?->slug ?? $parameters[$parameter]);
        }
    }

    if ($name && Route::has($locale === 'en' ? "en.{$name}" : $name)) {
        $url = route($locale === 'en' ? "en.{$name}" : $name, $parameters);
    } else {
        $path = request()->path();
        $path = $path === 'en' ? '' : preg_replace('#^en/#', '', $path);
        $url = url($locale === 'en' ? 'en'.($path !== '' ? "/{$path}" : '') : $path);
    }

    return $url.(request()->getQueryString() ? '?'.request()->getQueryString() : '');
}

function localized_route_is(string ...$patterns): bool
{
    $name = request()->route()?->getName();
    $name = str_starts_with((string) $name, 'en.') ? substr($name, 3) : $name;

    return $name !== null && Str::is($patterns, $name);
}
