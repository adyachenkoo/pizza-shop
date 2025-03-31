<?php

namespace App\Services;

use App\Enums\CategoryEnum;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    /**
     * Добавить продукт в корзину
     * @param User $user
     * @param int $productId
     * @param int $quantity
     * @return Collection
     */
    public function addProduct(User $user, int $productId, int $quantity): Collection
    {
        $canAddProduct = $this->canAddProduct($user, $productId, $quantity);

        if(!$canAddProduct) {
            return response([
                'result' => 'false',
                'message' => 'Вы можете добавить максимум '
            ],  200);
        }

        $cartProduct = $user->cart()
            ->where('product_id', $productId)
            ->first();

        if ($cartProduct) {
            $cartProduct->increment('quantity', $quantity);
            return $cartProduct->fresh();
        }

        return $user->cartProducts()->create([
            'product_id' => $productId,
            'quantity' => $quantity
        ]);
    }

    /**
     * Проверка лимитов на добавление продукта в корзину
     */
    public function canAddProduct(User $user, int $productId, int $quantity): bool
    {
        $categoryId = Product::where('id', $productId)
            ->value('category_id');

        $count = CartProduct::with('products')
            ->where('user_id', 1)
            ->get();

        $product = CategoryEnum::from($productId);

        return $quantity < config("limits.$product->name");
    }
}
