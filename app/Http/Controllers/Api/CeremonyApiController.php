<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CeremonyResource;
use App\Http\Resources\DeceasedProfileResource;
use App\Models\DeceasedProfile;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Public agenda",
 *     description="API Endpoints of public ceremonies list"
 * )
 */
class CeremonyApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/public/profile/{profile_id}/events",
     *      operationId="/public/profile/{profile_id}/events",
     *      tags={"Public ceremonies list"},
     *      summary="Get the public ceremonies list",
     *      description="Return the list of ceremonies associated with a specific profile",
     *
     *      @OA\Parameter(
     *          name="profile_id",
     *          in="path",
     *          description="Deceased profile id",
     *          @OA\Schema(
     *               type="integer",
     *          ),
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="User login successfully."),
     *          )
     *      ),
     * )
     */
    public function agenda( DeceasedProfile $profile)
    {
        return $this->sendResponse("Successful operation", (CeremonyResource::collection($profile->ceremonies)));
    }
}
