<?php

namespace App\Http\Requests\V1\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|unique:clients|max:255',
            'email' => 'required|email|unique:clients|max:255',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
