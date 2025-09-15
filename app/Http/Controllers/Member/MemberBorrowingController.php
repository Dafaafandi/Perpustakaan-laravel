<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class MemberBorrowingController extends Controller
{
    /**
     * Display user's borrowing history
     */
    public function index(Request $request)
    {
        $query = auth()->user()->borrowings()->with('book.category');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('member.borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new borrowing
     */
    public function create(Book $book)
    {

        $existingBorrowing = auth()->user()
            ->borrowings()
            ->where('book_id', $book->id)
            ->whereIn('status', ['approved', 'overdue'])
            ->first();

        if ($existingBorrowing) {
            return redirect()->back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        return view('member.borrowings.create', compact('book'));
    }

    /**
     * Store a newly created borrowing
     */
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $existingBorrowing = auth()->user()
            ->borrowings()
            ->where('book_id', $book->id)
            ->whereIn('status', ['approved', 'overdue'])
            ->first();

        if ($existingBorrowing) {
            return redirect()->back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        $borrowingPeriod = config('library.borrowing.default_period_days', 14);

        $borrowing = Borrowing::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'status' => 'approved',
            'borrowed_date' => now(),
            'due_date' => now()->addDays($borrowingPeriod),
            'approved_by' => null,
            'approved_at' => now(),
            'notes' => $request->notes,
        ]);

        return redirect()->route('member.borrowings.index')
            ->with('success', 'Peminjaman buku berhasil! Buku langsung dapat Anda gunakan selama ' . $borrowingPeriod . ' hari.');
    }

    /**
     * Display the specified borrowing
     */
    public function show(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== auth()->id()) {
            abort(403);
        }

        $borrowing->load('book.category');

        return view('member.borrowings.show', compact('borrowing'));
    }

    /**
     * Request return of borrowed book
     */
    public function requestReturn(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($borrowing->status, ['approved', 'overdue'])) {
            return redirect()->back()->with('error', 'Buku ini tidak dalam status dipinjam.');
        }

        $borrowing->update([
            'status' => 'returned',
            'returned_date' => now(),
        ]);

        return redirect()->route('member.borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
