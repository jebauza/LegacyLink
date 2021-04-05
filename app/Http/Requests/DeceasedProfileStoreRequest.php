<?php

namespace App\Http\Requests;

use App\Rules\Nif;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DeceasedProfileStoreRequest extends FormRequest
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
        return [
            'dprofile_office' => 'required|integer|exists:offices,id',
            'dprofile_adviser' => 'required|integer|exists:employees,id',
            'dprofile_name' => 'required|string|max:255',
            'dprofile_lastname' => 'required|string|max:255',
            'dprofile_birthday' => 'required|date|date_format:Y-m-d',
            'dprofile_death' => 'required|date|date_format:Y-m-d|after:dprofile_birthday',

            'client_id' => 'integer|exists:users,id',
            'client_name' => 'required|string|max:255',
            'client_lastname' => 'required|string|max:255',
            'client_dni' => ['required','string','max:20',new Nif,Rule::unique('users', 'dni')->ignore($this->client_id)],
            'client_email' => 'required|string|max:255|unique:users,email,'.$this->client_id.',id',
            'client_phone' => 'required|string|phone:ES,mobile',
            'client_sendEmail' => 'required|boolean',
            'client_sendSms' => 'required|boolean',

            'ceremonies' => 'bail|required|array|min:1',
            'ceremonies.*.additional_info' => 'nullable|string',
            'ceremonies.*.address' => 'required|string|max:255',
            'ceremonies.*.start' => 'required|date|date_format:Y-m-d H:i:s',
            'ceremonies.*.end' => 'required|date|date_format:Y-m-d H:i:s|after:ceremonies.*.start',
            'ceremonies.*.main' => 'required|boolean',
            'ceremonies.*.room_name' => 'nullable|string|max:255',
            'ceremonies.*.type_id' => 'required|integer|exists:ceremony_types,id',
        ];
    }
}
