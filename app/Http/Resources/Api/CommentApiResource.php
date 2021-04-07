<?php

namespace App\Http\Resources\Api;

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
            'approved' => $this->approved,
            'profile_id' => $this->profile_id,
            'public' => $this->public,
            'user_id' => $this->user_id,
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
     *      @OA\Property(property="approved", type="boolean", example=0),
     *      @OA\Property(property="profile_id", type="integer", example=11),
     *      @OA\Property(property="public", type="boolean", example=1),
     *      @OA\Property(property="user_id", type="integer", example=5),
     *      @OA\Property(property="created_at", type="string", example="2021-04-07 12:57:44"),
     * )
     */
}
