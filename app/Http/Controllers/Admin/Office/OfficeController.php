<?php

namespace App\Http\Controllers\Admin\Office;

use App\Models\Office;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OfficeEmployee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\OfficeResource;
use App\Http\Requests\OfficeStoreUpdateRequest;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('modules.office.office');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offices = Office::orderBy('name')->get();

        return $this->sendResponse(null, OfficeResource::collection($offices));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $officesPaginate = Office::orderBy('name')->paginate();
        $officesPaginate->setCollection(OfficeResource::collection($officesPaginate->getCollection())->collection);

        return $this->sendResponse(null, $officesPaginate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfficeStoreUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $newOffice = new Office($request->all());
            // $newOffice->is_active = $request->is_active ? true : false;
            $newOffice->created_by = auth()->user()->id;
            $newOffice->updated_by = auth()->user()->id;
            $newOffice->save();

            DB::commit();
            return $this->sendResponse("Save successfully", (new OfficeResource($newOffice)), 201);

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
        if(!$office = Office::find($id)) {
            return $this->sendError404();
        }

        return $this->sendResponse(null, (new OfficeResource($office)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OfficeStoreUpdateRequest $request, $id)
    {
        if(!$office = Office::find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $office->fill($request->all());
            //$office->is_active = $request->is_active ? true : false;
            $office->updated_by = auth()->user()->id;
            $office->save();

            DB::commit();
            return $this->sendResponse('Update successfully', (new OfficeResource($office)));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$office = Office::find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $office->delete();

            DB::commit();
            return $this->sendResponse('Deleted successfully', (new OfficeResource($office)));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }
}
