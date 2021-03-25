<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'dni' => $this->dni,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
        ];
    }
}
