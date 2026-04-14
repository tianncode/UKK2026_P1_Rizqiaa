<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE loans 
            MODIFY status ENUM(
                'pending',
                'approved',
                'returned',
                'rejected',
                'cancelled'
            ) DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE loans 
            MODIFY status ENUM(
                'pending',
                'approved',
                'borrowed',
                'returned',
                'rejected',
                'overdue'
            ) DEFAULT 'pending'
        ");
    }
};
