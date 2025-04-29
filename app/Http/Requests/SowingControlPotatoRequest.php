<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SowingControlPotatoRequest extends FormRequest
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
            'date' => 'required|date',
            'filial_id' => 'exists:filials,id',
            'type_field_work' => 'required|integer',
            'sowing_last_name' => 'required|integer',
            'pole' => 'required|integer',
            'point_control' => 'required|max:255',
            'result_control_agronomist' => 'required_without_all:result_control_director,result_control_deputy_director|nullable|integer|min:1',
            'result_control_director' => 'nullable|integer|min:1',
            'result_control_deputy_director' => 'nullable|integer|min:1',
            'comment' => 'nullable|max:255',
        ];
    }
    public function messages()
    {
        return
            [
                'required' => 'Заполните это поле',
                'required_without_all' => 'Должен быть заполнен минимум один результат контроля',
                'max' => 'Строка превышает :max символов',
                'min' => 'Значение должно быть больше нуля',
            ];
    }
}
