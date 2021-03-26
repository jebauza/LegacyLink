<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationApiResource extends JsonResource
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
            'phone' => $this->phone,
            'role' => $this->role,
            'name' => $this->name,
            'used_by' => $this->used_by,
            'created_at' => $this->created_at
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="InvitationApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="phone", type="string", example="+34622785623"),
     *      @OA\Property(property="role", type="string", example="family"),
     *      @OA\Property(property="name", type="string", example="Carlos Perez"),
     *      @OA\Property(property="used_by", type="string", example="2021-03-26 10:00:00 | null"),
     *      @OA\Property(property="created_at", type="string", example="2021-03-26 10:00:00"),
     * )
     */
}
