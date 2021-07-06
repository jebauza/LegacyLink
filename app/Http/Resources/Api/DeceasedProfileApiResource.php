<?php
namespace App\Http\Resources\Api;


use App\Http\Resources\Api\AdviserApiResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DeceasedProfileApiResource extends JsonResource
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
            "adviser"=>new AdviserApiResource($this->adviser),
            "photo"=>$this->urlPhoto,
            "wall_image"=>$this->urlWallImage,
            "web_code"=>$this->web_code,
            "title_epitaph"=>$this->title_epitaph,
            "message_epitaph"=>$this->message_epitaph,
        ];
    }

    /**
     *
     * @OA\Schema(
     *      schema="DeceasedProfileApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="user_id", type="integer", example=6),
     *      @OA\Property(property="name", type="string", example="Carlos"),
     *      @OA\Property(property="last_name", type="string", example="Perez Perez"),
     *      @OA\Property(property="birthday", type="date", example="1965-08-11"),
     *      @OA\Property(property="death", type="date", example="2021-03-20"),
     *      @OA\Property(property="adviser", ref="#/components/schemas/AdviserApiResource"),
     *      @OA\Property(property="photo", type="string", example="https://albia.celebratuvida.es/fdfhjduruiuinsdkd.jpg"),
     *      @OA\Property(property="wall_image", type="string", example="https://albia.celebratuvida.es/fdfhjduruiuinsdkd.jpg"),
     *      @OA\Property(property="web_code", type="string", example="TztH29"),
     *      @OA\Property(property="title_epitaph", type="string", example="UN GRAN HOMBRE TU FAMILIA NUNCA TE OLVIDARÁ"),
     *      @OA\Property(property="message_epitaph", type="string", example="FUISTE UNA PERSONA MUY ESPECIAL SIEMPRE TE LLEVAREMOS EN NUESTROS CORAZONES ASÍ COMO TODAS LAS AVENTURAS VIVIDAS NOS REENCONTRAREMOS EN LA OTRA VIDA"),
     * )
     */
}
