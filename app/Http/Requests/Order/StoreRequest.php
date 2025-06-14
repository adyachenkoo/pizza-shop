<?php

namespace App\Http\Requests\Order;

use App\Rules\ValidPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'address' => 'required|string',
            'phoneNumber' => ['required', 'string', new ValidPhoneNumber],
            'email' => 'string',
            'comment' => 'string',
            'deliveryTime' => 'required|date_format:H:i'
        ];
    }

    public function messages()
    {
        return [
            'address.required' => 'Вы не указали адрес',
            'address.string' => 'Адрес должен быть строкой',
            'phoneNumber.required' => 'Вы не указали номер телефона',
            'phoneNumber.string' => 'Номер телефона должен быть строкой',
            'email.string' => 'Емейл должен быть строкой',
            'comment.string' => 'Комментарий должен быть строкой',
        ];
    }
}
