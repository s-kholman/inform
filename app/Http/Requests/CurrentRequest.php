<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrentRequest extends FormRequest
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
            'hostname' => 'required|max:255',
            'ip' => 'required|ip',
            'filial' => 'required|numeric',
            'status' => 'required|numeric',
            'date' => 'required|date',
            'device_names_id' => 'required|numeric',
            'device_id' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Заполните это поле',
            'ip' => 'не соответствует IP адресу',
            'max' => 'Значение не должно быть длинне :max символов'
        ];

    }
}
