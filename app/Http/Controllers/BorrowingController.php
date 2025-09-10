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
            $borrowings = Borrowing::with(['user', 'book.category', 'approvedBy'])
                ->when($request->status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->latest()
                ->get();

            return DataTables::of($borrowings)
                ->addIndexColumn()
                ->addColumn('member', function ($row) {
                    return $row->user ? $row->user->name : 'N/A';
                })
                ->addColumn('member_email', function ($row) {
                    return $row->user ? $row->user->email : 'N/A';
                })
                ->addColumn('book_title', function ($row) {
                    return $row->book ? $row->book->title : 'N/A';
                })
                ->addColumn('book_author', function ($row) {
                    return $row->book ? $row->book->author : 'N/A';
                })
                ->addColumn('category', function ($row) {
                    return $row->book && $row->book->category ? $row->book->category->name : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    $badgeClass = match ($row->status) {
                        'pending' => 'badge-warning',
                        'approved' => 'badge-success',
                        'returned' => 'badge-info',
                        'overdue' => 'badge-danger',
                        'rejected' => 'badge-dark',
                        default => 'badge-secondary',
                    };

                    $statusText = $row->status_text;

                    if ($row->status === 'approved' && $row->isOverdue()) {
                        $badgeClass = 'badge-danger';
                        $statusText = 'Terlambat';
                    }

                    return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
                })
                ->addColumn('borrowed_date', function ($row) {
                    return $row->borrowed_date ? $row->borrowed_date->format('d/m/Y') : '-';
                })
                ->addColumn('due_date', function ($row) {
                    $dueDate = $row->due_date ? $row->due_date->format('d/m/Y') : '-';

                    if ($row->status === 'approved' && $row->due_date && $row->isOverdue()) {
                        $overdueDays = Carbon::parse($row->due_date)->diffInDays(now());
                        $dueDate .= ' <span class="text-danger">(' . $overdueDays . ' hari terlambat)</span>';
                    }

                    return $dueDate;
                })
                ->addColumn('returned_date', function ($row) {
                    return $row->returned_date ? $row->returned_date->format('d/m/Y') : '-';
                })
                ->addColumn('fine_amount', function ($row) {
                    if ($row->fine_amount > 0) {
                        return 'Rp ' . number_format($row->fine_amount, 0, ',', '.');
                    } elseif ($row->status === 'approved' && $row->isOverdue()) {
                        $fine = $row->calculateFine();
                        return '<span class="text-danger">Rp ' . number_format($fine, 0, ',', '.') . '</span>';
                    }
                    return 'Rp 0';
                })
                ->addColumn('approved_by', function ($row) {
                    return $row->approvedBy ? $row->approvedBy->name : '-';
                })
                ->addColumn('action', function ($row) {
                    return $this->getActionButtons($row);
                })
                ->rawColumns(['status', 'due_date', 'fine_amount', 'action'])
                ->make(true);
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
     * Approve borrowing request
     */
    public function approve(Request $request, Borrowing $borrowing): JsonResponse
    {
        if ($borrowing->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya peminjaman dengan status pending yang bisa disetujui.'
            ], 400);
        }

        // Check if book is still available
        if (!$borrowing->book->isAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Buku sudah tidak tersedia.'
            ], 400);
        }

        // Check if user can still borrow
        if (!$borrowing->user->canBorrowMore()) {
            return response()->json([
                'success' => false,
                'message' => 'Member sudah mencapai batas maksimal peminjaman.'
            ], 400);
        }

        // Check if user has overdue books
        if ($borrowing->user->hasOverdueBooks()) {
            return response()->json([
                'success' => false,
                'message' => 'Member memiliki buku yang terlambat dikembalikan.'
            ], 400);
        }

        // Approve the borrowing
        $loanPeriod = config('library.borrowing.loan_period_days', 14);
        $borrowedDate = now()->toDateString();
        $dueDate = now()->addDays($loanPeriod)->toDateString();

        $borrowing->update([
            'status' => 'approved',
            'borrowed_date' => $borrowedDate,
            'due_date' => $dueDate,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes
        ]);

        // Reduce book stock
        $borrowing->book->reduceStock();

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil disetujui.'
        ]);
    }

    /**
     * Reject borrowing request
     */
    public function reject(Request $request, Borrowing $borrowing): JsonResponse
    {
        if ($borrowing->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya peminjaman dengan status pending yang bisa ditolak.'
            ], 400);
        }

        $borrowing->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil ditolak.'
        ]);
    }

    /**
     * Mark borrowing as returned
     */
    public function return(Request $request, Borrowing $borrowing): JsonResponse
    {
        if ($borrowing->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya peminjaman yang sedang dipinjam yang bisa dikembalikan.'
            ], 400);
        }

        $fine = 0;
        $returnedDate = now()->toDateString();

        // Calculate fine if overdue
        if ($borrowing->isOverdue()) {
            $fine = $borrowing->calculateFine();
        }

        $borrowing->update([
            'status' => 'returned',
            'returned_date' => $returnedDate,
            'fine_amount' => $fine,
            'admin_notes' => $request->admin_notes
        ]);

        // Increase book stock
        $borrowing->book->increaseStock();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dikembalikan.' . ($fine > 0 ? ' Denda: Rp ' . number_format($fine, 0, ',', '.') : ''),
            'fine' => $fine
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
                'active_borrowings' => $member->activeBorrowings()->count(),
                'total_fine' => $member->getTotalFine()
            ];
        }));
    }

    /**
     * Get action buttons for DataTables
     */
    private function getActionButtons(Borrowing $borrowing): string
    {
        $buttons = '<div class="btn-group" role="group">';

        // View button
        $buttons .= '<a href="' . route('admin.borrowing.show', $borrowing) . '"
                       class="btn btn-sm btn-info" title="Detail">
                       <i class="fas fa-eye"></i>
                     </a>';

        if ($borrowing->status === 'pending') {
            // Approve button
            $buttons .= '<button type="button"
                           class="btn btn-sm btn-success approve-btn"
                           data-id="' . $borrowing->id . '"
                           title="Setujui">
                           <i class="fas fa-check"></i>
                         </button>';

            // Reject button
            $buttons .= '<button type="button"
                           class="btn btn-sm btn-danger reject-btn"
                           data-id="' . $borrowing->id . '"
                           title="Tolak">
                           <i class="fas fa-times"></i>
                         </button>';
        } elseif ($borrowing->status === 'approved') {
            // Return button
            $buttons .= '<button type="button"
                           class="btn btn-sm btn-primary return-btn"
                           data-id="' . $borrowing->id . '"
                           title="Kembalikan">
                           <i class="fas fa-undo"></i>
                         </button>';
        }

        $buttons .= '</div>';

        return $buttons;
    }

    /**
     * Get borrowing statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total' => Borrowing::count(),
            'pending' => Borrowing::where('status', 'pending')->count(),
            'approved' => Borrowing::where('status', 'approved')->count(),
            'returned' => Borrowing::where('status', 'returned')->count(),
            'overdue' => Borrowing::where('status', 'overdue')
                ->orWhere(function ($q) {
                    $q->where('status', 'approved')
                        ->where('due_date', '<', now()->toDateString());
                })->count(),
            'rejected' => Borrowing::where('status', 'rejected')->count(),
        ];

        return response()->json($stats);
    }
}
