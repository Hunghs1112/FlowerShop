<?php

namespace App\Policies;

/**
 * EXAMPLE: Using Authorization Policies
 * 
 * This file demonstrates how to use policies in controllers and views
 * to replace inline AdminMiddleware checks.
 */

/**
 * ============================================================================
 * IN CONTROLLER - AUTHORIZE ENTIRE RESOURCE
 * ============================================================================
 * 
 * use App\Models\Product;
 * 
 * class ProductController extends Controller
 * {
 *     public function store(StoreProductRequest $request)
 *     {
 *         // Authorize user can create products
 *         $this->authorize('create', Product::class);
 *         
 *         // User is authorized, proceed with creation
 *         $product = Product::create($request->validated());
 *         
 *         return redirect()->route('admin.products.index')
 *             ->with('success', 'Product created');
 *     }
 * 
 *     public function update(UpdateProductRequest $request, Product $product)
 *     {
 *         // Authorize user can update this specific product
 *         $this->authorize('update', $product);
 *         
 *         $product->update($request->validated());
 *         
 *         return redirect()->route('admin.products.index')
 *             ->with('success', 'Product updated');
 *     }
 * 
 *     public function destroy(Product $product)
 *     {
 *         // Authorize deletion
 *         $this->authorize('delete', $product);
 *         
 *         $product->delete();
 *         
 *         return redirect()->route('admin.products.index')
 *             ->with('success', 'Product deleted');
 *     }
 * }
 */

/**
 * ============================================================================
 * IN CONTROLLER - AUTHORIZE CUSTOM ACTION
 * ============================================================================
 * 
 * public function manageImages(Request $request, Product $product)
 * {
 *     // Authorize custom action
 *     $this->authorize('manageImages', $product);
 *     
 *     // Handle image management
 * }
 * 
 * public function manageVariants(Request $request, Product $product)
 * {
 *     $this->authorize('manageVariants', $product);
 *     
 *     // Handle variant management
 * }
 */

/**
 * ============================================================================
 * IN VIEWS - SHOW/HIDE ELEMENTS
 * ============================================================================
 * 
 * <!-- Blade template -->
 * @can('update', $product)
 *     <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
 *         Edit
 *     </a>
 * @endcan
 * 
 * @can('delete', $product)
 *     <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
 *         @csrf
 *         @method('DELETE')
 *         <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
 *             Delete
 *         </button>
 *     </form>
 * @endcan
 * 
 * @cannot('create', App\Models\Product::class)
 *     <p>You don't have permission to create products</p>
 * @endcannot
 */

/**
 * ============================================================================
 * IN MIDDLEWARE (ROUTE PROTECTION)
 * ============================================================================
 * 
 * // In routes/web.php
 * 
 * Route::middleware(['auth', 'can:viewAny,App\Models\Product'])->group(function () {
 *     Route::get('/admin/products', [ProductController::class, 'index']);
 * });
 * 
 * // Or with model binding
 * Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])
 *     ->middleware('can:update,product');
 */

/**
 * ============================================================================
 * REPLACING MIDDLEWARE WITH POLICIES
 * ============================================================================
 * 
 * BEFORE (AdminMiddleware):
 * 
 *     Route::middleware('admin')->group(function () {
 *         Route::resource('products', ProductController::class);
 *     });
 * 
 * AFTER (Policies):
 * 
 *     Route::group(function () {
 *         Route::resource('products', ProductController::class);
 *     });
 *     
 *     // Policies are checked inside controller actions
 *     public function index()
 *     {
 *         $this->authorize('viewAny', Product::class);
 *         // ...
 *     }
 */

/**
 * ============================================================================
 * CUSTOM POLICY METHODS
 * ============================================================================
 * 
 * // In ProductPolicy
 * public function manageImages(User $user, Product $product): bool
 * {
 *     return $user->isAdmin();
 * }
 * 
 * // In Controller
 * $this->authorize('manageImages', $product);
 * 
 * // In Blade
 * @can('manageImages', $product)
 *     <a href="{{ route('admin.products.images', $product) }}">Manage Images</a>
 * @endcan
 */

/**
 * ============================================================================
 * CHECKING AUTHORIZATION WITHOUT EXCEPTION
 * ============================================================================
 * 
 * // Returns boolean instead of throwing exception
 * if ($user->can('update', $product)) {
 *     // User can update
 * } else {
 *     // User cannot update
 * }
 * 
 * // In blade
 * @if(auth()->user()->can('delete', $product))
 *     <button>Delete</button>
 * @endif
 */

/**
 * ============================================================================
 * POLICY BEST PRACTICES
 * ============================================================================
 * 
 * 1. Always check authentication first - policies assume user is authenticated
 * 
 * 2. Use meaningful method names:
 *    - viewAny() - List/index view
 *    - view() - Single model view
 *    - create() - Create form/action
 *    - update() - Update form/action
 *    - delete() - Delete action
 *    - restore() - Restore soft-deleted
 *    - forceDelete() - Permanent delete
 * 
 * 3. For model-specific checks, add the model parameter:
 *    public function update(User $user, Product $product): bool
 * 
 * 4. For non-model resources, omit model parameter:
 *    public function create(User $user): bool
 * 
 * 5. Return boolean - don't throw exceptions
 *    The controller's authorize() method throws for you
 */

/**
 * ============================================================================
 * UNIT TESTING POLICIES
 * ============================================================================
 * 
 * use App\Models\User;
 * use App\Models\Product;
 * use Tests\TestCase;
 * 
 * class ProductPolicyTest extends TestCase
 * {
 *     public function test_admin_can_create_product()
 *     {
 *         $admin = User::factory()->admin()->create();
 *         $this->assertTrue($admin->can('create', Product::class));
 *     }
 * 
 *     public function test_customer_cannot_create_product()
 *     {
 *         $customer = User::factory()->create();
 *         $this->assertFalse($customer->can('create', Product::class));
 *     }
 * 
 *     public function test_admin_can_update_product()
 *     {
 *         $admin = User::factory()->admin()->create();
 *         $product = Product::factory()->create();
 *         $this->assertTrue($admin->can('update', $product));
 *     }
 * 
 *     public function test_admin_cannot_delete_self()
 *     {
 *         $admin = User::factory()->admin()->create();
 *         $this->assertFalse($admin->can('delete', $admin));
 *     }
 * }
 */

class PolicyUsageExample
{
    // This is just a demonstration file - not a real class
}
