<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
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
            'mac' => 'required|mac_address',
            'sn' => 'required|max:255',
            'device_names_id' => 'required|numeric',
            'date' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'mac' => 'не соответствует формату MAC - адресов',
            'required' => 'Заполните это поле',
            'max' => 'Значение не должно быть длинне :max символов',
            'numeric' => 'Выберите модель'
        ];
    }
}
