<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE unit_conditions 
            MODIFY conditions 
            ENUM('good', 'broken', 'maintenance', 'lost') 
            DEFAULT 'good'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE unit_conditions 
            MODIFY conditions 
            ENUM('good', 'broken', 'maintenance') 
            DEFAULT 'good'
        ");
    }
};
