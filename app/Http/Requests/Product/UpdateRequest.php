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
            'category_name' => 'sometimes|string',
            'name' => 'sometimes|string',
            'price' => 'sometimes|int',
            'description' => 'sometimes|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->hasAny(['category_name', 'name', 'price', 'description'])) {
                $validator->errors()->add('fields', 'Хотя бы одно из полей должно быть заполнено: category_name, name, price, description.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'category_name.string' => 'Категория должна быть строкой',
            'name.string' => 'Имя должно быть строкой',
            'price.int' => 'Цена должна быть числом',
            'description.string' => 'Описание должно быть строкой',
        ];
    }
}
