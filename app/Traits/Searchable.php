<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Scope to search multiple fields
     */
    public function scopeSearch(Builder $query, string $term, array $fields = []): Builder
    {
        if (empty($fields)) {
            $fields = $this->searchable ?? [];
        }

        return $query->where(function (Builder $query) use ($term, $fields) {
            foreach ($fields as $field) {
                if (str_contains($field, '.')) {
                    $parts = explode('.', $field);
                    $relation = $parts[0];
                    $column = $parts[1];

                    $query->orWhereHas($relation, function (Builder $subQuery) use ($column, $term) {
                        $subQuery->where($column, 'like', "%{$term}%");
                    });
                } else {
                    $query->orWhere($field, 'like', "%{$term}%");
                }
            }
        });
    }

    /**
     * Scope to filter by status
     */
    public function scopeWithStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter active records
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to order by latest
     */
    public function scopeLatest(Builder $query, string $column = 'created_at'): Builder
    {
        return $query->orderBy($column, 'desc');
    }
}
