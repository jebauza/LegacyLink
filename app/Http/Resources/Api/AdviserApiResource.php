<?php
namespace App\Http\Resources\Api;


use Illuminate\Http\Resources\Json\JsonResource;

class AdviserApiResource extends JsonResource
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
            "email"=>$this->email,
            "phone"=>$this->phone
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="AdviserApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="name", type="string", example="Alberto"),
     *      @OA\Property(property="last_name", type="string", example="Perez"),
     *      @OA\Property(property="email", type="string", example="alberto@albia.es"),
     *      @OA\Property(property="phone", type="string", example="+34622452513"),
     *
     * )
     */
}
