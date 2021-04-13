<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SMSHelper;
use App\Models\Invitation;
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
                                ->orderBy('created_at')
                                ->get();

        return $this->sendResponse(null, InvitationApiResource::collection($invitations));
    }

    /**
     * @OA\Post(
     *      path="/profile/{profile_id}/invitations/store",
     *      operationId="/profile/{profile_id}/invitations/store",
     *      tags={"Invitation"},
     *      summary="Store Private Invitation",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\RequestBody(ref="#/components/requestBodies/request_invitation_store"),
     *
     *      @OA\Response(response=201, description="OK",
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
     *      @OA\Response(response=422, ref="#/components/requestBodies/invitation_store_response_422"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     */
    public function store(InvitationStoreApiRequest $request)
    {
        $profile = session('profileWeb');

        $invitation = $profile->invitations()->where('role', $request->role)->first();

        try {
            DB::beginTransaction();
            if(!$invitation) {
                $invitation = new Invitation();
                $invitation->profile_id = $profile->id;
                $invitation->role = $request->role;
                $invitation->created_by = auth()->user()->id;
            }
            $invitation->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new InvitationApiResource($invitation)), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
