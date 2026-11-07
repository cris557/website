<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 't003_mahasiswa';

    protected $fillable = ['user_id', 'nim', 'nama', 'jurusan', 'angkatan'];

    protected $casts = [
        'angkatan' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'mahasiswa_id');
    }
}
