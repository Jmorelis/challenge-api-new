<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {

//Faltan validaciones
            $user = User::create([
                'name' => $request->title,
                'email' => $request->content,
                'rol' => $request->rol,
                'status' => $request->status ?? 'draft',
                
            ]);

            return response()->json([
                'message' => 'usuario resgistrado OK',
                'usuario' => $user->id,
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
