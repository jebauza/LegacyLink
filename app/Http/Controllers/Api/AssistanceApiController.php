<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AssistanceApiResource;
use App\Http\Requests\Api\AssistanceUpdateApiRequest;


class AssistanceApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/profile/{profile_id}/ceremonies/{ceremony_id}/assistance",
     *      operationId="/profile/{profile_id}/ceremonies/{ceremony_id}/assistance",
     *      tags={"Ceremony"},
     *      summary="Update ceremony attendance",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Parameter(name="ceremony_id", in="path", required=true, description="Ceremony identifier",
     *          @OA\Schema(type="integer", example=2)
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/AssistanceApiResource"),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=404, ref="#/components/requestBodies/response_404"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     */
    public function index(Request $request)
    {
        $profile = session('profileWeb');
        $ceremony_id = $request->route('ceremony_id');

        if(!$ceremony = $profile->ceremonies()->with('users')->find($ceremony_id)) {
            return $this->sendError404();
        }

        $users = $ceremony->users;

        return $this->sendResponse(null, (AssistanceApiResource::collection($users)));
    }

    /**
     * @OA\Put(
     *      path="/profile/{profile_id}/ceremonies/{ceremony_id}/assistance/update",
     *      operationId="/profile/{profile_id}/ceremonies/{ceremony_id}/assistance/update",
     *      tags={"Ceremony"},
     *      summary="Users who confirmed attendance at the ceremony",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Parameter(name="ceremony_id", in="path", required=true, description="Ceremony identifier",
     *          @OA\Schema(type="integer", example=2)
     *      ),
     *
     *      @OA\RequestBody(ref="#/components/requestBodies/request_assistance_update"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/AssistanceApiResource")
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=404, ref="#/components/requestBodies/response_404"),
     *
     *      @OA\Response(response=422, ref="#/components/requestBodies/assistance_update_response_422"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     */
    public function update(AssistanceUpdateApiRequest $request)
    {
        $profile = session('profileWeb');
        $ceremony_id = $request->route('ceremony_id');
        $ceremony = $profile->ceremonies()->visibleClient($profile->pivot->role)->with('users')->find($ceremony_id);

        if(!$ceremony) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $user = $ceremony->users()->find(auth()->user()->id);

            if ($user) {
                $ceremony->users()->updateExistingPivot($user->id, ['assistance' => $request->assistance]);
            } else {
                $ceremony->users()->attach(auth()->user()->id, ['assistance' => $request->assistance]);
            }

            $userAssistance = $ceremony->users()->find(auth()->user()->id);

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new AssistanceApiResource($userAssistance)), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

}
