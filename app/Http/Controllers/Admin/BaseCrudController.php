<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Base CRUD Controller with standardized patterns
 * 
 * Provides common CRUD operations with consistent:
 * - Validation via FormRequests
 * - Transaction handling
 * - Flash messaging
 * - Error handling
 * - Response formatting
 */
abstract class BaseCrudController extends Controller
{
    /**
     * Get the model class name
     * Override in child classes
     */
    abstract protected function getModelClass(): string;

    /**
     * Get the route prefix for redirects
     * Override in child classes
     * Example: 'admin.products'
     */
    abstract protected function getRoutePrefix(): string;

    /**
     * Get the view prefix for rendering
     * Override in child classes
     * Example: 'admin.products'
     */
    abstract protected function getViewPrefix(): string;

    /**
     * Display a listing of the resource
     */
    public function index(Request $request): View
    {
        $modelClass = $this->getModelClass();
        $query = $modelClass::query();

        // Apply search if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query = $this->applySearch($query, $search);
        }

        // Apply filters if provided
        if (method_exists($this, 'applyFilters')) {
            $query = $this->applyFilters($query, $request);
        }

        // Pagination
        $perPage = $request->input('per_page', 15);
        $items = $query->paginate($perPage);

        return view($this->getViewPrefix() . '.index', [
            'items' => $items,
            'search' => $request->input('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource
     */
    public function create(): View
    {
        return view($this->getViewPrefix() . '.create');
    }

    /**
     * Display a single resource
     */
    public function show(Model $item): View
    {
        return view($this->getViewPrefix() . '.show', compact('item'));
    }

    /**
     * Show the form for editing the resource
     */
    public function edit(Model $item): View
    {
        return view($this->getViewPrefix() . '.edit', compact('item'));
    }

    /**
     * Apply search filters to the query
     * Override in child classes to customize search behavior
     */
    protected function applySearch($query, string $search)
    {
        // Default: search by name or title
        if (method_exists($query->getModel(), 'searchable')) {
            return $query->search($search);
        }

        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('title', 'like', "%{$search}%");
    }

    /**
     * Handle successful creation
     */
    protected function handleStoreSuccess($item): RedirectResponse
    {
        $entityName = $this->getEntityName();
        return redirect()->route($this->getRoutePrefix() . '.index')
                       ->with('success', "Tạo {$entityName} thành công");
    }

    /**
     * Handle successful update
     */
    protected function handleUpdateSuccess($item): RedirectResponse
    {
        $entityName = $this->getEntityName();
        return redirect()->route($this->getRoutePrefix() . '.index')
                       ->with('success', "Cập nhật {$entityName} thành công");
    }

    /**
     * Handle successful deletion
     */
    protected function handleDeleteSuccess(): RedirectResponse
    {
        $entityName = $this->getEntityName();
        return redirect()->route($this->getRoutePrefix() . '.index')
                       ->with('success', "Xóa {$entityName} thành công");
    }

    /**
     * Handle delete failure (constraint violation)
     */
    protected function handleDeleteConstraintViolation(string $reason = null): RedirectResponse
    {
        $message = $reason ?? 'Không thể xóa mục này vì nó đang được sử dụng';
        return back()->with('error', $message);
    }

    /**
     * Get the entity name for messages (singular)
     * Override to customize
     */
    protected function getEntityName(): string
    {
        $modelClass = $this->getModelClass();
        return strtolower(class_basename($modelClass));
    }

    /**
     * Authorize a request
     * Override in child classes for custom authorization
     */
    protected function authorize(Request $request = null): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
}
