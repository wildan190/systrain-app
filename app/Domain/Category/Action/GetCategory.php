<?php

namespace App\Domain\Category\Action;

use App\Domain\Category\Infrastructure\CategoryRepository;

class GetCategory
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        return $this->repository->all();
    }
}
