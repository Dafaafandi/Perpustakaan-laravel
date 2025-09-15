<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $image
 * @property string $name
 * @property string $email
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's borrowings
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Get the user's active borrowings
     */
    public function activeBorrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class)->where('status', 'approved');
    }

    /**
     * Get the user's overdue borrowings
     */
    public function overdueBorrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class)->overdue();
    }

    /**
     * Check if user can borrow more books
     */
    public function canBorrowMore(): bool
    {
        $maxBooks = config('library.borrowing.max_books_per_user', 3);
        $activeBorrowings = $this->activeBorrowings()->count();

        return $activeBorrowings < $maxBooks;
    }

    /**
     * Check if user has overdue books
     */
    public function hasOverdueBooks(): bool
    {
        return $this->overdueBorrowings()->exists();
    }

    /**
     * Get member borrowing statistics
     */
    public function getBorrowingStatistics(): array
    {
        return [
            'total_borrowed' => $this->borrowings()->count(),
            'active_borrowings' => $this->borrowings()->where('status', 'approved')->count(),
            'overdue_books' => $this->borrowings()->where('status', 'overdue')->count(),
            'returned_books' => $this->borrowings()->where('status', 'returned')->count()
        ];
    }
}
