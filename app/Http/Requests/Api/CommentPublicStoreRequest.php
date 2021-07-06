<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CommentPublicStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @OA\RequestBody(required=true, request="request_comment_public_store",
     *      @OA\JsonContent(
     *          required={"title","message"},
     *          @OA\Property(property="title", type="string", example="De Angel tu amigo", title="required|string|max:255"),
     *          @OA\Property(property="message", type="string", example="Descansa en paz", title="required|string"),
     *          @OA\Property(property="file_base64", type="string", title="nullable|base64image", example="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD//gAfQ29tcHJlc3NlZCBieSBqcGVnLXJlY29tcHJlc3P/2wCEAAcHBwcHBwgJCQgLDAsMCxAPDg4PEBkSExITE"),
     *      )
     * )
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'file_base64' => 'nullable|base64image'
        ];
    }

    /**
     * @OA\RequestBody(request="comment_public_response_422", description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="title", example={"Sólo puede existir una ceremonia principal"}),
     *                  @OA\Property(property="message", example={"El campo lastname es obligatorio."}),
     *                  @OA\Property(property="file_base64", example={"El campo nacimiento es obligatorio."}),
     *              )
     *          )
     * )
     */
}
