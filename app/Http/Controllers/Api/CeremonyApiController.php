<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CeremonyResource;
use App\Http\Resources\DeceasedProfileResource;
use App\Models\Ceremony;
use App\Models\DeceasedProfile;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Ceremony",
 *     description="API Endpoints of public ceremonies list"
 * )
 */
class CeremonyApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/public/profile/{profile_id}/ceremonies",
     *      operationId="/public/profile/{profile_id}/ceremonies",
     *      tags={"Ceremony"},
     *      summary="Get the public ceremonies list",
     *      description="Return the list of ceremonies associated with a specific profile",
     *
     *      @OA\Parameter(
     *          name="profile_id",
     *          in="path",
     *          description="Profile_id",
     *          @OA\Schema(
     *               type="integer",
     *          ),
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/CeremonyResource")
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(response=404, ref="#/components/requestBodies/response_404"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     *  @param int $profile_id
     *  @return CeremonyResource
     */
    public function index($profile_id)
    {
        if(!$profile = DeceasedProfile::find($profile_id)){
            return $this->sendError404();
        }

        $ceremonies = Ceremony::where('profile_id',$profile->id)
                        ->orderBy('start')
                        ->get();

        return $this->sendResponse(null, (CeremonyResource::collection($ceremonies)));
    }
}
