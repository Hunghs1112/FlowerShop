<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Base CRUD Service providing standardized business logic
 * 
 * Handles:
 * - Model creation, updating, deletion
 * - Transaction management
 * - Relationships
 * - Pagination and filtering
 * - Error handling and logging
 */
abstract class CrudService
{
    /**
     * Get the model class
     */
    abstract protected function getModelClass(): string;

    /**
     * Create a new model instance
     * 
     * @param array $data Validated data from FormRequest
     * @return Model
     * @throws Throwable
     */
    public function create(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $modelClass = $this->getModelClass();
            $instance = $modelClass::create($this->prepareDataForCreate($data));
            
            // Allow child classes to handle related data (images, relationships, etc)
            if (method_exists($this, 'attachRelations')) {
                $this->attachRelations($instance, $data);
            }

            return $instance;
        });
    }

    /**
     * Update a model instance
     * 
     * @param Model $model
     * @param array $data Validated data from FormRequest
     * @return Model
     * @throws Throwable
     */
    public function update(Model $model, array $data): Model
    {
        return DB::transaction(function () use ($model, $data) {
            $model->update($this->prepareDataForUpdate($data));
            
            // Allow child classes to handle related data
            if (method_exists($this, 'updateRelations')) {
                $this->updateRelations($model, $data);
            }

            return $model->fresh();
        });
    }

    /**
     * Delete a model instance
     * 
     * @param Model $model
     * @return bool
     * @throws Throwable
     */
    public function delete(Model $model): bool
    {
        return DB::transaction(function () use ($model) {
            // Allow child classes to handle cleanup before deletion
            if (method_exists($this, 'beforeDelete')) {
                $this->beforeDelete($model);
            }

            $result = $model->delete();

            // Allow child classes to handle cleanup after deletion
            if (method_exists($this, 'afterDelete')) {
                $this->afterDelete($model);
            }

            return $result;
        });
    }

    /**
     * Get a single model by ID
     */
    public function getById(int $id): ?Model
    {
        $modelClass = $this->getModelClass();
        return $modelClass::find($id);
    }

    /**
     * Get all models with optional pagination
     */
    public function getAll(array $options = []): Collection|Paginator
    {
        $modelClass = $this->getModelClass();
        $query = $modelClass::query();

        // Apply filters
        if (isset($options['filters'])) {
            $query = $this->applyFilters($query, $options['filters']);
        }

        // Apply sort
        if (isset($options['sort'])) {
            [$column, $direction] = $options['sort'];
            $query = $query->orderBy($column, $direction);
        }

        // Paginate if requested
        if (isset($options['paginate'])) {
            return $query->paginate($options['paginate']);
        }

        return $query->get();
    }

    /**
     * Search for models
     */
    public function search(string $query, array $searchFields = [], int $limit = 15): Collection
    {
        $modelClass = $this->getModelClass();
        $builder = $modelClass::query();

        if (empty($searchFields)) {
            $searchFields = ['name', 'title'];
        }

        foreach ($searchFields as $field) {
            $builder->orWhere($field, 'like', "%{$query}%");
        }

        return $builder->limit($limit)->get();
    }

    /**
     * Prepare data for creation
     * Override in child classes to add custom logic
     */
    protected function prepareDataForCreate(array $data): array
    {
        return $data;
    }

    /**
     * Prepare data for update
     * Override in child classes to add custom logic
     */
    protected function prepareDataForUpdate(array $data): array
    {
        return $data;
    }

    /**
     * Apply filters to query
     * Override in child classes for custom filtering
     */
    protected function applyFilters($query, array $filters)
    {
        foreach ($filters as $field => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($field, $value);
            } else {
                $query = $query->where($field, $value);
            }
        }

        return $query;
    }

    /**
     * Check if model can be deleted
     * Override in child classes for custom constraints
     * Should throw an exception or return false if deletion is not allowed
     */
    public function canDelete(Model $model): bool
    {
        return true;
    }

    /**
     * Get deletion constraints message
     * Override in child classes
     */
    public function getDeletionConstraintMessage(Model $model): string
    {
        return 'Không thể xóa mục này vì nó đang được sử dụng';
    }
}
