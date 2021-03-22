<?php

namespace App\Http\Requests;

use App\Models\Office;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

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
            'password' => ($employee_id ? 'nullable' : 'required') .'|string|min:8',
            'extra_info' => 'nullable|string',
            'role' => 'required|exists:roles,id',
            'offices' => 'bail|array|min:1',
            'offices.*' => 'exists:offices,id'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(empty($validator->errors()->all())){
                if (!$this->user()->hasRole('Super Admin')) {
                    $this->checkOffices($validator);
                    $this->checkRol($validator);
                }
            }
        });
    }

    public function checkOffices($validator)
    {
        if (empty($this->offices)) {
            $validator->errors()->add('offices', __('You must select at least one :office', ['office' => __('Branch Office')]));
        }

        $offices = $this->user()->offices()->whereIn('offices.id', $this->offices)->get();
        if ($offices->count() != count($this->offices)) {
            $validator->errors()->add('offices', __('The selected :office is invalid', ['office' => __('Branch Office')]));
        }
    }

    public function checkRol($validator)
    {
        $canAssign = $this->user()->getCanAssignRoles()->pluck('id')->contains($this->role);
        if (!$canAssign) {
            $validator->errors()->add('role', __('The selected role is invalid'));
        }
    }
}
