<?php

namespace App\Domain\Category\Presentation;

use App\Domain\Category\Action\CreateCategory;
use App\Domain\Category\Action\DestroyCategory;
use App\Domain\Category\Action\GetCategory;
use App\Domain\Category\Action\UpdateCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $getCategory;

    protected $createCategory;

    protected $updateCategory;

    protected $destroyCategory;

    public function __construct(
        GetCategory $getCategory,
        CreateCategory $createCategory,
        UpdateCategory $updateCategory,
        DestroyCategory $destroyCategory
    ) {
        $this->getCategory = $getCategory;
        $this->createCategory = $createCategory;
        $this->updateCategory = $updateCategory;
        $this->destroyCategory = $destroyCategory;
    }

    public function index()
    {
        $categories = $this->getCategory->execute();

        return view('pages.admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $this->createCategory->execute($request->all());

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->getCategory->execute()->find($id);

        return view('pages.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $this->updateCategory->execute($id, $request->all());

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->destroyCategory->execute($id);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
