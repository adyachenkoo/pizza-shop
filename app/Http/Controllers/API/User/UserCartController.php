<?php

namespace App\Http\Controllers\API\User;

use App\Http\Requests\Cart\AddRequest;
use App\Http\Requests\Cart\DeleteRequest;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCartController extends UserBasedController
{

    public function __construct(
        private readonly CartService $cartService
    ) {

    }

    /**
     * Получение товаров из корзины пользователя
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserCart(Request $request): JsonResponse
    {
        try {
            if (auth('api')->check()) {
                $user = auth('api')->user();

                $cart = $user->cart()->firstOrCreate([]);

                $cartItems = $cart->products;
            } else {
                $guestToken = $request->cookie('guest_token') ?? generate_guest_token();

                $cart = Cart::firstOrCreate([
                    'guest_token' => $guestToken,
                ]);

                $cartItems = $cart->products;
            }

            return response()->json([
                'result' => true,
                'data' => [
                    'cart_id' => $cart->id,
                    'items' => $cartItems
                ],
            ])->cookie('guest_token', $guestToken ?? null, 60 * 24 * 30);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при получении корзины: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при получении корзины',
            ], 500);
        }
    }

    /**
     * Добавление товара в корзину
     *
     * @param AddRequest $request
     * @return JsonResponse
     */
    public function addProduct(AddRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $result = $this->cartService->addProduct(
                $validatedData['product_id'],
                $validatedData['quantity'],
                $request->cookie()
            );

            if ($result['result'] === false) {
                return response()->json([
                    'result' => false,
                    'message' => $result['message']
                ])->cookie('guest_token', $result['guest_token'] ?? null, 60 * 24 * 30);
            }

            return response()->json([
                'result' => true,
                'message' => 'Товар добавлен в корзину'
            ])->cookie('guest_token', $result['guest_token'] ?? null, 60 * 24 * 30);
        } catch(\Exception $e) {
            logger()->error('Возникла ошибка при добавлении товара в корзину: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при добавлении товара в корзину',
            ], 500);
        }
    }

    /**
     * Удаление товара из корзины
     *
     * @param DeleteRequest $request
     * @return JsonResponse
     */
    public function deleteProduct(DeleteRequest $request): JsonResponse
    {
        if (auth('api')->check()) {
            $user = auth('api')->user();

            $cart = $user->cart()->firstOrCreate([]);
        } else {
            $guestToken = $request->cookie('guest_token') ?? null;

            $cart = Cart::where('guest_token', $guestToken)
                ->firstOrFail();
        }

        $validatedData = $request->validated();

        try {
            $result = $cart->products()
                ->where(['product_id' => $validatedData['product_id']])
                ->delete();

            if (empty($result)) {
                return response()->json([
                    'result' => false,
                    'message' => 'Возникла ошибка при удалении товара из корзины',
                ])->cookie('guest_token', $guestToken ?? null, 60 * 24 * 30);
            }

            return response()->json([
                'result' => true,
                'message' => 'Товар удален'
            ])->cookie('guest_token', $guestToken ?? null, 60 * 24 * 30);
        } catch(\Exception $e) {
            logger()->error('Возникла ошибка при удалении товара из корзины: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при удалении товара из корзины',
            ], 500);
        }
    }
}
