<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Trait for handling common CRUD operation patterns
 * 
 * Used by service classes to provide standardized:
 * - Pagination
 * - Filtering
 * - Sorting
 * - Deletion with constraints
 */
trait HandlesCrudOperations
{
    /**
     * Paginate query results
     */
    protected function paginate($query, int $perPage = 15)
    {
        return $query->paginate($perPage);
    }

    /**
     * Apply active/inactive filter
     */
    protected function filterByActive($query, bool $isActive = true)
    {
        return $query->where('is_active', $isActive);
    }

    /**
     * Apply date range filter
     */
    protected function filterByDateRange($query, string $field, ?string $from, ?string $to)
    {
        if ($from) {
            $query = $query->whereDate($field, '>=', $from);
        }

        if ($to) {
            $query = $query->whereDate($field, '<=', $to);
        }

        return $query;
    }

    /**
     * Apply sort order
     */
    protected function applySortOrder($query, string $field = 'created_at', string $direction = 'desc')
    {
        return $query->orderBy($field, $direction);
    }

    /**
     * Delete model with constraint checking
     * 
     * @param Model $model
     * @param callable|null $constraintChecker Optional callback to check if deletion is allowed
     * @return bool
     * @throws Exception if constraint check fails
     */
    protected function deleteWithConstraints(Model $model, callable $constraintChecker = null): bool
    {
        if ($constraintChecker && !$constraintChecker($model)) {
            return false;
        }

        return DB::transaction(function () use ($model) {
            // Fire any model events before deletion
            $model->delete();
            return true;
        });
    }

    /**
     * Soft delete support
     */
    protected function softDelete(Model $model): bool
    {
        if (!method_exists($model, 'delete') || !in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model))) {
            return $this->deleteWithConstraints($model);
        }

        $model->delete();
        return true;
    }

    /**
     * Force delete (if using soft deletes)
     */
    protected function forceDelete(Model $model): bool
    {
        return $model->forceDelete();
    }

    /**
     * Restore soft-deleted model
     */
    protected function restore(Model $model): bool
    {
        if (!method_exists($model, 'restore')) {
            return false;
        }

        return $model->restore();
    }

    /**
     * Batch delete models with transaction
     */
    protected function batchDelete(array $ids, string $idField = 'id'): int
    {
        return DB::transaction(function () use ($ids, $idField) {
            $modelClass = $this->getModelClass();
            return $modelClass::whereIn($idField, $ids)->delete();
        });
    }
}
