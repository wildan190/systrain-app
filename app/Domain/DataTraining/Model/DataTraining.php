<?php

namespace App\Domain\DataTraining\Model;

use App\Domain\DetailPeserta\Model\DetailPeserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTraining extends Model
{
    use HasFactory;

    protected $table = 'data_training';

    protected $fillable = [
        'detail_peserta_id',
        'upload_pas_foto_biru',
        'upload_ktp',
        'upload_npwp',
        'upload_cv',
        'upload_sk_kerja',
        'upload_keterangan_sehat',
        'upload_pakta_integritas',
        'upload_ijazah',
        'upload_sertifikat_k3',
    ];

    protected $casts = [
        'detail_peserta_id' => 'integer',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function detailPeserta()
    {
        return $this->belongsTo(DetailPeserta::class)->withDefault();
    }
}
