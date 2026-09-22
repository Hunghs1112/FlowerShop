# Validation Guide - FlowerShop

## Overview

This guide explains the centralized validation system for the FlowerShop application. Validation is handled through:

1. **FormRequest Classes** - Request-level validation with custom messages
2. **ValidationService** - Reusable validation logic
3. **ValidationRules Constants** - Centralized rule definitions

## Quick Start

### Option 1: Using FormRequest (Recommended for Controllers)

```php
use App\Http\Requests\StoreProductRequest;

public function store(StoreProductRequest $request)
{
    // Validation happens automatically, validated data available
    $product = Product::create($request->validated());
}
```

### Option 2: Using ValidationService (For Services/Commands)

```php
use App\Services\ValidationService;

class ProductService
{
    protected ValidationService $validation;

    public function __construct(ValidationService $validation)
    {
        $this->validation = $validation;
    }

    public function create(array $data)
    {
        // Throws ValidationException if invalid
        $validated = $this->validation->validate($data, $this->validation->getProductRules());

        return Product::create($validated);
    }

    // Or use soft validation
    public function isValidPrice($price)
    {
        return $this->validation->isValid(['price' => $price], ['price' => 'numeric|min:0']);
    }
}
```

### Option 3: Using ValidationRules Constants

```php
use App\Constants\ValidationRules;

$rules = [
    'name' => ValidationRules::NAME_FIELD,
    'email' => ValidationRules::EMAIL,
    'price' => ValidationRules::PRICE,
];
```

## FormRequest Classes

### Available FormRequest Classes

#### Product
- `StoreProductRequest` - Creating products
- `UpdateProductRequest` - Updating products

#### Category
- `StoreCategoryRequest` - Creating categories
- `UpdateCategoryRequest` - Updating categories

#### Subcategory
- `StoreSubcategoryRequest` - Creating subcategories
- `UpdateSubcategoryRequest` - Updating subcategories

#### Post
- `StorePostRequest` - Creating posts
- `UpdatePostRequest` - Updating posts

#### Banner
- `StoreBannerRequest` - Creating banners
- `UpdateBannerRequest` - Updating banners

#### Page
- `StorePageRequest` - Creating pages
- `UpdatePageRequest` - Updating pages

#### User
- `StoreUserRequest` - Creating users
- `UpdateUserRequest` - Updating users

#### VIP Level
- `StoreVipLevelRequest` - Creating VIP levels
- `UpdateVipLevelRequest` - Updating VIP levels

#### Product Variant
- `StoreProductVariantRequest` - Creating variants
- `UpdateProductVariantRequest` - Updating variants

### Using FormRequest

```php
public function store(StorePageRequest $request)
{
    // $request->validated() returns validated data
    $page = Page::create($request->validated());

    return redirect()->route('admin.pages.index')
        ->with('success', 'Page created successfully');
}
```

### Error Handling

Validation errors are automatically converted to redirect with error bag:

```blade
@if ($errors->has('title'))
    <span class="error">{{ $errors->first('title') }}</span>
@endif

@foreach ($errors->get('images') as $error)
    <span class="error">{{ $error }}</span>
@endforeach
```

## ValidationService

### Single Field Validation

```php
$validation = app(ValidationService::class);

// String
$validated = $validation->validateString('Hello', 255);

// Email
$validated = $validation->validateEmail('user@example.com');

// Price
$validated = $validation->validatePrice(99.99);

// Stock
$validated = $validation->validateStock(100);

// Image
$validated = $validation->validateImage($request->file('image'));

// URL
$validated = $validation->validateUrl('https://example.com');

// Date Range
$validated = $validation->validateDateRange('2024-01-01', '2024-12-31');

// Password
$validated = $validation->validatePassword($password, $confirmation);
```

### Batch Validation (Throws Exception)

```php
try {
    $data = [
        'name' => 'Product Name',
        'price' => 99.99,
        'stock' => 100,
    ];

    $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ];

    $validated = $validation->validate($data, $rules);
} catch (ValidationException $e) {
    // Handle validation errors
    return redirect()->back()->withErrors($e->errors());
}
```

### Soft Validation (No Exception)

```php
// Returns boolean
if ($validation->isValid($data, $rules)) {
    // Valid
}

// Get errors as array
$errors = $validation->getErrors($data, $rules);

// Get single field errors
$titleErrors = $validation->getFieldErrors(
    $data,
    ['title' => 'required|string|max:255'],
    'title'
);
```

### Entity-Specific Rules

```php
// Product rules
$rules = $validation->getProductRules($productId);

// Category rules
$rules = $validation->getCategoryRules($categoryId);

// Post rules
$rules = $validation->getPostRules($postId);

// Page rules
$rules = $validation->getPageRules($pageId);

// User rules
$rules = $validation->getUserRules($userId);

// VIP Level rules
$rules = $validation->getVipLevelRules($vipLevelId);
```

## ValidationRules Constants

### Common Field Rules

```php
use App\Constants\ValidationRules;

// Strings
ValidationRules::REQUIRED_STRING      // required|string
ValidationRules::OPTIONAL_STRING      // nullable|string

// Names/Titles
ValidationRules::NAME_FIELD           // required|string|max:255
ValidationRules::OPTIONAL_NAME        // nullable|string|max:255
ValidationRules::TITLE_FIELD          // required|string|max:255

// Numeric
ValidationRules::PRICE                // required|numeric|min:0|max:999999999
ValidationRules::OPTIONAL_PRICE       // nullable|numeric|min:0|max:999999999
ValidationRules::STOCK                // required|integer|min:0|max:999999
ValidationRules::OPTIONAL_STOCK       // nullable|integer|min:0|max:999999

// Email
ValidationRules::EMAIL                // required|email|max:255|unique:users,email

// Text
ValidationRules::DESCRIPTION          // nullable|string
ValidationRules::SHORT_DESCRIPTION    // nullable|string|max:500
ValidationRules::CONTENT              // required|string

// Files
ValidationRules::IMAGE_FILE           // nullable|file|mimes:...|max:2048
ValidationRules::IMAGE_REQUIRED       // required|image|mimes:...|max:2048

// Relationships
ValidationRules::EXISTS_CATEGORY      // required|exists:categories,id
ValidationRules::OPTIONAL_VIP_LEVEL   // nullable|exists:vip_levels,id
```

### Using with Replacements

```php
ValidationRules::replace(
    ValidationRules::IMAGE_FILE,
    ['size' => 4096]  // Replace __SIZE__ placeholder
);

// Or get methods
$maxKb = ValidationRules::getMaxFileSize('product_images');
$maxCount = ValidationRules::getMaxFileCount('product_images');
```

## Custom Messages

### Default Messages (Vietnamese)

All validation messages are provided in Vietnamese by default. Customize in FormRequest:

```php
class StorePageRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề trang',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
        ];
    }
}
```

### Common Message Keys

- `required` - Field is required
- `max` - Maximum length exceeded
- `min` - Minimum length not met
- `unique` - Value already exists
- `email` - Invalid email format
- `numeric` - Must be a number
- `integer` - Must be an integer
- `image` - Must be an image file
- `mimes` - Invalid file type
- `url` - Invalid URL format
- `date` - Invalid date format
- `confirmed` - Confirmation doesn't match
- `exists` - Record doesn't exist

## AJAX Field Updates

For AJAX field updates, validation happens in the trait:

```php
use App\Http\Controllers\Traits\HandlesAjaxFieldUpdates;

public function updateField(Request $request, Page $page)
{
    return $this->handleAjaxFieldUpdate($request, $page, [
        'allowed_fields' => ['title', 'is_active'],
        'rules' => [
            'title' => 'required|string|max:255',
            'is_active' => 'boolean',
        ],
    ]);
}
```

Response on validation error:
```json
{
    "success": false,
    "message": "title không được vượt quá 255 ký tự",
    "errors": {
        "title": ["title không được vượt quá 255 ký tự"]
    }
}
```

## File Upload Validation

### Using FormRequest

```php
class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        $maxKb = (int) config('upload.limits.product_images.max_size', 2048);
        $maxCount = (int) config('upload.limits.product_images.max_count', 10);

        return [
            'images' => "nullable|array|max:{$maxCount}",
            'images.*' => "file|image|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ];
    }
}
```

### Using ValidationService

```php
$validation = app(ValidationService::class);

// Single image
$validated = $validation->validateImage($file, 2048, false);

// Multiple images
$validated = $validation->validateImages($files, 10, 2048);
```

### Configuration

File limits are defined in `config/upload.php`:

```php
'limits' => [
    'product_images' => [
        'max_size' => 2048,      // KB
        'max_count' => 10,
    ],
    'category_image' => [
        'max_size' => 2048,
        'max_count' => 1,
    ],
]
```

## Validation in Commands/Jobs

```php
use App\Services\ValidationService;

class ImportProductsCommand extends Command
{
    protected ValidationService $validation;

    public function __construct(ValidationService $validation)
    {
        parent::__construct();
        $this->validation = $validation;
    }

    public function handle()
    {
        foreach ($this->getProducts() as $productData) {
            try {
                $validated = $this->validation->validate(
                    $productData,
                    $this->validation->getProductRules()
                );

                Product::create($validated);
            } catch (ValidationException $e) {
                $this->error("Validation failed: " . json_encode($e->errors()));
            }
        }
    }
}
```

## Testing Validation

```php
use App\Http\Requests\StoreProductRequest;
use Illuminate\Testing\Fluent\AssertableJson;

public function test_product_validation_fails_with_invalid_data()
{
    $response = $this->postJson('/admin/products', [
        'name' => '',  // Required
        'price' => 'invalid',  // Must be numeric
    ]);

    $response->assertInvalid(['name', 'price']);
}

public function test_product_validation_passes()
{
    $response = $this->postJson('/admin/products', [
        'name' => 'Test Product',
        'subcategory_id' => 1,
        'price' => 99.99,
        'stock' => 100,
    ]);

    $response->assertValid();
}
```

## Best Practices

1. **Use FormRequest in Controllers** - Automatic validation and authorization
2. **Use ValidationService in Services** - Reusable validation logic
3. **Use ValidationRules Constants** - DRY principle for rule definitions
4. **Provide Clear Messages** - Use Vietnamese messages consistently
5. **Validate Relationships** - Use `exists:table,column` for foreign keys
6. **Check File Types** - Use `mimes` and `image` for uploads
7. **Set Size Limits** - Configure in `config/upload.php`
8. **Test Validation** - Write tests for edge cases
9. **Catch Exceptions** - Handle `ValidationException` appropriately
10. **Log Errors** - Track validation failures for debugging

## Common Issues

### Issue: Validation errors not showing in view

**Solution**: Check that form method is POST/PUT and error bag is displayed:

```blade
@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
```

### Issue: Custom messages not appearing

**Solution**: Override `messages()` method in FormRequest and use exact field names

### Issue: File validation failing

**Solution**: Verify file mime type and size are within `config/upload.php` limits

### Issue: Unique validation on update

**Solution**: Use model ID to exclude current record:

```php
'slug' => 'unique:products,slug,' . $product->id
```

This is automatically handled in UpdateXxxRequest classes.
