<?php

use App\Http\Controllers\API\Admin\AdminOrderController;
use App\Http\Controllers\API\Admin\AdminProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\User\UserCartController;
use App\Http\Controllers\API\User\UserOrderController;
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

    Route::prefix('cart')->controller(UserCartController::class)->group(function () {
        Route::get('/', [UserCartController::class, 'getUserCart']);
        Route::post('/add', [UserCartController::class, 'addProduct']);
        Route::delete('/delete', [UserCartController::class, 'deleteProduct']);
    });

    Route::prefix('order')->group(function () {
       Route::get('/', [UserOrderController::class, 'getOrders']);
       Route::get('/history', [UserOrderController::class, 'getHistory']);
       Route::post('/create', [UserOrderController::class, 'createOrder']);
    });
});

Route::prefix('admin')->middleware('auth:api')->group(function () {
    Route::prefix('product')->controller(AdminProductController::class)->group(function () {
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'delete');
    });

    Route::prefix('order')->controller('')->group(function () {
        Route::post('/update', [AdminOrderController::class, 'updateStatus']);
    });
});
