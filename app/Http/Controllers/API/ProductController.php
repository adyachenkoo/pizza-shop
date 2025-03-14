<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Product\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Метод для получения списка продуктов
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
       return response()->json(Product::all());
    }

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
