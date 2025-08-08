<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ESPStatusRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'mac' => 'не соответствует формату MAC - адресов',
            'required' => 'Заполните это поле',
        ];
    }
}
