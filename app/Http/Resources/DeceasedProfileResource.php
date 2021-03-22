<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeceasedProfileResource extends JsonResource
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
            "id"=>$this->id,
            "name"=>$this->name,
            "last_name"=>$this->last_name,
            "birthday"=>$this->birthday->format('Y-m-d'),
            "death"=>$this->death->format('Y-m-d'),
            "adviser"=>new AdviserResource($this->adviser)
        ];
    }

    /**
     * @OA\RequestBody(
     *      request="deceasedProfile_show_response_200",
     *      description="OK",
     *      @OA\JsonContent( ref="#/components/schemas/DeceasedProfileResource" )
     * )
     *
     * @OA\Schema(
     *      schema="DeceasedProfileResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="user_id", type="integer", example=6),
     *      @OA\Property(property="name", type="string", example="Carlos"),
     *      @OA\Property(property="last_name", type="string", example="Perez Perez"),
     *      @OA\Property(property="birthday", type="date", example="1965-08-11"),
     *      @OA\Property(property="death", type="date", example="2021-03-20"),
     *      @OA\Property(property="adviser", ref="#/components/schemas/AdviserResource"),
     * )
     */
}
