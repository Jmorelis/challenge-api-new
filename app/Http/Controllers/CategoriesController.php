<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Services\CategoriesServices;
use App\Repositories\Interfaces\CategoriesRepositoryInterface; 
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;

class CategoriesController extends Controller
{

    protected $categoriesServices;
    protected $categoriesRepo;

    public function __construct(CategoriesServices $categoriesServices, CategoriesRepositoryInterface $categoriesRepo)
    {
        $this->categoriesServices = $categoriesServices;
        $this->categoriesRepo = $categoriesRepo;
    }

    public function index()
    {
        try {
            $categories = $this->categoriesRepo->all();

             return response()->json([
                'message' => 'listado ok',
                'categorias' => $categories,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unexpected error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {


            $categories = Categories::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ?? 'draft',
            ]);

            return response()->json([
                'message' => 'Categoria resgistrado OK',
                'categoria' => $categories->id,
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



    public function destroy(Category $category): JsonResponse
    {
       
        if ($category->articles()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se puede eliminar la categoría porque tiene artículos vinculados.',
                'code' => 'CAT 1'
            ], 422); 
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Categoría eliminada correctamente.'
        ], 200);
    }
    

}
