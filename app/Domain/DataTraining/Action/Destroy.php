<?php

namespace App\Domain\DataTraining\Action;

use App\Domain\DataTraining\Infrastructure\DataTrainingRepository;

class Destroy
{
    protected DataTrainingRepository $repository;

    public function __construct(DataTrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        return $this->repository->delete($id);
    }
}
