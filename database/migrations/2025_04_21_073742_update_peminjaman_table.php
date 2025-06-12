<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Add new columns for tracking status and history
            $table->string('status')->default('Dipinjam')->after('purpose');
            $table->date('actual_return_date')->nullable()->after('return_date');
            $table->text('notes')->nullable()->after('status');
            $table->integer('rating')->nullable()->after('notes');
            $table->text('review')->nullable()->after('rating');
            $table->json('extension_history')->nullable()->after('review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'actual_return_date',
                'notes',
                'rating',
                'review',
                'extension_history'
            ]);
        });
    }
};