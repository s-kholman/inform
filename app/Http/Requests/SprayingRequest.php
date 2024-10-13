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
            'pole' => 'numeric|min:1',
            'kultura' => 'numeric',
            'date' => ['date', new CreateNoTomorrow],
            'szrClasses' => 'numeric|min:1',
            'szr' => 'numeric|min:1',
            'dosage' => 'numeric',
            'volume' => 'numeric',
            'comment' => 'nullable|max:255',
        ];
    }

    public function messages()
    {
        return [
            'min' => 'Заполните это поле',
            'numeric' => 'Заполните это поле',
            'max' => 'Значение не должно быть длиннее :max символов',
            'before_or_equal' => 'Дата не может быть в будущем'
        ];
    }
}
