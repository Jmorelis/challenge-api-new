<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleServices;
use App\Repositories\Interfaces\ArticleRepositoryInterface; 
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\StoreArticleRequest;

use Exception;

class ArticleController extends Controller
{
    protected $articleServices;
    protected $articleRepo;

    public function __construct(ArticleServices $articleServices, ArticleRepositoryInterface $articleRepo)
    {
        $this->articleServices = $articleServices;
        $this->articleRepo = $articleRepo;
    }

    public function index()
    {
        try {
            $articles = $this->articleRepo->all();

             return response()->json([
                'message' => 'listado ok',
                'articulos' => $articles,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unexpected error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $article = $this->articleRepo->find($id);

            return response()->json([
                'message' => 'Articulo encontrado',
                'articulo' => $article,
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Articulo no encontrado'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error inesperado'], 500);
        }
    }

    public function store(StoreArticleRequest $request)
    {
        try {
            $article = $this->articleServices->createArticle($request->validated());

            return response()->json([
                'message' => 'Articulo registrado OK',
                'articulo_id' => $article->id,
                'articulo' => $article
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(), 
            ], $e->getCode() ?: 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $article = $this->articleRepo->find($id);

            $updatedArticle = $this->articleServices->updateArticle($article, $request->all());

            return response()->json([
                'message' => 'Articulo actualizado correctamente',
                'articulo' => $updatedArticle,
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Articulo no encontrado'], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $article = $this->articleRepo->find($id);
            $this->articleRepo->delete($article);

            return response()->json([
                'message' => 'Articulo eliminado correctamente',
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Articulo no encontrado'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al eliminar'], 500);
        }
    }
}