<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // Tambah kolom untuk sistem validasi
            $table->enum('status_validasi', ['valid', 'tidak_valid', 'revisi'])->nullable()->after('guru_id');
            $table->text('catatan_validasi')->nullable()->after('status_validasi');
            
            // Nilai tetap ada tapi nullable (untuk penilaian berkala)
            $table->integer('nilai')->nullable()->change();
            
            // Rename catatan ke catatan_nilai untuk pembedaan
            $table->renameColumn('catatan', 'catatan_nilai');
            
            // Tambah kolom untuk periode penilaian
            $table->enum('periode_penilaian', ['bulanan', 'triwulan', 'semester'])->nullable()->after('catatan_nilai');
            $table->date('tanggal_penilaian')->nullable()->after('periode_penilaian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropColumn(['status_validasi', 'catatan_validasi', 'periode_penilaian', 'tanggal_penilaian']);
            $table->renameColumn('catatan_nilai', 'catatan');
            $table->integer('nilai')->nullable(false)->change();
        });
    }
};
