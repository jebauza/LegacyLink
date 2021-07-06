<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CeremonyTypeApiResource extends JsonResource
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
            'name' => $this->name,
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="CeremonyTypeApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="name", type="string", example="Incineración"),
     * )
     */
}
