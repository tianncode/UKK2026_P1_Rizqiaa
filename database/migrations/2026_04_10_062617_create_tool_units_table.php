<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tool_units', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // HARUS UNIQUE untuk jadi foreign key
            $table->unsignedBigInteger('tool_id')->nullable();
            $table->enum('status', ['available', 'borrowed', 'maintenance', 'damaged'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('tool_id')->references('id')->on('tools')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tool_units');
    }
};
