<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'data_mahasiswa';

    protected $fillable = [
        'nim', 'nama', 'foto', 'prodi', 'angkatan'
    ];
}

