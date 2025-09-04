<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Get all resources
     */
    public function all(): Collection;

    /**
     * Find resource by ID
     */
    public function find(int $id): ?Model;

    /**
     * Create a new resource
     */
    public function create(array $data): Model;

    /**
     * Update a resource
     */
    public function update(Model $model, array $data): Model;

    /**
     * Delete a resource
     */
    public function delete(Model $model): bool;

    /**
     * Find resource by specific field
     */
    public function findBy(string $field, $value): ?Model;

    /**
     * Get resources by specific field
     */
    public function getBy(string $field, $value): Collection;
}
