<?php

namespace App\Http\Controllers\API\User;

use App\Http\Requests\Cart\AddRequest;
use App\Http\Requests\Cart\DeleteRequest;
use App\Models\CartProduct;
use App\Services\CartService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends UserBasedController
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
        $userId = Auth::id();

        $cartItems = CartProduct::where('user_id', $userId)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $cartItems,
        ]);
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

            $this->cartService->addProduct(
                $user,
                $validatedData['product_id'],
                $validatedData['quantity']
            );

            return response()->json([
                'result' => 'success',
                'message' => 'Товар добавлен в корзину'
            ]);
        } catch(\ErrorException $e) {
            return response()->json($e, 500);
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
        $userId = Auth::id();

        $validatedData = $request->validated();

        try {
            CartProduct::where([
                'user_id' => $userId,
                'product_id' => $validatedData['product_id']
            ])
                ->delete();

            return response()->json([
                'result' => 'success',
                'message' => 'Товар удален'
            ]);
        } catch(QueryException $e) {
            return response()->json($e, 500);
        }
    }
}
