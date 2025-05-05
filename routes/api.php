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

Route::prefix('user')->group(function () {
    Route::prefix('product')->controller(UserProductController::class)->group(function () {
        Route::get('/', 'index');
    });

    Route::prefix('cart')->controller(UserCartController::class)->middleware(['attachCart'])
        ->group(function () {
            Route::get('/', 'getUserCart');
            Route::post('/add', 'addProduct');
            Route::delete('/delete', 'deleteProduct');
        });

    Route::prefix('order')->controller(UserOrderController::class)->middleware(['auth:api'])
        ->group(function () {
            Route::get('/', 'getOrders');
            Route::get('/history', 'getHistory');
            Route::post('/create', 'createOrder');
        });
});

Route::prefix('admin')->middleware(['auth:api', 'isAdmin'])->group(function () {
    Route::prefix('product')->controller(AdminProductController::class)->group(function () {
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/', 'delete');
    });

    Route::prefix('order')->controller('')->group(function () {
        Route::get('/', [AdminOrderController::class, 'getAllOrders']);
        Route::post('/update', [AdminOrderController::class, 'updateStatus']);
    });
});
