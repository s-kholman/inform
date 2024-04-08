<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoleRequest extends FormRequest
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
            'pole' => 'required|max:50',
            'filial' => 'required_without:update|integer',
            'image' => 'image|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Заполните это поле',
            'required_without' => 'Выберите филиал',
            'pole.max' => 'Значение не должно быть длинне :max символов',
            'image.max' => 'Размер файла не может превышать 2Mb',
            'image' => 'Файл может быть только изображением'
        ];
    }
}
