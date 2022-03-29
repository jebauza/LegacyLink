<?php

namespace App\Http\Controllers\Api;

use App\Models\Candle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CandleApiResource;
use App\Http\Resources\Api\PaginationApiResource;

/**
 * @OA\Tag(
 *     name="Candle",
 *     description="API Endpoints of Candle"
 * )
 */
class CandleApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/public/profile/{profile_id}/candles",
     *      operationId="/public/profile/{profile_id}/candles",
     *      tags={"Candle"},
     *      summary="Get public Candle",
     *      description="Return list public Candle",
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/CandleApiResource")
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(response=400, ref="#/components/requestBodies/response_400"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPublic()
    {
        $profile = session('profileWeb');

        $candles = $profile->candles()
                            ->latest()
                            ->get();

        return $this->sendResponse(null, CandleApiResource::collection($candles));
    }

    /**
     * @OA\Get(
     *      path="/public/profile/{profile_id}/candles/paginate",
     *      operationId="/public/profile/{profile_id}/candles/paginate",
     *      tags={"Candle"},
     *      summary="Get public Candle paginate",
     *      description="Return paginate public Candle",
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *      @OA\Parameter(ref="#/components/parameters/page"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/CandlePaginateApiResource")
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(response=400, ref="#/components/requestBodies/response_400"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function paginatePublic()
    {
        $profile = session('profileWeb');

        $paginateCandles = $profile->candles()
                            ->latest()
                            ->paginate();

        $paginateCandles->setCollection(CandleApiResource::collection($paginateCandles->getCollection())->collection);
        return $this->sendResponse(null, new PaginationApiResource($paginateCandles));
    }

    /**
     * @OA\Post(
     *      path="/public/profile/{profile_id}/candles/store",
     *      operationId="/public/profile/{profile_id}/candles/store",
     *      tags={"Candle"},
     *      summary="Store Candle",
     *      description="",
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"author","message"},
     *              @OA\Property(property="author", type="string", example="Maria"),
     *              @OA\Property(property="message", type="string", example="De Juan")
     *          ),
     *      ),
     *
     *      @OA\Response(response=201, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/CandleApiResource"),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=422, description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="author", example={"El campo author es obligatorio."}),
     *                  @OA\Property(property="message", example={"El campo message es obligatorio."})
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     */
    public function storePublic(Request $request)
    {
        $profile = session('profileWeb');

        $request->validate([
            'author' => 'required|string|max:255',
            'message' => 'required|string|max:255'
        ]);

        try {
            DB::beginTransaction();
            $newCandle = new Candle($request->all());
            $newCandle->profile_id = $profile->id;
            $newCandle->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new CandleApiResource($newCandle)), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/profile/{profile_id}/candles/{candle_id}/destroy",
     *      operationId="/profile/{profile_id}/candles/{candle_id}/destroy",
     *      tags={"Candle"},
     *      summary="Destroy Candle",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Parameter(name="candle_id", in="path", required=true, description="Candle identifier",
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
        $candle_id = $request->route('candle_id');

        if(!$candle = $profile->candles()->find($candle_id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $candle->delete();

            DB::commit();
            return $this->sendResponse(__('Deleted successfully'), null, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }
}
