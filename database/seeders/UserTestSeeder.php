<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Instansi;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Test Account
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@smkn2jambi.sch.id',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'gender' => 'L'
        ]);

        // Guru Test Account
        $guru = User::create([
            'name' => 'Drs. Ahmad Hidayat, M.Pd',
            'username' => 'guru1',
            'email' => 'guru1@smkn2jambi.sch.id',
            'password' => bcrypt('guru123'),
            'role' => 'guru',
            'nip' => '196501011988031001',
            'phone' => '081234567891',
            'gender' => 'L'
        ]);

        // Get or create test instansi
        $instansi = Instansi::firstOrCreate(
            ['nama' => 'PT. Teknologi Maju'],
            [
                'alamat' => 'Jl. Ahmad Yani No. 123, Jambi',
                'telepon' => '0741-123456'
            ]
        );

        // Siswa Test Account
        User::create([
            'name' => 'Ahmad Rizki Pratama',
            'username' => 'siswa1',
            'email' => 'siswa1@smkn2jambi.sch.id',
            'password' => bcrypt('siswa123'),
            'role' => 'siswa',
            'nisn' => '3121001001',
            'guru_id' => $guru->id,
            'instansi_id' => $instansi->id,
            'phone' => '081234567892',
            'gender' => 'L'
        ]);

        echo "✅ User test accounts created:\n";
        echo "Admin: username=admin, password=admin123\n";
        echo "Guru: username=guru1, nip=196501011988031001, password=guru123\n";
        echo "Siswa: username=siswa1, nisn=3121001001, password=siswa123\n";
    }
}
