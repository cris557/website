<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 't003_matakuliah';

    protected $fillable = ['kode_mk', 'nama_mk', 'sks'];

    protected $casts = [
        'sks' => 'integer',
    ];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'matakuliah_id');
    }
}
