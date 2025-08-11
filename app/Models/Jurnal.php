<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\Attributes\Policy;

#[Policy(\App\Policies\JurnalPolicy::class)]
class Jurnal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'kegiatan',
        'deskripsi',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penilaian()
    {
        return $this->hasMany(\App\Models\Penilaian::class, 'jurnal_id');
    }
}
