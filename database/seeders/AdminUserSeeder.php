<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Menggunakan DB::table agar pasti tersimpan tanpa terhalang fillable
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@hafalquran.com'], // Kondisi pencarian
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'), // Password di-hash
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
