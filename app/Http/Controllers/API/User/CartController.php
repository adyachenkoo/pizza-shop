<?php

namespace App\Http\Controllers\API\User;

use App\Http\Requests\Cart\AddRequest;
use App\Http\Requests\Cart\DeleteRequest;
use App\Models\Cart;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Получение товаров из корзины пользователя
     *
     * @return JsonResponse
     */
    public function getUserCart(): JsonResponse
    {
        $userId = Auth::id();

        $cartItems = Cart::where('user_id', $userId)
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
        $userId = Auth::id();

        $validatedData = $request->validated();

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $validatedData['product_id'])
            ->exists();

        try {
            if ($cartItem) {
                return response()->json([
                    'error' => 'Товар уже в корзине'
                ]);
            }

            Cart::create([
                'user_id' => $userId,
                'product_id' => $validatedData['product_id'],
                'quantity' => 1,
            ]);

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
            Cart::where([
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
