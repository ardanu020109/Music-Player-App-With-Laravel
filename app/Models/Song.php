<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $table = 'songs'; // Nama tabel di database

    protected $fillable = [
        'judul_lagu',
        'penyanyi',
        'album',
        'musik',
    ];
}
