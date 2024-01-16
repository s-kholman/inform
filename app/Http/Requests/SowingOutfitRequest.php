<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SowingOutfitRequest extends FormRequest
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
            'sowing_last_name' => 'required|numeric',
            'filial' => 'required|numeric',
            'sowing_type' => 'required|numeric',
            'cultivation' => 'required_without:machine|numeric',
            'machine' => 'required_without:cultivation|numeric',
        ];
    }

    public function messages()
    {
        return
            [
                'required' => 'Заполните это поле',
                'required_without' => 'Заполните это поле',
                'numeric' => 'Выберите из предложенных значений',
            ];
    }
}
