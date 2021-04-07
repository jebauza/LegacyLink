<?php
namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CommentApiResource;
use App\Http\Requests\Api\CommentPublicStoreRequest;
use App\Http\Requests\Api\CommentStoreUpdateRequest;


/**
 * @OA\Tag(
 *     name="Comment",
 *     description="API Endpoints of Comment"
 * )
 */
class CommentApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/public/profile/{profile_id}/comments",
     *      operationId="/public/profile/{profile_id}/comments",
     *      tags={"Comment"},
     *      summary="Get public comment",
     *      description="Return list public comment",
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/CommentApiResource")
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

        $comments = $profile->comments()
                            ->where('public', true)
                            ->where('approved', true)
                            ->latest()
                            ->get();

        return $this->sendResponse(null, CommentApiResource::collection($comments));
    }

    /**
     * @OA\Get(
     *      path="/profile/{profile_id}/comments",
     *      operationId="/profile/{profile_id}/comments",
     *      tags={"Comment"},
     *      summary="Get comment",
     *      description="Return list comment",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/CommentApiResource")
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(response=400, ref="#/components/requestBodies/response_400"),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = session('profileWeb');

        $comments = $profile->comments()
                            ->latest()
                            ->get();

        return $this->sendResponse(null, CommentApiResource::collection($comments));
    }

    /**
     * @OA\Post(
     *      path="/public/profile/{profile_id}/comments/store",
     *      operationId="/public/profile/{profile_id}/comments/store",
     *      tags={"Comment"},
     *      summary="Store public comment",
     *      description="Return new public comment",
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\RequestBody(ref="#/components/requestBodies/request_comment_public_store"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/CommentApiResource"),
     *          )
     *      ),
     *
     *      @OA\Response(response=400, ref="#/components/requestBodies/response_400"),
     *
     *      @OA\Response(response=422, ref="#/components/requestBodies/comment_public_response_422"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePublic(CommentPublicStoreRequest $request)
    {
        $profile = session('profileWeb');
        $path = null;
        try {
            DB::beginTransaction();
            $newComment = new Comment($request->all());
            $newComment->profile_id = $profile->id;
            $newComment->public = true;
            $newComment->approved = false;
            if($request->file_base64) {
                $dirPath = 'deceased_profiles/' . $profile->id . '/comments';
                $path = UploadFile::upload($request->file_base64, $dirPath, true);
                $newComment->path_file = $path;
            }
            $newComment->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new CommentApiResource($newComment)), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            if($path){
                UploadFile::delete($path);
            }
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      path="/profile/{profile_id}/comments/store",
     *      operationId="/profile/{profile_id}/comments/store",
     *      tags={"Comment"},
     *      summary="Store comment",
     *      description="Return new comment",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\RequestBody(ref="#/components/requestBodies/request_comment_store"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Solicitud procesada correctamente."),
     *              @OA\Property(property="data", ref="#/components/schemas/CommentApiResource"),
     *          )
     *      ),
     *
     *      @OA\Response(response=400, ref="#/components/requestBodies/response_400"),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=422, ref="#/components/requestBodies/comment_public_response_422"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentStoreUpdateRequest $request)
    {
        $profile = session('profileWeb');
        $path = null;
        try {
            DB::beginTransaction();
            $newComment = new Comment($request->all());
            $newComment->profile_id = $profile->id;
            $newComment->public = $request->public ? true : false;
            $newComment->approved = !$newComment->hasModeration($profile->pivot->role);
            $newComment->user_id = auth()->user()->id;
            if($request->file_base64) {
                $dirPath = 'deceased_profiles/' . $profile->id . '/comments';
                $path = UploadFile::upload($request->file_base64, $dirPath, true);
                $newComment->path_file = $path;
            }
            $newComment->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new CommentApiResource($newComment)), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            if($path){
                UploadFile::delete($path);
            }
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
