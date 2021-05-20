<?php
namespace App\Http\Resources\Api;


use App\Http\Resources\Api\VimeoApiResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\AssistanceApiResource;
use App\Http\Resources\Api\CeremonyTypeApiResource;

class CeremonyApiResource extends JsonResource
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
            "type"=> new CeremonyTypeApiResource($this->type),
            "profile_id"=>$this->profile_id,
            "main"=>$this->main,
            "start"=>$this->start->format('Y-m-d H:i:s'),
            "end"=>$this->end->format('Y-m-d H:i:s'),
            "address"=>$this->address,
            "room_name"=>$this->room_name,
            "additional_info"=>$this->additional_info,
            "visible"=>$this->visible,
            'assistance' => $this->when(auth()->check(), AssistanceApiResource::collection($this->users)),
            'streaming' => $this->streaming,
            'video' => $this->streaming ? (new VimeoApiResource($this->video)) : null
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="CeremonyApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="type", ref="#/components/schemas/CeremonyTypeApiResource"),
     *      @OA\Property(property="profile_id", type="integer", example=161),
     *      @OA\Property(property="main", type="boolean", example=true),
     *      @OA\Property(property="start", type="date", example="2021-03-20 08:00:00"),
     *      @OA\Property(property="end", type="date", example="2021-03-20 16:00:00"),
     *      @OA\Property(property="address", type="string", example="Carrer del Campament, 80, 46035 València, Valencia"),
     *      @OA\Property(property="room_name", type="string", example="Sala 03"),
     *      @OA\Property(property="additional_info", type="string", example="Informacion adicional"),
     *      @OA\Property(property="visible", type="string", example="private", title="private|public"),
     *      @OA\Property(property="assistance", type="array",
     *          @OA\Items(ref="#/components/schemas/AssistanceApiResource")
     *      ),
     *      @OA\Property(property="streaming", type="boolean", example="true"),
     *      @OA\Property(property="video", ref="#/components/schemas/VimeoApiResource"),
     * )
     */
}
