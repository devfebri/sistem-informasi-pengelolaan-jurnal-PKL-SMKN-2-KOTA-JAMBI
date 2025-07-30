<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Guru',
            'email' => 'guru@guru.com',
            'username' => 'guru',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Siswa',
            'username' => 'siswa',
            'email' => 'siswa@siswa.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);
    }
}
