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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id'); // FK ke tabel loans
            $table->unsignedBigInteger('employee_id'); // FK ke tabel users (sebagai employee)
            $table->string('condition_id', 255)->nullable();
            $table->date('return_date');
            $table->integer('late_days')->default(0); // Ubah jadi integer lebih masuk akal
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade'); // Pakai users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
