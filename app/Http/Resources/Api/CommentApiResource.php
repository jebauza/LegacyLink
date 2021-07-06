<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\UserApiResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'file' => $this->file,
            'type_file' => $this->typeFile,
            'approved' => $this->approved,
            'profile_id' => $this->profile_id,
            'public' => $this->public,
            'user' => $this->user ? $this->user->only('id','name','lastname','fullName') : null,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="CommentApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="title", type="string", example="Jose amigo"),
     *      @OA\Property(property="message", type="string", example="Descansa en paz mi colega 3"),
     *      @OA\Property(property="file", type="string", example="http://albia.local/storage/deceased_profiles/9/comments/606d9028556ae.jpeg"),
     *      @OA\Property(property="type_file", type="string", example="image", title="video|image"),
     *      @OA\Property(property="approved", type="boolean", example=0),
     *      @OA\Property(property="profile_id", type="integer", example=11),
     *      @OA\Property(property="public", type="boolean", example=1),
     *      @OA\Property(property="user", title="nullable|user",
     *          @OA\Property(property="id", type="integer", example=1),
     *          @OA\Property(property="name", type="string", example="Alberto"),
     *          @OA\Property(property="lastname", type="string", example="Perez Castro"),
     *          @OA\Property(property="fullName", type="string", example="Alberto Perez Castro"),
     *      ),
     *      @OA\Property(property="created_at", type="string", example="2021-04-07 12:57:44"),
     * )
     */
}
