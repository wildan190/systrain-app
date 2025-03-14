<?php

namespace App\Domain\DataSKP\Action;

use App\Domain\DataSKP\Infrastructure\DataSKPRepository;

class Destroy
{
    protected DataSKPRepository $repository;

    public function __construct(DataSKPRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        return $this->repository->delete($id);
    }
}
