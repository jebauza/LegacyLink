<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeceasedProfileResource;
use App\Models\DeceasedProfile;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Tag(
 *     name="Profile",
 *     description="API Profile"
 * )
 */
class DeceasedProfileApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/public/profile/{profile_id}",
     *      operationId="/public/profile/{profile_id}",
     *      tags={"Profile"},
     *      summary="Get the public details of deseased profile",
     *      description="Return the public details of a specific profile",
     *
     *      @OA\Parameter(
     *          name="profile_id",
     *          in="path",
     *          description="Profile id",
     *          @OA\Schema(
     *               type="integer",
     *          ),
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/DeceasedProfileResource"),
     *          )
     *      ),
     *
     *      @OA\Response(response=404, ref="#/components/requestBodies/response_404"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     * @param int $profile_id
     */
    public function show($profile_id)
    {
        $profile = DeceasedProfile::find($profile_id);

        if(!$profile){
            return $this->sendError404();
        }

        return $this->sendResponse(null, (new DeceasedProfileResource($profile)));
    }
}
