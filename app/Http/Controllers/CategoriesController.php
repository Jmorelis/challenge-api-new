<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;

class CategoriesController extends Controller
{
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
