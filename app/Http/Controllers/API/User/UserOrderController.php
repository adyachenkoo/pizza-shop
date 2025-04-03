<?php

namespace App\Http\Controllers\API\User;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\Order\StoreRequest;
use App\Models\CartProduct;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class UserOrderController extends UserBasedController
{
    public function __construct(
        private readonly OrderService $orderService
    ) {

    }
    public function getOrders()
    {
        return response()->json([
            'result' => true,
            'data' => Order::where('user_id', auth()->id())
                ->whereIn('status_id', [2,3])
                ->get()
        ]);
    }

    public function getHistory()
    {
        return response()->json([
            'result' => true,
            'data' => Order::where('user_id', auth()->id())
                ->where('status_id', 1)
                ->get()
        ]);
    }

    public function createOrder(StoreRequest $request)
    {
        $validatedData = $request->validated();

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
            'message' => 'Заказ успешно создан'
        ]);
    }
}
