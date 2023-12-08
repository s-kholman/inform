<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PeatRequest extends FormRequest
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
            'PeatExtraction' => 'required|numeric',
            'Pole' => 'required|numeric',
            'date' => 'required|date',
            'volume' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'volume.numeric' => 'только целое число',
            'Pole.required' => 'Выберите значение',
            'PeatExtraction.required' => 'Выберите значение',
            'date' => 'Обязательно для заполнения',
            'volume.required' => 'Обязательно для заполнения',
        ];
    }
}
