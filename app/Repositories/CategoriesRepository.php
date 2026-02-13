<?php

namespace App\Repositories;

use App\Models\Categories;
use App\Repositories\Interfaces\CategoriesRepositoryInterface;

class CategoriesRepository implements CategoriesRepositoryInterface
{
    public function all()
    {
        return Categories::with(['user', 'categories'])->get();
    }

    public function find($id)
    {
        return Categories::with(['user', 'categories'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Categories::create($data);
    }

    public function update(Categories $categoria, array $data)
    {
        $categoria->update($data);
        return $categoria;
    }

    public function delete(Categories $categoria)
    {
        return $categoria->delete();
    }

}