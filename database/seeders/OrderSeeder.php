<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allOrderItems = [];
        $orders = Order::factory(50)->create();

        foreach ($orders as $order) {

            $orderItemsCount = rand(1, 5);

            for ($j = 0; $j < $orderItemsCount; $j++) {
                $allOrderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => rand(1, 6),
                    'quantity' => rand(1, 10),
                ];
            }

            // Чтобы не убиться по памяти, вставляй порционно
            if (count($allOrderItems) > 100) {
                DB::table('order_product')->insert($allOrderItems);
                $allOrderItems = [];
            }
        }

        // Вставить остаток
        if (!empty($allOrderItems)) {
            DB::table('order_product')->insert($allOrderItems);
        }
    }
}
