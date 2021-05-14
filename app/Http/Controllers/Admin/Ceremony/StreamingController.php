<?php

namespace App\Http\Controllers\Admin\Ceremony;

use App\Models\Ceremony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CeremonyResource;
use App\Models\Video;

class StreamingController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('modules.streaming.streaming');
    }

    public function paginate(Request $request)
    {

        $ceremonyPaginate = Ceremony::filterByRole()
                            ->streaming()
                            ->office($request->office)
                            ->profile($request->web)
                            ->declarant($request->declarant)
                            ->with('video','profile.clientDeclarant', 'type')
                            ->orderBy('start', 'DESC')
                            ->paginate();

        //$dprofilesPaginate->setCollection(DeceasedProfileResource::collection($dprofilesPaginate->getCollection())->collection);

        return $this->sendResponse(null, $ceremonyPaginate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $id)
    {
        if(!$ceremony = Ceremony::find($id)) {
            return $this->sendError404();
        }

        $request->validate([
            'vimeo_code' => 'required|string|max:255',
            'vimeo_url' => 'required|string|max:255',
            'vimeo_rmtp_url' => 'required|string|max:255',
            'vimeo_rmtp_key' => 'required|string|max:255'
        ]);

        try {
            DB::beginTransaction();
            if (!$video = $ceremony->video) {
                $video = new Video();
            }
            $video->fill($request->all());
            $video->ceremony_id = $ceremony->id;
            $video->save();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), $video, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }
}
