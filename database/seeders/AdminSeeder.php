<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $userId = DB::table('users')->insertGetId([
            'email' => 'admin@ukk2026.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'penalty_points' => 0,
            'is_restricted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('user_details')->insert([
            'user_id' => $userId,
            'nik' => '0000000000000000',
            'name' => 'Administrator',
            'no_hp' => '08123456789',
            'address' => 'System',
            'birth_date' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
