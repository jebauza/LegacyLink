<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class VimeoApiResource extends JsonResource
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
            'ceremony_id' => $this->ceremony_id,
            'vimeo_code' => $this->vimeo_code,
            'vimeo_url' => $this->vimeo_url,
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="VimeoApiResource",
     *      @OA\Property(property="ceremony_id", type="integer", example=161),
     *      @OA\Property(property="vimeo_code", type="string", example="548798286"),
     *      @OA\Property(property="vimeo_url", type="string", example="https://vimeo.com/548798286"),
     * )
     */
}
