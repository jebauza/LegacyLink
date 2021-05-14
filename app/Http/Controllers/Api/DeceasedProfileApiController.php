<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UploadFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\DeceasedProfileApiResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\DeceasedProfileUpdateApiRequest;

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
     *      @OA\Parameter(parameter="web_code", name="web_code", in="path", required=true,
     *          description="Profile code",
     *          @OA\Schema(type="string", example="SdfRt12")
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/DeceasedProfileApiResource"),
     *          )
     *      ),
     *
     *      @OA\Response(response=404, ref="#/components/requestBodies/response_404"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     * @param int $web_code
     */
    public function show($web_code)
    {
        $profile = DeceasedProfile::where('web_code', $profile)
                                    ->first();

        if(!$profile){
            return $this->sendError404();
        }

        return $this->sendResponse(null, (new DeceasedProfileApiResource($profile)));
    }

    /**
     * @OA\Post(
     *      path="/profile/{profile_id}/update",
     *      operationId="/profile/{profile_id}/update",
     *      tags={"Profile"},
     *      summary="Get the public details of deseased profile",
     *      description="Return the public details of a specific profile",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(
     *          name="profile",
     *          in="path",
     *          description="Profile id or web_code",
     *          @OA\Schema(
     *               type="string",
     *          ),
     *      ),
     *
     *      @OA\RequestBody(ref="#/components/requestBodies/request_deceased_profile_update"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/DeceasedProfileApiResource"),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=422, ref="#/components/requestBodies/deceased_profile_update_response_422"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     * @param int $profile_id
     */
    public function update(DeceasedProfileUpdateApiRequest $request, $profile_id)
    {
        $path = null;
        $profile = session('profileWeb');

        try {
            DB::beginTransaction();
            $profile->name = $request->name;
            $profile->last_name = $request->lastname;
            $profile->birthday = $request->birthday;
            $profile->death = $request->death;
            if($request->photo_base64) {
                $dirPath = 'deceased_profiles/' . $profile->id;
                $path = UploadFile::upload($request->photo_base64, $dirPath, true);
                if($profile->photo) {
                    UploadFile::delete($profile->photo);
                }
                $profile->photo = $path;
            }
            $profile->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new DeceasedProfileApiResource($profile)), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            if($path){
                UploadFile::delete($path);
            }
            return $this->sendError500($e->getMessage());
        }
    }
}
