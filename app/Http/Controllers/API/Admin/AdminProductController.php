<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AdminProductController extends Controller
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

            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Не удалось создать продукт']);
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
            $product = Product::find($id)->update($validatedData);

            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Не удалось создать продукт']);
        }
    }

    /**
     * Метод для удаления продукта
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return response()->json((bool) Product::destroy($id));
    }
}
