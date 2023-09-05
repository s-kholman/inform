<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FactoryGuesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->Registration->activation ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'factory_material_id' => 'required|numeric',
            'volume' => 'required|numeric',
            'mechanical' => 'nullable|numeric|min:0',
            'land' => 'nullable|numeric|min:0',
            'haulm' => 'nullable|numeric|min:0',
            'rot' => 'nullable|numeric|min:0',
            'sixty' => 'nullable|numeric|min:0',
            'fifty' => 'nullable|numeric|min:0',
            'forty' => 'nullable|numeric|min:0',
            'thirty' => 'nullable|numeric|min:0',
            'less_thirty' => 'nullable|numeric|min:0',
            'full' => 'nullable|numeric',
        ];
    }
    public function messages()
    {
        return [
            'numeric' => 'только числовое значение',
            'min' => 'Только положительное значение',
            'required' => 'Поле обязательно для заполнения'
        ];
    }
}
