<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(User $user, array $data): array
    {
        if ($user->cartProducts->isEmpty()) {
            return [
                'result' => false,
                'message' => 'Корзина пуста'
            ];
        }

        DB::transaction(function () use ($user, $data) {
            $cartProducts = $user->cartProducts;

            $order = Order::create([
                'status_id' => OrderStatusEnum::PREPARING->value,
                'user_id' => $user->id,
                'address' => $data['address'],
                'phoneNumber' => $data['phoneNumber'],
                'deliveryTime' => $data['deliveryTime'],
                'email' => $data['email'] ?? null,
                'totalPrice' => $user->getTotalCart(),
                'comment' => $data['comment'] ?? null
            ]);

            foreach ($cartProducts as $cartProduct) {
                $order->products()->attach(
                    $cartProduct->product_id,
                    ['quantity' => $cartProduct->quantity]
                );
            }

            $user->cartProducts()->delete();
        });

        return [
            'result' => true,
            'message' => 'Заказ создан'
        ];
    }

    public function updateStatus(User $user, array $data): array
    {

        $result = $user->orders()
            ->where('id', $data['order_id'])
            ->update(['status_id' => $data['status_id']]);

        if (empty($result)) {
            return [
                'result' => false,
                'message' => 'Ошибка при обновлении статуса заказа'
            ];
        }

        return [
            'result' => true,
            'message' => 'Статус заказа обновлен'
        ];
    }
}
