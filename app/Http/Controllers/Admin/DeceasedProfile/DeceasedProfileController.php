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
use App\Jobs\DeceasedProfile\NotificationDeclarantJob;

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
                            ->declarant($request->declarant)
                            ->with('office', 'clients', 'adviser', 'ceremonies.type')
                            ->latest()
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

                if (!$client = User::where('id', $request->client_id)->first()) {
                    $client = new User();
                    $client->password = Hash::make(Str::random(8));
                }
                $client->dni = $request->client_dni;
                $client->name = $request->client_name;
                $client->lastname = $request->client_lastname;
                $client->email = $request->client_email;
                $client->phone = (string) PhoneNumber::make($request->client_phone)->ofCountry('ES');  // +3412345678;
                if ($client->save()) {
                    $newDProfile->clients()->attach($client->id, [
                        'role' => 'admin',
                        'declarant' => true,
                        'token' => $newDProfile->id . Str::random(5) . $client->id,
                    ]);

                    // NotificationDeclarantJob::dispatch($newDProfile, $request->client_sendSms, $request->client_sendEmail);
                    NotificationDeclarantJob::dispatchNow($newDProfile);
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
        $request->validate([
            'office' => 'required|integer|exists:offices,id',
            'adviser' => 'required|integer|exists:employees,id',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date|date_format:Y-m-d',
            'death' => 'required|date|date_format:Y-m-d|after:birthday',
        ]);

        if(!$profile = DeceasedProfile::find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $profile->fill($request->all());
            $profile->save();

            DB::commit();
            return $this->sendResponse(__('Updated successfully'), (new DeceasedProfileResource($profile)));

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
        if(!$profile = DeceasedProfile::find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $profile->delete();

            DB::commit();
            return $this->sendResponse(__('Deleted successfully'), (new DeceasedProfileResource($profile)));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendNotification(Request $request, $id)
    {
        try {

            if(!$profile = DeceasedProfile::with('clientDeclarant')->find($id)) {
                return $this->sendError404();
            }

            $client = $profile->clientDeclarant()->first();
            if (!$client) {
                return $this->sendError(__('Declarant does not exist'));
            }

            // NotificationDeclarantJob::dispatch($profile);
            NotificationDeclarantJob::dispatchNow($profile);

            $message = 'Su acceso para la web de ' . $profile->fullName . ' es ' . config('albia.web_client_url') . '/admin?token=' . $client->pivot->token . ' .Este acceso es intransferible, solo usted puede utilizarlo.';

            return $this->sendResponse(__('Message sent successfully'), ['message' => $message]);

        } catch (\Exception $e) {
            return $this->sendError500($e->getMessage());
        }
    }
}
