<?php

namespace App\Domain\DataTraining\Action;

use App\Domain\DataTraining\Infrastructure\DataTrainingRepository;
use Illuminate\Http\Request;

class CreateOrUpdate
{
    protected DataTrainingRepository $repository;

    public function __construct(DataTrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(Request $request, $detailPesertaId)
    {
        $data = $request->except(['_token', '_method']);

        // Perbaiki pemanggilan dengan menambahkan $request
        return $this->repository->createOrUpdate($detailPesertaId, $data, $request);
    }
}
