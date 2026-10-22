<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DynamicContentLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_translation_schema_is_nullable_and_complete(): void
    {
        $expected = [
            'products' => ['name_en', 'slug_en', 'short_description_en', 'description_en'],
            'categories' => ['name_en', 'slug_en', 'description_en'],
            'subcategories' => ['name_en', 'slug_en', 'description_en'],
            'pages' => ['title_en', 'content_en'],
            'posts' => ['title_en', 'slug_en', 'excerpt_en', 'content_en'],
            'product_collections' => ['name_en', 'slug_en', 'criterion_en'],
        ];

        foreach ($expected as $table => $columns) {
            $this->assertTrue(Schema::hasColumns($table, $columns), $table.' is missing translation columns.');
        }
    }

    public function test_accessors_use_english_only_in_english_locale_and_fall_back_to_vietnamese(): void
    {
        $models = [
            [new Product(['name' => 'Hoa', 'name_en' => 'Flower']), 'display_name', 'Hoa', 'Flower'],
            [new Category(['name' => 'Danh mục', 'name_en' => 'Category']), 'display_name', 'Danh mục', 'Category'],
            [new Subcategory(['name' => 'Danh mục con', 'name_en' => null]), 'display_name', 'Danh mục con', 'Danh mục con'],
            [new Page(['title' => 'Trang', 'title_en' => 'Page']), 'display_title', 'Trang', 'Page'],
            [new Post(['title' => 'Bài viết', 'title_en' => 'Post']), 'display_title', 'Bài viết', 'Post'],
            [new ProductCollection(['name' => 'Bộ sưu tập', 'name_en' => 'Collection']), 'display_name', 'Bộ sưu tập', 'Collection'],
        ];

        foreach ($models as [$model, $attribute, $vietnamese, $english]) {
            app()->setLocale('vi');
            $this->assertSame($vietnamese, $model->{$attribute});
            app()->setLocale('en');
            $this->assertSame($english, $model->{$attribute});
        }

        $this->assertSame('#A3B18A', (new ProductCollection)->accent_color);
    }

    public function test_english_product_search_includes_translation_columns(): void
    {
        $category = Category::create(['name' => 'Hoa', 'slug' => 'hoa', 'is_active' => true]);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Hồng đỏ',
            'name_en' => 'Red rose',
            'slug' => 'hong-do',
            'price' => 100,
            'stock' => 1,
            'is_active' => true,
        ]);

        app()->setLocale('en');
        $this->assertSame('Red rose', Product::search('rose')->firstOrFail()->display_name);
    }

    public function test_product_collection_update_ignores_itself_and_rejects_cross_column_slug_collisions(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $existing = ProductCollection::create(['name' => 'Shared slug']);
        $collection = ProductCollection::create([
            'name' => 'Target',
            'slug_en' => 'target-en',
        ]);

        $payload = [
            'name' => 'Target',
            'slug_en' => 'target-en',
            'product_ids' => [],
        ];

        $this->actingAs($admin)
            ->put(route('admin.product-collections.update', $collection), $payload)
            ->assertRedirect(route('admin.product-collections.index'));

        $this->actingAs($admin)
            ->put(route('admin.product-collections.update', $collection), [
                ...$payload,
                'slug_en' => $existing->slug,
            ])
            ->assertSessionHasErrors('slug_en');
    }
}
