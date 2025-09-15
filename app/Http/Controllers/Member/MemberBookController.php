<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class MemberBookController extends Controller
{
    /**
     * Display a listing of books for members
     */
    public function index(Request $request)
    {
        $query = Book::with('category')
            ->where('status', 'available')
            ->where('available_stock', '>', 0);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $sortBy = $request->get('sort_by', 'title');
        $sortOrder = $request->get('sort_order', 'asc');

        if (in_array($sortBy, ['title', 'author', 'publication_year', 'available_stock'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $books = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('member.books.index', compact('books', 'categories'));
    }

    /**
     * Display the specified book details
     */
    public function show(Book $book)
    {
        $book->load('category');

        $userHasActiveBorrowing = auth()->user()
            ->borrowings()
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        return view('member.books.show', compact('book', 'userHasActiveBorrowing'));
    }

    /**
     * Search books via AJAX
     */
    public function search(Request $request)
    {
        $search = $request->get('q');

        $books = Book::with('category')
            ->where('status', 'available')
            ->where('available_stock', '>', 0)
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    });
            })
            ->limit(10)
            ->get();

        return response()->json($books);
    }
}
