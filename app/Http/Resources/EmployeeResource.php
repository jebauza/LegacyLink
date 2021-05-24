<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'last_name' => $this->last_name,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'phone' => $this->phone,
            'extra_info' => $this->extra_info,
            'offices' => $this->offices,
            'role' => $this->roles->first(),
            'deleted_at' => $this->deleted_at
        ];
    }


}
