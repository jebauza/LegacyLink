<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class InvitationStoreApiRequest extends FormRequest
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
     * @OA\RequestBody(required=true, request="request_invitation_store",
     *      @OA\JsonContent(
     *          required={"main","start","end","address","type_id","visible"},
     *          @OA\Property(property="phone", type="string", example="+34622453641", title="required|string|phone:ES,mobile"),
     *          @OA\Property(property="role", type="string", example="family", title="required|string|in:admin,family,close_friend"),
     *          @OA\Property(property="name", type="string", example="Carlos Perez", title="required|string|max:20"),
     *      )
     * )
     */
    public function rules()
    {
        return [
            'phone' => 'required|string|phone:ES,mobile|max:20',
            'role'  => 'required|string|in:admin,family,close_friend',
            'name'  => 'required|string|max:20'
        ];
    }

    /**
     * @OA\RequestBody(request="invitation_store_response_422", description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="phone", example={"El campo phone es obligatorio."}),
     *                  @OA\Property(property="role", example={"El campo rol es obligatorio."}),
     *                  @OA\Property(property="name", example={"El campo nombre es obligatorio."}),
     *              )
     *          )
     * )
     */
}
