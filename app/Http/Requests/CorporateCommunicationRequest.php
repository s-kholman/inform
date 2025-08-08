<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorporateCommunicationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'fio' => 'required|max:255',
            'phone' => 'required|regex:/^7\d{10}$/',
            'limit' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'limit.numeric' => 'только целое число',
            'required' => 'Обязательно для заполнения',
            'regex' => 'Номер должен начинаться 7 и далее 10 цифр'
        ];
    }
}
