<?php
namespace App\Http\Controllers\Api;

use App\Models\Commentary;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\CommentaryApiResource;

class CommentaryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePublic(Request $request, $profile_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'file' => 'nullable|file'
        ]);

        $profile = session('profileWeb');
        $path = null;
        try {
            DB::beginTransaction();
            $newCommentary = new Commentary($request->all());
            if($request->hasFile('file')) {
                $file = $request->file('file');
                $file_name = Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('deceased_profiles/' . $profile->id, $file, $file_name);
                $newCommentary->path_file = $path;
                $newCommentary->type_file = $file->getClientOriginalExtension();
            }
            $newCommentary->profile_id = $profile->id;
            $newCommentary->public = true;
            $profile->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new CommentaryApiResource($newCommentary)), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            if($path && Storage::disk('public')->exists($path)){
                Storage::disk('public')->delete($path);
            }
            return $this->sendError500($e->getMessage());
        }
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
    public function destroy($id)
    {
        //
    }
}
