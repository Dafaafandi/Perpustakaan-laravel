<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    // Status constants for the simplified status system
    const STATUS_APPROVED = 'approved';
    const STATUS_RETURNED = 'returned';
    const STATUS_OVERDUE = 'overdue';

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'borrowed_date',
        'due_date',
        'returned_date',
        'notes',
        'admin_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'borrowed_date' => 'date',
        'due_date' => 'date',
        'returned_date' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user who borrowed the book
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the borrowed book
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the admin who approved the borrowing
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope for approved borrowings
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for overdue borrowings
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
            ->orWhere(function ($q) {
                $q->where('status', 'approved')
                    ->where('due_date', '<', now()->toDateString());
            });
    }

    /**
     * Check if borrowing is overdue
     */
    public function isOverdue(): bool
    {
        if ($this->status !== 'approved' || !$this->due_date) {
            return false;
        }

        return Carbon::parse($this->due_date)->isPast();
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'success',
            'returned' => 'info',
            'overdue' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'Dipinjam',
            'returned' => 'Dikembalikan',
            'overdue' => 'Terlambat',
            default => ucfirst($this->status),
        };
    }
}
