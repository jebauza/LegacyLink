<?php
namespace App\Http\Resources\Api;


use App\Http\Resources\Api\VimeoApiResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\AssistanceApiResource;
use App\Http\Resources\Api\CeremonyTypeApiResource;

class CandleApiResource extends JsonResource
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
            "message"=>$this->message,
            "profile_id"=>$this->profile_id
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="CandleApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="message", type="string", example="De Manuel"),
     *      @OA\Property(property="profile_id", type="integer", example=161),
     * )
     */
}
