<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Nama tabel khusus dengan prefix t003_
    protected $table = 't003_users';

    // Kolom-kolom yang wajib diizinkan untuk diisi
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'role_id',
        'foto_profil',
        'is_active',
    ];

    // Menyembunyikan password agar aman saat data diambil
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Relasi ke Model Role (t003_roles)
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }
}
