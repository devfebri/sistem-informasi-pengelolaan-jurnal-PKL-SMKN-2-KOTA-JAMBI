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
            // Make jurnal_id nullable for penilaian berkala
            $table->unsignedBigInteger('jurnal_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // Revert jurnal_id to not nullable
            $table->unsignedBigInteger('jurnal_id')->nullable(false)->change();
        });
    }
};
