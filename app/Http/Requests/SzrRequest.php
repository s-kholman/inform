<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SzrRequest extends FormRequest
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
            //'name' => 'required|max:255|unique:szrs,name',
            'name' => 'required|max:255',
            'select' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Заполните это поле',
            'numeric' => 'Выберите из списка',
            'max' => 'Значение не должно быть длиннее :max символов',
            'unique' => 'Значение не уникально'
        ];
    }
}
