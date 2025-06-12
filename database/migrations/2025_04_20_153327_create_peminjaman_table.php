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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('book_id');
            $table->string('book_title');
            $table->text('book_authors')->nullable();
            $table->string('book_isbn')->nullable();
            $table->string('fullname');
            $table->string('student_id');
            $table->date('borrow_date');
            $table->date('return_date');
            $table->text('purpose')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
