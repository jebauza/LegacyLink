<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CeremonyResource extends JsonResource
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
            "type"=>$this->type->name,
            "profile_id"=>$this->profile_id,
            "main"=>$this->main,
            "start"=>$this->start,
            "end"=>$this->end,
            "address"=>$this->address,
            "room_name"=>$this->room_name,
            "additional_info"=>$this->additional_info,
        ];
    }
}
