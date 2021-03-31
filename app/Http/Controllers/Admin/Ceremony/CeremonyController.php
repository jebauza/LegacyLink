<?php

namespace App\Http\Controllers\Admin\Ceremony;

use App\Models\Ceremony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CeremonyResource;

class CeremonyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Ceremony::deceasedProfile($request->profile)
                        ->with('type')
                        ->orderBy('start')
                        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'additional_info' => 'nullable|string',
            'address' => 'required|string|max:255',
            'start' => 'required|date|date_format:Y-m-d H:i:s',
            'end' => 'required|date|date_format:Y-m-d H:i:s|after:start',
            'main' => 'required|boolean',
            'room_name' => 'nullable|string|max:255',
            'type_id' => 'required|integer|exists:ceremony_types,id',
            'profile_id' => 'required|integer|exists:deceased_profiles,id',
        ]);

        try {
            DB::beginTransaction();
            $newCeremony = new Ceremony($request->all());
            $newCeremony->save();
            if ($newCeremony->main) {
                Ceremony::where('profile_id',$newCeremony->profile_id)
                            ->where('id','<>',$newCeremony->id)
                            ->update(['main' => false]);
            }

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new CeremonyResource($newCeremony)), 201);

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
