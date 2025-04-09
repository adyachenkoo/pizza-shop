<?php

namespace App\Services;

use App\Enums\CategoryEnum;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class CartService
{
    /**
     * Добавить продукт в корзину
     * @param int $productId
     * @param int $quantity
     * @param array $cookie
     * @return array
     */
    public function addProduct(int $productId, int $quantity, array $cookie): array
    {
        if (auth()->check()) {
            $user = auth()->user();

            $cart = $user->cart()
                ->firstOrCreate([]);
        } else {
            $guestToken = $cookie['guest_token'] ?? generate_guest_token();

            $cart = Cart::firstOrCreate([
                'guest_token' => $guestToken
            ]);
        }

        $canAddProduct = $this->checkLimit($cart, $productId, $quantity);

        if(!$canAddProduct) {
            return [
                'result' => false,
                'message' => 'Превышен допустимый лимит этой категории товаров',
                'guest_token' => $guestToken ?? null,

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
                'guest_token' => $guestToken ?? null,
            ];
        }

        $category = Product::where('id', $productId)
            ->value('category_id');

        $cart->products()->attach($productId, [
            'category_id' => $category,
            'quantity' => $quantity,
        ]);

        return [
            'result' => true,
            'message' => 'Товар добавлен в корзину',
            'guest_token' => $guestToken ?? null,
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
            ->wherePivot('category_id', $categoryId)
            ->wherePivot('product_id', '!=', $productId)
            ->sum('quantity');

        $category = CategoryEnum::from($categoryId);

        return $quantity + (int) $count <= config("limits.$category->name");
    }
}
