<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Display a listing of borrowings for admin
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            try {
                Borrowing::where('status', 'approved')
                    ->where('due_date', '<', now()->toDateString())
                    ->update(['status' => 'overdue']);

                $query = Borrowing::with(['user', 'book.category', 'approvedBy'])
                    ->when($request->member_id, function ($query, $member_id) {
                        return $query->where('user_id', $member_id);
                    });

                // Handle search
                if ($request->has('search') && !empty($request->search['value'])) {
                    $searchValue = $request->search['value'];
                    $query->where(function ($q) use ($searchValue) {
                        $q->whereHas('user', function ($q) use ($searchValue) {
                            $q->where('name', 'LIKE', "%{$searchValue}%")
                                ->orWhere('email', 'LIKE', "%{$searchValue}%");
                        })
                            ->orWhereHas('book', function ($q) use ($searchValue) {
                                $q->where('title', 'LIKE', "%{$searchValue}%")
                                    ->orWhere('author', 'LIKE', "%{$searchValue}%");
                            })
                            ->orWhereHas('book.category', function ($q) use ($searchValue) {
                                $q->where('name', 'LIKE', "%{$searchValue}%");
                            });
                    });
                }

                // Get total count before pagination
                $totalRecords = Borrowing::count();
                $filteredRecords = $query->count();

                // Handle ordering
                if ($request->has('order')) {
                    $orderColumn = $request->order[0]['column'];
                    $orderDir = $request->order[0]['dir'];

                    // Define ordering based on column index
                    switch ($orderColumn) {
                        case 1: // Member name
                            $query->join('users', 'borrowings.user_id', '=', 'users.id')
                                ->orderBy('users.name', $orderDir)
                                ->select('borrowings.*');
                            break;
                        case 2: // Member email
                            $query->join('users', 'borrowings.user_id', '=', 'users.id')
                                ->orderBy('users.email', $orderDir)
                                ->select('borrowings.*');
                            break;
                        case 3: // Book title
                            $query->join('books', 'borrowings.book_id', '=', 'books.id')
                                ->orderBy('books.title', $orderDir)
                                ->select('borrowings.*');
                            break;
                        case 4: // Book author
                            $query->join('books', 'borrowings.book_id', '=', 'books.id')
                                ->orderBy('books.author', $orderDir)
                                ->select('borrowings.*');
                            break;
                        case 5: // Category
                            $query->join('books', 'borrowings.book_id', '=', 'books.id')
                                ->join('categories', 'books.category_id', '=', 'categories.id')
                                ->orderBy('categories.name', $orderDir)
                                ->select('borrowings.*');
                            break;
                        case 6: // Borrow date
                            $query->orderBy('borrowed_date', $orderDir);
                            break;
                        case 7: // Due date
                            $query->orderBy('due_date', $orderDir);
                            break;
                        case 8: // Return date
                            $query->orderBy('returned_date', $orderDir);
                            break;
                        default:
                            $query->latest();
                    }
                } else {
                    $query->latest();
                }

                // Handle pagination
                $start = $request->input('start', 0);
                $length = $request->input('length', 25);

                $borrowings = $query->skip($start)->take($length)->get();

                \Log::info('Borrowings count: ' . $borrowings->count());
                \Log::info('Search value: ' . ($request->search['value'] ?? 'none'));

                $data = [];
                foreach ($borrowings as $index => $b) {
                    $data[] = [
                        'DT_RowIndex' => $start + $index + 1,
                        'member' => $b->user ? $b->user->name : 'N/A',
                        'member_email' => $b->user ? $b->user->email : 'N/A',
                        'book_title' => $b->book ? $b->book->title : 'N/A',
                        'book_author' => $b->book ? ($b->book->author ?? 'N/A') : 'N/A',
                        'category' => $b->book && $b->book->category ? $b->book->category->name : 'N/A',
                        'borrow_date' => $b->borrowed_date ? Carbon::parse($b->borrowed_date)->format('d/m/Y') : '-',
                        'due_date' => $b->due_date ? Carbon::parse($b->due_date)->format('d/m/Y') : '-',
                        'return_date' => $b->returned_date ? Carbon::parse($b->returned_date)->format('d/m/Y') : '-'
                    ];
                }

                return response()->json([
                    'draw' => intval($request->input('draw', 1)),
                    'recordsTotal' => $totalRecords,
                    'recordsFiltered' => $filteredRecords,
                    'data' => $data
                ]);
            } catch (\Exception $e) {
                \Log::error('DataTables error: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to load data'], 500);
            }
        }

        return view('admin.borrowing.index', [
            'title' => 'Manajemen Peminjaman'
        ]);
    }

    /**
     * Show borrowing details
     */
    public function show(Borrowing $borrowing): View
    {
        $borrowing->load(['user', 'book.category', 'approvedBy']);

        return view('admin.borrowing.show', [
            'title' => 'Detail Peminjaman',
            'borrowing' => $borrowing
        ]);
    }

    /**
     * Mark borrowing as returned
     */
    public function return(Request $request, Borrowing $borrowing): JsonResponse
    {
        if (!in_array($borrowing->status, ['approved', 'overdue'])) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya peminjaman yang sedang dipinjam atau terlambat yang bisa dikembalikan.'
            ], 400);
        }

        $returnedDate = now()->toDateString();

        $borrowing->update([
            'status' => 'returned',
            'returned_date' => $returnedDate,
            'admin_notes' => $request->admin_notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dikembalikan.'
        ]);
    }

    /**
     * Search members for borrowing
     */
    public function searchMembers(Request $request): JsonResponse
    {
        $query = $request->get('q');

        if (empty($query)) {
            return response()->json([]);
        }

        $members = User::role('member')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($members->map(function ($member) {
            return [
                'id' => $member->id,
                'text' => $member->name . ' (' . $member->email . ')',
                'name' => $member->name,
                'email' => $member->email,
                'can_borrow' => $member->canBorrowMore(),
                'has_overdue' => $member->hasOverdueBooks(),
                'active_borrowings' => $member->activeBorrowings()->count()
            ];
        }));
    }

    /**
     * Get borrowing statistics (updated for simplified status system)
     */
    public function statistics(): JsonResponse
    {
        Borrowing::where('status', 'approved')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        $stats = [
            'total' => Borrowing::count(),
            'dipinjam' => Borrowing::where('status', 'approved')->count(),
            'dikembalikan' => Borrowing::where('status', 'returned')->count(),
            'terlambat' => Borrowing::where('status', 'overdue')->count(),
        ];

        return response()->json($stats);
    }
}
