<?php

namespace App\Services;

use App\Enums\CategoryEnum;
use App\Models\CartProduct;
use App\Models\Category;
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
    public function addProduct(User $user, int $productId, int $quantity): array
    {
        $canAddProduct = $this->checkLimit($user, $productId, $quantity);

        if(!$canAddProduct) {
            return [
                'result' => false,
                'message' => 'Превышен допустимый лимит этой категории товаров'
            ];
        }

        $cartProduct = $user->cartProducts()
            ->where('product_id', $productId)
            ->first();

        if ($cartProduct) {
            $cartProduct->update(['quantity' => $quantity]);

            return [
                'result' => true,
                'message' => 'Количество товара увеличено'
            ];
        }

        $category = Product::where('id', $productId)
            ->value('category_id');

        $user->cartProducts()->create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'category_id' => $category,
            'quantity' => $quantity,
        ]);

        return [
            'result' => true,
            'message' => 'Товар добавлен в корзину'
        ];
    }

    /**
     * Проверка лимитов на добавление продукта в корзину
     */
    public function checkLimit(User $user, int $productId, int $quantity): bool
    {
        $categoryId = Product::where('id', $productId)
            ->value('category_id');

        $count = CartProduct::where('user_id', $user->id)
            ->where('category_id', $categoryId)
            ->sum('quantity');

        $category = CategoryEnum::from($categoryId);

        return $quantity + (int) $count <= config("limits.$category->name");
    }
}
