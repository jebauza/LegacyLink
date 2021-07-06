<?php

namespace App\Http\Requests\Api;

use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CommentStoreUpdateRequest extends FormRequest
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
     * @OA\RequestBody(required=true, request="request_comment_store",
     *      @OA\JsonContent(
     *          required={"title","message","public"},
     *          @OA\Property(property="title", type="string", example="De Angel tu amigo", title="required|string|max:255"),
     *          @OA\Property(property="message", type="string", example="Descansa en paz", title="required|string"),
     *          @OA\Property(property="file_base64", type="string", title="nullable|base64image", example="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD//gAfQ29tcHJlc3NlZCBieSBqcGVnLXJlY29tcHJlc3P/2wCEAAcHBwcHBwgJCQgLDAsMCxAPDg4PEBkSExITE"),
     *          @OA\Property(property="public", type="boolean", title="required|boolean", example=false),
     *          @OA\Property(property="remove_file", type="boolean", title="nullable|boolean", example=true),
     *          @OA\Property(property="file", type="file",example="file", title="nullable|file|max:25000|mimetypes:video/h264,video/mpeg,video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi,video/x-matroska,image/jpeg,image/gif,image/png,image/svg+xml,image/bmp,image/tiff,image/vnd.adobe.photoshop"),
     *      )
     * )
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'file_base64' => 'nullable|base64image',
            'public' => 'required|boolean',
            'remove_file' => 'nullable|boolean',
            'file' => 'nullable|file|max:25000|mimetypes:video/h264,video/mpeg,video/x-ms-asf,video/x-flv,video/mp4,application/vnd.apple.mpegurl,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi,video/x-matroska,image/jpeg,image/gif,image/png,image/svg+xml,image/bmp,image/tiff,image/vnd.adobe.photoshop'
        ];
    }
}
