<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publication_year',
        'image',
        'stock',
        'available_stock',
        'status',
    ];

    /**
     * Get the category that owns the book
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the borrowings for the book
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Get active borrowings for the book
     */
    public function activeBorrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class)->whereIn('status', ['approved', 'overdue']);
    }

    /**
     * Check if book is available for borrowing
     */
    public function isAvailable(): bool
    {
        return $this->available_stock > 0 && $this->status === 'available';
    }

    /**
     * Reduce available stock
     */
    public function reduceStock(): void
    {
        if ($this->available_stock > 0) {
            $this->decrement('available_stock');
        }
    }

    /**
     * Increase available stock
     */
    public function increaseStock(): void
    {
        if ($this->available_stock < $this->stock) {
            $this->increment('available_stock');
        }
    }

    /**
     * Get stock status
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->available_stock <= 0) {
            return 'Tidak Tersedia';
        } elseif ($this->available_stock <= 2) {
            return 'Stok Terbatas';
        } else {
            return 'Tersedia';
        }
    }
}
