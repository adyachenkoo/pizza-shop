<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\Product\DeleteRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

final readonly class AdminProductController
{
    /**
     * Метод для создания продукта
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $product = Product::create($validatedData);

            if (empty($product)) {
                return response()->json([
                    'result' => false,
                    'message' => 'Возникла ошибка при создании продукта',
                ]);
            }

            return response()->json([
                'result' => true,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при создании продукта: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при создании продукта',
            ], 500);
        }
    }

    /**
     * Метод для обновления данных продукта
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $product = Product::findOrFail($id);

            $product->update($validatedData);

            return response()->json([
                'result' => true,
                'data' => $product->fresh(),
            ]);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при обновлении продукта: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при обновлении продукта',
            ], 500);
        }
    }

    /**
     * Метод для удаления продукта
     *
     * @param DeleteRequest $request
     * @return JsonResponse
     */
    public function delete(DeleteRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $result = Product::destroy($validatedData['product_id']);

            if (empty($result)) {
                return response()->json([
                    'result' => false,
                    'message' => 'Возникла ошибка при удалении продукта',
                ]);
            }

            return response()->json([
                'result' => true,
                'message' => 'Товар удален',
            ]);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при удалении продукта: ', ['error' => $e->getMessage()]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при удалении продукта',
            ], 500);
        }
    }
}
