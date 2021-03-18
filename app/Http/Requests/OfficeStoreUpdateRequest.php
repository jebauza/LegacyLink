<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OfficeStoreUpdateRequest extends FormRequest
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
        $office_id = $this->route('office_id') ?? null;
        return [
            'name' => "required|string|max:255|unique:offices,name,$office_id,id",
            'cif' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'extra_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'cp' => 'nullable|string|max:10',
            'province' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'timezone' => 'nullable|integer|exists:timezones,id',
            'phone' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
        ];
    }
}
