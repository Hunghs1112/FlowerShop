<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Central place for the "Mùa lễ hội" content tree.
 *
 * The three original seasons (Hội Mùa Thu, Halloween, Cây Thông) are still
 * defined by the JSON files in resources/data/seasonal and keep their own
 * hand-built layouts. Seasons created from the admin are stored as extra
 * entries inside the `mua-le-hoi` page content and reuse the autumn template.
 */
class SeasonalPageService
{
    public const BUILT_IN = [
        'thu' => [
            'label' => 'Hội Mùa Thu',
            'file' => 'autumn',
            'layout' => 'autumn',
            'slug' => 'hoi-mua-thu',
            'route' => 'season.autumn',
        ],
        'halloween' => [
            'label' => 'Halloween',
            'file' => 'halloween',
            'layout' => 'halloween',
            'slug' => 'halloween',
            'route' => 'season.halloween',
        ],
        'thong' => [
            'label' => 'Cây Thông Đan Mạch',
            'file' => 'danish-tree',
            'layout' => 'tree',
            'slug' => 'cay-thong-dan-mach',
            'route' => 'season.danish-tree',
        ],
    ];

    public const LAYOUT_LABELS = [
        'autumn' => 'Giao diện mẫu · Hội Mùa Thu',
        'halloween' => 'Giao diện riêng · Halloween',
        'tree' => 'Giao diện riêng · Cây thông',
    ];

    /** Slugs that would collide with the fixed seasonal routes. */
    public const RESERVED_SLUGS = ['hoi-mua-thu', 'halloween', 'cay-thong-dan-mach', 'dat-truoc'];

    public function __construct(
        protected ImageStorageService $images,
        protected SettingService $settings,
    ) {}

    public function page(): ?Page
    {
        return Page::where('slug', 'mua-le-hoi')->first();
    }

    public function rawContent(): array
    {
        $page = $this->page();

        if (! $page || blank($page->content)) {
            return [];
        }

        $decoded = json_decode($page->content, true);

        return is_array($decoded) ? $decoded : [];
    }

    public function saveContent(array $content): void
    {
        $page = $this->page();
        abort_unless($page, 404);

        $page->update([
            'content' => json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);
    }

    /**
     * Full frontend config for the hub and every season.
     */
    public function config(string $sourceSlug = 'mua-le-hoi'): array
    {
        $page = Page::where('slug', $sourceSlug)->active()->first()
            ?? Page::where('slug', 'mua-le-hoi')->active()->firstOrFail();
        $stored = json_decode($page->content ?? '', true);
        $stored = is_array($stored) ? $stored : [];
        $defaults = $this->file('hub');
        $defaults['seasons'] = array_map(
            fn (string $file) => $this->file($file),
            array_column(self::BUILT_IN, 'file')
        );

        $storedSeasons = is_array($stored['seasons'] ?? null) ? $stored['seasons'] : [];
        unset($stored['seasons']);

        $config = $this->merge($defaults, $stored);

        $seasons = [];
        foreach ($defaults['seasons'] as $season) {
            $override = $this->firstWhereId($storedSeasons, $season['id']);
            $seasons[$season['id']] = $override ? $this->merge($season, $override) : $season;
        }

        foreach ($storedSeasons as $season) {
            $id = $season['id'] ?? null;
            if (! $id || isset($seasons[$id]) || isset(self::BUILT_IN[$id])) {
                continue;
            }
            $seasons[$id] = $this->normalizeCustom($season);
        }

        $heroes = $this->settings->getMultiple(
            array_map(fn (string $id) => $this->heroKey($id), array_keys($seasons))
        );

        foreach ($seasons as $id => &$season) {
            if ($heroImage = $heroes[$this->heroKey($id)] ?? null) {
                $season['img'] = $this->images->url($heroImage);
            }

            if (isset($season['tree'])) {
                $season['tree'] = $this->normalizeTree($season['tree']);
            }

            $season['url'] = isset(self::BUILT_IN[$id])
                ? localized_route(self::BUILT_IN[$id]['route'])
                : localized_route('season.page', $season['slug'] ?? $id);
        }
        unset($season);

        $config['seasons'] = array_values($seasons);
        $config['hub']['url'] = localized_route('season.mua-le-hoi');
        $config['orderEndpoint'] = localized_route('season.preorder');
        $config['csrfToken'] = csrf_token();
        $config['seasonSlug'] = $sourceSlug;

        return $this->localize($config);
    }

    /**
     * One built-in season with the stored overrides applied (used by the admin form).
     */
    public function builtIn(string $id): array
    {
        abort_unless(isset(self::BUILT_IN[$id]), 404);

        $season = $this->file(self::BUILT_IN[$id]['file']);
        $override = $this->firstWhereId($this->storedSeasons(), $id);

        return $override ? $this->merge($season, $override) : $season;
    }

    public function customSeason(string $id): ?array
    {
        foreach ($this->storedSeasons() as $season) {
            if (($season['id'] ?? null) === $id && ! isset(self::BUILT_IN[$id])) {
                return $this->normalizeCustom($season);
            }
        }

        return null;
    }

    /**
     * @return array<int, array>
     */
    public function storedSeasons(): array
    {
        $seasons = $this->rawContent()['seasons'] ?? [];

        return is_array($seasons) ? array_values(array_filter($seasons, 'is_array')) : [];
    }

    /**
     * Custom (admin-created) seasons, in creation order.
     *
     * @return array<int, array>
     */
    public function customSeasons(): array
    {
        return array_values(array_filter(
            $this->storedSeasons(),
            fn (array $season) => isset($season['id']) && ! isset(self::BUILT_IN[$season['id']])
        ));
    }

    public function customIdBySlug(string $slug): ?string
    {
        foreach ($this->customSeasons() as $season) {
            if ($this->slugOf($season) === $slug) {
                return $season['id'];
            }
        }

        return null;
    }

    /**
     * Rows for the admin index. Always starts with the three built-in seasons.
     */
    public function listForAdmin(): array
    {
        $seasons = [];

        foreach (self::BUILT_IN as $id => $meta) {
            $seasons[$id] = [
                'id' => $id,
                'label' => $meta['label'],
                'slug' => $meta['slug'],
                'custom' => false,
                'layout' => $meta['layout'],
                'layout_label' => self::LAYOUT_LABELS[$meta['layout']],
            ];
        }

        foreach ($this->customSeasons() as $season) {
            $seasons[$season['id']] = [
                'id' => $season['id'],
                'label' => $season['name'] ?: 'Trang lễ hội',
                'slug' => $this->slugOf($season),
                'custom' => true,
                'layout' => 'autumn',
                'layout_label' => self::LAYOUT_LABELS['autumn'],
            ];
        }

        return $seasons;
    }

    public function findForAdmin(string $id): ?array
    {
        return $this->listForAdmin()[$id] ?? null;
    }

    public function heroKey(string $id): string
    {
        return 'seasonal_'.$id.'_hero';
    }

    public function heroUrl(string $id): ?string
    {
        return $this->images->url($this->settings->get($this->heroKey($id)));
    }

    /**
     * Gallery images of a season (absolute URLs ready for the frontend).
     *
     * @return array<int, string>
     */
    public function gallery(string $id): array
    {
        return array_map(
            fn (string $path) => $this->images->url($path) ?? $path,
            $this->galleryPaths($id)
        );
    }

    /**
     * Raw stored gallery paths (what has to be written back / deleted).
     *
     * @return array<int, string>
     */
    public function galleryPaths(string $id): array
    {
        $season = isset(self::BUILT_IN[$id]) ? $this->builtIn($id) : ($this->customSeason($id) ?? []);
        $gallery = $season['gallery'] ?? [];

        return array_values(array_filter(
            is_array($gallery) ? $gallery : [],
            fn ($path) => is_string($path) && $path !== ''
        ));
    }

    public function addGalleryImage(string $id, \Illuminate\Http\UploadedFile $file): string
    {
        $path = $this->images->upload($file, 'images/seasonal/gallery', null, 'seasonal_'.$id);

        $this->mutateSeason($id, function (array $season) use ($path) {
            $gallery = is_array($season['gallery'] ?? null) ? array_values($season['gallery']) : [];
            $gallery[] = $path;
            $season['gallery'] = $gallery;

            return $season;
        });

        return $this->images->url($path) ?? '';
    }

    public function removeGalleryImage(string $id, int $index): bool
    {
        $removed = null;

        $this->mutateSeason($id, function (array $season) use ($index, &$removed) {
            $gallery = is_array($season['gallery'] ?? null) ? array_values($season['gallery']) : [];

            if (! array_key_exists($index, $gallery)) {
                return $season;
            }

            $removed = $gallery[$index];
            unset($gallery[$index]);
            $season['gallery'] = array_values($gallery);

            return $season;
        });

        if (! is_string($removed) || $removed === '') {
            return false;
        }

        $this->images->delete($removed);

        return true;
    }

    /**
     * Read, modify and persist a single season entry (creating it if missing).
     */
    protected function mutateSeason(string $id, callable $callback): void
    {
        $content = $this->rawContent();
        $seasons = $this->storedSeasons();
        $index = null;

        foreach ($seasons as $i => $season) {
            if (($season['id'] ?? null) === $id) {
                $index = $i;
                break;
            }
        }

        if ($index === null) {
            $seasons[] = isset(self::BUILT_IN[$id])
                ? $this->file(self::BUILT_IN[$id]['file'])
                : ['id' => $id];
            $index = array_key_last($seasons);
        }

        $seasons[$index] = $callback($seasons[$index]);
        $content['seasons'] = $seasons;
        $this->saveContent($content);
    }

    /**
     * Create a new admin-managed season that reuses the autumn template.
     */
    public function create(array $attributes): array
    {
        $name = trim((string) ($attributes['name'] ?? ''));
        if ($name === '') {
            throw ValidationException::withMessages(['name' => 'Vui lòng nhập tên trang lễ hội.']);
        }

        $season = $this->file('autumn');
        $season['id'] = $this->generateId();
        $season['slug'] = $this->uniqueSlug($attributes['slug'] ?? '', $name);
        $season['custom'] = true;
        $season['layout'] = 'autumn';
        $season['theme'] = 'autumn';
        $season['code'] = Str::upper(trim((string) ($attributes['code'] ?? '')) ?: 'LNT');
        $season['name'] = $name;
        $season['tagline'] = trim((string) ($attributes['tagline'] ?? ''));
        $season['status'] = trim((string) ($attributes['status'] ?? '')) ?: 'Đang chuẩn bị';
        $season['date'] = $attributes['date'] ?? '';
        $season['intro'] = trim((string) ($attributes['intro'] ?? ''));
        $season['palette'] = $season['palette'] ?? [];
        $season['labels'] = [];
        $season['gallery'] = [];
        $season['cta'] = [
            'label' => trim((string) ($attributes['cta_label'] ?? '')) ?: 'Xem bộ sưu tập',
            'link' => trim((string) ($attributes['cta_link'] ?? '')) ?: localized_route('products.index'),
        ];

        if (filled($attributes['extra_label'] ?? null)) {
            $season['extra'] = [
                'label' => trim((string) $attributes['extra_label']),
                'link' => trim((string) ($attributes['extra_link'] ?? '')),
            ];
        } else {
            unset($season['extra']);
        }

        // Product cards are always populated from the products assigned in Admin.
        unset($season['products']);

        $content = $this->rawContent();
        $content['seasons'] = array_merge($this->storedSeasons(), [$season]);
        $this->saveContent($content);

        return $season;
    }

    /**
     * Save the admin form payload for either a built-in or a custom season.
     */
    public function updateSeason(string $id, array $data): void
    {
        $content = $this->rawContent();
        $seasons = $this->storedSeasons();
        $index = null;

        foreach ($seasons as $i => $season) {
            if (($season['id'] ?? null) === $id) {
                $index = $i;
                break;
            }
        }

        $current = $index !== null ? $seasons[$index] : ['id' => $id];
        $clean = $this->clean($data);

        if (isset(self::BUILT_IN[$id])) {
            unset($clean['slug'], $clean['custom'], $clean['layout'], $clean['theme']);
        } else {
            $clean['id'] = $id;
            $clean['custom'] = true;
            $clean['layout'] = 'autumn';
            $clean['theme'] = 'autumn';
            if (array_key_exists('slug', $clean)) {
                $clean['slug'] = $this->uniqueSlug($clean['slug'], $clean['name'] ?? ($current['name'] ?? ''), $id);
            }
        }

        $merged = array_replace($current, $clean);

        if ($index !== null) {
            $seasons[$index] = $merged;
        } else {
            $seasons[] = $merged;
        }

        $content['seasons'] = $seasons;
        $this->saveContent($content);
    }

    public function syncProducts(string $id, array $productIds): void
    {
        Product::where('season_id', $id)->update(['season_id' => null]);

        $ids = array_values(array_filter(array_map('intval', $productIds)));

        if ($ids !== []) {
            Product::whereIn('id', $ids)->update(['season_id' => $id]);
        }
    }

    public function deleteCustom(string $id): bool
    {
        if (isset(self::BUILT_IN[$id])) {
            return false;
        }

        $content = $this->rawContent();
        $seasons = $this->storedSeasons();
        $remaining = array_values(array_filter(
            $seasons,
            fn (array $season) => ($season['id'] ?? null) !== $id
        ));

        if (count($remaining) === count($seasons)) {
            return false;
        }

        Product::where('season_id', $id)->update(['season_id' => null]);

        if ($path = $this->settings->get($this->heroKey($id))) {
            $this->images->delete($path);
            \App\Models\Setting::where('key', $this->heroKey($id))->delete();
        }

        $content['seasons'] = $remaining;
        $this->saveContent($content);

        return true;
    }

    protected function normalizeCustom(array $season): array
    {
        $id = (string) $season['id'];

        return array_merge([
            'id' => $id,
            'slug' => $id,
            'custom' => true,
            'layout' => 'autumn',
            'theme' => 'autumn',
            'code' => 'LNT',
            'name' => '',
            'tagline' => '',
            'status' => '',
            'date' => '',
            'img' => '',
            'intro' => '',
            'palette' => [],
            'labels' => [],
            'cta' => [
                'label' => 'Xem bộ sưu tập',
                'link' => localized_route('products.index'),
            ],
        ], $season, [
            'id' => $id,
            'custom' => true,
            'layout' => 'autumn',
            'theme' => 'autumn',
        ]);
    }

    protected function normalizeTree(array $tree): array
    {
        $tree['addons'] = collect($tree['addons'] ?? [])->map(
            fn ($item) => is_array($item) ? $item : ['name' => $item, 'price' => '']
        )->all();

        if (isset($tree['accessories'][0]) && is_string($tree['accessories'][0])) {
            $tree['accessories'] = [[
                'group' => 'Phụ kiện & đồ trang trí',
                'items' => collect($tree['accessories'])->map(
                    fn ($item) => ['name' => $item, 'desc' => '', 'icon' => 'hop', 'price' => '', 'img' => '']
                )->all(),
            ]];
        }

        $tree['faq'] = collect($tree['faq'] ?? [])->map(fn ($item) => [
            'q' => $item['q'] ?? $item['question'] ?? '',
            'q_en' => $item['q_en'] ?? $item['question_en'] ?? $item['q'] ?? $item['question'] ?? '',
            'a' => $item['a'] ?? $item['answer'] ?? '',
            'a_en' => $item['a_en'] ?? $item['answer_en'] ?? $item['a'] ?? $item['answer'] ?? '',
        ])->all();

        return $tree;
    }

    protected function clean(array $data): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            if (in_array($key, ['products', 'id', 'season_id', 'url'], true)) {
                continue;
            }

            if ($key === 'palette') {
                $palette = collect(is_array($value) ? $value : [])
                    ->map(fn ($color) => [
                        trim((string) ($color[0] ?? '')),
                        trim((string) ($color[1] ?? '')),
                    ])
                    ->filter(fn ($color) => $color[0] !== '' && $color[1] !== '')
                    ->values()
                    ->all();

                if ($palette !== []) {
                    $result['palette'] = $palette;
                }

                continue;
            }

            if ($key === 'labels') {
                $labels = collect(is_array($value) ? $value : [])
                    ->map(fn ($label) => trim((string) $label))
                    ->filter(fn ($label) => $label !== '')
                    ->all();

                $result['labels'] = $labels;

                continue;
            }

            if (is_array($value)) {
                $nested = $this->clean($value);
                if ($nested !== []) {
                    $result[$key] = $nested;
                }

                continue;
            }

            if (is_string($value)) {
                $value = trim($value);
            }

            if ($value === '' || $value === null) {
                continue;
            }

            $result[$key] = $value;
        }

        return $result;
    }

    protected function uniqueSlug(string $slug, string $fallback, ?string $ignoreId = null): string
    {
        $base = Str::slug($slug !== '' ? $slug : $fallback) ?: 'le-hoi';
        $base = Str::limit($base, 80, '');

        $taken = self::RESERVED_SLUGS;

        foreach ($this->customSeasons() as $season) {
            if ($ignoreId !== null && ($season['id'] ?? null) === $ignoreId) {
                continue;
            }
            $taken[] = $this->slugOf($season);
        }

        if (! in_array($base, $taken, true)) {
            return $base;
        }

        $suffix = 2;
        while (in_array($candidate = "{$base}-{$suffix}", $taken, true)) {
            $suffix++;
        }

        return $candidate;
    }

    protected function slugOf(array $season): string
    {
        $slug = trim((string) ($season['slug'] ?? ''));

        return $slug !== '' ? $slug : (string) ($season['id'] ?? '');
    }

    protected function generateId(): string
    {
        do {
            $id = 'c'.substr(bin2hex(random_bytes(5)), 0, 9);
        } while (isset($this->listForAdmin()[$id]));

        return $id;
    }

    protected function firstWhereId(array $seasons, string $id): ?array
    {
        foreach ($seasons as $season) {
            if (is_array($season) && ($season['id'] ?? null) === $id) {
                return $season;
            }
        }

        return null;
    }

    protected function file(string $file): array
    {
        return json_decode(
            file_get_contents(resource_path("data/seasonal/{$file}.json")),
            true,
            flags: JSON_THROW_ON_ERROR
        );
    }

    protected function merge(array $defaults, array $stored): array
    {
        foreach ($stored as $key => $value) {
            $defaults[$key] = is_array($value)
                && ! array_is_list($value)
                && isset($defaults[$key])
                && is_array($defaults[$key])
                && ! array_is_list($defaults[$key])
                    ? $this->merge($defaults[$key], $value)
                    : $value;
        }

        return $defaults;
    }

    /**
     * Replace every "key" with its "key_en" sibling when the locale is English.
     */
    protected function localize(array $data): array
    {
        if (app()->getLocale() !== 'en') {
            return $data;
        }

        $result = [];

        foreach ($data as $key => $value) {
            if (str_ends_with((string) $key, '_en')) {
                continue;
            }

            $enKey = $key.'_en';
            if (array_key_exists($enKey, $data)) {
                $enValue = $data[$enKey];
                $result[$key] = is_array($enValue) ? $this->localize($enValue) : $enValue;
            } elseif (is_array($value)) {
                $result[$key] = array_is_list($value)
                    ? array_map(fn ($item) => is_array($item) ? $this->localize($item) : $item, $value)
                    : $this->localize($value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
