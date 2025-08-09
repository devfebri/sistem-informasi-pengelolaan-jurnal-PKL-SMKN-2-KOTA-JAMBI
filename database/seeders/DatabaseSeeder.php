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
            'nip' => '196801011994030001',
            'phone' => '081234567890',
            'gender' => 'L',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Budi Setiawan',
            'email' => 'budi.guru@gmail.com',
            'username' => 'budi_guru',
            'nip' => '197205152006041002',
            'phone' => '085678901234',
            'gender' => 'L',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Siswa',
            'username' => 'siswa',
            'email' => 'siswa@siswa.com',
            'phone' => '082345678901',
            'gender' => 'P',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        // Tambahan data siswa untuk testing guru pembimbing
        \App\Models\User::factory()->create([
            'name' => 'Siti Aisyah',
            'username' => 'siti_aisyah',
            'nisn' => '0012345678',
            'email' => 'siti.aisyah@gmail.com',
            'phone' => '081111111111',
            'gender' => 'P',
            'guru_id' => 2, // ID guru pertama
            'instansi_id' => 1, // Akan dibuat setelah instansi seeder
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Ahmad Rizky',
            'username' => 'ahmad_rizky',
            'nisn' => '0012345679',
            'email' => 'ahmad.rizky@gmail.com',
            'phone' => '082222222222',
            'gender' => 'L',
            'guru_id' => 2, // ID guru pertama
            'instansi_id' => 2, // Akan dibuat setelah instansi seeder
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Dinda Putri',
            'username' => 'dinda_putri',
            'nisn' => '0012345680',
            'email' => 'dinda.putri@gmail.com',
            'phone' => '083333333333',
            'gender' => 'P',
            'guru_id' => 3, // ID guru kedua
            'instansi_id' => 1, // Akan dibuat setelah instansi seeder
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        // Tambahan data instansi untuk testing
        \App\Models\Instansi::create([
            'nama' => 'PT. Teknologi Indonesia',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta',
            'telepon' => '021-12345678',
        ]);

        \App\Models\Instansi::create([
            'nama' => 'CV. Digital Solutions',
            'alamat' => 'Jl. Gatot Subroto No. 456, Jambi',
            'telepon' => '0741-987654',
        ]);

        // Jalankan JurnalSeeder untuk data sample
        $this->call([
            JurnalSeeder::class,
        ]);
    }
}
