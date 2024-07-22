<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrikopkiRequest extends FormRequest
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
            'date' => 'required|date',
            'pole' => 'required|integer',
            'filial_id' => 'required|integer',
            'sevooborot' => 'required|integer|min:1',
            'prikopki_squares' => 'required|integer',
            'fraction_1' => 'nullable|numeric|min:0',
            'fraction_2' => 'nullable|numeric|min:0',
            'fraction_3' => 'nullable|numeric|min:0',
            'fraction_4' => 'nullable|numeric|min:0',
            'fraction_5' => 'nullable|numeric|min:0',
            'fraction_6' => 'nullable|numeric|min:0',
            'volume' => 'required|numeric|min:0.001',
            'comment' => 'nullable|max:255',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Данное поле обязательно к заполнению',
            'volume.required' => 'Должна быть заполненна минимум одна фракция',
            'volume.min' => 'Значение не может быть меньше :min',
            'min' => 'Ошибка'
        ];
    }
}
