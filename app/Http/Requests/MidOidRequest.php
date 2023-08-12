<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MidOidRequest extends FormRequest
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
            'name' => 'required|max:255',
            'comment' => 'required|max:255'
        ];
    }

    public function messages()
    {
        return
            [
                'required' => 'Заполните это поле',
                'max' => 'Значение не должно быть длинне :max символов'
            ];
    }
}
