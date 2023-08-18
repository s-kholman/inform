<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorageBoxRequest extends FormRequest
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
            'storage_name' => 'required|numeric',
            'field' => 'nullable|max:500',
            'selectFirst' => 'required|numeric',
            'selectSecond' => 'required|numeric',
            'selectThird' => 'nullable|numeric',
            'type' => 'numeric',
            'volume' => 'numeric'
        ];
    }

    public function messages()
    {
        return [
            'storage_name.numeric' => 'Выберите склад хранения',
            'selectFirst.required' => 'Выберите культуру',
            'selectSecond.required' => 'Заполните справочник',
            'selectThird.numeric' => 'Заполните справочник',
            'volume.numeric' => 'Значение может быть только числом',
            'max' => 'Максимальное значение поля :max символов'
        ];
    }
}
