<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'int',
            'name' => 'string',
            'price' => 'int',
            'description' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.int' => 'Категория должна быть числом',
            'name.string' => 'Имя должно быть строкой',
            'price.int' => 'Цена должна быть числом',
            'description.string' => 'Описание должно быть строкой',
        ];
    }
}
