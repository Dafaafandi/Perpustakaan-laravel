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
        // First, convert any books with 'special' status to 'available'
        DB::statement("UPDATE books SET status = 'available' WHERE status = 'special'");

        // Then update the enum to remove 'special' option
        DB::statement("ALTER TABLE books MODIFY COLUMN status ENUM('available', 'unavailable') NOT NULL DEFAULT 'available'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the enum with 'special' option
        DB::statement("ALTER TABLE books MODIFY COLUMN status ENUM('available', 'unavailable', 'special') NOT NULL DEFAULT 'available'");
    }
};
