<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\Subcategory;
use App\Services\LibreTranslateService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Throwable;

class BackfillTranslations extends Command
{
    protected $signature = 'translations:backfill';

    protected $description = 'Translate missing Vietnamese content into English fields';

    private const CHUNK_SIZE = 100;

    private const TEXT_LIMIT = 9000;

    public function handle(LibreTranslateService $translator): int
    {
        $failed = 0;

        foreach ([
            Product::class => ['name' => 'name_en', 'short_description' => 'short_description_en', 'description' => 'description_en'],
            Category::class => ['name' => 'name_en', 'description' => 'description_en'],
            Subcategory::class => ['name' => 'name_en', 'description' => 'description_en'],
            Post::class => ['title' => 'title_en', 'excerpt' => 'excerpt_en', 'content' => 'content_en'],
            Page::class => ['title' => 'title_en', 'content' => 'content_en'],
            ProductCollection::class => ['name' => 'name_en', 'criterion' => 'criterion_en'],
        ] as $modelClass => $fields) {
            $this->line(class_basename($modelClass));
            $modelClass::query()->chunkById(self::CHUNK_SIZE, function ($records) use ($fields, $translator, &$failed) {
                foreach ($records as $record) {
                    try {
                        $changed = false;
                        foreach ($fields as $source => $target) {
                            if (blank($record->{$target}) && filled($record->{$source})) {
                                $record->{$target} = $this->translateContent($record->{$source}, $translator);
                                $changed = true;
                            }
                        }

                        if (in_array($record::class, [Product::class, Category::class, Subcategory::class, Post::class, ProductCollection::class], true)
                            && blank($record->slug_en) && filled($record->{isset($record->name) ? 'name_en' : 'title_en'})) {
                            $record->slug_en = $this->uniqueEnglishSlug($record, $record->{isset($record->name) ? 'name_en' : 'title_en'});
                            $changed = true;
                        }

                        if ($changed) {
                            $record->save();
                        }
                    } catch (Throwable $exception) {
                        $failed++;
                        $this->warn(class_basename($record).' #'.$record->getKey().': translation failed ('.class_basename($exception).').');
                    }
                }
            });
        }

        $this->info($failed ? "Backfill finished with {$failed} failed record(s)." : 'Backfill complete.');

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    private function translateContent(string $text, LibreTranslateService $translator): string
    {
        $json = json_decode($text, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
            return json_encode($this->translateJsonStrings($json, $translator), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        }

        $parts = preg_split('/(<script\b[^>]*>.*?<\/script\s*>|<style\b[^>]*>.*?<\/style\s*>|<!--.*?-->|```[\s\S]*?```|`[^`\n]*`|<[^>]*>)/isu', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $translated = '';

        foreach ($parts ?: [$text] as $part) {
            if ($part === '' || preg_match('/^(?:<script\b|<style\b|<!--|```|`|<[^>]*>$)/isu', $part)) {
                $translated .= $part;

                continue;
            }

            $translated .= $this->translateChunks($part, $translator);
        }

        return $translated;
    }

    private function translateJsonStrings(array $data, LibreTranslateService $translator): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->translateJsonStrings($value, $translator);
            } elseif (is_string($value) && preg_match('/[À-ỹđĐ]/u', $value)) {
                $data[$key] = $this->translateContent($value, $translator);
            }
        }

        return $data;
    }

    private function translateChunks(string $text, LibreTranslateService $translator): string
    {
        if (blank($text)) {
            return $text;
        }

        $words = preg_split('/(\s+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [$text];
        $result = '';
        $chunk = '';

        foreach ($words as $word) {
            if (mb_strlen($chunk.$word) > self::TEXT_LIMIT && $chunk !== '') {
                $result .= $translator->translate($chunk);
                $chunk = '';
            }

            while (mb_strlen($word) > self::TEXT_LIMIT) {
                $piece = mb_substr($word, 0, self::TEXT_LIMIT);
                $result .= $translator->translate($chunk.$piece);
                $chunk = '';
                $word = mb_substr($word, self::TEXT_LIMIT);
            }

            $chunk .= $word;
        }

        return $result.($chunk !== '' ? $translator->translate($chunk) : '');
    }

    private function uniqueEnglishSlug(Model $record, string $englishName): string
    {
        $base = Str::slug($englishName) ?: 'item-'.$record->getKey();
        $slug = $base;
        $suffix = 1;

        while ($record::query()->where(function ($query) use ($slug) {
            $query->where('slug_en', $slug)->orWhere('slug', $slug);
        })->whereKeyNot($record->getKey())->exists()) {
            $slug = $base.'-'.(++$suffix);
        }

        return $slug;
    }
}
