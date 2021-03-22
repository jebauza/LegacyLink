<?php
namespace App\Http\Controllers\Admin\DeceasedProfile;


use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DeceasedProfileResource;
use App\Http\Requests\DeceasedProfileStoreUpdateRequest;

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
    public function store(DeceasedProfileStoreUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $newDProfile = new DeceasedProfile();
            $newDProfile->name = $request->dprofile_name;
            $newDProfile->last_name = $request->dprofile_lastname;
            $newDProfile->birthday = $request->dprofile_birthday;
            $newDProfile->death = $request->dprofile_death;
            $newDProfile->adviser_id = $request->dprofile_adviser;
            $newDProfile->office_id = $request->dprofile_office;
            if ($newDProfile->save()) {
                if (!$client = User::where('email', $request->client_email)->first()) {
                    $client = new User();
                }
                $client->dni = $request->client_dni;
                $client->name = $request->client_name;
                $client->lastname = $request->client_lastname;
                $client->email = $request->client_email;
                $client->phone = $request->client_phone;
                $client->password = Hash::make(Str::random(8));
                if ($client->save()) {
                    $newDProfile->clients()->attach($client->id, [
                        'role' => 'admin',
                        'declarant' => true
                    ]);
                }
            }

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new DeceasedProfileResource($newDProfile)), 201);

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
