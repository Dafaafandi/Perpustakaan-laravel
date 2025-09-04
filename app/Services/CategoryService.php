<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Get all categories with book count
     */
    public function getAllCategories(): Collection
    {
        return Category::withCount('books')->latest()->get();
    }

    /**
     * Create a new category
     */
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update a category
     */
    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    /**
     * Delete a category
     */
    public function deleteCategory(Category $category): bool
    {
        // Check if category has books
        if ($category->books()->count() > 0) {
            throw new \Exception('Kategori tidak dapat dihapus karena masih memiliki buku.');
        }

        return $category->delete();
    }

    /**
     * Check if category can be deleted
     */
    public function canDeleteCategory(Category $category): bool
    {
        return $category->books()->count() === 0;
    }

    /**
     * Search categories
     */
    public function searchCategories(string $query): Collection
    {
        return Category::where('name', 'like', "%{$query}%")
            ->withCount('books')
            ->get();
    }
}
