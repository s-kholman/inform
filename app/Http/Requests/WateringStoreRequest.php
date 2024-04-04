<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WateringStoreRequest extends FormRequest
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
            'MM' => 'required|integer|min:1',
            'pole' => 'required|integer',
            'gidrant' => 'required',
            'sector' => 'required|integer',
            'date'  => 'required|date',
            'speed' => 'nullable|integer|min:1',
            'KAC' => 'nullable|integer|min:1',
            'comment' => 'nullable|max:255'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Заполните это поле',
            'max' => 'Значение не должно быть длинне :max символов',
            'integer' => 'Может быть только целым числом',
            'min' => 'Минимальное значение :min'
        ];
    }
}
