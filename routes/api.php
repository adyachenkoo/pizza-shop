<?php

use App\Http\Controllers\API\Admin\AdminProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\User\CartController;
use App\Http\Controllers\API\User\UserProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::get('user', 'user');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::prefix('user')->middleware('auth:api')->group(function () {
    Route::prefix('product')->controller(AdminProductController::class)->group(function () {
        Route::get('/', [UserProductController::class, 'index']);
    });

    Route::prefix('cart')->controller(CartController::class)->group(function () {
        Route::get('/', [CartController::class, 'getUserCart']);
        Route::post('/add', [CartController::class, 'addProduct']);
        Route::post('/delete', [CartController::class, 'deleteProduct']);
    });
});

Route::prefix('admin')->middleware('auth:api')->group(function () {
    Route::prefix('product')->controller(AdminProductController::class)->group(function () {
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'delete');
    });
});
