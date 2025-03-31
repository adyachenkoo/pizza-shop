<?php

namespace App\Http\Controllers\API\User;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class UserProductController extends UserBasedController
{

    /**
     * Получение списка продуктов
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Product::all());
    }
}
