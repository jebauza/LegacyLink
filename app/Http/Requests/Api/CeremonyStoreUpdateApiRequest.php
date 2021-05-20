<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CeremonyStoreUpdateApiRequest extends FormRequest
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
     * @OA\RequestBody(required=true, request="request_ceremony_store",
     *      @OA\JsonContent(
     *          required={"main","start","end","address","type_id","visible"},
     *          @OA\Property(property="main", type="boolean", example=true, title="required|boolean"),
     *          @OA\Property(property="start", type="string", example="2021-03-21 08:00:00", title="required|date|date_format:Y-m-d H:i:s"),
     *          @OA\Property(property="end", type="string", example="2021-03-21 11:00:00", title="required|date|date_format:Y-m-d H:i:s|after:start"),
     *          @OA\Property(property="address", type="string", example="Carrer del Campament, 80, 46035 València, Valencia", title="required|string|max:255"),
     *          @OA\Property(property="room_name", type="string", example="sala 4", title="nullable|string|max:255"),
     *          @OA\Property(property="additional_info", type="string", example="sala 4", title="nullable|string"),
     *          @OA\Property(property="type_id", type="integer", example=3, title="required|integer|exists:ceremony_types,id"),
     *          @OA\Property(property="visible", type="string", example="public", title="required|string|in:private,public")
     *      )
     * )
     */
    public function rules()
    {
        $ceremony_id = $this->route('ceremony_id') ?? null;
        return [
            'main' => 'required|boolean',
            'start' => 'required|date|date_format:Y-m-d H:i:s',
            'end' => 'required|date|date_format:Y-m-d H:i:s|after:start',
            'room_name' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'address' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:ceremony_types,id',
            'visible' => 'required|string|in:private,public'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(empty($validator->errors()->all())){
                $this->checkMain($validator);
            }
        });
    }

    public function checkMain($validator)
    {
        $profile = session('profileWeb');
        if ($this->main && $profile && $profile->ceremonies()->where('main', true)->count() > 0) {
            $validator->errors()->add('main', __('There can only be one main ceremony'));
        }
    }

    /**
     * @OA\RequestBody(request="ceremony_store_response_422", description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="main", example={"Sólo puede existir una ceremonia principal"}),
     *                  @OA\Property(property="start", example={"El campo lastname es obligatorio."}),
     *                  @OA\Property(property="end", example={"El campo nacimiento es obligatorio."}),
     *                  @OA\Property(property="address", example={"El campo defunción es obligatorio."}),
     *                  @OA\Property(property="type_id", example={"El campo defunción es obligatorio."}),
     *                  @OA\Property(property="visible", example={"El campo defunción es obligatorio."}),
     *                  @OA\Property(property="room_name", example={"El campo defunción es obligatorio."}),
     *                  @OA\Property(property="additional_info", example={"El campo defunción es obligatorio."}),
     *              )
     *          )
     * )
     */
}
