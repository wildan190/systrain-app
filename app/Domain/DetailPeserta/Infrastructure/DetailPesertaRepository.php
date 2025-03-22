<?php

namespace App\Domain\DetailPeserta\Infrastructure;

use App\Domain\DetailPeserta\Model\DetailPeserta;
use App\Domain\DetailPeserta\Presentation\Interface\DetailPesertaRepositoryInterface;

class DetailPesertaRepository implements DetailPesertaRepositoryInterface
{
    public function getAll($perPage = 9, $search = null)
    {
        $query = DetailPeserta::latest();

        if ($search) {
            $query->where('nama', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('nomor_induk_kependudukan', 'like', "%$search%")
                ->orWhere('nama_perusahaan', 'like', "%$search%")
                ->orWhere('telepon', 'like', "%$search%");
        }

        return $query->paginate($perPage);
    }

    public function findById($id)
    {
        return DetailPeserta::findOrFail($id);
    }

    public function create(array $data)
    {
        return DetailPeserta::create($data);
    }

    public function update($id, array $data)
    {
        $detailPeserta = DetailPeserta::findOrFail($id);
        $detailPeserta->update($data);

        return $detailPeserta;
    }

    public function delete($id)
    {
        return DetailPeserta::destroy($id);
    }
}
