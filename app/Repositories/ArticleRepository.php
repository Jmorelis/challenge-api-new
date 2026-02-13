<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function all()
    {
        return Article::with(['user', 'categories'])->get();
    }

    public function find($id)
    {
        return Article::with(['user', 'categories'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Article::create($data);
    }

    public function update(Article $article, array $data)
    {
        $article->update($data);
        return $article;
    }

    public function delete(Article $article)
    {
        return $article->delete();
    }

    public function syncCategories(Article $article, array $categoryIds)
    {
        return $article->categories()->sync($categoryIds);
    }
}