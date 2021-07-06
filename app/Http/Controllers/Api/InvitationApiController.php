<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SMSHelper;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\InvitationApiResource;
use App\Http\Requests\Api\InvitationStoreApiRequest;


/**
 * @OA\Tag(
 *     name="Invitation",
 *     description="API Endpoints of Invitation"
 * )
 */
class InvitationApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/profile/{profile_id}/invitations",
     *      operationId="/profile/{profile_id}/invitations",
     *      tags={"Invitation"},
     *      summary="Get the invitations list",
     *      description="Return the list of invitations",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/InvitationApiResource")
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     */
    public function index()
    {
        $profile = session('profileWeb');

        $invitations = $profile->invitations()
                                ->orderBy('role')
                                ->get();

        return $this->sendResponse(null, InvitationApiResource::collection($invitations));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * @OA\Put(
     *      path="/profile/{profile_id}/invitations/{invitation_id}/update/token",
     *      operationId="/profile/{profile_id}/invitations/{invitation_id}/update/token",
     *      tags={"Invitation"},
     *      summary="Update Private Invitation",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Parameter(name="invitation_id", in="path", required=true, description="Invitation identifier",
     *          @OA\Schema(type="integer", example=2)
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/InvitationApiResource"),
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
    public function updateToken(Request $request)
    {
        $profile = session('profileWeb');
        $invitation_id = $request->route('invitation_id');

        if(!$invitation = $profile->invitations()->find( $invitation_id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $invitation->token = str_shuffle(Str::random(8)) . uniqid();
            $invitation->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new InvitationApiResource($invitation)), 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }
}
