<?php

namespace App\Domain\Category\Action;

use App\Domain\Category\Infrastructure\CategoryRepository;

class DestroyCategory
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id)
    {
        return $this->repository->delete($id);
    }
}
