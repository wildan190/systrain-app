<?php

namespace App\Domain\DetailPerusahaan\Infrastructure;

use App\Domain\DetailPerusahaan\Model\DetailPerusahaan;
use App\Domain\DetailPerusahaan\Presentation\Interface\DetailPerusahaanRepositoryInterface;

class DetailPerusahaanRepository implements DetailPerusahaanRepositoryInterface
{
    public function createOrUpdate($detailPesertaId, array $data)
    {
        return DetailPerusahaan::updateOrCreate(
            ['detail_peserta_id' => $detailPesertaId],
            $data
        );
    }

    public function delete($id)
    {
        return DetailPerusahaan::where('id', $id)->delete();
    }

    public function findByDetailPesertaId($detailPesertaId)
    {
        return DetailPerusahaan::where('detail_peserta_id', $detailPesertaId)->first();
    }
}
