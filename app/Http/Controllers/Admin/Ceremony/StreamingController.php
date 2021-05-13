<?php

namespace App\Http\Controllers\Admin\Ceremony;

use App\Models\Ceremony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CeremonyResource;

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
                            ->with('video','profile.clientDeclarant')
                            ->orderBy('start', 'DESC')
                            ->paginate();

        //$dprofilesPaginate->setCollection(DeceasedProfileResource::collection($dprofilesPaginate->getCollection())->collection);

        return $this->sendResponse(null, $ceremonyPaginate);
    }
}
