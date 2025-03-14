<?php

namespace App\Domain\DetailPeserta\Model;

use App\Domain\Category\Model\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
        'nomor_induk_kependudukan',
        'jenis_kelamin',
        'golongan_darah',
        'pendidikan_terakhir',
        'nama_sekolah',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'provinsi',
        'kabupaten',
        'ukuran_seragam',
        'category_id',
        'referal',
        'sumber_informasi',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
