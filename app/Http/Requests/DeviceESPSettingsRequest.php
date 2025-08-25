<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceESPSettingsRequest extends FormRequest
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
            'deviceESP' => 'required',
            'description' => 'nullable|string|max:50',
            //'storageName' => 'nullable|integer|min:1',
            'storageName' => 'required_if:deviceActivate,1',
            'deviceActivate' => 'required|boolean',
            'update_status' => 'required|boolean',
            'updateBin' => 'required_if:update_status,1',
            'thermometers' => 'nullable',
            'pointSelect' => 'nullable|required_with:thermometers',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле обязательно для заполнения',
            'max' => 'Максимальное значение :max символов',
            'storageName.required_if' => 'Для активации необходимо указать место установки',
            'updateBin.required_if' => 'Выберите версию прошивки',
            'active_url' => 'Проверьте URL',
            'required_with' => 'При выборе термометра необходимо указать точку измерения'
        ];
    }
}
