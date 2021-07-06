<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AssistanceUpdateApiRequest extends FormRequest
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
     * @OA\RequestBody(required=true, request="request_assistance_update",
     *      @OA\JsonContent(
     *          required={"assistance"},
     *          @OA\Property(property="assistance", type="boolean", example="true", title="required|boolean"),
     *      )
     * )
     */
    public function rules()
    {
        return [
            'assistance'  => 'required|boolean',
        ];
    }

    /**
     * @OA\RequestBody(request="assistance_update_response_422", description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="assistance", example={"El campo rol es obligatorio."}),
     *              )
     *          )
     * )
     */
}
