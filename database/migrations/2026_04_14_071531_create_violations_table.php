<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('return_id')->nullable();
            $table->enum('type', ['late_return', 'damage', 'loss', 'other']);
            $table->integer('points');
            $table->integer('days_late')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'settled', 'appealed'])->default('pending');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('return_id')->references('id')->on('returns')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};