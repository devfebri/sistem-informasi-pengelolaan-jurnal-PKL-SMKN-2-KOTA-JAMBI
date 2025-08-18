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
        Schema::table('jurnals', function (Blueprint $table) {
            // Hapus kolom file_jurnal
 
            
            // Tambah kolom deskripsi
            $table->text('deskripsi')->nullable()->after('kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurnals', function (Blueprint $table) {
            // Kembalikan kolom file_jurnal

            
            // Hapus kolom deskripsi
            $table->dropColumn('deskripsi');
        });
    }
};
