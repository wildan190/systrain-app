<?php

namespace App\Domain\DetailPerusahaan\Presentation\Interface;

interface DetailPerusahaanRepositoryInterface
{
    public function createOrUpdate($detailPesertaId, array $data);

    public function delete($id);

    public function findByDetailPesertaId($detailPesertaId);
}
