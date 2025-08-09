<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'nisn',
        'nip',
        'email',
        'phone',
        'gender',
        'role',
        'instansi_id',
        'guru_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function instansi()
    {
        return $this->belongsTo(\App\Models\Instansi::class, 'instansi_id');
    }

    public function guru()
    {
        return $this->belongsTo(\App\Models\User::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->hasMany(\App\Models\User::class, 'guru_id')->where('role', 'siswa');
    }
}
