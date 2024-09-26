<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoragePhaseTemperaturesRequest extends FormRequest
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
            'temperature_min' => 'required|numeric|min:0|max:25',
            'temperature_max' => 'required|numeric|min:0|max:25',
            'storage_phase_id' => 'required|numeric|min:1',
        ];
    }
}
