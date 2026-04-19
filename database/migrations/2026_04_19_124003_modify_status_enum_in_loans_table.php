<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pending', 'approved', 'borrowed', 'returned', 'rejected', 'overdue', 'pending_return') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pending', 'approved', 'borrowed', 'returned', 'rejected', 'overdue') DEFAULT 'pending'");
    }
};
