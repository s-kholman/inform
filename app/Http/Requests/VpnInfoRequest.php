<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VpnInfoRequest extends FormRequest
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
            'ip_domain' => 'nullable|ipv4',
            'login_domain' => 'nullable|string|max:255',
            'id' => 'required|exists:registrations,id',
            'mail_send' => 'nullable|email',
        ];
    }
}
