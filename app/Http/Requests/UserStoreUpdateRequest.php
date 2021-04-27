<?php

namespace App\Http\Requests;

use App\Rules\Nif;
use App\Models\Office;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreUpdateRequest extends FormRequest
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
        $user_id = $this->route('client_id') ?? null;
        return [
            'dni' => ['required','string','max:20',new Nif,"unique:users,dni,$user_id,id"],
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => "required|string|max:255|unique:users,email,$user_id,id",
            'phone' => 'required|string|phone:ES,mobile',
        ];
    }
}
