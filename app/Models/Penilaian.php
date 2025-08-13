<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'jurnal_id',
        'guru_id',
        'siswa_id',
        'status_validasi',
        'catatan_validasi',
        'nilai',
        'catatan_nilai',
        'periode_penilaian',
        'tanggal_penilaian'
    ];

    protected $casts = [
        'tanggal_penilaian' => 'date',
        'nilai' => 'decimal:2'
    ];

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
