<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductMonitoringRequest extends FormRequest
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
            'storage' => 'required|numeric',
            'date' => ['required',
            Rule::unique('product_monitorings', 'date')->where('storage_name_id', $this->input('storage'))],
            'tempBurt' => 'nullable|numeric',
            'tempAboveBurt' => 'nullable|numeric',
            'tempMorning' => 'nullable|numeric',
            'tempEvening' => 'nullable|numeric',
            'humidity' => 'nullable|numeric',
            'phase' => 'required|numeric',
            'timeUp' => 'nullable|date_format:H:i',
            'timeDown' => 'nullable|date_format:H:i',
            'comment' => 'nullable|max:255',

        ];
    }
    public function messages()
    {
        return [
            'date.unique' => 'На данное число запись не уникальна',
            'numeric' => 'только числовое значение',
            'max' => 'Максимально 255 символов',
            'required' => 'Поле обязательно для заполнения'
        ];
    }
}
