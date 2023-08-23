<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GuesStoreRequest extends FormRequest
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
            'storage_box_id' => 'required|numeric',
            'fifty' => 'nullable|numeric|min:0|max:100',
            'forty' => 'nullable|numeric|min:0|max:100',
            'thirty' => 'nullable|numeric|min:0|max:100',
            'standard' => 'nullable|numeric|min:0|max:100',
            'waste' => 'nullable|numeric|min:0|max:100',
            'land' => 'nullable|numeric|min:0|max:100',
            'date' => 'required|date',
            'comment' => 'nullable|max:500',
        ];
    }
    public function messages()
    {
        return [
            'numeric' => 'только числовое значение',
            'max' => 'Значение не может быть больше :max',
            'min' => 'Значение не может отрицательным',
        ];
    }
}
