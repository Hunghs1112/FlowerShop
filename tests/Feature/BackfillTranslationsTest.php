<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BackfillTranslationsTest extends TestCase
{
    public function test_backfill_keeps_existing_english_and_makes_unique_slugs(): void
    {
        Http::fake(fn ($request) => Http::response([
            'translatedText' => mb_strtolower($request['q']) === 'hoa hồng' ? 'English Rose' : 'EN:'.$request['q'],
        ]));

        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Hoa', 'slug' => 'hoa', 'created_at' => now(), 'updated_at' => now(),
        ]);
        foreach ([['Hoa hồng', 'Manual Rose', 'english-rose'], ['Hoa hồng', null, 'product-two']] as [$name, $english, $slug]) {
            DB::table('products')->insert([
                'category_id' => $categoryId,
                'name' => $name,
                'name_en' => $english,
                'slug' => $slug,
                'price' => 1,
                'description' => '<p>Hoa đẹp</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->assertSame(0, Artisan::call('translations:backfill'));

        $products = DB::table('products')->orderBy('id')->get();
        $this->assertSame('Manual Rose', $products[0]->name_en);
        $this->assertSame('manual-rose', $products[0]->slug_en);
        $this->assertSame('English Rose', $products[1]->name_en);
        $this->assertSame('english-rose-2', $products[1]->slug_en);
        $this->assertSame('<p>EN:Hoa đẹp</p>', $products[0]->description_en);
    }

    public function test_backfill_splits_long_html_without_sending_markup_or_oversized_requests(): void
    {
        Http::fake(function ($request) {
            $this->assertLessThanOrEqual(9000, mb_strlen($request['q']));

            return Http::response(['translatedText' => 'EN:'.$request['q']]);
        });

        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Hoa', 'slug' => 'hoa', 'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('products')->insert([
            'category_id' => $categoryId,
            'name' => 'Hoa hồng',
            'slug' => 'hoa-hong',
            'price' => 1,
            'description' => '<p>'.str_repeat('florxyz ', 2501).'</p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertSame(0, Artisan::call('translations:backfill'));
        $translated = DB::table('products')->value('description_en');
        $this->assertStringStartsWith('<p>EN:', $translated);
        $this->assertStringEndsWith('</p>', $translated);
        Http::assertSent(fn ($request) => ! str_contains($request['q'], '<p>') && ! str_contains($request['q'], '</p>'));
        $contentRequests = Http::recorded()->filter(fn ($pair) => str_contains($pair[0]['q'], 'florxyz'));
        $this->assertCount(3, $contentRequests);
    }

    public function test_backfill_continues_after_a_record_translation_fails(): void
    {
        Http::fake(fn ($request) => $request['q'] === 'Fail Trigger'
            ? Http::response(['error' => 'failure'], 500)
            : Http::response(['translatedText' => 'English']));

        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Hoa', 'slug' => 'hoa', 'created_at' => now(), 'updated_at' => now(),
        ]);
        foreach (['Fail Trigger', 'Next Record'] as $index => $name) {
            DB::table('products')->insert([
                'category_id' => $categoryId,
                'name' => $name,
                'slug' => 'product-'.$index,
                'price' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->assertSame(1, Artisan::call('translations:backfill'));

        $products = DB::table('products')->orderBy('id')->get();
        $this->assertNull($products[0]->name_en);
        $this->assertSame('English', $products[1]->name_en);
    }

    public function test_backfill_keeps_page_json_valid_and_preserves_non_text_values(): void
    {
        Http::fake(fn ($request) => Http::response(['translatedText' => 'English']));
        DB::table('pages')->insert([
            'title' => 'Tuyá»ƒn dá»¥ng',
            'slug' => 'backfill-json-test',
            'content' => json_encode(['title' => 'CÆ¡ há»™i nghá» nghiá»‡p', 'image' => '/images/career.jpg', 'id' => 'tuyen-dung']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertSame(0, Artisan::call('translations:backfill'));

        $content = json_decode(DB::table('pages')->where('slug', 'backfill-json-test')->value('content_en'), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame('English', $content['title']);
        $this->assertSame('/images/career.jpg', $content['image']);
        $this->assertSame('tuyen-dung', $content['id']);
    }
}
