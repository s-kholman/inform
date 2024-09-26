<?php

namespace App\Http\Requests;

use App\Rules\CreateNoTomorrow;
use App\Rules\CreateOneToHarvest;
use App\Rules\CreateOneToHarvestProductMonitoring;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductMonitoringRequest extends FormRequest
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
            'storage' => 'required|numeric',
            /*'date' => ['required',
                Rule::unique('product_monitorings', 'date')
                ->where('storage_name_id', $this->input('storage'))
                ->where('storage_phase_id', $this->input('phase')),
                new CreateOneToHarvestProductMonitoring,
                new CreateNoTomorrow
                ],*/
            'date' => ['required','date',
                new CreateOneToHarvestProductMonitoring,
                //new CreateNoTomorrow
            ],
            //'tempBurt' => 'nullable|numeric|max:20|min:-5',
            //'tempAboveBurt' => 'nullable|numeric|max:20|min:-5',
            'tuberTemperatureMorning' => 'nullable|numeric|max:20|min:-5',
            //'tempEvening' => 'nullable|numeric|max:20|min:-5',
            'humidity' => 'nullable|numeric|max:100',
            'storage_phase_id' => 'filled|numeric',
            'timeUp' => 'nullable|date_format:H:i',
            'timeDown' => 'nullable|date_format:H:i',
            'condensate' => 'sometimes|accepted',
            'comment' => 'nullable|max:255',
            'temperature_keeping' => 'nullable|numeric|max:20|min:-5',
            'humidity_keeping' => 'nullable|numeric|max:100',
            'control_manager' => 'nullable|max:255',
            'control_director' => 'nullable|max:255',

        ];
    }
    public function messages()
    {
        return [
            'date.unique' => 'На данное число запись не уникальна',
            'numeric' => 'только числовое значение',
            'max' => 'температура на может быть выше :max градусов',
            'min' => 'температура на может быть ниже :min градусов',
            'humidity.max' => 'влажность не может превышать :max%',
            'comment.max' => 'Максимально :max символов',
            'required' => 'Поле обязательно для заполнения',
            'filled' => 'Поле обязательно для заполнения',
        ];
    }
}
