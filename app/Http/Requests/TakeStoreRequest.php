<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TakeStoreRequest extends FormRequest
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
            'storage_box_id' => 'required|numeric',
            'fifty' => 'nullable|numeric|min:0',
            'forty' => 'nullable|numeric|min:0',
            'thirty' => 'nullable|numeric|min:0',
            'standard' => 'nullable|numeric|min:0',
            'waste' => 'nullable|numeric|min:0',
            'land' => 'nullable|numeric|min:0',
            'date' => 'required|date',
            'comment' => 'nullable|max:500',
            'max' => 'nullable|numeric',
            'volume' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
       return [
            'numeric' => 'только числовое значение',
            'max' => 'Сократите сообщение до :max символов',
            'min' => 'Только положительное значение'
        ];
    }
}
