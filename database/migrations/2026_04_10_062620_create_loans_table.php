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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // User yang meminjam
            $table->unsignedBigInteger('tool_id'); // Tool yang dipinjam
            $table->string('unit_code'); // Unit code yang dipinjam
            $table->string('loan_code')->unique(); // Kode peminjaman
            $table->unsignedBigInteger('employee_id')->nullable(); // Employee yang memproses
            $table->enum('status', ['pending', 'approved', 'borrowed', 'returned', 'rejected', 'overdue'])->default('pending');
            $table->date('loan_date'); // Tanggal peminjaman
            $table->date('due_date'); // Tanggal jatuh tempo
            $table->text('purpose')->nullable(); // Tujuan peminjaman
            $table->text('notes')->nullable(); // Catatan
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tool_id')->references('id')->on('tools')->onDelete('cascade');
            $table->foreign('unit_code')->references('code')->on('tool_units')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
