<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Base Repository for centralized query logic
 * 
 * Provides:
 * - Pagination with filters
 * - Search across multiple fields
 * - Sorting
 * - Active/inactive filtering
 * - Scoping
 */
abstract class BaseRepository
{
    /**
     * The root model instance — never mutated, always a plain Model.
     */
    protected Model $model;

    /**
     * Accumulated query builder — starts fresh each request via newQuery().
     * Typed as mixed so child repos can assign Builder instances freely.
     */
    protected mixed $currentQuery = null;

    /**
     * Get the model class
     */
    abstract protected function getModel(): string;

    /**
     * Initialize repository
     */
    public function __construct()
    {
        $this->model = app($this->getModel());
    }

    /**
     * Create a fresh query builder from the root model.
     * Child repos should call this, NOT $this->model->newQuery() directly.
     */
    protected function query(): Builder
    {
        // If a query is being accumulated (fluent chain), return it and reset.
        if ($this->currentQuery !== null) {
            $q = $this->currentQuery;
            $this->currentQuery = null;
            return $q;
        }

        return $this->model->newQuery();
    }

    /**
     * Accumulate a builder into the fluent chain.
     * Used by chainable methods (active, sort, with, etc.)
     */
    protected function setQuery(Builder $query): static
    {
        $this->currentQuery = $query;
        return $this;
    }

    /**
     * Start a fresh accumulated query (entry point for fluent chains).
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Get all records
     */
    public function all(): Collection
    {
        return $this->newQuery()->get();
    }

    /**
     * Get by ID
     */
    public function find(int $id): ?Model
    {
        return $this->newQuery()->find($id);
    }

    /**
     * Get by multiple IDs
     */
    public function findMany(array $ids): Collection
    {
        return $this->newQuery()->whereIn('id', $ids)->get();
    }

    /**
     * Paginate results
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->newQuery()->paginate($perPage);
    }

    /**
     * Search by keyword
     */
    public function search(string $keyword, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->newQuery();

        if (!empty($keyword)) {
            $query = $this->applySearch($query, $keyword);
        }

        return $query->paginate($perPage);
    }

    /**
     * Apply search filters
     */
    protected function applySearch($query, string $keyword)
    {
        $searchFields = $this->getSearchFields();

        if (empty($searchFields)) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword, $searchFields) {
            foreach ($searchFields as $field) {
                $q->orWhere($field, 'like', "%{$keyword}%");
            }
        });
    }

    /**
     * Get search fields — override in child class
     */
    protected function getSearchFields(): array
    {
        return ['name', 'title'];
    }

    /**
     * Filter by active status
     */
    public function active(): static
    {
        return $this->setQuery($this->newQuery()->where('is_active', true));
    }

    /**
     * Filter by inactive status
     */
    public function inactive(): static
    {
        return $this->setQuery($this->newQuery()->where('is_active', false));
    }

    /**
     * Apply multiple filters
     */
    public function filter(array $filters): static
    {
        $query = $this->newQuery();

        foreach ($filters as $field => $value) {
            if ($value === null) {
                continue;
            }
            if (is_array($value)) {
                $query = $query->whereIn($field, $value);
            } else {
                $query = $query->where($field, $value);
            }
        }

        return $this->setQuery($query);
    }

    /**
     * Filter by date range
     */
    public function whereDateBetween(string $column, ?string $from, ?string $to): static
    {
        $query = $this->newQuery();

        if ($from) {
            $query = $query->whereDate($column, '>=', $from);
        }

        if ($to) {
            $query = $query->whereDate($column, '<=', $to);
        }

        return $this->setQuery($query);
    }

    /**
     * Sort results
     */
    public function sort(string $field = 'created_at', string $direction = 'desc'): static
    {
        return $this->setQuery($this->newQuery()->orderBy($field, $direction));
    }

    /**
     * Latest first
     */
    public function latest(): static
    {
        return $this->sort('created_at', 'desc');
    }

    /**
     * Oldest first
     */
    public function oldest(): static
    {
        return $this->sort('created_at', 'asc');
    }

    /**
     * Get query results — executes the accumulated query
     */
    public function get(): Collection
    {
        return $this->query()->get();
    }

    /**
     * Get first result
     */
    public function first(): ?Model
    {
        return $this->query()->first();
    }

    /**
     * Count results
     */
    public function count(): int
    {
        return $this->query()->count();
    }

    /**
     * Check if record exists
     */
    public function exists(): bool
    {
        return $this->query()->exists();
    }

    /**
     * Create new record
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update record
     */
    public function update(int $id, array $data): bool
    {
        $record = $this->find($id);
        if (!$record) {
            return false;
        }

        return $record->update($data);
    }

    /**
     * Delete record
     */
    public function delete(int $id): bool
    {
        $record = $this->find($id);
        if (!$record) {
            return false;
        }

        return (bool) $record->delete();
    }

    /**
     * Get with eager loading
     */
    public function with($relations): static
    {
        return $this->setQuery($this->newQuery()->with($relations));
    }

    /**
     * withCount support
     */
    public function withCount($relations): static
    {
        return $this->setQuery($this->newQuery()->withCount($relations));
    }

    /**
     * Chunk results for memory efficiency
     */
    public function chunk(int $size, callable $callback): void
    {
        $this->newQuery()->chunk($size, $callback);
    }

    /**
     * Pluck single column
     */
    public function pluck(string $column, string $key = null): Collection
    {
        return $this->newQuery()->pluck($column, $key);
    }

    /**
     * Get paginated results with search and filters
     */
    public function getFiltered(array $options = []): LengthAwarePaginator
    {
        $query = $this->newQuery();

        // Apply search
        if (!empty($options['search'])) {
            $query = $this->applySearchToQuery($query, $options['search']);
        }

        // Apply filters
        if (!empty($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                $query = $this->applyFilterToQuery($query, $field, $value);
            }
        }

        // Apply sort
        if (!empty($options['sort'])) {
            [$field, $direction] = $options['sort'];
            $query = $query->orderBy($field, $direction);
        }

        // Paginate
        $perPage = $options['per_page'] ?? 15;
        return $query->paginate($perPage);
    }

    /**
     * Apply search to existing query
     */
    protected function applySearchToQuery($query, string $keyword)
    {
        $searchFields = $this->getSearchFields();

        if (empty($searchFields)) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword, $searchFields) {
            foreach ($searchFields as $field) {
                $q->orWhere($field, 'like', "%{$keyword}%");
            }
        });
    }

    /**
     * Apply filter to existing query — override for custom filter logic
     */
    protected function applyFilterToQuery($query, string $field, $value)
    {
        if ($value === null) {
            return $query;
        }

        if (is_array($value)) {
            return $query->whereIn($field, $value);
        }

        return $query->where($field, $value);
    }

    /**
     * Begin transaction
     */
    public static function transaction(callable $callback)
    {
        return DB::transaction($callback);
    }
}
