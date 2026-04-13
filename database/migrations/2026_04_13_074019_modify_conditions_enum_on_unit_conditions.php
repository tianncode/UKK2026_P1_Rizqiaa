<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tambah enum baru dulu
        DB::statement("
            ALTER TABLE unit_conditions 
            MODIFY conditions 
            ENUM('good', 'minor', 'damaged', 'lost', 'broken', 'maintenance') 
            DEFAULT 'good'
        ");

        // 2. Mapping data
        DB::statement("
            UPDATE unit_conditions 
            SET conditions = 'maintenance' 
            WHERE conditions = 'minor'
        ");

        DB::statement("
            UPDATE unit_conditions 
            SET conditions = 'broken' 
            WHERE conditions IN ('damaged', 'lost')
        ");

        // 3. Hapus enum lama
        DB::statement("
            ALTER TABLE unit_conditions 
            MODIFY conditions 
            ENUM('good', 'broken', 'maintenance') 
            DEFAULT 'good'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE unit_conditions 
            MODIFY conditions 
            ENUM('good', 'minor', 'damaged', 'lost') 
            DEFAULT 'good'
        ");
    }
};