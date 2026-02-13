<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        try {


            $article = Article::create([
                'title' => $request->title,
                'content' => $request->content,
                // 'slug' => \Str::slug($request->title),
                'status' => $request->status ?? 'draft',
                'published_at' => $request->status === 'published' ? now() : null,
                'user_id' => 1 
            ]);

            return response()->json([
                'message' => 'Articulo resgistrado OK',
                'articulo_id' => $article->id,
            ], 201);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Database error',
                'error' => $e->getMessage(),
            ], 500);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unexpected error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $articles = Article::with(['user_id', 'categories'])->get(); //user_id aauthor

             return response()->json([
                'message' => 'listado ok',
                'articulo' => $articles,
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Database error',
                'error' => $e->getMessage(),
            ], 500);

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

            $article = Article::with(['user_id', 'categories'])->findOrFail($id);

            return response()->json([
                'message' => 'Articulo encontrado',
                'articulo' => $article,
            ], 200);

        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Database error',
                'error' => $e->getMessage(),
            ], 500);

        } catch (Exception $e) {

            return response()->json([
                'message' => 'Articulo no encontrado',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $article = Article::findOrFail($id);

            $article->update([
                'title' => $request->title ?? $article->title,
                'content' => $request->content ?? $article->content,
                'status' => $request->status ?? $article->status,
                'published_at' => $request->status === 'published' ? now() : $article->published_at,
            ]);

            return response()->json([
                'message' => 'Articulo actualizado correctamente',
                'articulo' => $article,
            ], 200);

        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Database error',
                'error' => $e->getMessage(),
            ], 500);

        } catch (Exception $e) {

            return response()->json([
                'message' => 'Articulo no encontrado',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function destroy($id)
{
    try {

        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json([
            'message' => 'Articulo eliminado correctamente',
        ], 200);

    } catch (QueryException $e) {

        return response()->json([
            'message' => 'Database error',
            'error' => $e->getMessage(),
        ], 500);

    } catch (Exception $e) {

        return response()->json([
            'message' => 'Articulo no encontrado',
            'error' => $e->getMessage(),
        ], 404);
    }
}

}
