<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SowingHoeingPotatoRequest extends FormRequest
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
            'pole' => 'required|integer',
            'type_field_work' => 'required|integer',
            'sowing_last_name' => 'required|integer',
            'volume' => 'required|numeric',
            'shift' => 'required|integer',
            'hoeing_result_agronomist_point_1' => 'required_without_all:hoeing_result_agronomist_point_2,hoeing_result_agronomist_point_3,hoeing_result_director_point_1,hoeing_result_director_point_2,hoeing_result_director_point_3,hoeing_result_deputy_director_point_1,hoeing_result_deputy_director_point_2,hoeing_result_deputy_director_point_3|nullable|integer|min:1',
            'hoeing_result_agronomist_point_2' => 'nullable|integer|min:1',
            'hoeing_result_agronomist_point_3' => 'nullable|integer|min:1',
            'hoeing_result_director_point_1' => 'nullable|integer|min:1',
            'hoeing_result_director_point_2' => 'nullable|integer|min:1',
            'hoeing_result_director_point_3' => 'nullable|integer|min:1',
            'hoeing_result_deputy_director_point_1' => 'nullable|integer|min:1',
            'hoeing_result_deputy_director_point_2' => 'nullable|integer|min:1',
            'hoeing_result_deputy_director_point_3' => 'nullable|integer|min:1',
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
