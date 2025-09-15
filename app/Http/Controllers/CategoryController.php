<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::withCount('books')->latest()->get();

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('books_count', function ($row) {
                    return $row->books_count . ' buku';
                })
                ->addColumn('action', function ($row) {
                    return $this->getActionButtons($row);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.category.kategori', [
            'title' => 'Category Management'
        ]);
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $request->category_id
        ]);

        try {
            Category::updateOrCreate(
                ['id' => $request->category_id],
                ['name' => $request->name]
            );

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(int $id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(int $id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->books()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih memiliki buku.'
                ], 400);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate action buttons for DataTable.
     */
    private function getActionButtons($category): string
    {
        return '
                <button type="button" class="btn btn-sm btn-primary editCategory"
                        data-id="' . $category->id . '"
                        data-toggle="tooltip"
                        title="Edit kategori">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-danger deleteCategory"
                        data-id="' . $category->id . '"
                        data-toggle="tooltip"
                        title="Hapus kategori">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        ';
    }
}
