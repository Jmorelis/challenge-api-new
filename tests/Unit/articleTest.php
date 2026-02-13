<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Categories;
use App\Services\ArticleServices;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_article_successfully_with_categories()
    {
        $user = User::factory()->create([
            'name' => 'Juan carlo',
            'status' => 'active'
        ]);

        $category = Categories::factory()->create([
            'name' => 'Tecnología'
        ]);

        $this->actingAs($user, 'api');

        $articleService = app(ArticleServices::class);

        $data = [
            'title' => 'Mi Primer Artículo',
            'content' => 'Contenido extenso del artículo',
            'status' => 'published',
            'category_ids' => [$category->id]
        ];

        $article = $articleService->createArticle($data);

        $this->assertEquals('Mi Primer Artículo', $article->title);
        $this->assertEquals($user->id, $article->user_id);
        
        $this->assertEquals('mi-primer-articulo', $article->slug);

        $this->assertTrue($article->categories->contains($category->id));

        $this->assertDatabaseHas('articles', [
            'title' => 'Mi Primer Artículo',
            'user_id' => $user->id,
            'slug' => 'mi-primer-articulo'
        ]);

        $this->assertDatabaseHas('article_category', [
            'category_id' => $category->id,
            'article_id' => $article->id
        ]);
    }
}