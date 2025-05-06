<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

final readonly class AdminOrderController
{
    public function __construct(
        private readonly OrderService $orderService
    ) {
    }

    /**
     * Метод для получения списка заказов
     *
     * @return JsonResponse
     */
    public function getAllOrders(): JsonResponse
    {
        try {
            return response()->json([
                'result' => true,
                'data' => Order::all()
            ]);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при получении списка заказов: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при получении списка заказов',
            ], 500);
        }
    }

    /**
     * Метод для обновления статуса заказа
     *
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function updateStatus(UpdateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $user = auth()->user();

            $result = $this->orderService->updateStatus($user, $validatedData);

            if ($result['result'] === false) {
                return response()->json([
                    'result' => false,
                    'message' => $result['message']
                ]);
            }

            return response()->json([
                'result' => true,
                'message' => $result['message']
            ]);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при обновлении статуса заказа: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при обновлении статуса заказа',
            ], 500);
        }
    }
}
