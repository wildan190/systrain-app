<?php

namespace App\Domain\Category\Action;

use App\Domain\Category\Infrastructure\CategoryRepository;

class CreateCategory
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data)
    {
        return $this->repository->create($data);
    }
}
