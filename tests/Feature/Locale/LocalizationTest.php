<?php

namespace Tests\Feature\Locale;

use App\Mail\OrderConfirmationMail;
use App\Models\Category;
use App\Models\Order;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\User;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_vietnamese_routes_remain_unprefixed_and_are_the_default(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<html lang="vi">', false)
            ->assertSee('href="'.url('/san-pham').'"', false);
    }

    public function test_english_prefix_sets_locale_and_keeps_generated_links_prefixed(): void
    {
        $this->get('/en')
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('href="'.url('/en/san-pham').'"', false)
            ->assertSee('hreflang="vi"', false)
            ->assertSee('content="en_US"', false);
    }

    public function test_unknown_locale_prefix_is_not_routable(): void
    {
        $this->get('/fr')->assertNotFound();
    }

    public function test_customer_api_is_available_in_both_locales(): void
    {
        $this->getJson('/api/products')->assertOk()->assertJson(['success' => true]);
        $this->getJson('/en/api/products')->assertOk()->assertJson(['success' => true]);
    }

    public function test_content_uses_locale_translation_and_falls_back_to_default(): void
    {
        app()->setLocale('en');

        $this->assertSame('Showing', content('products_showing', 'Hiển thị'));
        $this->assertSame('Fallback', content('missing_key', 'Fallback'));
    }

    public function test_seo_shell_never_emits_empty_title_or_description(): void
    {
        $this->get('/en')
            ->assertOk()
            ->assertDontSee('<title></title>', false)
            ->assertDontSee('<meta name="description" content="">', false);
    }

    public function test_authentication_redirects_keep_the_english_locale(): void
    {
        $this->get('/en/tai-khoan')->assertRedirect('/en/login');

        $user = User::factory()->create();
        $this->post('/en/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/en/tai-khoan');
        $this->post('/en/logout')->assertRedirect('/en/login');

        $lockedUser = User::factory()->create(['is_active' => false]);
        $this->actingAs($lockedUser)->get('/en/tai-khoan')
            ->assertRedirect('/en/login')
            ->assertSessionHasErrors(['email' => 'Your account has been locked.']);
    }

    public function test_english_customer_forms_and_global_cart_ajax_use_localized_routes(): void
    {
        $this->get('/en/login')
            ->assertOk()
            ->assertSee('action="'.url('/en/login').'"', false)
            ->assertSee('Welcome back');

        $this->get('/en/lien-he')
            ->assertOk()
            ->assertSee('action="'.url('/en/lien-he').'"', false)
            ->assertSee('Send message')
            ->assertSee(json_encode(url('/en/gio-hang/them')), false);

        $this->get('/en')
            ->assertSee('action="'.url('/en/newsletter').'"', false);
    }

    public function test_canonical_and_hreflang_urls_use_the_target_locale_slug(): void
    {
        $category = Category::create([
            'name' => 'Hoa hồng',
            'name_en' => 'Roses',
            'slug' => 'hoa-hong',
            'slug_en' => 'roses',
            'is_active' => true,
        ]);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Hồng đỏ',
            'name_en' => 'Red rose',
            'slug' => 'hong-do',
            'slug_en' => 'red-rose',
            'price' => 100000,
            'stock' => 1,
            'is_active' => true,
        ]);
        $post = Post::create([
            'title' => 'Chăm hoa',
            'slug' => 'cham-hoa',
            'category' => 'cham-hoa',
            'content' => 'Nội dung',
            'is_published' => true,
            'published_at' => now(),
        ]);
        Page::create([
            'title' => 'Câu hỏi thường gặp',
            'slug' => 'cau-hoi-thuong-gap',
            'content' => 'Nội dung',
            'is_active' => true,
        ]);

        $this->get('/san-pham/hong-do')
            ->assertOk()
            ->assertSee('hreflang="en" href="'.url('/en/san-pham/red-rose').'"', false);
        $this->get('/en/san-pham/red-rose')
            ->assertOk()
            ->assertSee('rel="canonical" href="'.url('/en/san-pham/red-rose').'"', false)
            ->assertSee('hreflang="vi" href="'.url('/san-pham/hong-do').'"', false);
        $this->getJson('/en/api/search?q=Hồng')
            ->assertOk()
            ->assertJsonPath('data.0.slug', 'red-rose')
            ->assertJsonPath('data.0.url', url('/en/san-pham/red-rose'));
        $this->get('/en/danh-muc/roses')
            ->assertOk()
            ->assertSee('hreflang="vi" href="'.url('/danh-muc/hoa-hong').'"', false)
            ->assertSee('action="'.url('/en/danh-muc/roses').'"', false);
        $this->get('/en/bai-viet/'.$post->slug)
            ->assertOk()
            ->assertSee('rel="canonical" href="'.url('/en/bai-viet/cham-hoa').'"', false)
            ->assertSee('hreflang="vi" href="'.url('/bai-viet/cham-hoa').'"', false);
        $this->get('/en/trang/cau-hoi-thuong-gap')
            ->assertOk()
            ->assertSee('rel="canonical" href="'.url('/en/trang/cau-hoi-thuong-gap').'"', false)
            ->assertSee('hreflang="vi" href="'.url('/trang/cau-hoi-thuong-gap').'"', false);
    }

    public function test_inactive_category_is_not_exposed_by_either_slug(): void
    {
        Category::create([
            'name' => 'Ẩn',
            'name_en' => 'Hidden',
            'slug' => 'an',
            'slug_en' => 'hidden',
            'is_active' => false,
        ]);

        $this->get('/danh-muc/an')->assertNotFound();
        $this->get('/en/danh-muc/hidden')->assertNotFound();
    }

    public function test_english_dynamic_content_is_used_on_home_blog_and_product_pages(): void
    {
        $category = Category::create([
            'name' => 'Hoa',
            'name_en' => 'Flowers',
            'slug' => 'hoa',
            'slug_en' => 'flowers',
            'is_active' => true,
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Hoa Việt',
            'name_en' => 'English flower',
            'slug' => 'hoa-viet',
            'slug_en' => 'english-flower',
            'short_description' => 'Mô tả ngắn Việt',
            'short_description_en' => 'English short description',
            'description' => 'Mô tả Việt',
            'description_en' => 'English product description',
            'price' => 100000,
            'stock' => 1,
            'is_active' => true,
            'is_new_arrival' => true,
        ]);
        $collection = ProductCollection::create([
            'name' => 'Bộ sưu tập Việt',
            'name_en' => 'English collection',
            'slug_en' => 'english-collection',
            'criterion' => 'Tiêu chí Việt',
            'criterion_en' => 'English criterion',
            'is_active' => true,
        ]);
        $collection->products()->attach($product->id);
        Post::create([
            'title' => 'Bài Việt',
            'title_en' => 'English journal title',
            'slug' => 'bai-viet',
            'slug_en' => 'english-journal',
            'excerpt' => 'Tóm tắt Việt',
            'excerpt_en' => 'English journal excerpt',
            'category' => 'cham-hoa',
            'content' => 'Nội dung Việt',
            'content_en' => 'English journal body',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->get('/en')->assertOk()->assertSee('English flower')->assertSee('English journal title');
        $this->get('/en/bai-viet/english-journal')
            ->assertOk()
            ->assertSee('English journal title')
            ->assertSee('English journal body');
        $this->get('/en/san-pham/english-flower')
            ->assertOk()
            ->assertSee('English short description')
            ->assertSee('English product description');
        $this->get('/en/san-pham')
            ->assertOk()
            ->assertSee('English collection')
            ->assertSee('English criterion');
    }

    public function test_customer_order_email_uses_the_selected_locale(): void
    {
        app()->setLocale('en');
        $order = (new Order)->forceFill([
            'id' => 42,
            'customer_name' => '<img src=x onerror=alert(1)>Taylor',
            'customer_phone' => '0900000000',
            'customer_email' => 'taylor@example.com',
            'delivery_address' => 'Hanoi',
            'delivery_date' => now(),
            'delivery_time' => '10:00',
            'subtotal' => 100000,
            'shipping_fee' => null,
            'total' => 100000,
            'note' => null,
            'created_at' => now(),
        ]);
        $mail = new OrderConfirmationMail($order, [[
            'name' => 'Red rose',
            'price' => 100000,
            'quantity' => 1,
            'subtotal' => 100000,
        ]], 100000);

        $this->assertSame('Order confirmation #42', $mail->envelope()->subject);
        $html = $mail->render();
        $this->assertStringContainsString('Your order was placed successfully', $html);
        $this->assertStringContainsString('<strong>&lt;img src=x onerror=alert(1)&gt;Taylor</strong>', $html);
        $this->assertStringNotContainsString('<img src=x onerror=alert(1)>', $html);
    }
}
