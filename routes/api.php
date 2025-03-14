<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->controller(AuthController::class)->group(function() {
    Route::post('login', 'login');
    Route::get('user', 'user');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::prefix('product')->controller(ProductController::class)->group(function() {
    Route::get('/', 'index');
    Route::post('/create', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/delete/{id}', 'delete');
});

Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('/', [CartController::class, 'getUserCart']);
    Route::post('/add', [CartController::class, 'addProduct']);
    Route::post('/delete', [CartController::class, 'deleteProduct']);
    Route::post('/increment', [CartController::class, 'incrementQuantity']);
    Route::post('/decrement', [CartController::class, 'decrementQuantity']);
});
