<?php

namespace App\Domain\DetailPerusahaan\Action;

use App\Domain\DetailPerusahaan\Infrastructure\DetailPerusahaanRepository;

class Destroy
{
    protected DetailPerusahaanRepository $repository;

    public function __construct(DetailPerusahaanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        return $this->repository->delete($id);
    }
}
