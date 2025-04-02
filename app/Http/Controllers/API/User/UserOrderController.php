<?php

namespace App\Http\Controllers\API\User;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\Order\StoreRequest;
use App\Models\CartProduct;
use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends UserBasedController
{
    public function getOrders()
    {
        return response()->json([
            'result' => true,
            'data' => Order::where('user_id', auth()->id())
                ->get()
        ]);
    }

    public function createOrder(StoreRequest $request)
    {
        $validatedData = $request->validated();

        $user = auth()->user();

        Order::create([
           'status_id' => OrderStatusEnum::PREPARING->value,
           'user_id' => $user->id,
           'address' => $validatedData['address'],
           'phoneNumber' => $validatedData['phoneNumber'],
           'deliveryTime' => $validatedData['deliveryTime'],
           'email' => $validatedData['email'] ?? null,
           'totalPrice' => $user->getTotalCart(),
           'comment' => $validatedData['comment'] ?? null
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Заказ успешно создан'
        ]);
    }
}
