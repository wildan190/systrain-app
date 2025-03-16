<?php

namespace App\Domain\DetailPerusahaan\Action;

use App\Domain\DetailPerusahaan\Infrastructure\DetailPerusahaanRepository;
use Illuminate\Http\Request;

class CreateOrUpdate
{
    protected DetailPerusahaanRepository $repository;

    public function __construct(DetailPerusahaanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(Request $request, $detailPesertaId)
    {
        $data = $request->only([
            'kode_perusahaan',
            'nama_perusahaan',
            'alamat',
            'telepon',
            'jabatan',
        ]);

        return $this->repository->createOrUpdate($detailPesertaId, $data);
    }
}
