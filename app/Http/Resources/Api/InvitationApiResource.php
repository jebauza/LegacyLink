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
            'profile_id' => $this->profile_id,
            'role' => $this->role,
            'message' => "Se le ha invitado a unirse a la web de " .$this->profile->fullName. " su link es " . config('albia.web_client_url') . "/invitation?token=" . $this->token . "&profile=" . $this->profile->web_code,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="InvitationApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="profile_id", type="integer", example=12),
     *      @OA\Property(property="role", type="string", example="family"),
     *      @OA\Property(property="message", type="string", example="Se le ha invitado a unirse a la web de Pepe Gonzalez su link es https://web.celebrasuvida.es/invitation?token=ASDDXcM260755ad575d54&profile=xmrZJ10"),
     *      @OA\Property(property="created_by", type="integer", example=31),
     *      @OA\Property(property="created_at", type="string", example="2021-03-26 10:00:00"),
     * )
     */
}
