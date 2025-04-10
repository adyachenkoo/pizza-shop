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
            'category_id' => 'sometimes|int',
            'name' => 'sometimes|string',
            'price' => 'sometimes|int',
            'description' => 'sometimes|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->hasAny(['category_id', 'name', 'price', 'description'])) {
                $validator->errors()->add('fields', 'Хотя бы одно из полей должно быть заполнено: category_id, name, price, description.');
            }
        });
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
