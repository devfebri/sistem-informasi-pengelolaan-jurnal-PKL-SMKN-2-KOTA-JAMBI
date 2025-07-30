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
        'nilai',
        'catatan'
    ];

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
