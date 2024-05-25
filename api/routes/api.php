<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceSchenduleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::prefix('admin')->group(function () {

    Route::middleware('auth:api')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/user', [UserController::class, 'store']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::put('/user/{id}', [UserController::class, 'update']);
        Route::delete('/user/{id}', [UserController::class, 'destroy']);

        Route::get('/services', [ServiceController::class, 'index']);
        Route::post('/service', [ServiceController::class, 'store']);
        Route::get('/service/{id}', [ServiceController::class, 'show']);
        Route::put('/service/{id}', [ServiceController::class, 'update']);
        Route::delete('/service/{id}', [ServiceController::class, 'destroy']);

        Route::get('/service-schedules', [ServiceSchenduleController::class, 'index']);
        Route::post('/service-schedules', [ServiceSchenduleController::class, 'store']);
        Route::get('/service-schedules/{id}', [ServiceSchenduleController::class, 'show']);
        Route::put('/service-schedules/{id}', [ServiceSchenduleController::class, 'update']);
        Route::delete('/service-schedules/{id}', [ServiceSchenduleController::class, 'destroy']);
    });
});
