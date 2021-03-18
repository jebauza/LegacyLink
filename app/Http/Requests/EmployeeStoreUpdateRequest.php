<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $employee_id = $this->route('employee_id') ?? null;
        return [
            'name' => "required|string|max:255",
            'last_name' => 'required|string|max:255',
            'email' => "required|email|unique:employees,email,$employee_id,id",
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'extra_info' => 'nullable|string'
        ];
    }
}
