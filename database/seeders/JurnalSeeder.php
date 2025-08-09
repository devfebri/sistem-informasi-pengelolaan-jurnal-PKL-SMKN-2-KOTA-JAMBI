<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurnal;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Penilaian;
use Carbon\Carbon;

class JurnalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa instansi sample jika belum ada
        $instansi1 = Instansi::firstOrCreate(['nama' => 'PT. Teknologi Maju'], [
            'alamat' => 'Jl. Ahmad Yani No. 123, Jambi',
            'telepon' => '0741-123456'
        ]);

        $instansi2 = Instansi::firstOrCreate(['nama' => 'CV. Digital Solution'], [
            'alamat' => 'Jl. Sudirman No. 456, Jambi',
            'telepon' => '0741-789012'
        ]);

        $instansi3 = Instansi::firstOrCreate(['nama' => 'Dinas Komunikasi dan Informatika'], [
            'alamat' => 'Jl. Gatot Subroto No. 789, Jambi',
            'telepon' => '0741-345678'
        ]);

        // Buat guru sample jika belum ada
        $guru1 = User::firstOrCreate(['email' => 'guru1@smkn2jambi.sch.id'], [
            'name' => 'Drs. Ahmad Hidayat, M.Pd',
            'username' => 'guru1',
            'password' => bcrypt('password'),
            'role' => 'guru',
            'nip' => '196501011988031001',
            'phone' => '081234567890',
            'gender' => 'L'
        ]);

        $guru2 = User::firstOrCreate(['email' => 'guru2@smkn2jambi.sch.id'], [
            'name' => 'Sri Wahyuni, S.Kom, M.T',
            'username' => 'guru2',
            'password' => bcrypt('password'),
            'role' => 'guru',
            'nip' => '197203151998032001',
            'phone' => '081234567891',
            'gender' => 'P'
        ]);

        // Buat siswa sample jika belum ada
        $siswaSample = [
            ['name' => 'Ahmad Rizki Pratama', 'nisn' => '3121001001', 'gender' => 'L', 'guru_id' => $guru1->id, 'instansi_id' => $instansi1->id],
            ['name' => 'Siti Nurhaliza', 'nisn' => '3121001002', 'gender' => 'P', 'guru_id' => $guru1->id, 'instansi_id' => $instansi2->id],
            ['name' => 'Muhammad Fadil', 'nisn' => '3121001003', 'gender' => 'L', 'guru_id' => $guru2->id, 'instansi_id' => $instansi1->id],
            ['name' => 'Dewi Kartika Sari', 'nisn' => '3121001004', 'gender' => 'P', 'guru_id' => $guru2->id, 'instansi_id' => $instansi3->id],
            ['name' => 'Reza Firmansyah', 'nisn' => '3121001005', 'gender' => 'L', 'guru_id' => $guru1->id, 'instansi_id' => $instansi2->id],
        ];

        $siswaList = [];
        foreach ($siswaSample as $index => $siswaData) {
            $siswa = User::firstOrCreate(['nisn' => $siswaData['nisn']], [
                'name' => $siswaData['name'],
                'username' => 'siswa' . ($index + 1),
                'email' => strtolower(str_replace(' ', '', $siswaData['name'])) . '@smkn2jambi.sch.id',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'guru_id' => $siswaData['guru_id'],
                'instansi_id' => $siswaData['instansi_id'],
                'nisn' => $siswaData['nisn'],
                'phone' => '0812345678' . rand(10, 99),
                'gender' => $siswaData['gender']
            ]);
            $siswaList[] = $siswa;
        }

        // Data kegiatan PKL yang realistis
        $kegiatanList = [
            ['kegiatan' => 'Mempelajari struktur database aplikasi', 'deskripsi' => 'Memahami ERD dan relasi antar tabel dalam sistem informasi perusahaan'],
            ['kegiatan' => 'Membuat dokumentasi sistem', 'deskripsi' => 'Membuat dokumentasi teknis untuk aplikasi web yang sedang dikembangkan'],
            ['kegiatan' => 'Testing aplikasi web', 'deskripsi' => 'Melakukan pengujian fitur-fitur aplikasi untuk menemukan bug dan error'],
            ['kegiatan' => 'Backup data server', 'deskripsi' => 'Melakukan backup rutin data server menggunakan tools backup otomatis'],
            ['kegiatan' => 'Maintenance hardware komputer', 'deskripsi' => 'Membersihkan dan mengecek kondisi hardware komputer kantor'],
            ['kegiatan' => 'Instalasi software aplikasi', 'deskripsi' => 'Menginstal dan konfigurasi software yang dibutuhkan untuk operasional'],
            ['kegiatan' => 'Membuat laporan progress project', 'deskripsi' => 'Menyusun laporan kemajuan proyek IT yang sedang berjalan'],
            ['kegiatan' => 'Troubleshooting jaringan', 'deskripsi' => 'Mengatasi masalah koneksi jaringan dan internet di kantor'],
            ['kegiatan' => 'Input data ke sistem', 'deskripsi' => 'Memasukkan data master dan transaksi ke dalam sistem informasi'],
            ['kegiatan' => 'Meeting dengan tim developer', 'deskripsi' => 'Mengikuti rapat koordinasi tim pengembangan aplikasi'],
            ['kegiatan' => 'Coding program aplikasi', 'deskripsi' => 'Membuat program sesuai dengan requirement yang telah ditentukan'],
            ['kegiatan' => 'Desain UI/UX aplikasi', 'deskripsi' => 'Merancang tampilan dan user experience aplikasi mobile'],
            ['kegiatan' => 'Konfigurasi server web', 'deskripsi' => 'Setting konfigurasi web server Apache dan database MySQL'],
            ['kegiatan' => 'Monitoring sistem server', 'deskripsi' => 'Memantau performa dan status server menggunakan monitoring tools'],
            ['kegiatan' => 'Training penggunaan aplikasi', 'deskripsi' => 'Memberikan pelatihan kepada user tentang cara menggunakan aplikasi baru'],
            ['kegiatan' => 'Analisis kebutuhan sistem', 'deskripsi' => 'Menganalisis kebutuhan bisnis untuk pengembangan sistem informasi'],
            ['kegiatan' => 'Pemeliharaan website', 'deskripsi' => 'Melakukan update konten dan maintenance website perusahaan'],
            ['kegiatan' => 'Security audit sistem', 'deskripsi' => 'Melakukan audit keamanan sistem dan aplikasi yang digunakan'],
            ['kegiatan' => 'Optimasi database', 'deskripsi' => 'Melakukan optimasi query dan struktur database untuk performa yang lebih baik'],
            ['kegiatan' => 'Deploy aplikasi ke server', 'deskripsi' => 'Melakukan deployment aplikasi dari development ke production server']
        ];

        // Buat 20 jurnal sample
        for ($i = 0; $i < 20; $i++) {
            $siswa = $siswaList[array_rand($siswaList)];
            $kegiatan = $kegiatanList[array_rand($kegiatanList)];
            
            // Random tanggal dalam 2 bulan terakhir
            $tanggal = Carbon::now()->subDays(rand(1, 60))->format('Y-m-d');
            
            // Random jam kerja
            $jamMulai = rand(7, 9) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
            $jamSelesai = rand(15, 17) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);

            $jurnal = Jurnal::create([
                'user_id' => $siswa->id,
                'tanggal' => $tanggal,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'kegiatan' => $kegiatan['kegiatan'],
                'deskripsi' => $kegiatan['deskripsi'],
            ]);

            // Random validasi (70% sudah divalidasi, 30% belum)
            if (rand(1, 10) <= 7) {
                $statusValidasi = ['valid', 'revisi', 'tidak_valid'][rand(0, 2)];
                $catatanValidasi = [
                    'valid' => 'Kegiatan sudah sesuai dengan program PKL',
                    'revisi' => 'Mohon diperjelas deskripsi kegiatannya',
                    'tidak_valid' => 'Kegiatan tidak sesuai dengan kompetensi yang diharapkan'
                ];

                Penilaian::create([
                    'jurnal_id' => $jurnal->id,
                    'guru_id' => $siswa->guru_id,
                    'status_validasi' => $statusValidasi,
                    'catatan_validasi' => $catatanValidasi[$statusValidasi],
                ]);
            }
        }

        // Buat sample penilaian berkala untuk siswa
        $siswaList = User::where('role', 'siswa')->get();
        foreach($siswaList as $siswa) {
            if($siswa->guru_id) {
                // Penilaian Triwulan 1
                Penilaian::create([
                    'jurnal_id' => null,
                    'guru_id' => $siswa->guru_id,
                    'siswa_id' => $siswa->id,
                    'nilai' => rand(70, 95),
                    'periode_penilaian' => 'triwulan',
                    'tanggal_penilaian' => Carbon::now()->subMonths(3)->format('Y-m-d'),
                    'catatan_nilai' => 'Penilaian triwulan pertama. Siswa menunjukkan kemajuan yang baik dalam menjalankan tugas PKL.',
                ]);

                // Penilaian Triwulan 2
                Penilaian::create([
                    'jurnal_id' => null,
                    'guru_id' => $siswa->guru_id,
                    'siswa_id' => $siswa->id,
                    'nilai' => rand(75, 98),
                    'periode_penilaian' => 'triwulan',
                    'tanggal_penilaian' => Carbon::now()->subMonths(1)->format('Y-m-d'),
                    'catatan_nilai' => 'Penilaian triwulan kedua. Terjadi peningkatan dalam kualitas kerja dan kedisiplinan.',
                ]);

                // Penilaian Semester (jika sudah waktunya)
                if(rand(0, 1)) {
                    Penilaian::create([
                        'jurnal_id' => null,
                        'guru_id' => $siswa->guru_id,
                        'siswa_id' => $siswa->id,
                        'nilai' => rand(80, 100),
                        'periode_penilaian' => 'semester',
                        'tanggal_penilaian' => Carbon::now()->format('Y-m-d'),
                        'catatan_nilai' => 'Penilaian semester. Siswa telah menunjukkan kinerja yang sangat baik dan memahami tugas-tugas PKL dengan baik.',
                    ]);
                }
            }
        }
    }
}
