<?php

namespace App\Domain\DataSKP\Presentation\Interface;

interface DataSKPRepositoryInterface
{
    public function createOrUpdate($detailPesertaId, array $data, $request);

    public function delete($id);

    public function findByDetailPesertaId($detailPesertaId);
}
