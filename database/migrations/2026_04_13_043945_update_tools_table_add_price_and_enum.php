<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tambah kolom price
        Schema::table('tools', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('name');
        });

        // 2. Update ENUM item_type
        DB::statement("
            ALTER TABLE tools 
            MODIFY item_type ENUM('single', 'bundle', 'bundle_tools') NOT NULL
        ");
    }

    public function down(): void
    {
        // rollback enum (balikin ke semula, HAPUS bundle_tools)
        DB::statement("
            ALTER TABLE tools 
            MODIFY item_type ENUM('single', 'bundle') NOT NULL
        ");

        // hapus kolom price
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
