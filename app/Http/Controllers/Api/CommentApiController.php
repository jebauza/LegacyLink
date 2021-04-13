<?php
namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
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
                            ->with('user')
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
                            ->with('user')
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
        if (auth()->user()->cant('store', Comment::class)) {
            return $this->sendError403();
        }

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

    }

    /**
     * @OA\Post(
     *      path="/profile/{profile_id}/comments/{comment_id}/update",
     *      operationId="/profile/{profile_id}/comments/{comment_id}/update",
     *      tags={"Comment"},
     *      summary="Update comment",
     *      description="Return comment",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Parameter(name="comment_id", in="path", required=true, description="Comment identifier",
     *          @OA\Schema(type="integer", example=2)
     *      ),
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
     *      @OA\Response(response=404, ref="#/components/requestBodies/response_404"),
     *
     *      @OA\Response(response=422, ref="#/components/requestBodies/comment_public_response_422"),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CommentStoreUpdateRequest $request)
    {
        $profile = session('profileWeb');
        $comment_id = $request->route('comment_id');

        if(!$comment = $profile->comments()->find($comment_id)) {
            return $this->sendError404();
        }

        if (auth()->user()->cant('update', $comment)) {
            return $this->sendError403();
        }

        $path = null;
        try {
            DB::beginTransaction();
            $comment->fill($request->all());
            $comment->public = $request->public ? true : false;
            if($request->file_base64) {
                $dirPath = 'deceased_profiles/' . $profile->id . '/comments';
                $path = UploadFile::upload($request->file_base64, $dirPath, true);
                $comment->path_file = $path;
            }
            if ($request->remove_file) {
                $comment->deleteFile();
                $comment->path_file = null;
            }
            $comment->save();

            DB::commit();
            return $this->sendResponse(__('Updated successfully'), (new CommentApiResource($comment)), 200);

        } catch (\Exception $e) {
            DB::rollBack();
            if($path){
                UploadFile::delete($path);
            }
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/profile/{profile_id}/comments/{comment_id}/destroy",
     *      operationId="/profile/{profile_id}/comments/{comment_id}/destroy",
     *      tags={"Comment"},
     *      summary="Destroy Comment",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Parameter(name="comment_id", in="path", required=true, description="Comment identifier",
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
     *      @OA\Response(response=400, ref="#/components/requestBodies/response_400"),
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
        $comment_id = $request->route('comment_id');

        if(!$comment = $profile->comments()->find($comment_id)) {
            return $this->sendError404();
        }

        if (auth()->user()->cant('delete', $comment)) {
            return $this->sendError403();
        }

        try {
            DB::beginTransaction();
            $comment->delete();

            DB::commit();
            return $this->sendResponse(__('Deleted successfully'), null, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/profile/{profile_id}/comments/{comment_id}/approve",
     *      operationId="/profile/{profile_id}/comments/{comment_id}/approve",
     *      tags={"Comment"},
     *      summary="Approve Comment",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Parameter(name="comment_id", in="path", required=true, description="Comment identifier",
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
     *      @OA\Response(response=400, ref="#/components/requestBodies/response_400"),
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
    public function approve(Request $request)
    {
        $profile = session('profileWeb');
        $comment_id = $request->route('comment_id');

        if(!$comment = $profile->comments()->find($comment_id)) {
            return $this->sendError404();
        }

        if (auth()->user()->cant('approve', $comment)) {
            return $this->sendError403();
        }

        try {
            DB::beginTransaction();
            $comment->approved = true;
            $comment->save();

            DB::commit();
            return $this->sendResponse(null, null, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }
}
