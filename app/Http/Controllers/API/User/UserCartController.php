<?php

namespace App\Http\Controllers\API\User;

use App\Http\Requests\Cart\AddRequest;
use App\Http\Requests\Cart\DeleteRequest;
use App\Models\CartProduct;
use App\Services\CartService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserCartController extends UserBasedController
{

    public function __construct(
        private readonly CartService $cartService
    ) {

    }

    /**
     * Получение товаров из корзины пользователя
     *
     * @return JsonResponse
     */
    public function getUserCart(): JsonResponse
    {
        try {
            $user = auth()->user();

            $cartItems = $user->cartProducts;

            return response()->json([
                'result' => true,
                'data' => $cartItems,
            ]);
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
        $user = Auth::user();

        $validatedData = $request->validated();

        try {
            $result = $this->cartService->addProduct(
                $user,
                $validatedData['product_id'],
                $validatedData['quantity']
            );

            if ($result['result'] === false) {
                return response()->json([
                    'result' => false,
                    'message' => $result['message']
                ]);
            }

            return response()->json([
                'result' => true,
                'message' => 'Товар добавлен в корзину'
            ]);
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
        $user = auth()->user();

        $validatedData = $request->validated();

        try {
            $result = $user->cartProducts()
                ->where(['product_id' => $validatedData['product_id']])
                ->delete();

            if (empty($result)) {
                return response()->json([
                    'result' => false,
                    'message' => 'Возникла ошибка при удалении товара из корзины',
                ]);
            }

            return response()->json([
                'result' => true,
                'message' => 'Товар удален'
            ]);
        } catch(\Exception $e) {
            logger()->error('Возникла ошибка при удалении товара из корзины: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при удалении товара из корзины',
            ], 500);
        }
    }
}
