<?php

namespace App\Repositories\Interfaces;

use App\Models\Article;

interface ArticleRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Article $article, array $data);
    public function delete(Article $article);
    public function syncCategories(Article $article, array $categoryIds);
}