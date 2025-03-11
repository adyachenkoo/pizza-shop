<?php

namespace App\Http\Controllers\API;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /** 
     *
     * @param Request $request 
     * 
     */     
    public function index(Request $request)
    {
       return response()->json(Product::all());
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        
        try {
            $product = Product::create($validatedData);
        
            return response()->json($product);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Не удалось создать продукт']);
        }
    }

    public function update(UpdateRequest $request, int $id)
    {
        $validatedData = $request->validated();
        
        try {
            $product = Product::find($id)->update($validatedData);

            return response()->json($product);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Не удалось создать продукт']);
        }
    }

    public function delete(int $id)
    {
        return response()->json((bool) Product::destroy($id));
    }
}
