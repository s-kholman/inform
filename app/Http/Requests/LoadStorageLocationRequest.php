<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadStorageLocationRequest extends FormRequest
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
            'loadStorageLocation' => ['required' ,'mimes:xml'],
        ];
    }
//, 'extensions:xml','mimes:application/xml'
    public function messages()
    {
        return
            [
                'required' => 'Пустое поле загрузки',
                'extensions' => 'Не допустимое разрешение файла',
                'mimes' => 'Тип файла не подходит',
            ];
    }
}
