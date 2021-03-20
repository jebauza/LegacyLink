<?php

namespace App\Http\Controllers\Admin\Deceased_profiles;

use Illuminate\Http\Request;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeceasedProfileResource;

class DeceasedProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('modules.deceased_profile.profile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dprofiles = DeceasedProfile::filterByRole()
                            ->with('office')
                            ->orderBy('name')
                            ->get();

        return $this->sendResponse(null, DeceasedProfileResource::collection($dprofiles));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request)
    {
        $dprofilesPaginate = DeceasedProfile::filterByRole()
                            ->with('office')
                            ->orderBy('name')
                            ->paginate();

        $dprofilesPaginate->setCollection(DeceasedProfileResource::collection($dprofilesPaginate->getCollection())->collection);

        return $this->sendResponse(null, $dprofilesPaginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $newEmployee = new Employee($request->all());
            $newEmployee->password = Hash::make($request->password);
            $newEmployee->created_by = auth()->user()->id;
            $newEmployee->updated_by = auth()->user()->id;
            if ($newEmployee->save()) {
                $newEmployee->syncRoles(Role::where('id', $request->role)->get());
                if (!$newEmployee->hasRole('Super Admin')) {
                    $newEmployee->offices()->sync($request->offices);
                }
            }

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new EmployeeResource($newEmployee)), 201);

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
