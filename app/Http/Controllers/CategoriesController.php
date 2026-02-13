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
                'categoria' => $categoria->id,
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

    

}
