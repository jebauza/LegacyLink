<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DeceasedProfileUpdateApiRequest extends FormRequest
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
     * @OA\RequestBody(required=true, request="request_deceased_profile_update",
     *      @OA\JsonContent(
     *          required={"name","lastname","birthday","death"},
     *          @OA\Property(property="name", type="string", example="Carlos", title="required|string|max:255"),
     *          @OA\Property(property="lastname", type="string", example="Gonzalez Perez", title="required|string|max:255"),
     *          @OA\Property(property="birthday", type="string", example="1975-03-21", title="required|date|date_format:Y-m-d"),
     *          @OA\Property(property="death", type="string", example="2021-03-21", title="required|date|date_format:Y-m-d|after:birthday"),
     *          @OA\Property(property="photo_base64", type="string", title="nullable|base64image"),
     *          @OA\Property(property="wall_image_base64", type="string", title="nullable|base64image"),
     *          @OA\Property(property="title_epitaph", type="string", title="nullable|string|max:255"),
     *          @OA\Property(property="message_epitaph", type="string", title="nullable|string"),
     *          @OA\Property(property="template", type="string", title="required|string|in:1,2,3,4"),
     *      )
     * )
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'birthday' => 'required|date|date_format:Y-m-d',
            'death' => 'required|date|date_format:Y-m-d|after:birthday',
            'photo_base64' => 'nullable|base64image',
            'wall_image_base64' => 'nullable|base64image',
            'title_epitaph' => 'nullable|string|max:255',
            'message_epitaph' => 'nullable|string',
            'template' => 'required|string|in:1,2,3,4'
        ];
    }

     /**
     * @OA\RequestBody(request="deceased_profile_update_response_422", description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="name", example={"El campo nombre es obligatorio."}),
     *                  @OA\Property(property="lastname", example={"El campo lastname es obligatorio."}),
     *                  @OA\Property(property="birthday", example={"El campo nacimiento es obligatorio."}),
     *                  @OA\Property(property="death", example={"El campo defunción es obligatorio."}),
     *                  @OA\Property(property="photo_base64", example={"El campo photo_base64 es obligatorio."}),
     *                  @OA\Property(property="wall_image_base64", example={"El campo wall_image_base64 es obligatorio."}),
     *                  @OA\Property(property="title_epitaph", example={"El campo title_epitaph es obligatorio."}),
     *                  @OA\Property(property="message_epitaph", example={"El campo message_epitaph es obligatorio."}),
     *              )
     *          )
     * )
     */
}
