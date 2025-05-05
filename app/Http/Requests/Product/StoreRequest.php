<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_name' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|int',
            'description' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'category_name.required' => 'Вы не указали категорию товара',
            'name.required' => 'Вы не указали название товара',
            'price.required' => 'Вы не указали цену товара',
            'description.required' => 'Вы не указали описание товара',
        ];
    }
}
