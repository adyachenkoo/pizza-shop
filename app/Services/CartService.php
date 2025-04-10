<?php

namespace App\Services;

use App\Enums\CategoryEnum;
use App\Models\Cart;
use App\Models\Product;

class CartService
{
    /**
     * Добавить продукт в корзину
     * @param int $productId
     * @param int $quantity
     * @param Cart $cart
     * @return array
     */
    public function addProduct(int $productId, int $quantity, Cart $cart): array
    {
        $canAddProduct = $this->checkLimit($cart, $productId, $quantity);

        if(!$canAddProduct) {
            return [
                'result' => false,
                'message' => 'Превышен допустимый лимит этой категории товаров',

            ];
        }

        $existingProduct = $cart->products()
            ->where(['product_id' => $productId])
            ->first();

        if ($existingProduct) {
            $cart->products()->updateExistingPivot($productId, ['quantity' => $quantity]);

            return [
                'result' => true,
                'message' => 'Количество товара увеличено',
            ];
        }

        $cart->products()->attach($productId, [
            'quantity' => $quantity,
        ]);

        return [
            'result' => true,
            'message' => 'Товар добавлен в корзину',
        ];
    }

    /**
     * Проверка лимитов на добавление продукта в корзину
     * @param Cart $cart
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function checkLimit(Cart $cart, int $productId, int $quantity): bool
    {
        $categoryId = Product::where('id', $productId)
            ->value('category_id');

        $count = $cart->products()
            ->where('products.category_id', $categoryId)
            ->wherePivot('product_id', '!=', $productId)
            ->sum('quantity');

        $category = CategoryEnum::from($categoryId);

        return $quantity + (int) $count <= config("limits.$category->name");
    }
}
