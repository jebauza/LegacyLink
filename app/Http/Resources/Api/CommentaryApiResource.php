<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentaryApiResource extends JsonResource
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
            'created_at' => $this->created_at
        ];
    }
}
