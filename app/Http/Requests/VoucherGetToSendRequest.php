<?php

namespace App\Http\Requests;

use App\Actions\PhonePrepare\PhonePrepare;
use Illuminate\Foundation\Http\FormRequest;

class VoucherGetToSendRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    protected function prepareForValidation(): void
    {
        $phoneValidate = new PhonePrepare();

        $phone = $phoneValidate($this->phone);

        if ($phone['status']){

            $this->merge([
                'phone' =>  $phone['phone']
            ]);

        }

    }

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
            'phone' => 'required|regex:/^\+7\d{10}$/',
            'day' => 'required|integer|between:1,365'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Не заполнено обязательное поле',
            'day.integer' => 'Дни могут быть только целое число',
            'day.between' => 'Допустимое значение от 1 до 365',
            'phone.regex' => 'Должно соответствовать формату телефона',
        ];
    }
}
