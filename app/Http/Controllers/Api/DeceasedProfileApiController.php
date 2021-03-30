<?php

namespace App\Http\Controllers\Api;

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
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
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
     * @param int $profile_id
     */
    public function show($profile_id)
    {
        $profile = DeceasedProfile::find($profile_id);

        if(!$profile){
            return $this->sendError404();
        }

        return $this->sendResponse(null, (new DeceasedProfileApiResource($profile)));
    }


    /**
     * @OA\Put(
     *      path="/profile/{profile_id}/update",
     *      operationId="/profile/{profile_id}/update",
     *      tags={"Profile"},
     *      summary="Get the public details of deseased profile",
     *      description="Return the public details of a specific profile",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *     @OA\Parameter(
     *          name="photo",
     *          in="query",
     *          required=true,
     *          description="Building photo",
     *           @OA\Schema(type="file")
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
            if($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photo_name = Str::random(10) . '.' . $photo->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('deceased_profiles/' . $profile->id, $photo, $photo_name);
                if($profile->photo) {
                    if(Storage::disk('public')->exists($profile->photo)) {
                        Storage::disk('public')->delete($profile->photo);
                    }
                }
                $profile->photo = $path;
            }
            $profile->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new DeceasedProfileApiResource($profile)), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            if($path && Storage::disk('public')->exists($path)){
                Storage::disk('public')->delete($path);
            }
            return $this->sendError500($e->getMessage());
        }
    }
}
