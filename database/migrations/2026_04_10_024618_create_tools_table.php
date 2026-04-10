<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();

            // relasi ke categories
            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('cascade');

            $table->string('name');
            $table->enum('item_type', ['single', 'bundle'])->default('single');
            $table->integer('max_penalty_points')->default(100);
            $table->text('description')->nullable();

            // optional dulu (boleh dipakai nanti)
            $table->string('code_slug')->nullable();
            $table->string('photo_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
