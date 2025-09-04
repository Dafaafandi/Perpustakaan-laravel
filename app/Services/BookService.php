<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BookService
{
    /**
     * Get all books with categories
     */
    public function getAllBooks(): Collection
    {
        return Book::with('category')->latest()->get();
    }

    /**
     * Get paginated books
     */
    public function getPaginatedBooks(int $perPage = 15): LengthAwarePaginator
    {
        return Book::with('category')->latest()->paginate($perPage);
    }

    /**
     * Create a new book
     */
    public function createBook(array $data): Book
    {
        return Book::create($data);
    }

    /**
     * Update a book
     */
    public function updateBook(Book $book, array $data): Book
    {
        $book->update($data);
        return $book;
    }

    /**
     * Delete a book
     */
    public function deleteBook(Book $book): bool
    {
        return $book->delete();
    }

    /**
     * Search books
     */
    public function searchBooks(string $query): Collection
    {
        return Book::with('category')
            ->where('title', 'like', "%{$query}%")
            ->orWhere('author', 'like', "%{$query}%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->get();
    }

    /**
     * Get books by category
     */
    public function getBooksByCategory(Category $category): Collection
    {
        return $category->books()->latest()->get();
    }
}
