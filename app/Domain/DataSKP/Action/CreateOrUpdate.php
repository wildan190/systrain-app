<?php

namespace App\Domain\DataSKP\Action;

use App\Domain\DataSKP\Infrastructure\DataSKPRepository;
use Illuminate\Http\Request;

class CreateOrUpdate
{
    protected DataSKPRepository $repository;

    public function __construct(DataSKPRepository $repository)
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