<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 't003_nilai';

    protected $fillable = ['mahasiswa_id', 'matakuliah_id', 'nilai_angka', 'nilai_huruf'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }

    protected $casts = [
        'nilai_angka' => 'integer',
    ];
}
