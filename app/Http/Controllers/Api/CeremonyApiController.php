<?php

namespace App\Http\Controllers\Api;

use App\Models\Ceremony;
use App\Models\CeremonyType;
use Illuminate\Http\Request;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CeremonyApiResource;
use App\Http\Resources\Api\CeremonyTypeApiResource;
use App\Http\Resources\Api\UserCeremonyApiResource;
use App\Http\Requests\Api\CeremonyStoreUpdateApiRequest;

/**
 * @OA\Tag(
 *     name="Ceremony",
 *     description="API Endpoints of Ceremony"
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
     *      description="Return the list of public ceremonies associated with a specific profile",
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/CeremonyApiResource")
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(response=400, ref="#/components/requestBodies/response_400"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     *  @return CeremonyApiResource
     */
    public function indexPublic()
    {
        $profile = session('profileWeb');

        $ceremonies = $profile->ceremonies()->where('visible', 'public')
                                            ->orderBy('start')
                                            ->get();

        return $this->sendResponse(null, (CeremonyApiResource::collection($ceremonies)));
    }

    /**
     * @OA\Get(
     *      path="/profile/{profile_id}/ceremonies",
     *      operationId="/profile/{profile_id}/ceremonies",
     *      tags={"Ceremony"},
     *      summary="Get the public ceremonies list",
     *      description="Return the list of public ceremonies associated with a specific profile",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/CeremonyApiResource")
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
     *  @param int $profile_id
     *  @return CeremonyApiResource
     */
    public function index()
    {
        $profile = session('profileWeb');

        $ceremonies = $profile->ceremonies()
                        ->visibleClient($profile->pivot->role)
                        ->with('users')
                        ->orderBy('start')
                        ->get();

        return $this->sendResponse(null, (CeremonyApiResource::collection($ceremonies)));
    }

    /**
     * @OA\Get(
     *      path="/profile/{profile_id}/ceremonies/ceremony-types",
     *      operationId="/profile/{profile_id}/ceremonies/ceremony-types",
     *      tags={"Ceremony"},
     *      summary="Get the public ceremony types list",
     *      description="Return the list of ceremony types",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/CeremonyTypeApiResource")
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
     *  @param int $profile_id
     *  @return CeremonyResource
     */
    public function getCeremonyTypes()
    {
        $ceremonyTypes = CeremonyType::orderBy('name')->get();

        return $this->sendResponse(null, (CeremonyTypeApiResource::collection($ceremonyTypes)));
    }

    /**
     * @OA\Post(
     *      path="/profile/{profile_id}/ceremonies/store",
     *      operationId="/profile/{profile_id}/ceremonies/store",
     *      tags={"Ceremony"},
     *      summary="Store Ceremony",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\RequestBody(ref="#/components/requestBodies/request_ceremony_store"),
     *
     *      @OA\Response(response=201, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/CeremonyApiResource"),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=422, ref="#/components/requestBodies/ceremony_store_response_422"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     */
    public function store(CeremonyStoreUpdateApiRequest $request)
    {
        $profile = session('profileWeb');

        try {
            DB::beginTransaction();
            $newCeremony = new Ceremony($request->all());
            $newCeremony->profile_id = $profile->id;
            $newCeremony->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new CeremonyApiResource($newCeremony)), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/profile/{profile_id}/ceremonies/{ceremony_id}/update",
     *      operationId="/profile/{profile_id}/ceremonies/{ceremony_id}/update",
     *      tags={"Ceremony"},
     *      summary="Update Ceremony",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Parameter(name="ceremony_id", in="path", required=true, description="Ceremony identifier",
     *          @OA\Schema(type="integer", example=2)
     *      ),
     *
     *      @OA\RequestBody(ref="#/components/requestBodies/request_ceremony_store"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/CeremonyApiResource"),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=404, ref="#/components/requestBodies/response_404"),
     *
     *      @OA\Response(response=422, ref="#/components/requestBodies/ceremony_store_response_422"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     */
    public function update(CeremonyStoreUpdateApiRequest $request)
    {
        $profile = session('profileWeb');
        $ceremony_id = $request->route('ceremony_id');

        if(!$ceremony = $profile->ceremonies()->find($ceremony_id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $ceremony->fill($request->all());
            $ceremony->profile_id = $profile->id;
            $ceremony->save();

            DB::commit();
            return $this->sendResponse(__('Updated successfully'), (new CeremonyApiResource($ceremony)), 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/profile/{profile_id}/ceremonies/{ceremony_id}/destroy",
     *      operationId="/profile/{profile_id}/ceremonies/{ceremony_id}/destroy",
     *      tags={"Ceremony"},
     *      summary="Destroy Ceremony",
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
     *              @OA\Property(property="message", example="Solicitud procesada correctamente.")
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
    public function destroy(Request $request)
    {
        $profile = session('profileWeb');
        $ceremony_id = $request->route('ceremony_id');

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
        }
    }
}
