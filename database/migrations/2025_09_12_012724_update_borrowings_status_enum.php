<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing statuses to match new enum
        DB::statement("UPDATE borrowings SET status = 'approved' WHERE status IN ('pending', 'return_requested')");
        DB::statement("UPDATE borrowings SET status = 'returned' WHERE status = 'rejected'");

        // Then modify the enum to only allow approved, returned, overdue
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('approved', 'returned', 'overdue') NOT NULL DEFAULT 'approved'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore original enum values
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('pending', 'approved', 'returned', 'rejected', 'overdue', 'return_requested') NOT NULL DEFAULT 'pending'");
    }
};
