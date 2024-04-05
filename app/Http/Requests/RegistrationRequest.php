<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'filial_name' => 'required|integer|gt:0',
            'last_name' => 'required|min:3|max:50',
            'first_name' => 'required|min:3|max:50',
            'middle_name' => 'present',
            'phone' => 'regex:/^\+7\d{10}/|max:12|min:12',
            'post_name' => 'required|integer|gt:0'
        ];
    }


//regex:/^[а-яА-Я\s]+[а-яА-Я]+[а-яА-Я]*$/u
    public function messages()
    {
        return [
            'required' => 'Заполните это поле',
            'max' => 'Значение не должно быть длинне :max символов',
            'gt' => 'Выберите из списка',
            'min' => 'Должно содержать не менее :min символов',
            'regex' => 'Должно соответствовать формату +7'
        ];
    }
}
