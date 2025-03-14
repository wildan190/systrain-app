<?php

namespace App\Domain\Category\Infrastructure;

use App\Domain\Category\Model\Category;
use App\Domain\Category\Presentation\Interface\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(int $id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);

        return $category;
    }

    public function delete(int $id)
    {
        $category = Category::findOrFail($id);

        return $category->delete();
    }
}
