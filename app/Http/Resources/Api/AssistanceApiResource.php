<?php
namespace App\Http\Resources\Api;


use Illuminate\Http\Resources\Json\JsonResource;

class AssistanceApiResource extends JsonResource
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
            'lastname' => $this->lastname,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'assistance' => $this->pivot->assistance
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="AssistanceApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="name", type="string", example="Carlos"),
     *      @OA\Property(property="lastname", type="string", example="Perez Perez"),
     *      @OA\Property(property="fullName", type="string", example="Carlos Perez Perez"),
     *      @OA\Property(property="email", type="string", example="carlos@gmail.com"),
     *      @OA\Property(property="phone", type="string", example="+34622789562"),
     *      @OA\Property(property="assistance", type="boolean", example="true"),
     * )
     */
}
