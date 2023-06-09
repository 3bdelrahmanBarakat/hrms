<?php

namespace App\Http\Requests\V1\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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

                'name' => 'required|string|min:3|max:64',
                'position' => 'required|string|min:3|max:64|alpha_dash',
                'email' => 'required|string|min:3|max:64',
                'schedule_id' => 'required|exists:schedules,id',

        ];
    }
}
