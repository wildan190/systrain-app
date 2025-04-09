<?php

namespace App\Domain\Program\Model;

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

    public function detailPrograms()
    {
        return $this->hasMany(DetailProgram::class, 'program_id');
    }
}
