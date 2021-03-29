<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserApiResource;

/**
 * @OA\Tag(
 *     name="Client",
 *     description="API Profile"
 * )
 */
class UserApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/profile/{profile_id}/clients",
     *      operationId="/profile/{profile_id}/clients",
     *      tags={"Client"},
     *      summary="Get lists of people associated with the profile",
     *      description="Return lists of people",
     *      security={{"api_key": {}}},
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
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/UserApiResource")
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
     */
    public function index()
    {
        $profile = session('profileWeb');

        $users = $profile->clients()
                    ->orderBy('name')
                    ->orderBy('lastname')
                    ->get();

        return $this->sendResponse(null, UserApiResource::collection($users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($user_id)
    {
        /* $profile = session('profileWeb');

        if(!$ceremony = $profile->ceremonies()->find($ceremony_id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $ceremony->delete();

            DB::commit();
            return $this->sendResponse(__('Deleted successfully'), null, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        } */
    }
}
