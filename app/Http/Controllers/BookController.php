<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\BooksExport;
use App\Imports\BooksImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::with('category')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return $row->category ? $row->category->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('books.edit', $row->id);
                    $deleteUrl = route('books.destroy', $row->id);
                    $actionBtn = '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>
                                  <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                                      ' . csrf_field() . '
                                      ' . method_field('DELETE') . '
                                      <button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Delete</button>
                                  </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('books.buku', ['title' => 'List Buku']);
    }
    public function create()
    {
        $categories = Category::all();
        return view('books.buku', ['title' => 'Tambah Buku', 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y')),
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.buku', ['title' => 'Edit Buku', 'book' => $book, 'categories' => $categories]);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y')),
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }

    public function exportPdf()
    {
        $books = Book::with('category')->get();
        $pdf = Pdf::loadView('books.pdf', ['books' => $books]);
        return $pdf->download('books.pdf');
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new BooksImport, $request->file('file'));
        return redirect()->route('books.index')->with('success', 'Data buku berhasil diimpor.');
    }
}
