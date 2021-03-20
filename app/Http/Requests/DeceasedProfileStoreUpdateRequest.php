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
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:100|unique:users,email',

            'dprofile_name' => 'required|string|max:255',
            'dprofile_lastname' => 'required|string|max:255',
            'dprofile_birthday' => 'required|date|date_format:Y-m-d',
            'dprofile_death' => 'required|date|date_format:Y-m-d|after:dprofile_birthday',
            'dprofile_adviser_id' => 'required|integer|exists:employees,id',
            'dprofile_office_id' => 'required|integer|exists:offices,id',

            'ceremonies' => 'required|array|min:1',
            'ceremonies.*.main' => 'required|boolean',
            'ceremonies.*.start' => 'required|date|date_format:Y-m-d H:i:s',
            'ceremonies.*.end' => 'required|date|date_format:Y-m-d H:i:s',
            'ceremonies.*.room_name' => 'required|string|max:100',
            'ceremonies.*.additional_info' => 'required|string',
            'ceremonies.*.address' => 'required|string',
            'ceremonies.*.type_id' => 'required|string',
        ];
    }
}
