<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // Drop foreign key constraints if they exist
            try {
                $table->dropForeign(['approved_by']);
            } catch (Exception $e) {
                // Foreign key might not exist, ignore error
            }

            try {
                $table->dropForeign(['user_id']);
            } catch (Exception $e) {
                // Foreign key might not exist, ignore error
            }

            try {
                $table->dropForeign(['book_id']);
            } catch (Exception $e) {
                // Foreign key might not exist, ignore error
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // Re-add foreign keys if needed (optional)
            // $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('book_id')->references('id')->on('books');
        });
    }
};
