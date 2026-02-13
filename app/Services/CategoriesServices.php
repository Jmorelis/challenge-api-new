<?php

namespace App\Services;

use App\Models\Categories;
use App\Repositories\Interfaces\CategoriesRepositoryInterface;
use Illuminate\Support\Str;
use Exception;

class CategoriesServices
{
    protected $repository;

    public function __construct(CategoriesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createCategories(array $data)
    {
        $user = auth('api')->user();

        if (!$user || $user->status !== 'active') {
            throw new Exception("Solo los usuarios activos pueden crear artículos.", 403);
        }

        $data['user_id'] = $user->id;
   
        $categories = $this->repository->create($data);


        return $categories;
    }

    public function updateCategories(Categories $categories, array $data)
    {
        $user = auth('api')->user();
        if (!$user || $user->status !== 'active') {
            throw new Exception("Usuario no autorizado o inactivo.", 403);
        }

        $this->repository->update($categories, $data);

        

        return $categories;
    }
}