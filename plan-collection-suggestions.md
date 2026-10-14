# Plan: Gợi ý hoa theo bộ sưu tập trên trang /san-pham

## Context

Trang `/san-pham` hiện chỉ có hero + filter + lưới sản phẩm + editorial. Admin muốn có thêm **một dải gợi ý hoa theo bộ sưu tập** (thường là theo màu hoặc một tiêu chí admin đặt tên). Admin tạo các bộ sưu tập, chọn sản phẩm vào từng bộ, và bộ đó sẽ hiện ở cuối trang sản phẩm dưới dạng carousel/grid ngang.

Hướng tiếp cận: bảng `product_collections` (mỗi collection có tên + slug + tiêu chề/màu chủ đạo + sort_order) + bảng pivot `collection_product` (n-N, có `sort_order`). Public controller lấy danh sách collection active cùng 4-8 sản phẩm đầu tiên. Admin có CRUD đơn giản, dùng lại pattern hiện có của SeasonalPageController.

User đã chốt: hiển thị **sau grid sản phẩm, trước editorial**; dùng **bảng Collection + pivot**; **không giới hạn** số bộ.

## Thay đổi

### 1. Database (1 migration)

`database/migrations/2026_12_02_000000_create_product_collections_tables.php`

- `product_collections`: `id`, `name` (VD: "Hoa tông đỏ", "Hoa pastel", "Hoa cho mùa thu"), `slug` (unique, tự sinh từ name), `criterion` (text nullable, mô tả ngắn tiêu chí — VD: "Hoa có sắc đỏ, hồng đậm"), `accent_color` (hex, nullable, dùng làm màu nhấn khi hiển thị), `sort_order` (int default 0), `is_active` (bool default true), timestamps.
- `collection_product`: `collection_id`, `product_id`, `sort_order` (int default 0), timestamps. PK `(collection_id, product_id)`, index `product_id` để query ngược.

### 2. Models

- `app/Models/ProductCollection.php` (fillable, cast `is_active` boolean, `sort_order` int; relationships `products()` belongsToMany qua pivot; scope `active`; helper `accentColor` trả hex về default `#A3B18A`).
- `app/Models/Product.php` — thêm `collections()` belongsToMany `ProductCollection::class` với pivot `sort_order` (sắp xếp theo pivot khi load).

### 3. Controller (2 cái)

- `app/Http/Controllers/Admin/ProductCollectionController.php` — resource-style: `index`, `create`, `store`, `edit`, `update`, `destroy`, `autoSave` (PATCH). Form nhận `name`, `criterion`, `accent_color`, `is_active`, `sort_order`, `product_ids[]`. Lưu: sync pivot với `sort_order` tương ứng vị trí trong mảng.
- `app/Http/Controllers/ProductController.php` — `index()` thêm 2 dòng:
  ```php
  $suggestionCollections = ProductCollection::with(['products' => fn($q) => $q->active()->inStock()->with('productImages')->orderBy('collection_product.sort_order')->limit(8)])
      ->active()->orderBy('sort_order')->get();
  ```
  Truyền vào view.

### 4. Routes

`routes/web.php` — trong nhóm admin (sau block seasonal-pages):
```php
Route::resource('product-collections', \App\Http\Controllers\Admin\ProductCollectionController::class);
Route::patch('product-collections/{productCollection}/auto-save', [\App\Http\Controllers\Admin\ProductCollectionController::class, 'autoSave'])->name('product-collections.autoSave');
```

### 5. Admin views

- `resources/views/admin/product-collections/index.blade.php` — bảng danh sách (tên, tiêu chí, số SP, trạng thái, sắp xếp) + nút Thêm/Sửa/Xóa. Pattern giống `admin/catalog/index.blade.php` (dùng `admin-card`).
- `resources/views/admin/product-collections/form.blade.php` — form dùng chung cho create/edit: name, criterion, accent_color (color picker), is_active, sort_order + bảng chọn sản phẩm (tìm kiếm + checkbox + sort, y hệt pattern đã có ở `admin/seasonal-pages/edit.blade.php` — copy logic `updateSelectedIds` đã viết).
- `resources/views/admin/product-collections/create.blade.php`, `edit.blade.php` — extends form.

### 6. Sidebar

`resources/views/admin/partials/sidebar.blade.php` — thêm 1 link "Bộ sưu tập gợi ý" dẫn tới `admin.product-collections.index`, đặt cạnh mục "Trang mùa".

### 7. Public view

`resources/views/products/index.blade.php` — chèn ngay sau `</section>` của `products-grid-section` (line 477) và trước `<section class="products-editorial">` (line 480):

```blade
@if($suggestionCollections->isNotEmpty())
<section class="products-suggestions">
  <div class="products-suggestions-container">
    <h2 class="products-suggestions-heading">Gợi ý theo phong cách</h2>
    @foreach($suggestionCollections as $collection)
      @if($collection->products->isNotEmpty())
      <div class="suggestion-block" style="--accent: {{ $collection->accent_color }}">
        <header class="suggestion-block-header">
          <h3 class="suggestion-block-title">{{ $collection->name }}</h3>
          @if($collection->criterion)
            <p class="suggestion-block-criterion">{{ $collection->criterion }}</p>
          @endif
          <a href="{{ route('products.index', ['collection' => $collection->slug]) }}" class="suggestion-block-link">Xem tất cả →</a>
        </header>
        <div class="suggestion-block-grid">
          @foreach($collection->products as $product)
            <x-product-card :product="$product" />
          @endforeach
        </div>
      </div>
      @endif
    @endforeach
  </div>
</section>
@endif
```

CSS cho `.products-suggestions*` thêm inline trong view (theo style hiện có của file). Public không cần filter mới — link "Xem tất cả" trỏ về `/san-pham?collection=<slug>` (chưa lọc; để đơn giản dùng anchor thuần — link sang một trang tương lai nếu cần, không bắt buộc).

### 8. Component x-product-card (đã có)

Tái sử dụng `<x-product-card :product="$product" />` — đã tồn tại, không cần đổi.

## Tệp chính

- Mới: 1 migration, 1 model (`ProductCollection`), 1 controller admin, 4 view admin, 1 seeder-class (chèn 1-2 bộ mẫu).
- Sửa: `app/Models/Product.php` (thêm 1 relationship), `app/Http/Controllers/ProductController.php` (3 dòng), `resources/views/products/index.blade.php` (1 block mới), `resources/views/admin/partials/sidebar.blade.php` (1 link), `routes/web.php` (2 route).

## Verification

1. `php artisan migrate` chạy thành công tạo 2 bảng mới.
2. Truy cập `/admin/product-collections` thấy danh sách rỗng → "Thêm mới" → tạo "Hoa tông đỏ" với 4 sản phẩm → lưu → quay lại thấy bộ vừa tạo.
3. Truy cập `/san-pham` cuộn xuống dưới grid sản phẩm → thấy block "Gợi ý theo phong cách" với carousel sản phẩm.
4. Tắt `is_active` của 1 collection trong admin → reload trang public → block đó biến mất.
5. Bật/tắt `is_active` của 1 sản phẩm trong bộ → reload → sản phẩm đó ẩn/hiện theo.
6. Sắp xếp lại `sort_order` của 2 collection trong admin → reload trang public → thứ tự block đổi theo.
