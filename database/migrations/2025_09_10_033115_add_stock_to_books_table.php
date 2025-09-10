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
        Schema::table('books', function (Blueprint $table) {
            $table->integer('stock')->default(1)->after('publication_year');
            $table->integer('available_stock')->default(1)->after('stock');
            $table->enum('status', ['available', 'unavailable', 'special'])->default('available')->after('available_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['stock', 'available_stock', 'status']);
        });
    }
};
