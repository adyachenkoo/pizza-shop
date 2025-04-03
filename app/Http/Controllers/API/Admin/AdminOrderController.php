<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class AdminOrderController
{
    public function __construct(
        private readonly OrderService $orderService
    ) {
    }

    public function getAllOrders(): JsonResponse
    {
        return response()->json([
            'result' => true,
            'data' => Order::all()
        ]);
    }

    public function updateStatus(UpdateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

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
           'message' => 'Статус обновлен'
        ]);
    }
}
