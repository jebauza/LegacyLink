<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DeceasedProfileStoreUpdateRequest extends FormRequest
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
        // $office_id = $this->route('office_id') ?? null;
        return [
            'dprofile_office' => 'required|integer|exists:offices,id',
            'dprofile_adviser' => 'required|integer|exists:employees,id',
            'dprofile_name' => 'required|string|max:255',
            'dprofile_lastname' => 'required|string|max:255',
            'dprofile_birthday' => 'required|date|date_format:Y-m-d',
            'dprofile_death' => 'required|date|date_format:Y-m-d|after:dprofile_birthday'
        ];
    }
}
