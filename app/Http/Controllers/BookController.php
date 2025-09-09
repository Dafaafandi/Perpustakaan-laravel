<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Exports\BooksTemplateExport;
use App\Imports\BooksImport;
use App\Models\Book;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $books = Book::with('category')->latest()->get();

            return DataTables::of($books)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return $row->category?->name ?? 'N/A';
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<div style="width: 60px; height: 80px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 4px; overflow: hidden;">
                                    <img src="' . asset('storage/' . $row->image) . '" alt="Book Image"
                                         style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 4px;">
                                </div>';
                    }
                    return '<div style="width: 60px; height: 80px; display: flex; align-items: center; justify-content: center; background-color: #e9ecef; border-radius: 4px;">
                                <span class="badge bg-secondary" style="font-size: 10px;">No Image</span>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return $this->getActionButtons($row);
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('admin.books.buku', [
            'title' => 'Book Management'
        ]);
    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('admin.books.buku', [
            'title' => 'Tambah Buku',
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateBookData($request);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('book-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        Book::create($validatedData);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book): View
    {
        $categories = Category::all();

        return view('admin.books.buku', [
            'title' => 'Edit Buku',
            'book' => $book,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validatedData = $this->validateBookData($request);

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $imagePath = $request->file('image')->store('book-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $book->update($validatedData);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book): RedirectResponse|JsonResponse
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        // Check if request is Ajax
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dihapus.'
            ]);
        }

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Export books to Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new BooksExport, 'books-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Download template for importing books.
     */
    public function downloadTemplate()
    {
        return Excel::download(new BooksTemplateExport, 'template-import-buku.xlsx');
    }

    /**
     * Export books to PDF.
     */
    public function exportPdf()
    {
        $books = Book::with('category')->get();
        $pdf = Pdf::loadView('admin.books.pdf', ['books' => $books]);

        return $pdf->download('books-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Import books from Excel.
     */
    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new BooksImport, $request->file('file'));

            return redirect()
                ->route('admin.books.index')
                ->with('success', 'Data buku berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.books.index')
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Validate book data.
     */
    private function validateBookData(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book): View
    {
        return view('admin.books.show', [
            'book' => $book->load('category'),
            'title' => 'Detail Buku: ' . $book->title
        ]);
    }

    /**
     * Generate action buttons for DataTable.
     */
    private function getActionButtons($book): string
    {
        $detailUrl = route('admin.books.show', $book->id);
        $editUrl = route('admin.books.edit', $book->id);
        $deleteUrl = route('admin.books.destroy', $book->id);

        return '
            <div class="btn-group" role="group">
                <a href="' . $detailUrl . '" class="btn btn-info">
                    <i class="fa-solid fa-info"></i> Detail
                </a>
                <a href="' . $editUrl . '" class="btn btn-sm btn-success">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-danger delete-btn"
                        data-url="' . $deleteUrl . '"
                        data-title="' . htmlspecialchars($book->title) . '">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        ';
    }
}
