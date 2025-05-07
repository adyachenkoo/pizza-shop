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
        if ($this->cartIsEmpty($user)) {
            return [
                'result' => false,
                'message' => 'Корзина пуста'
            ];
        }

        try {
            DB::beginTransaction();

            $cartProducts = $user->cart->products;

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

            foreach ($cartProducts as $product) {
                $order->products()->attach(
                    $product->id,
                    ['quantity' => $product->pivot->quantity]
                );
            }

            $user->cart->products()->detach();

            DB::commit();

            return [
                'result' => true,
                'message' => 'Заказ создан',
                'data' => $order
            ];
        } catch (\Throwable $e) {
            DB::rollBack();

            logger()->error('Ошибка при создании заказа: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return [
                'result' => false,
                'message' => 'Произошла ошибка при создании заказа.',
            ];
        }
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

    public function cartIsEmpty(User $user): bool
    {
        return !$user->cart || !$user->cart->products()->exists();
    }
}
