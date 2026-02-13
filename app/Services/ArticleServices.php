<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Support\Str;
use Exception;

class ArticleServices
{
    protected $repository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createArticle(array $data)
    {
        $user = auth('api')->user();

        if (!$user || $user->status !== 'active') {
            throw new Exception("Solo los usuarios activos pueden crear artículos.", 403);
        }

        $data['user_id'] = $user->id;
   
        if (isset($data['status']) && $data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $article = $this->repository->create($data);

        if (isset($data['category_ids']) && is_array($data['category_ids'])) {
            $this->repository->syncCategories($article, $data['category_ids']);
        }

        return $article->load('categories');
    }

    public function updateArticle(Article $article, array $data)
    {
        $user = auth('api')->user();
        if (!$user || $user->status !== 'active') {
            throw new Exception("Usuario no autorizado o inactivo.", 403);
        }

        if (isset($data['title']) && $data['title'] !== $article->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (isset($data['status']) && $data['status'] === 'published' && !$article->published_at) {
            $data['published_at'] = now();
        }

        $this->repository->update($article, $data);



        if (isset($data['category_ids'])) {
            $this->repository->syncCategories($article, $data['category_ids']);
        }

        return $article->load('categories');
    }
}