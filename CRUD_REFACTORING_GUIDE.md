# CRUD Refactoring Guide - FlowerShop

## Overview

This document describes the standardization and cleanup of CRUD operations across the FlowerShop admin panel.

## Key Improvements

### 1. FormRequest Validation (Task #1)
**Status**: ✅ Complete

Created 18 centralized FormRequest classes:
- `StoreProductRequest`, `UpdateProductRequest`
- `StoreCategoryRequest`, `UpdateCategoryRequest`
- `StoreSubcategoryRequest`, `UpdateSubcategoryRequest`
- `StorePostRequest`, `UpdatePostRequest`
- `StoreBannerRequest`, `UpdateBannerRequest`
- `StorePageRequest`, `UpdatePageRequest`
- `StoreUserRequest`, `UpdateUserRequest`
- `StoreVipLevelRequest`, `UpdateVipLevelRequest`
- `StoreProductVariantRequest`, `UpdateProductVariantRequest`

**Benefits**:
- Centralized validation rules
- Consistent error messages (Vietnamese)
- Automatic slug generation
- Boolean value handling

**Usage**:
```php
public function store(StorePageRequest $request)
{
    $page = Page::create($request->validated());
    // ...
}
```

### 2. Base Abstractions (Task #2)
**Status**: ✅ Complete

- `BaseCrudController` - Abstract base with index, create, edit, show, destroy
- `CrudService` - Transaction-wrapped create/update/delete operations
- `AjaxResponse` - Standardized JSON response helper
- `HandlesCrudOperations` trait - Pagination, filtering, sorting
- `HandlesFileUploads` trait - File operations with cleanup

**Benefits**:
- Reduced code duplication
- Consistent patterns across controllers
- Transaction safety for multi-step operations

### 3. Image Handling (Task #3)
**Status**: ✅ Complete

Enhanced `ImageStorageService` with:
- `getImageUrl()` - Unified URL generation
- `deleteMany()` - Batch deletion
- `copy()`, `move()` - File operations
- Path type detection (storage vs public vs external)

Created image traits:
- `HasImageUrl` - For single-image models
- `HasMultipleImages` - For multi-image relations
- `ImageModelTrait` - For image models with auto-deletion

Created `ValidationRules` constants class

**Benefits**:
- Consistent image URL generation across views
- Single source of truth for validation rules
- Automatic cleanup on model deletion

### 4. AJAX Field Updates (Task #4)
**Status**: ✅ Complete

- `HandlesAjaxFieldUpdates` trait - Standardized auto-save pattern
- `AjaxFieldService` - Reusable AJAX operations
- Consistent JSON response format

**Example**:
```php
public function updateField(Request $request, Page $page)
{
    return $this->handleAjaxFieldUpdate($request, $page, [
        'allowed_fields' => ['title', 'is_active'],
        'rules' => ['title' => 'required|string|max:255'],
    ]);
}
```

**Response Format**:
```json
{
    "success": true,
    "message": "Đã lưu title",
    "data": {
        "field": "title",
        "value": "New Value",
        "display_value": "New Value"
    }
}
```

### 5. Repository Pattern (Task #5)
**Status**: ✅ Complete

- `BaseRepository` - Common query operations
- `ProductRepository` - Product-specific filters
- `CategoryRepository` - Hierarchical queries
- `PostRepository` - Published/draft filtering
- `PageRepository` - Page-specific queries

**Benefits**:
- Chainable fluent interface
- Eliminates duplicate query logic
- Easier testing and maintenance

**Usage**:
```php
public function __construct(ProductRepository $products)
{
    $this->products = $products;
}

public function index()
{
    $products = $this->products
        ->active()
        ->byCategory(1)
        ->priceRange(100000, 500000)
        ->sort('created_at', 'desc')
        ->paginate(15);
}
```

### 6. Authorization Policies (Task #6)
**Status**: ✅ Complete

Created policies for:
- `ProductPolicy`
- `CategoryPolicy`
- `PostPolicy`
- `BannerPolicy`
- `PagePolicy`
- `UserPolicy` (with self-deletion protection)
- `VipLevelPolicy`

Registered in `AuthServiceProvider`

**Benefits**:
- Replaces inline AdminMiddleware checks
- Declarative authorization
- Testable authorization logic

**Usage**:
```php
public function update(UpdatePageRequest $request, Page $page)
{
    $this->authorize('update', $page);
    // ...
}
```

### 7. Controller Refactoring (Task #7)
**Status**: ✅ Partially Complete

#### Refactored Controllers:
1. **PageController** ✅
   - Uses `StorePageRequest`, `UpdatePageRequest`
   - Uses `PageRepository` for queries
   - Uses `HandlesAjaxFieldUpdates` trait
   - Consistent response handling

2. **BannerController** ✅
   - Uses `StoreBannerRequest`, `UpdateBannerRequest`
   - Uses `HandlesAjaxFieldUpdates` trait
   - Uses `AjaxResponse` helper
   - Centralized image upload

#### To Be Refactored:
- ProductController (complex - multiple image/variant handling)
- CategoryController
- PostController
- UserController
- SubcategoryController
- ProductVariantController
- VipLevelController
- SettingController
- InquiryController
- etc.

**Pattern Example** (from PageController):
```php
use App\Http\Controllers\Traits\HandlesAjaxFieldUpdates;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Repositories\PageRepository;

class PageController extends Controller
{
    use HandlesAjaxFieldUpdates;

    protected PageRepository $pages;

    public function __construct(PageRepository $pages)
    {
        $this->pages = $pages;
    }

    public function index(Request $request): View
    {
        $pages = $this->pages->getFiltered([
            'search' => $request->input('search'),
            'filters' => $this->buildFilters($request),
            'sort' => ['created_at', 'desc'],
            'per_page' => 15,
        ]);

        return view('admin.pages.index', compact('pages'));
    }

    public function store(StorePageRequest $request)
    {
        Page::create($request->validated());
        return redirect()->route('admin.pages.index')
            ->with('success', 'Tạo trang thành công');
    }

    public function updateField(Request $request, Page $page)
    {
        return $this->handleAjaxFieldUpdate($request, $page, [
            'allowed_fields' => ['title', 'slug', 'content', 'is_active'],
            'rules' => [
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            ],
        ]);
    }
}
```

## Migration Checklist

When refactoring a controller, follow this pattern:

- [ ] Create/verify FormRequest classes (StoreXxxRequest, UpdateXxxRequest)
- [ ] Create/verify Repository class
- [ ] Add trait imports (`HandlesAjaxFieldUpdates`, etc.)
- [ ] Inject repository in constructor
- [ ] Replace inline validation with FormRequest
- [ ] Replace inline queries with repository methods
- [ ] Replace inline AJAX handlers with trait methods
- [ ] Use `AjaxResponse` helper for JSON responses
- [ ] Add type hints to methods
- [ ] Test all CRUD operations
- [ ] Verify policies are in place

## Testing Checklist

When testing a refactored controller:

- [ ] Create new record (POST /admin/xxx)
- [ ] List records (GET /admin/xxx)
- [ ] View single record (GET /admin/xxx/{id})
- [ ] Update record (PUT /admin/xxx/{id})
- [ ] Delete record (DELETE /admin/xxx/{id})
- [ ] Test search/filtering
- [ ] Test AJAX field updates
- [ ] Test file uploads (if applicable)
- [ ] Verify authorization policies work

## Implementation Status

```
✅ FormRequest Validation - 18 classes created
✅ Base Abstractions - CrudService, BaseCrudController, traits
✅ Image Handling - Enhanced ImageStorageService, traits
✅ AJAX Standardization - Trait and service
✅ Repository Pattern - Base + 4 specific repos
✅ Authorization Policies - 8 policies created
🟠 Controller Refactoring - 2/15 controllers refactored
⏳ Validation Constants - Created (Task #8)
⏳ Testing - To be done (Task #9)
```

## File Structure

```
app/
├── Constants/
│   └── ValidationRules.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── BaseCrudController.php
│   │   │   ├── PageController.php (refactored)
│   │   │   ├── BannerController.php (refactored)
│   │   │   └── ...
│   │   └── Traits/
│   │       ├── HandlesAjaxFieldUpdates.php
│   │       └── AjaxFieldUpdateExample.php
│   ├── Requests/
│   │   ├── StoreXxxRequest.php (18 total)
│   │   └── UpdateXxxRequest.php (18 total)
│   └── Responses/
│       └── AjaxResponse.php
├── Models/
│   └── Traits/
│       ├── HasImageUrl.php
│       ├── HasMultipleImages.php
│       └── ImageModelTrait.php
├── Policies/
│   ├── AdminPolicy.php
│   ├── ProductPolicy.php
│   ├── CategoryPolicy.php
│   ├── PostPolicy.php
│   ├── BannerPolicy.php
│   ├── PagePolicy.php
│   ├── UserPolicy.php
│   └── VipLevelPolicy.php
├── Repositories/
│   ├── BaseRepository.php
│   ├── ProductRepository.php
│   ├── CategoryRepository.php
│   ├── PostRepository.php
│   ├── PageRepository.php
│   └── RepositoryExample.php
├── Providers/
│   └── AuthServiceProvider.php
└── Services/
    ├── AjaxFieldService.php
    ├── CrudService.php
    ├── ImageStorageService.php (enhanced)
    └── Traits/
        ├── HandlesCrudOperations.php
        └── HandlesFileUploads.php
```

## Next Steps

1. **Continue Controller Refactoring** - Apply patterns to remaining controllers
2. **Run Full Test Suite** - Verify all CRUD operations work correctly
3. **Update Views** - Ensure views use standardized response format
4. **Documentation** - Add inline comments to critical methods
5. **Performance Review** - Check query optimization with repositories

## Notes

- All new classes follow PSR-12 code style
- Vietnamese error messages are consistent with existing codebase
- Policies integrate with Laravel's built-in authorization
- Repositories provide chainable fluent interface
- AJAX responses follow standardized format for consistent frontend handling
