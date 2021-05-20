<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
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
     * @OA\Delete(
     *      path="/profile/{profile_id}/clients/{client_id}/detach",
     *      operationId="/profile/{profile_id}/clients/{client_id}/detach",
     *      tags={"Client"},
     *      summary="Remove client from profile",
     *      description="Remove client from profile",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Parameter(
     *          name="client_id",
     *          in="path",
     *          description="Client id",
     *          @OA\Schema(
     *               type="integer",
     *          ),
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
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
    public function detach($profile_id, $client_id)
    {
        $profile = session('profileWeb');

        if(!$client = $profile->clients()->find($client_id)) {
            return $this->sendError404();
        }

        if ($client->pivot->declarant) {
            return $this->sendError(__('The declaring customer cannot be removed.'));
        }

        try {
            DB::beginTransaction();
            $profile->clients()->detach($client_id);

            DB::commit();
            return $this->sendResponse(__('Deleted successfully'), null, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }
}
