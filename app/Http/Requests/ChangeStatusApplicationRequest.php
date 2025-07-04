<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusApplicationRequest extends FormRequest
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
            'id' => 'required|exists:users,id',
            'applicationStatusId' => 'required|exists:application_statuses,id',
            'identification' => 'required',
            'applicationNameId' => 'required',
        ];
    }

    public function messages()
    {
        return
            [
                'required' => 'Заполните это поле',
                'exists' => 'Поле не найдено',

            ];
    }
}
