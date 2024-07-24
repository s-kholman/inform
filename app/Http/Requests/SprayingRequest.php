<?php

namespace App\Http\Requests;

use App\Rules\CreateNoTomorrow;
use Illuminate\Foundation\Http\FormRequest;

class SprayingRequest extends FormRequest
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
            'pole' => 'numeric',
            'kultura' => 'numeric',
            'date' => ['date', new CreateNoTomorrow],
            'szrClasses' => 'numeric',
            'szr' => 'numeric',
            'doza' => 'numeric',
            'volume' => 'numeric',
            'comment' => 'nullable|max:255',
        ];
    }

    public function messages()
    {
        return [
            'numeric' => 'Заполните это поле',
            'max' => 'Значение не должно быть длинне :max символов',
            'before_or_equal' => 'Дата не может быть в будущем'
        ];
    }
}
