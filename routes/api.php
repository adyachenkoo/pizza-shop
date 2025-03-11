<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('product')->controller(ProductController::class)->group(function() {
    Route::get('/', 'index');
    Route::post('/create', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/delete/{id}', 'delete');
});

Route::prefix('auth')->controller(AuthController::class)->group(function() {
    Route::post('login', 'login');
    Route::get('user', 'user');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

