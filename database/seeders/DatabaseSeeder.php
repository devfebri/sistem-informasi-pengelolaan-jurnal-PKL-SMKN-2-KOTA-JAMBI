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

        // Tambahan user role pimpinan
        \App\Models\User::factory()->create([
            'name' => 'Pimpinan Sekolah',
            'username' => 'pimpinan',
            'email' => 'pimpinan@smkn2jambi.sch.id',
            'password' => bcrypt('password'),
            'role' => 'pimpinan',
        ]);


    }
}
