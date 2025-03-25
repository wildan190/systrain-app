<?php

namespace App\Domain\Program\Model;

use App\Domain\DetailPeserta\Model\DetailPeserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'nomor_peserta',
        'detail_peserta_id',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function detailPeserta()
    {
        return $this->belongsTo(DetailPeserta::class);
    }
}
