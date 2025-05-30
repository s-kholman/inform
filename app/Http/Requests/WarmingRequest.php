<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Closure;

class WarmingRequest extends FormRequest
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
            'storage_name_id' => 'required|numeric',
            'volume' => 'required|numeric|min:0',
            'sowing_date' => 'required|date',
            'warming_date' => 'required|date',
            'comment' => 'nullable|max:255',
            'comment_agronomist' => [
                'nullable',
                'max:255',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!auth()->user()->can('Warming.completed.create')){
                        $fail("Нет прав доступа");
                    }
                }
                ],
            'comment_deputy_director' => [
                'nullable',
                'max:255',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!auth()->user()->can('Warming.deploy.create')){
                        $fail("Нет прав доступа");
                    }
                }
            ],
        ];
    }
}
