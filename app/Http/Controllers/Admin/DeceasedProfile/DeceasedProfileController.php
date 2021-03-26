<?php
namespace App\Http\Controllers\Admin\DeceasedProfile;


use App\Models\User;
use App\Models\Ceremony;
use App\Helpers\SMSHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\Http\Resources\DeceasedProfileResource;
use App\Http\Requests\DeceasedProfileStoreRequest;

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
                            ->with('office', 'adviser')
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
                            ->office($request->office)
                            ->name($request->name)
                            ->with('office', 'clients', 'adviser')
                            ->orderBy('name')
                            ->paginate();

        //$dprofilesPaginate->setCollection(DeceasedProfileResource::collection($dprofilesPaginate->getCollection())->collection);

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
    public function store(DeceasedProfileStoreRequest $request)
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
                $newDProfile->token = Str::random(10) . $newDProfile->id;
                $newDProfile->save();
                if (!$client = User::where('email', $request->client_email)->first()) {
                    $client = new User();
                }
                $client->dni = $request->client_dni;
                $client->name = $request->client_name;
                $client->lastname = $request->client_lastname;
                $client->email = $request->client_email;
                $client->phone = (string) PhoneNumber::make($request->phone)->ofCountry('ES');  // +3412345678;
                $client->password = Hash::make(Str::random(8));
                if ($client->save()) {
                    $newDProfile->clients()->attach($client->id, [
                        'role' => 'admin',
                        'declarant' => true
                    ]);

                    $message = 'Su acceso para la web de ' . $newDProfile->name . ' es https://web.celebrasuvida.es/admin?token=' . $newDProfile->token;
                    $smsResp = SMSHelper::sendingSMS($client->phone, $message);
                }

                foreach ($request->ceremonies as $key => $value) {
                    $newCeremony = new Ceremony($value);
                    $newCeremony->profile_id = $newDProfile->id;
                    $newCeremony->save();
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
