<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some members and books
        $members = User::role('member')->take(5)->get();
        $books = Book::take(10)->get();
        $admin = User::role('admin')->first();

        if ($members->isEmpty() || $books->isEmpty() || !$admin) {
            $this->command->info('Please make sure you have members, books, and admin users before running this seeder.');
            return;
        }

        // Create various borrowing scenarios
        $borrowings = [
            // Pending borrowings
            [
                'user_id' => $members->random()->id,
                'book_id' => $books->random()->id,
                'status' => 'pending',
                'notes' => 'Ingin meminjam buku untuk tugas kuliah',
                'created_at' => now()->subDays(1),
            ],
            [
                'user_id' => $members->random()->id,
                'book_id' => $books->random()->id,
                'status' => 'pending',
                'notes' => 'Butuh untuk referensi skripsi',
                'created_at' => now()->subDays(2),
            ],

            // Approved borrowings (active)
            [
                'user_id' => $members->random()->id,
                'book_id' => $books->random()->id,
                'status' => 'approved',
                'borrowed_date' => now()->subDays(5),
                'due_date' => now()->addDays(9),
                'approved_by' => $admin->id,
                'approved_at' => now()->subDays(5),
                'admin_notes' => 'Disetujui untuk peminjaman reguler',
                'created_at' => now()->subDays(6),
            ],
            [
                'user_id' => $members->random()->id,
                'book_id' => $books->random()->id,
                'status' => 'approved',
                'borrowed_date' => now()->subDays(10),
                'due_date' => now()->addDays(4),
                'approved_by' => $admin->id,
                'approved_at' => now()->subDays(10),
                'admin_notes' => 'Peminjaman untuk penelitian',
                'created_at' => now()->subDays(11),
            ],

            // Overdue borrowings
            [
                'user_id' => $members->random()->id,
                'book_id' => $books->random()->id,
                'status' => 'approved',
                'borrowed_date' => now()->subDays(20),
                'due_date' => now()->subDays(6), // Already overdue
                'approved_by' => $admin->id,
                'approved_at' => now()->subDays(20),
                'admin_notes' => 'Peminjaman regular',
                'created_at' => now()->subDays(21),
            ],

            // Returned borrowings
            [
                'user_id' => $members->random()->id,
                'book_id' => $books->random()->id,
                'status' => 'returned',
                'borrowed_date' => now()->subDays(30),
                'due_date' => now()->subDays(16),
                'returned_date' => now()->subDays(15),
                'fine_amount' => 0, // Returned on time
                'approved_by' => $admin->id,
                'approved_at' => now()->subDays(30),
                'admin_notes' => 'Dikembalikan dalam kondisi baik',
                'created_at' => now()->subDays(31),
            ],
            [
                'user_id' => $members->random()->id,
                'book_id' => $books->random()->id,
                'status' => 'returned',
                'borrowed_date' => now()->subDays(25),
                'due_date' => now()->subDays(11),
                'returned_date' => now()->subDays(8),
                'fine_amount' => 3000, // Late return
                'approved_by' => $admin->id,
                'approved_at' => now()->subDays(25),
                'admin_notes' => 'Denda keterlambatan 3 hari',
                'created_at' => now()->subDays(26),
            ],

            // Rejected borrowing
            [
                'user_id' => $members->random()->id,
                'book_id' => $books->random()->id,
                'status' => 'rejected',
                'approved_by' => $admin->id,
                'approved_at' => now()->subDays(3),
                'admin_notes' => 'Member memiliki tunggakan denda',
                'notes' => 'Ingin meminjam buku novel',
                'created_at' => now()->subDays(4),
            ],
        ];

        foreach ($borrowings as $borrowing) {
            Borrowing::create($borrowing);
        }

        $this->command->info('Created ' . count($borrowings) . ' borrowing records.');
    }
}
