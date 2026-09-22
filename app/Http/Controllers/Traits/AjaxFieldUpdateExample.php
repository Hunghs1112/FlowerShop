<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Str;

/**
 * EXAMPLE: Standardized AJAX Field Update Pattern
 * 
 * This file demonstrates how to use the HandlesAjaxFieldUpdates trait
 * and AjaxFieldService for consistent AJAX field updates across all controllers.
 * 
 * Copy the examples below into your controller and customize as needed.
 */

/**
 * ============================================================================
 * BASIC USAGE - Simple field update with trait
 * ============================================================================
 * 
 * In your controller:
 * 
 *     use App\Http\Controllers\Traits\HandlesAjaxFieldUpdates;
 * 
 *     class ProductController extends Controller
 *     {
 *         use HandlesAjaxFieldUpdates;
 * 
 *         public function updateField(Request $request, Product $product)
 *         {
 *             return $this->handleAjaxFieldUpdate($request, $product, [
 *                 'allowed_fields' => ['name', 'price', 'stock', 'is_active'],
 *                 'rules' => [
 *                     'name' => 'required|string|max:255',
 *                     'price' => 'required|numeric|min:0',
 *                     'stock' => 'required|integer|min:0',
 *                     'is_active' => 'boolean',
 *                 ],
 *             ]);
 *         }
 *     }
 * 
 * Request format (AJAX):
 *     POST /admin/products/{product}/field
 *     Content-Type: application/json
 *     {
 *         "field": "name",
 *         "value": "New Product Name"
 *     }
 * 
 * Response format (success):
 *     {
 *         "success": true,
 *         "message": "Đã lưu name",
 *         "data": {
 *             "field": "name",
 *             "value": "New Product Name",
 *             "display_value": "New Product Name"
 *         }
 *     }
 * 
 * Response format (validation error):
 *     {
 *         "success": false,
 *         "message": "name không được vượt quá 255 ký tự",
 *         "errors": {
 *             "name": ["name không được vượt quá 255 ký tự"]
 *         }
 *     }
 */

/**
 * ============================================================================
 * ADVANCED USAGE - With value transformers and hooks
 * ============================================================================
 * 
 * public function updateField(Request $request, Post $post)
 * {
 *     return $this->handleAjaxFieldUpdate($request, $post, [
 *         'allowed_fields' => ['title', 'slug', 'status', 'published_at'],
 *         'rules' => [
 *             'title' => 'required|string|max:255',
 *             'slug' => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
 *             'status' => 'required|in:draft,published',
 *             'published_at' => 'nullable|date',
 *         ],
 *         'transformers' => [
 *             // Auto-generate slug from title
 *             'title' => function ($value, $post) {
 *                 if (empty($post->slug)) {
 *                     $post->slug = Str::slug($value);
 *                 }
 *                 return $value;
 *             },
 *             // Convert status to boolean
 *             'status' => function ($value) {
 *                 return $value === 'published' ? true : false;
 *             },
 *         ],
 *         'before_save' => function ($post, $field, $value) {
 *             // Custom validation or pre-processing
 *             if ($field === 'title' && strlen($value) < 3) {
 *                 return false; // Reject update
 *             }
 *             return true;
 *         },
 *         'after_save' => function ($post, $field, $value) {
 *             // Trigger events, clear cache, etc
 *             if ($field === 'status') {
 *                 event(new PostStatusChanged($post));
 *             }
 *         },
 *     ]);
 * }
 */

/**
 * ============================================================================
 * CUSTOM LOGIC - Complete control with handleCustomAjaxFieldUpdate
 * ============================================================================
 * 
 * public function updateField(Request $request, Category $category)
 * {
 *     return $this->handleCustomAjaxFieldUpdate($request, $category, function ($category, $field, $value) {
 *         // Custom logic for each field
 *         if ($field === 'parent_id') {
 *             // Prevent circular reference
 *             if ($value == $category->id) {
 *                 return false;
 *             }
 *             // Validate parent exists
 *             $parent = Category::find($value);
 *             if (!$parent) {
 *                 return false;
 *             }
 *         }
 * 
 *         $category->update([$field => $value]);
 * 
 *         return [
 *             'message' => "Cập nhật {$field} thành công",
 *             'data' => [
 *                 'field' => $field,
 *                 'value' => $category->$field,
 *             ]
 *         ];
 *     });
 * }
 */

/**
 * ============================================================================
 * SERVICE-BASED APPROACH - Using AjaxFieldService
 * ============================================================================
 * 
 * use App\Services\AjaxFieldService;
 * 
 * class UserController extends Controller
 * {
 *     protected AjaxFieldService $fieldService;
 * 
 *     public function __construct(AjaxFieldService $fieldService)
 *     {
 *         $this->fieldService = $fieldService;
 *     }
 * 
 *     // Simple single field update
 *     public function updateField(Request $request, User $user)
 *     {
 *         return $this->fieldService->updateField($user, 'name', $request->input('value'), [
 *             'allowed_fields' => ['name', 'email', 'phone'],
 *             'rules' => [
 *                 'name' => 'required|string|max:255',
 *             ],
 *         ]);
 *     }
 * 
 *     // Toggle boolean field
 *     public function toggleActive(Request $request, User $user)
 *     {
 *         return $this->fieldService->toggleField($user, 'is_active', 
 *             ['is_active', 'is_admin']
 *         );
 *     }
 * 
 *     // Multiple fields at once
 *     public function updateFields(Request $request, User $user)
 *     {
 *         return $this->fieldService->updateFields($user, $request->input('fields'), [
 *             'allowed_fields' => ['name', 'email', 'phone', 'address'],
 *             'rules' => [
 *                 'name' => 'required|string|max:255',
 *                 'email' => 'required|email|unique:users,email,' . $user->id,
 *                 'phone' => 'nullable|string|max:20',
 *             ],
 *         ]);
 *     }
 * }
 */

/**
 * ============================================================================
 * FRONTEND USAGE EXAMPLE (JavaScript)
 * ============================================================================
 * 
 * // Basic field update
 * async function updateField(field, value) {
 *     const response = await fetch('/admin/products/{id}/field', {
 *         method: 'POST',
 *         headers: {
 *             'Content-Type': 'application/json',
 *             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
 *         },
 *         body: JSON.stringify({ field, value })
 *     });
 * 
 *     const data = await response.json();
 *     if (data.success) {
 *         showNotification('success', data.message);
 *     } else {
 *         showNotification('error', data.message);
 *     }
 * }
 * 
 * // Toggle field
 * async function toggleField(field) {
 *     const response = await fetch(`/admin/users/{id}/field/toggle`, {
 *         method: 'POST',
 *         headers: {
 *             'Content-Type': 'application/json',
 *             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
 *         },
 *         body: JSON.stringify({ field })
 *     });
 * 
 *     const data = await response.json();
 *     if (data.success) {
 *         document.querySelector(`[data-field="${field}"]`).textContent = data.data.display;
 *     }
 * }
 */

class AjaxFieldUpdateExample
{
    // This is just a demonstration file - not a real class
}
