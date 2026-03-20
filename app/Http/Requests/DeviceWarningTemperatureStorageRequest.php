<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceWarningTemperatureStorageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'storageName' => 'numeric|min:0',
            'temperatureMax' => 'numeric|min:0',
            'temperatureMin' => 'numeric|min:0',
            'role' => 'numeric|min:0',
        ];
    }
}
