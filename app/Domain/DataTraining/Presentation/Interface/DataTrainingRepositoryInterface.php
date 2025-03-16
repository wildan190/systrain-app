<?php

namespace App\Domain\DataTraining\Presentation\Interface;

interface DataTrainingRepositoryInterface
{
    public function createOrUpdate($detailPesertaId, array $data, $request);

    public function delete($id);

    public function findByDetailPesertaId($detailPesertaId);
}
