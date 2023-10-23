<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductMonitoringUpdateRequest extends FormRequest
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
            'tempBurt' => 'nullable|numeric|max:20|min:-5',
            'tempAboveBurt' => 'nullable|numeric|max:20|min:-5',
            'tempMorning' => 'nullable|numeric|max:20|min:-5',
            'tempEvening' => 'nullable|numeric|max:20|min:-5',
            'humidity' => 'nullable|numeric|max:100',
            'timeUp' => 'nullable|date_format:H:i',
            'timeDown' => 'nullable|date_format:H:i',
            'comment' => 'nullable|max:255',
        ];
    }
    public function messages()
    {
        return [
            'numeric' => 'только числовое значение',
            'max' => 'температура на может быть выше :max градусов',
            'min' => 'температура на может быть ниже :min градусов',
            'humidity.max' => 'влажность не может превышать :max%',
            'comment.max' => 'Максимально :max символов',
            'required' => 'Поле обязательно для заполнения'
        ];
    }
}
