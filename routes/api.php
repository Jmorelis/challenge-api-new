<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    // Devuelve la info del usuario logueado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // CRUD de artículos (Ahora SI está protegido)
    Route::apiResource('articles', ArticleController::class);
    
});
