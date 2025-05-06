<?php

namespace App\Http\Controllers\API\User;

use App\Http\Requests\Order\StoreRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

final readonly class UserOrderController
{
    public function __construct(
        private readonly OrderService $orderService
    ) {

    }

    /**
     * Получение пользовательских заказов в работе
     *
     * @return JsonResponse
     */
    public function getOrders(): JsonResponse
    {
        try {
            return response()->json([
                'result' => true,
                'data' => Order::where('user_id', auth()->id())
                    ->whereIn('status_id', [2,3])
                    ->get()
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
     * Получение истории заказов пользователя
     *
     * @return JsonResponse
     */
    public function getHistory(): JsonResponse
    {
        try {
            return response()->json([
                'result' => true,
                'data' => Order::where('user_id', auth()->id())
                    ->where('status_id', 1)
                    ->get()
            ]);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при получении истории заказов: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при получении истории заказов',
            ], 500);
        }

    }

    /**
     * Создание заказа
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function createOrder(StoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $user = auth()->user();

            $result = $this->orderService->createOrder($user, $validatedData);

            if ($result['result'] === false) {
                return response()->json([
                    'result' => false,
                    'message' => $result['message']
                ]);
            }

            return response()->json([
                'result' => true,
                'message' => $result['message'],
                'data' => $result['data'],
            ]);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при создании заказа: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при создании заказа',
            ], 500);
        }
    }
}
