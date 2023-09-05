<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FactoryMaterialRequest extends FormRequest
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
            'date' => 'required|date',
            'filial_name' => 'required|numeric',
            'fio' => 'nullable|max:255',
            'nomenklature' => 'required|numeric',
            'image' => 'mimes:jpg,bmp,png,jpeg'
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Заполните поле',
            'numeric' => 'только числовое значение',
            'filial_name.numeric' => 'Выберите из списка',
            'nomenklature.numeric' => 'Выберите из списка',
            'max' => 'Сократите сообщение до :max символов',
            'mimes' => 'Тип файла не соответствует изображению'
        ];
    }
}
