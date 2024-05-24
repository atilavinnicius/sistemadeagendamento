<?php

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::prefix('admin')->group(function () {

    Route::get('/users', [UserController::class, 'index']); // Rota para listar todos os usuários
    Route::post('/user', [UserController::class, 'store']); // Rota para criar um novo usuário
    Route::get('/user/{id}', [UserController::class, 'show']); // Rota para exibir um usuário específico
    Route::put('/user/{id}', [UserController::class, 'update']); // Rota para atualizar um usuário existente
    Route::delete('/user/{id}', [UserController::class, 'destroy']); // Rota para excluir um usuário existente

    Route::get('/services', [ServiceController::class, 'index']); // Rota para listar todos os serviços
    Route::post('/services', [ServiceController::class, 'store']); // Rota para criar um novo serviço
    Route::get('/services/{service}', [ServiceController::class, 'show']); // Rota para exibir um serviço específico
    Route::put('/services/{service}', [ServiceController::class, 'update']); // Rota para atualizar um serviço existente
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']); // Rota para excluir um serviço existente

});

