<?php

namespace App\Domain\DetailPerusahaan\Model;

use App\Domain\DetailPeserta\Model\DetailPeserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPerusahaan extends Model
{
    use HasFactory;

    protected $table = 'detail_perusahaan';

    protected $fillable = [
        'detail_peserta_id',
        'kode_perusahaan',
        'nama_perusahaan',
        'alamat',
        'telepon',
        'jabatan',
    ];

    protected $casts = [
        'detail_peserta_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function detailPeserta()
    {
        return $this->belongsTo(DetailPeserta::class)->withDefault();
    }
}
