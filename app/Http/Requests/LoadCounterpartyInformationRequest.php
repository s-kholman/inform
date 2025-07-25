<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadCounterpartyInformationRequest extends FormRequest
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
            'loadInformation' => ['required', 'mimes:txt'],
            'counterpartyDate' => 'required|date',
            'documentDate' => 'required|date',
            'counterpartyNumber' => 'required',
        ];
    }
    public function messages()
    {
        return
            [
                'required' => 'Поле обязательно для заполнения',
                'date' => 'Дата не корректна',
                'mimes' => 'Тип файла не подходит',
            ];
    }
}
