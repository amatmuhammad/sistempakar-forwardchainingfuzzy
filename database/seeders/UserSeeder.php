<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Dinas
        DB::table('users')->updateOrInsert([
            'email' => 'admin@dinas.local',
        ],[
            'name' => 'Admin Dinas',
            'email' => 'admin@dinas.local',
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Optional other user
        DB::table('users')->updateOrInsert([
            'email' => 'user@local',
        ],[
            'name' => 'User',
            'email' => 'user@local',
            'role' => 'user',
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
