<?php
namespace App\Http\Resources\Api;


use Illuminate\Http\Resources\Json\JsonResource;

class UserApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $add_data = [];
        if ($this->add_profile) {
            $add_data['profile_id'] = $this->add_profile;
        }

        if ($this->add_role) {
            $add_data['role'] = $this->add_role;
        }

        return array_merge($add_data, [
            'id' => $this->id,
            'dni' => $this->dni,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
        ]);
    }

    /**
     *
     * @OA\Schema(
     *      schema="UserApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="dni", type="string", example="46485700M"),
     *      @OA\Property(property="name", type="string", example="Carlos"),
     *      @OA\Property(property="lastname", type="string", example="Perez Perez"),
     *      @OA\Property(property="fullName", type="string", example="Carlos Perez Perez"),
     *      @OA\Property(property="email", type="string", example="carlos@gmail.com"),
     *      @OA\Property(property="phone", type="string", example="+34622789562"),
     *      @OA\Property(property="is_active", type="boolean", example=true),
     * )
     *
     * @OA\Schema(
     *      schema="UserAuthApiResource",
     *      @OA\Property(property="id", type="integer", example=161),
     *      @OA\Property(property="dni", type="string", example="46485700M"),
     *      @OA\Property(property="name", type="string", example="Carlos"),
     *      @OA\Property(property="lastname", type="string", example="Perez Perez"),
     *      @OA\Property(property="fullName", type="string", example="Carlos Perez Perez"),
     *      @OA\Property(property="email", type="string", example="carlos@gmail.com"),
     *      @OA\Property(property="phone", type="string", example="+34622789562"),
     *      @OA\Property(property="is_active", type="boolean", example=true),
     *      @OA\Property(property="profile_id", type="integer", example=2),
     *      @OA\Property(property="role", type="string", example="admin"),
     * )
     */
}
