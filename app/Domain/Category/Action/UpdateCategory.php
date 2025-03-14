<?php

namespace App\Domain\Category\Action;

use App\Domain\Category\Infrastructure\CategoryRepository;

class UpdateCategory
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }
}
