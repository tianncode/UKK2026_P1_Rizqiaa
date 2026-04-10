<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('unit_code', 255);
            $table->foreignId('return_id')->nullable();
            $table->enum('conditions', ['good', 'minor', 'damaged', 'lost'])->default('good');
            $table->text('notes')->nullable();
            $table->timestamp('recorded_at')->useCurrent();

            $table->foreign('unit_code')->references('code')->on('tool_units')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_conditions');
    }
};
