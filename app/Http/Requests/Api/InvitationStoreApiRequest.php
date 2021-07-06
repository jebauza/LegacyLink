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
     *          required={"role"},
     *          @OA\Property(property="role", type="string", example="family", title="required|string|in:admin,family,close_friend"),
     *      )
     * )
     */
    public function rules()
    {
        return [
            'role'  => 'required|string|in:admin,family,close_friend',
        ];
    }

    /**
     * @OA\RequestBody(request="invitation_store_response_422", description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="role", example={"El campo rol es obligatorio."}),
     *              )
     *          )
     * )
     */
}
