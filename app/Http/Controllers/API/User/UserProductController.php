<?php

namespace App\Http\Controllers\API\User;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

final readonly class UserProductController
{
    /**
     * Получение списка продуктов
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json([
                'result' => true,
                'data' => Product::all()
            ]);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при получении списка заказов: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при получении списка заказов',
            ], 500);
        }
    }
}
