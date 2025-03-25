<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_program',
        'batch',
        'peserta',
        'tanggal_mulai',
        'tanggal_selesai',
        'harga',
    ];
}
