<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SzrRequest extends FormRequest
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
            //'name' => 'required|max:255|unique:szrs,name',
            'name' => 'required|max:255',
            'select' => 'required|numeric',
            'interval_day_start' => 'nullable|numeric|min:1',
            'interval_day_end' => 'required_with:interval_day_start|gte:interval_day_start',
            'dosage' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Заполните это поле',
            'numeric' => 'Только числовые значения',
            'required_with' => 'Обязательно к заполнению если указан От',
            'gte' => 'Может быть больше или равен параметру От',
            'max' => 'Значение не должно быть длиннее :max символов',
            'unique' => 'Значение не уникально'
        ];
    }
}
