<?php

namespace App\Domain\DataSKP\Model;

use App\Domain\DetailPeserta\Model\DetailPeserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSKP extends Model
{
    use HasFactory;

    protected $table = 'data_s_k_p';

    protected $fillable = [
        'detail_peserta_id',
        'upload_surat_permohonan',
        'upload_sertifikat_pembinaan',
        'upload_sk_kerja',
        'upload_surat_pernyataan_kerja',
        'upload_rekapitulasi',
        'upload_pas_foto',
        'upload_ijazah_terakhir',
        'upload_paklaring',
        'upload_surat_pengantar',
        'upload_pernyataan_personel',
        'upload_ktp',
        'upload_keahlian_teknis',
        'upload_cv',
        'upload_laporan_kegiatan',
        'upload_sk_pensiun',
    ];

    public function detailPeserta()
    {
        return $this->belongsTo(DetailPeserta::class);
    }
}
