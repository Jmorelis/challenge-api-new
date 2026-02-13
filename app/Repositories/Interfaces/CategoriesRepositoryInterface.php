<?php

namespace App\Repositories\Interfaces;

use App\Models\Categories;

interface CategoriesRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Categories $categories, array $data);
    public function delete(Categories $categories);
}