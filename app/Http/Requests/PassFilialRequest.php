<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PassFilialRequest extends FormRequest
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
            'filial' => 'required|exists:filials,id',
            'date' => 'required|date',
            'numberCar' => 'required|max:25',
            'lastName' => 'nullable|max:255',
            'comment' => 'nullable|max:255',
        ];
    }
}
