<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\Order\UpdateRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminOrderController
{
    public function __construct(
        private readonly OrderService $orderService
    ) {
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
