<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SowingRequest extends FormRequest
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
            'filial' => 'required|numeric',
            'sowing_type' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return
            [
                'required' => 'Заполните это поле',
            ];
    }
}
