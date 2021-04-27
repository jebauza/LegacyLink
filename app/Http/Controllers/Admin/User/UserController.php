<?php

namespace App\Http\Controllers\Admin\User;

use App\Rules\Nif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserStoreUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('modules.user.user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = User::EmailDni($request->emailDni)
                    ->orderBy('name')
                    ->get();

        return $this->sendResponse(null, UserResource::collection($clients));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request)
    {
        $usersPaginate = User::search($request->search)
                                ->orderBy('name')
                                ->paginate();

        $usersPaginate->setCollection(UserResource::collection($usersPaginate->getCollection())->collection);

        return $this->sendResponse(null, $usersPaginate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $newClient = new User($request->all());
            $newClient->save();

            DB::commit();
            return $this->sendResponse(__('Updated successfully'), new UserResource($newClient));

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
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dni' => ['required','string','max:20',new Nif,"unique:users,dni,$id,id"],
            'email' => "required|string|max:255|unique:users,email,$id,id",
            'phone' => 'required|string|phone:ES,mobile',
        ]);

        if(!$client = User::find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();

            $client->fill($request->all());
            $client->save();

            DB::commit();
            return $this->sendResponse(__('Updated successfully'), ($client));

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
        if(!$client = User::find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $client->delete();

            DB::commit();
            return $this->sendResponse(__('Deleted successfully'), (new UserResource($client)));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }
}
