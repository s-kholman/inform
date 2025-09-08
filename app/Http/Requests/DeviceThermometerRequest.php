<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceThermometerRequest extends FormRequest
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
            'serial_number' => 'required|min:10|max:25|unique:device_thermometers|regex:/^[0-9]+$/u'
        ];
    }

    public function messages()
    {
        return [
            'max' => 'не более :max символов',
            'min' => 'не менее :min символов',
            'required' => 'Обязательно к заполнению',
            'unique' => 'Значение не уникально',
            'regex' => 'Только числа'
        ];
    }
}
