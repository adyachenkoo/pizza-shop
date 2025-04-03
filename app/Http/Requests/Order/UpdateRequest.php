<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|int',
            'status_id' => 'required|int'
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'Вы не указали номер заказа',
            'order_id.int' => 'Номер заказа должен быть числом',
            'status_id.required' => 'Вы не указали новый статус',
            'status_id.int' => 'Статус должен быть числом'
        ];
    }
}
